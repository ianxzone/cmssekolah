<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class TeacherController extends Controller
{
    /**
     * Display a listing of SDM & Educators.
     */
    public function index(Request $request)
    {
        $query = Teacher::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%")
                  ->orWhere('unit', 'like', "%{$search}%");
            });
        }

        if ($request->filled('unit')) {
            $query->where('unit', $request->input('unit'));
        }

        $teachers = $query->orderBy('order', 'asc')
                          ->orderBy('id', 'desc')
                          ->paginate(10)
                          ->withQueryString();

        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new SDM record.
     */
    public function create()
    {
        $units = ['LPP', 'KB-TK', 'SDIT', 'SMPIT', 'SMAIT', 'Umum'];
        return view('admin.teachers.create', compact('units'));
    }

    /**
     * Store a newly created SDM record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'unit' => 'nullable|string|max:100',
            'bio' => 'nullable|string',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $request->input('order', 0);

        if ($request->hasFile('image')) {
            $opt = ImageService::optimizeAndStore($request->file('image'), 'teachers');
            $validated['image'] = $opt['path'];
        }

        Teacher::create($validated);

        return redirect()->route('admin.teachers.index')->with('success', 'Data SDM / Pimpinan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified SDM record.
     */
    public function edit(Teacher $teacher)
    {
        $units = ['LPP', 'KB-TK', 'SDIT', 'SMPIT', 'SMAIT', 'Umum'];
        return view('admin.teachers.edit', compact('teacher', 'units'));
    }

    /**
     * Update the specified SDM record.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'unit' => 'nullable|string|max:100',
            'bio' => 'nullable|string',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $request->input('order', 0);

        if ($request->hasFile('image')) {
            if ($teacher->image && Storage::disk('public')->exists($teacher->image)) {
                Storage::disk('public')->delete($teacher->image);
            }
            $opt = ImageService::optimizeAndStore($request->file('image'), 'teachers');
            $validated['image'] = $opt['path'];
        }

        $teacher->update($validated);

        return redirect()->route('admin.teachers.index')->with('success', 'Data SDM / Pimpinan berhasil diperbarui.');
    }

    /**
     * Remove the specified SDM record.
     */
    public function destroy(Teacher $teacher)
    {
        if ($teacher->image && Storage::disk('public')->exists($teacher->image)) {
            Storage::disk('public')->delete($teacher->image);
        }

        $teacher->delete();

        return redirect()->route('admin.teachers.index')->with('success', 'Data SDM / Pimpinan berhasil dihapus.');
    }
}
