<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('admin.facilities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'badge' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:100',
            'desc' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'featured_image_path' => 'nullable|string',
        ]);

        if ($request->filled('featured_image_path')) {
            $validated['image'] = str_starts_with($request->featured_image_path, 'http') ? $request->featured_image_path : '/storage/' . $request->featured_image_path;
        }

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('facilities', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        if(!isset($validated['is_active'])) $validated['is_active'] = false;
        if(!isset($validated['order'])) $validated['order'] = 0;

        Facility::create($validated);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil ditambahkan');
    }

    public function edit(Facility $facility)
    {
        return view('admin.facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'badge' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:100',
            'desc' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'featured_image_path' => 'nullable|string',
            'remove_image' => 'nullable|boolean',
        ]);

        if ($request->remove_image) {
            $validated['image'] = null;
        } elseif ($request->filled('featured_image_path')) {
            $validated['image'] = str_starts_with($request->featured_image_path, 'http') ? $request->featured_image_path : '/storage/' . $request->featured_image_path;
        }

        if ($request->hasFile('image_file')) {
            if ($facility->image && str_starts_with($facility->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $facility->image));
            }
            
            $path = $request->file('image_file')->store('facilities', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        $validated['is_active'] = $request->has('is_active');

        $facility->update($validated);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil diperbarui');
    }

    public function destroy(Facility $facility)
    {
        if ($facility->image && str_starts_with($facility->image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $facility->image));
        }
        $facility->delete();

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil dihapus');
    }
}
