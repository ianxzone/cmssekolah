@extends('frontend.layouts.app')

@section('title', $post->title . ' - ' . config('app.name'))
@section('meta_description', $post->description ?? Str::limit(strip_tags($post->content), 150))

@push('styles')
    <style>
        .layout-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
            max-width: 1200px;
            margin: -60px auto 60px;
            padding: 0 20px;
            position: relative;
            z-index: 10;
            align-items: start;
        }

        @media (max-width: 900px) {
            .layout-container {
                grid-template-columns: 1fr;
            }
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
            border-radius: 0 var(--radius-md) var(--radius-md) 0;
        }

        /* SIDEBAR */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .sidebar-widget {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 25px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .sidebar-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-list li {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed var(--border-color);
        }

        .sidebar-list li:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .sidebar-list a {
            color: var(--text-main);
            font-weight: 500;
            display: block;
            line-height: 1.4;
            transition: color 0.2s;
        }

        .sidebar-list a:hover {
            color: var(--primary);
        }

        .sidebar-meta {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .category-badge {
            display: inline-block;
            padding: 5px 15px;
            background: var(--bg-light);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-right: 5px;
            margin-bottom: 10px;
            transition: all 0.2s;
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
        $heroBg = $settings['hero_bg_image'] ?? 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&q=80&w=1920';
        if (!Str::startsWith($heroBg, ['http://', 'https://', 'data:'])) {
            $heroBg = Storage::url($heroBg);
        }
    @endphp
    <section class="subpage-hero" style="background-image: url('{{ $heroBg }}');">
        <div class="subpage-hero-overlay"></div>
        <div class="container">
            <h1>Berita & Artikel</h1>
            <div class="subpage-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <i data-feather="chevron-right" style="width: 14px;"></i>
                <a href="{{ route('posts.index') }}">Berita</a>
                <i data-feather="chevron-right" style="width: 14px;"></i>
                <span>Detail</span>
            </div>
        </div>
    </section>
@endsection

@section('content')
    {{-- Old page-header-bg removed --}}

    <div class="layout-container">
        <!-- Main Content -->
        <div class="article-column">
            <article class="article-container">
                @if($post->image)
                    <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="article-thumbnail">
                @endif

                <header class="article-header">
                    <h1 class="article-title">{{ $post->title }}</h1>
                    @if($post->subtitle)
                        <p class="article-subtitle">{{ $post->subtitle }}</p>
                    @endif
                    <div class="article-meta">
                        @if($post->category)
                            <a href="{{ route('categories.show', $post->category->slug) }}" class="article-category">
                                {{ $post->category->name }}
                            </a>
                        @endif
                        <span style="display:flex; align-items:center; gap:5px;">
                            <i data-feather="calendar" style="width:14px;"></i>
                            {{ $post->published_at ? $post->published_at->format('d M Y') : '' }}
                        </span>
                        <span style="display:flex; align-items:center; gap:5px;">
                            <i data-feather="user" style="width:14px;"></i> Admin
                        </span>
                    </div>
                </header>

                <div class="article-content trix-content">
                    {!! $post->content !!}
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- SPMB Banner Widget -->
            <div class="sidebar-widget"
                style="background: var(--primary); color: white; text-align: center; padding: 30px 20px;">
                <h3 style="color: white; font-weight: 800; font-size: 1.4rem; margin-bottom: 10px;">
                    {{ $settings['sidebar_ppdb_title'] ?? 'PPDB Dibuka!' }}</h3>
                <p style="font-size: 0.9rem; margin-bottom: 20px; opacity: 0.9;">
                    {{ $settings['sidebar_ppdb_desc'] ?? 'Daftarkan putra-putri Anda sekarang juga.' }}
                </p>
                <a href="{{ $settings['contact_ppdb_link'] ?? '#' }}" class="btn"
                    style="background: white; color: var(--primary); padding: 10px 20px; font-weight: 700; width: 100%;">{{ $settings['sidebar_ppdb_btn_text'] ?? 'Info Selengkapnya' }}</a>
            </div>

            <!-- Recent Posts Widget -->
            <div class="sidebar-widget">
                <h3 class="sidebar-title"><i data-feather="clock" style="width:18px;"></i> Berita Terbaru</h3>
                <ul class="sidebar-list">
                    @php
                        $recentPosts = \App\Models\Post::where('id', '!=', $post->id)
                            ->whereNotNull('published_at')->where('published_at', '<=', now())
                            ->latest('published_at')->take(5)->get();
                    @endphp
                    @forelse($recentPosts as $recent)
                        <li>
                            <a href="{{ route('posts.show', $recent->slug) }}">{{ $recent->title }}</a>
                            <div class="sidebar-meta">
                                <i data-feather="calendar" style="width:12px;"></i> {{ $recent->published_at->format('d M Y') }}
                            </div>
                        </li>
                    @empty
                        <li>Belum ada berita lain.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Categories Widget -->
            <div class="sidebar-widget">
                <h3 class="sidebar-title"><i data-feather="folder" style="width:18px;"></i> Kategori</h3>
                <div class="sidebar-categories">
                    @php
                        $categories = \App\Models\Category::withCount('posts')->orderBy('name')->get();
                    @endphp
                    @foreach($categories as $category)
                        <a href="{{ route('categories.show', $category->slug) }}" class="category-badge">
                            {{ $category->name }} ({{ $category->posts_count }})
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
@endsection