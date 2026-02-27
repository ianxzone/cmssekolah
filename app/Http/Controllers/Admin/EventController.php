<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest('start_time')->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:offline,online',
            'meeting_link' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'location' => 'nullable|string|max:255',
            'map_link' => 'nullable|string',
            'capacity' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'organizer_name' => 'nullable|string|max:255',
            'sponsor_names' => 'nullable|array',
            'sponsor_logos' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image'] = $imagePath;
        }

        $sponsors = [];
        if ($request->has('sponsor_names')) {
            foreach ($request->sponsor_names as $index => $name) {
                if ($name) {
                    $logoPath = null;
                    if ($request->hasFile("sponsor_logos.$index")) {
                        $logoPath = $request->file("sponsor_logos.$index")->store('sponsors', 'public');
                    }
                    $sponsors[] = [
                        'name' => $name,
                        'logo' => $logoPath
                    ];
                }
            }
        }
        $validated['sponsors'] = $sponsors;

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not used in admin panel usually
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:offline,online',
            'meeting_link' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'location' => 'nullable|string|max:255',
            'map_link' => 'nullable|string',
            'capacity' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'organizer_name' => 'nullable|string|max:255',
            'sponsor_names' => 'nullable|array',
            'sponsor_logos' => 'nullable|array',
            'existing_sponsor_logos' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $sponsors = [];
        if ($request->has('sponsor_names')) {
            foreach ($request->sponsor_names as $index => $name) {
                if ($name) {
                    $logoPath = $request->existing_sponsor_logos[$index] ?? null;
                    if ($request->hasFile("sponsor_logos.$index")) {
                        // Delete old logo if replacing
                        if ($logoPath) {
                            Storage::disk('public')->delete($logoPath);
                        }
                        $logoPath = $request->file("sponsor_logos.$index")->store('sponsors', 'public');
                    }
                    $sponsors[] = [
                        'name' => $name,
                        'logo' => $logoPath
                    ];
                }
            }
        }

        // Cleanup old logos that are no longer present
        $oldLogos = collect($event->sponsors ?? [])->pluck('logo')->filter()->all();
        $newLogos = collect($sponsors)->pluck('logo')->filter()->all();
        foreach (array_diff($oldLogos, $newLogos) as $deletedLogo) {
            Storage::disk('public')->delete($deletedLogo);
        }

        $validated['sponsors'] = $sponsors;

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        if ($event->sponsors) {
            foreach ($event->sponsors as $sponsor) {
                if (!empty($sponsor['logo'])) {
                    Storage::disk('public')->delete($sponsor['logo']);
                }
            }
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}
