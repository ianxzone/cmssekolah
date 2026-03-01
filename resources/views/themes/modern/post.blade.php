@extends('theme::layouts.app')

@section('title', $post->title . ' - ' . config('app.name'))
@section('meta_description', $post->description ?? Str::limit(strip_tags($post->content), 150))

@push('styles')
    <style>
        .layout-container {
            max-width: 900px;
            /* Narrower for readability */
            margin: -60px auto 60px;
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }

        /* MAIN CONTENT */
        .article-container {
            background: var(--bg-surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .article-header {
            padding: 2.5rem 2.5rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .article-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }

        .article-category {
            color: var(--primary-color);
            font-weight: 600;
            background: var(--bg-light);
            border: 1px solid var(--primary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
        }

        .article-title {
            font-size: 2.2rem;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .article-subtitle {
            font-size: 1.15rem;
            color: var(--text-secondary);
            font-weight: 400;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .article-thumbnail {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            background-color: var(--bg-body);
        }

        .article-content {
            padding: 2.5rem;
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-main);
        }

        .article-content p,
        .article-content ul,
        .article-content ol,
        .article-content li {
            margin-bottom: 1.5rem;
            color: inherit;
        }

        .article-content h2,
        .article-content h3 {
            color: var(--text-primary);
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .article-content h2 {
            font-size: 1.8rem;
            border-bottom: 2px solid var(--primary-light);
            display: inline-block;
            padding-bottom: 5px;
        }

        .article-content h3 {
            font-size: 1.4rem;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: var(--radius-md);
            margin: 2rem 0;
            box-shadow: var(--shadow-sm);
        }

        .article-content blockquote {
            border-left: 4px solid var(--primary-color);
            margin: 2rem 0;
            font-style: italic;
            color: var(--text-secondary);
            background: var(--bg-light);
            padding: 1.5rem;
            border-radius: var(--radius-md);
        }

        .category-badge:hover {
            background: var(--primary);
            color: var(--white);
        }

        @media (max-width: 768px) {

            .article-content,
            .article-header {
                padding: 1.5rem;
            }

            .article-title {
                font-size: 1.8rem;
            }
        }
    </style>
@endpush

@section('hero')
    @php
        $heroBg = $post->image ? Storage::url($post->image) : ($settings['hero_bg_image'] ?? 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&q=80&w=1920');
        if (!Str::startsWith($heroBg, ['http://', 'https://', 'data:', '/storage'])) {
            $heroBg = Storage::url($heroBg);
        }
    @endphp
    <section class="subpage-hero"
        style="background-image: url('{{ $heroBg }}'); min-height: 60vh; display: flex; align-items: center; justify-content: center; text-align: center; position: relative;">
        <!-- Gradient overlay to ensure text is always readable over any image -->
        <div class="subpage-hero-overlay"
            style="background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.85)); position: absolute; inset: 0;">
        </div>

        <div class="container" style="position: relative; z-index: 2; max-width: 900px; padding-top: 60px;">
            @if($post->category)
                <a href="{{ route('categories.show', $post->category->slug) }}"
                    style="background: var(--primary); color: white; padding: 6px 20px; border-radius: 50px; font-weight: 700; font-size: 0.85rem; margin-bottom: 25px; display: inline-block; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
                    {{ $post->category->name }}
                </a>
            @endif
            <h1
                style="font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 800; line-height: 1.2; margin-bottom: 25px; text-shadow: 0 2px 10px rgba(0,0,0,0.5);">
                {{ $post->title }}
            </h1>

            <div
                style="color: rgba(255,255,255,0.9); font-size: 1.1rem; display: flex; align-items: center; justify-content: center; gap: 25px; font-weight: 500;">
                <span style="display: flex; align-items: center; gap: 8px;">
                    <i data-feather="calendar" style="width:18px;"></i>
                    {{ $post->published_at ? $post->published_at->format('d M Y') : '' }}
                </span>
                <span style="display: flex; align-items: center; gap: 8px;">
                    <i data-feather="user" style="width:18px;"></i> Administrator
                </span>
                <span style="display: flex; align-items: center; gap: 8px;">
                    <i data-feather="clock" style="width:18px;"></i>
                    {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read
                </span>
            </div>
        </div>
    </section>
@endsection

@section('content')
    {{-- Old page-header-bg removed --}}

    <div class="layout-container">
        <!-- Main Content -->
        <div class="article-column">
            <article class="article-container"
                style="border: none; margin-top: -80px; position: relative; z-index: 10; box-shadow: var(--shadow-xl, 0 25px 50px -12px rgba(0, 0, 0, 0.25)); padding-top: 1rem;">

                @if($post->subtitle)
                    <div style="padding: 2.5rem 2.5rem 0; text-align: center;">
                        <p class="article-subtitle"
                            style="font-size: 1.25rem; font-weight: 500; color: var(--text-muted); font-style: italic;">
                            "{{ $post->subtitle }}"
                        </p>
                    </div>
                @endif

                <div class="article-content trix-content">
                    {!! \App\Helpers\ShortcodeHelper::parse($post->content) !!}
                </div>
            </article>
        </div>
    </div>
@endsection