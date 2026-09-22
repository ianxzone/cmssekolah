<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Page::query();

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('status', 'published')
                      ->where(function ($q) {
                          $q->whereNull('published_at')
                            ->orWhere('published_at', '<=', now());
                      });
            } elseif ($request->status === 'scheduled') {
                $query->where(function ($q) {
                    $q->where('status', 'scheduled')
                      ->orWhere(function ($sub) {
                          $sub->whereNotNull('published_at')
                              ->where('published_at', '>', now());
                      });
                });
            } else {
                $query->where('status', $request->status);
            }
        }

        // Search by title or slug
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%');
            });
        }

        $pages = $query->latest()->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'featured_image_path' => 'nullable|string|max:500',
            'type' => 'nullable|string|max:50',
            'status' => 'required|in:draft,pending,published,scheduled',
            'published_at' => 'nullable|required_if:status,scheduled|date',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('image')) {
            $optimized = ImageService::optimizeAndStore($request->file('image'), 'pages');
            $validated['image'] = $optimized['path'];
        } elseif ($request->filled('featured_image_path')) {
            $validated['image'] = $request->input('featured_image_path');
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = $validated['published_at'] ?: now();
        } elseif ($validated['status'] === 'scheduled') {
            // Keep provided published_at
        } else {
            $validated['published_at'] = null;
        }

        Page::create($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'featured_image_path' => 'nullable|string|max:500',
            'remove_image' => 'nullable|boolean',
            'type' => 'nullable|string|max:50',
            'status' => 'required|in:draft,pending,published,scheduled',
            'published_at' => 'nullable|required_if:status,scheduled|date',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:255',
        ]);

        if ($request->boolean('remove_image')) {
            if ($page->image && !str_starts_with($page->image, 'media/')) {
                Storage::disk('public')->delete($page->image);
            }
            $validated['image'] = null;
        } elseif ($request->hasFile('image')) {
            if ($page->image && !str_starts_with($page->image, 'media/')) {
                Storage::disk('public')->delete($page->image);
            }
            $optimized = ImageService::optimizeAndStore($request->file('image'), 'pages');
            $validated['image'] = $optimized['path'];
        } elseif ($request->filled('featured_image_path')) {
            $validated['image'] = $request->input('featured_image_path');
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = $validated['published_at'] ?: ($page->published_at ?: now());
        } elseif ($validated['status'] === 'scheduled') {
            // Keep provided published_at
        } else {
            $validated['published_at'] = null;
        }

        $page->update($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        if ($page->image && !str_starts_with($page->image, 'media/')) {
            Storage::disk('public')->delete($page->image);
        }

        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}
