<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['category', 'author']);

        // Filtering by status
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'published') {
                $query->whereNotNull('published_at')->where('published_at', '<=', now());
            } elseif ($request->status === 'scheduled') {
                $query->whereNotNull('published_at')->where('published_at', '>', now());
            } elseif ($request->status === 'draft') {
                $query->whereNull('published_at');
            }
        }

        // Searching by title
        if ($request->has('search') && $request->search !== '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $posts = $query->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $authors = User::orderBy('name')->get();
        return view('admin.posts.create', compact('categories', 'authors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'nullable|exists:users,id',
            'content' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'featured_image_path' => 'nullable|string|max:500',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|required_if:status,scheduled|date',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Determine author: Admin/Editor can assign to any user; otherwise fallback to current user
        $currentUser = auth()->user() ?? User::find(1);
        if ($currentUser && $currentUser->canChangeAuthor() && $request->filled('user_id')) {
            $validated['user_id'] = (int) $request->input('user_id');
        } else {
            $validated['user_id'] = $currentUser ? $currentUser->id : 1;
        }

        if ($request->hasFile('image')) {
            $optimized = ImageService::optimizeAndStore($request->file('image'), 'posts');
            $validated['image'] = $optimized['path'];
        } elseif ($request->filled('featured_image_path')) {
            $validated['image'] = $request->input('featured_image_path');
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        } elseif ($validated['status'] === 'draft') {
            $validated['published_at'] = null;
        }
        // If scheduled, the published_at from the request is used

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $authors = User::orderBy('name')->get();
        return view('admin.posts.edit', compact('post', 'categories', 'authors'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $post->id,
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'nullable|exists:users,id',
            'content' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'featured_image_path' => 'nullable|string|max:500',
            'remove_image' => 'nullable|boolean',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|required_if:status,scheduled|date',
        ]);

        // Determine author update: Admin/Editor can switch author; others cannot
        $currentUser = auth()->user() ?? User::find(1);
        if ($currentUser && $currentUser->canChangeAuthor() && $request->filled('user_id')) {
            $validated['user_id'] = (int) $request->input('user_id');
        } else {
            // Keep existing author if user cannot change author
            unset($validated['user_id']);
        }

        if ($request->boolean('remove_image')) {
            if ($post->image && !str_starts_with($post->image, 'media/')) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = null;
        } elseif ($request->hasFile('image')) {
            if ($post->image && !str_starts_with($post->image, 'media/')) {
                Storage::disk('public')->delete($post->image);
            }
            $optimized = ImageService::optimizeAndStore($request->file('image'), 'posts');
            $validated['image'] = $optimized['path'];
        } elseif ($request->filled('featured_image_path')) {
            $validated['image'] = $request->input('featured_image_path');
        }

        if ($validated['status'] === 'published') {
            // Only update published_at to now if it wasn't already published
            if (!$post->published_at || $post->published_at->isFuture()) {
                $validated['published_at'] = now();
            }
        } elseif ($validated['status'] === 'draft') {
            $validated['published_at'] = null;
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }
}
