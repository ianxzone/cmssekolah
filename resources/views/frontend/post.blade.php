@extends('frontend.layouts.app')

@section('title', $post->title . ' - ' . config('app.name'))
@section('meta_description', $post->description ?? Str::limit(strip_tags($post->content), 150))

@push('styles')
    <style>
        .article-container {
            max-width: 800px;
            margin: 0 auto;
            background: var(--bg-surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .article-header {
            padding: 3rem 2rem 2rem;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
        }

        .article-meta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }

        .article-category {
            color: var(--primary-color);
            font-weight: 600;
            background: #e0e7ff;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
        }

        .article-title {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .article-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            font-weight: 400;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .article-thumbnail {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            background-color: var(--bg-body);
        }

        .article-content {
            padding: 3rem 4rem;
            font-size: 1.125rem;
            line-height: 1.8;
            color: #374151;
        }

        /* Typography inside article content */
        .article-content p {
            margin-bottom: 1.5rem;
        }

        .article-content h2,
        .article-content h3 {
            color: var(--text-primary);
            font-weight: 700;
            margin-top: 2.5rem;
            margin-bottom: 1rem;
        }

        .article-content h2 {
            font-size: 1.875rem;
        }

        .article-content h3 {
            font-size: 1.5rem;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: var(--radius-md);
            margin: 2rem 0;
        }

        .article-content blockquote {
            border-left: 4px solid var(--primary-color);
            padding-left: 1.5rem;
            margin: 2rem 0;
            font-style: italic;
            color: var(--text-secondary);
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 0 var(--radius-md) var(--radius-md) 0;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .article-content {
                padding: 2rem 1.5rem;
            }

            .article-title {
                font-size: 2rem;
            }
        }
    </style>
@endpush

@section('content')
    <div style="max-width: 800px; margin: 0 auto;">
        <a href="{{ route('home') }}" class="back-link">
            <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i> Back to Articles
        </a>
    </div>

    <article class="article-container">
        <header class="article-header">
            <div class="article-meta">
                @if($post->category)
                    <a href="{{ route('categories.show', $post->category->slug) }}" class="article-category">
                        {{ $post->category->name }}
                    </a>
                @endif
                <span style="display: flex; align-items: center; gap: 0.25rem;">
                    <i data-feather="calendar" style="width: 14px; height: 14px;"></i>
                    {{ $post->published_at ? $post->published_at->format('F d, Y') : '' }}
                </span>
            </div>
            <h1 class="article-title">{{ $post->title }}</h1>
            @if($post->subtitle)
                <p class="article-subtitle">{{ $post->subtitle }}</p>
            @endif
        </header>

        @if($post->image)
            <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="article-thumbnail">
        @endif

        <div class="article-content">
            {!! $post->content !!}
        </div>
    </article>
@endsection