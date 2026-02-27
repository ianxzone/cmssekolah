@extends('admin.layouts.app')

@section('title', 'Manage Posts')

@push('styles')
<style>
    .filter-bar { display: flex; gap: 1rem; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .search-input { padding: 0.625rem 1rem; border: 1px solid var(--border-color); border-radius: 8px; width: 300px; max-width: 100%; transition: border-color 0.15s ease; }
    .search-input:focus { outline: none; border-color: var(--primary-color); }
    .filter-select { padding: 0.625rem 1rem; border: 1px solid var(--border-color); border-radius: 8px; background-color: white; }
    .thumbnail { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; background-color: var(--bg-body); }
    .post-title { font-weight: 600; font-size: 0.875rem; color: var(--text-primary); margin-bottom: 0.25rem; }
    .post-category { font-size: 0.75rem; color: var(--primary-color); background-color: rgba(79, 70, 229, 0.1); padding: 0.2rem 0.5rem; border-radius: 4px; display: inline-block; }
</style>
@endpush

@section('content')
<div class="panel">
    <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <h2 class="panel-title">All Posts</h2>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
            <i data-feather="plus"></i> Create Post
        </a>
    </div>
    <div class="panel-body">
        <form method="GET" action="{{ route('admin.posts.index') }}" class="filter-bar">
            <div style="display: flex; gap: 1rem;">
                <input type="text" name="search" class="search-input" placeholder="Search by title..." value="{{ request('search') }}">
                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            @if(request()->has('search') || request()->has('status'))
                <a href="{{ route('admin.posts.index') }}" style="color: var(--text-secondary); font-size: 0.875rem; text-decoration: underline;">Clear Filters</a>
            @endif
        </form>

        @if($posts->count() > 0)
            <div class="table-responsive">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border-color);">
                            <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Post</th>
                            <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Category</th>
                            <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Status</th>
                            <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Date</th>
                            <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.15s ease;" onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor='transparent'">
                                <td style="padding: 1rem; display: flex; align-items: center; gap: 1rem;">
                                    @if($post->image)
                                        <img src="{{ Storage::url($post->image) }}" class="thumbnail" alt="Thumb">
                                    @else
                                        <div class="thumbnail" style="display:flex;align-items:center;justify-content:center;color:var(--text-secondary);">
                                            <i data-feather="image"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="post-title">{{ $post->title }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-secondary);">/berita/{{ $post->slug }}</div>
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    @if($post->category)
                                        <span class="post-category">{{ $post->category->name }}</span>
                                    @else
                                        <span style="color: var(--text-secondary); font-size: 0.75rem;">None</span>
                                    @endif
                                </td>
                                <td style="padding: 1rem;">
                                    @if($post->published_at)
                                        @if($post->published_at->isPast())
                                            <span style="background-color: rgba(16, 185, 129, 0.1); color: var(--success-color); padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Published</span>
                                        @else
                                            <span style="background-color: rgba(59, 130, 246, 0.1); color: #3b82f6; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Scheduled</span>
                                        @endif
                                    @else
                                        <span style="background-color: rgba(245, 158, 11, 0.1); color: var(--warning-color); padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Draft</span>
                                    @endif
                                </td>
                                <td style="padding: 1rem; font-size: 0.875rem; color: var(--text-secondary);">
                                    @if($post->published_at)
                                        {{ $post->published_at->format('M d, Y') }}
                                    @else
                                        Last updated:<br>
                                        {{ $post->updated_at->format('M d, Y') }}
                                    @endif
                                </td>
                                <td style="padding: 1rem; text-align: right;">
                                    <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                        <a href="{{ route('posts.show', $post->slug) }}" target="_blank" style="padding: 0.5rem; color: var(--text-secondary); border-radius: 6px;" title="View Live">
                                            <i data-feather="external-link" style="width: 18px; height: 18px;"></i>
                                        </a>
                                        <a href="{{ route('admin.posts.edit', $post) }}" style="padding: 0.5rem; color: var(--primary-color); background-color: rgba(79, 70, 229, 0.1); border-radius: 6px;" title="Edit">
                                            <i data-feather="edit-2" style="width: 18px; height: 18px;"></i>
                                        </a>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="padding: 0.5rem; color: var(--danger-color); background-color: rgba(239, 68, 68, 0.1); border: none; border-radius: 6px; cursor: pointer;" title="Delete">
                                                <i data-feather="trash-2" style="width: 18px; height: 18px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div style="margin-top: 2rem;">
                {{ $posts->withQueryString()->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 4rem 1rem;">
                <div style="color: var(--text-secondary); margin-bottom: 1rem;">
                    <i data-feather="edit-3" style="width: 48px; height: 48px; opacity: 0.5;"></i>
                </div>
                <h3 style="font-size: 1.125rem; font-weight: 500; color: var(--text-primary); margin-bottom: 0.5rem;">No posts found</h3>
                <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Get started by writing your first article.</p>
                @if(request()->has('search') || request()->has('status'))
                    <a href="{{ route('admin.posts.index') }}" class="btn" style="background-color: var(--bg-body); border-color: var(--border-color);">
                        Clear Filters
                    </a>
                @else
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                        <i data-feather="plus"></i> Create Post
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
