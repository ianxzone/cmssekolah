@extends('frontend.layouts.app')

@section('title', 'Latest Blog Posts & Updates - ' . config('app.name'))
@section('meta_description', 'Read the latest news, articles, and updates from our platform.')

@push('styles')
    <style>
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: var(--text-secondary);
            font-size: 1.125rem;
        }

        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }

        .post-card {
            background: var(--bg-surface);
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid var(--border-color);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .post-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .post-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background-color: var(--border-color);
            /* fallback */
        }

        .post-content {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .post-meta {
            font-size: 0.875rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }

        .post-category {
            font-weight: 600;
            color: var(--primary-color);
        }

        .post-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .post-excerpt {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
            flex-grow: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .read-more {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            color: var(--primary-color);
            transition: gap 0.2s ease;
        }

        .read-more:hover {
            gap: 0.75rem;
            /* arrow slides right */
        }

        .pagination-wrapper {
            margin-top: 3rem;
            display: flex;
            justify-content: center;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
            color: var(--text-secondary);
            background: var(--bg-surface);
            border-radius: var(--radius-lg);
            border: 1px dashed var(--border-color);
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1>Latest Updates</h1>
        <p>Discover our newest articles and announcements.</p>
    </div>

    @if($posts->count() > 0)
        <div class="posts-grid">
            @foreach($posts as $post)
                <article class="post-card">
                    @if($post->image)
                        <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="post-image" loading="lazy">
                    @endif
                    <div class="post-content">
                        <div class="post-meta">
                            @if($post->category)
                                <a href="{{ route('categories.show', $post->category->slug) }}"
                                    class="post-category">{{ $post->category->name }}</a>
                            @else
                                <span>Uncategorized</span>
                            @endif
                            <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : '' }}</span>
                        </div>
                        <h2 class="post-title">
                            <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                        </h2>

                        <a href="{{ route('posts.show', $post->slug) }}" class="read-more">
                            Read Article <i data-feather="arrow-right" style="width: 16px; height: 16px;"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $posts->links() }}
        </div>
    @else
        <div class="empty-state">
            <i data-feather="book-open" style="width: 48px; height: 48px; opacity: 0.5; margin-bottom: 1rem;"></i>
            <h3>No posts published yet</h3>
            <p>Check back later for exciting updates.</p>
        </div>
    @endif
@endsection