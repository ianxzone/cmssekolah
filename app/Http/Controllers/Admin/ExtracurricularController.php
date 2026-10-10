<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExtracurricularController extends Controller
{
    public function index()
    {
        $extracurriculars = Extracurricular::orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        return view('admin.extracurriculars.index', compact('extracurriculars'));
    }

    public function create()
    {
        return view('admin.extracurriculars.create');
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
            $path = $request->file('image_file')->store('extracurriculars', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        if(!isset($validated['is_active'])) $validated['is_active'] = false;
        if(!isset($validated['order'])) $validated['order'] = 0;

        Extracurricular::create($validated);

        return redirect()->route('admin.extracurriculars.index')->with('success', 'Ekstrakurikuler berhasil ditambahkan');
    }

    public function edit(Extracurricular $extracurricular)
    {
        return view('admin.extracurriculars.edit', compact('extracurricular'));
    }

    public function update(Request $request, Extracurricular $extracurricular)
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
            if ($extracurricular->image && str_starts_with($extracurricular->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $extracurricular->image));
            }
            
            $path = $request->file('image_file')->store('extracurriculars', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        $validated['is_active'] = $request->has('is_active');

        $extracurricular->update($validated);

        return redirect()->route('admin.extracurriculars.index')->with('success', 'Ekstrakurikuler berhasil diperbarui');
    }

    public function destroy(Extracurricular $extracurricular)
    {
        if ($extracurricular->image && str_starts_with($extracurricular->image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $extracurricular->image));
        }
        $extracurricular->delete();

        return redirect()->route('admin.extracurriculars.index')->with('success', 'Ekstrakurikuler berhasil dihapus');
    }
}
