@extends('frontend.layouts.app')

@section('title', 'Berita & Artikel - ' . ($settings['school_name'] ?? config('app.name')))
@section('meta_description', 'Baca berita, artikel, dan pembaruan terkini dari ' . ($settings['school_name'] ?? config('app.name')))

@push('styles')
    <style>
        .news-archive {
            padding: 0 20px 80px;
            margin: -60px auto 0;
            max-width: 1200px;
            position: relative;
            z-index: 10;
        }

        .page-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .page-header span {
            color: var(--primary-color);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
            display: block;
            margin-bottom: 10px;
        }

        .page-header h1 {
            font-size: 2.5rem;
            color: var(--text-primary);
            font-weight: 800;
        }

        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }

        .news-card {
            background: var(--bg-surface);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .news-img {
            height: 220px;
            overflow: hidden;
            position: relative;
        }

        .news-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .news-card:hover .news-img img {
            transform: scale(1.05);
        }

        .news-content {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .news-meta {
            font-size: 0.8rem;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            gap: 15px;
            opacity: 0.8;
        }

        .news-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .news-content h3 {
            font-size: 1.25rem;
            margin-bottom: 12px;
            line-height: 1.4;
            color: var(--text-primary);
            font-weight: 700;
        }

        .news-content h3 a:hover {
            color: var(--primary-color);
        }

        .news-content p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-bottom: 20px;
            flex-grow: 1;
            line-height: 1.6;
        }

        .news-link {
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: auto;
            font-size: 0.95rem;
        }

        .news-link i {
            width: 16px;
            transition: transform 0.2s ease;
        }

        .news-link:hover i {
            transform: translateX(3px);
        }

        .pagination-wrapper {
            margin-top: 60px;
            display: flex;
            justify-content: center;
        }

        .empty-state {
            text-align: center;
            padding: 100px 20px;
            color: var(--text-secondary);
            background: var(--bg-surface);
            border-radius: var(--radius-lg);
            border: 1px dashed var(--border-color);
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
            <h1>Berita & Artikel Terkini</h1>
            <div class="subpage-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <i data-feather="chevron-right" style="width: 14px;"></i>
                <span>Berita</span>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <div class="news-archive">
        {{-- Removed old page-header as it's now in hero --}}

        @if($posts->count() > 0)
            <div class="news-grid">
                @foreach($posts as $post)
                    <article class="news-card">
                        <div class="news-img">
                            @php
                                $fallbackImg = 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?auto=format&fit=crop&q=80&w=800';
                                $imgUrl = $post->image ? Storage::url($post->image) : $fallbackImg;
                            @endphp
                            <img src="{{ $imgUrl }}" alt="{{ $post->title }}" onerror="this.src='{{ $fallbackImg }}'">
                        </div>
                        <div class="news-content">
                            <div class="news-meta">
                                <span><i data-feather="calendar"></i>
                                    {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                                @if($post->category)
                                    <span><i data-feather="tag"></i> {{ $post->category->name }}</span>
                                @endif
                            </div>
                            <h3>
                                <a href="{{ route('posts.show', $post->slug) }}" style="color: inherit;">{{ $post->title }}</a>
                            </h3>
                            <p>{{ Str::limit(strip_tags($post->content), 120) }}</p>
                            <a href="{{ route('posts.show', $post->slug) }}" class="news-link">
                                Selengkapnya <i data-feather="arrow-right"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $posts->links('frontend.layouts.pagination') }}
            </div>
        @else
            <div class="empty-state">
                <i data-feather="book-open" style="width: 48px; height: 48px; opacity: 0.3; margin-bottom: 20px;"></i>
                <h3>Belum ada berita dipublikasikan</h3>
                <p>Silakan kembali lagi nanti untuk informasi terbaru.</p>
            </div>
        @endif
    </div>
@endsection