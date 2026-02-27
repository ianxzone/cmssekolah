@extends('frontend.layouts.app')

@section('title', $page->title . ' - ' . config('app.name'))
@section('meta_description', $page->seo_description ?? Str::limit(strip_tags($page->content), 150))

@push('styles')
    <style>
        .page-header-bg {
            background: var(--primary-dark);
            padding: 60px 0;
            text-align: center;
            color: var(--white);
            margin-bottom: 40px;
        }

        .page-header-bg h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .page-header-bg .breadcrumb {
            color: var(--primary-light);
            font-size: 0.95rem;
        }

        .page-header-bg .breadcrumb a {
            color: var(--white);
            margin: 0 5px;
        }

        .layout-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto 60px;
            padding: 0 20px;
        }

        @media (max-width: 900px) {
            .layout-container {
                grid-template-columns: 1fr;
            }
        }

        /* MAIN CONTENT */
        .page-container {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .page-header {
            padding: 2.5rem 2.5rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background: #f8fafc;
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1.3;
            color: var(--primary-dark);
            margin-bottom: 0;
        }

        .page-content {
            padding: 2.5rem;
            font-size: 1.1rem;
            line-height: 1.8;
            color: #334155;
        }

        .page-content p {
            margin-bottom: 1.5rem;
        }

        .page-content h2,
        .page-content h3 {
            color: var(--primary-dark);
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .page-content h2 {
            font-size: 1.8rem;
            border-bottom: 2px solid var(--primary-light);
            display: inline-block;
            padding-bottom: 5px;
        }

        .page-content h3 {
            font-size: 1.4rem;
        }

        .page-content ul,
        .page-content ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }

        .page-content li {
            margin-bottom: 0.5rem;
        }

        .page-content img {
            max-width: 100%;
            height: auto;
            border-radius: var(--radius-md);
            margin: 2rem 0;
            box-shadow: var(--shadow-sm);
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

        @media (max-width: 768px) {

            .page-content,
            .page-header {
                padding: 1.5rem;
            }

            .page-title {
                font-size: 1.8rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-header-bg">
        <div class="container">
            <h1>Halaman Informasi</h1>
            <div class="breadcrumb">
                <a href="{{ route('home') }}">Beranda</a> / {{ Str::limit($page->title, 40) }}
            </div>
        </div>
    </div>

    <div class="layout-container">
        <!-- Main Content -->
        <main>
            <article class="page-container">
                <header class="page-header">
                    <h1 class="page-title">{{ $page->title }}</h1>
                </header>

                <div class="page-content trix-content">
                    {!! $page->content !!}
                </div>
            </article>
        </main>

        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Navigate Pages Widget -->
            <div class="sidebar-widget">
                <h3 class="sidebar-title"><i data-feather="file-text" style="width:18px;"></i> Informasi Lainnya</h3>
                <ul class="sidebar-list">
                    @php
                        $otherPages = \App\Models\Page::where('id', '!=', $page->id)
                            ->where('type', 'default')
                            ->orderBy('title')->get();
                    @endphp
                    @forelse($otherPages as $p)
                        <li>
                            <a href="{{ route('pages.show', $p->slug) }}">{{ $p->title }}</a>
                        </li>
                    @empty
                        <li>Belum ada halaman lain.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Recent Posts Widget -->
            <div class="sidebar-widget">
                <h3 class="sidebar-title"><i data-feather="clock" style="width:18px;"></i> Berita Terbaru</h3>
                <ul class="sidebar-list">
                    @php
                        $recentPosts = \App\Models\Post::whereNotNull('published_at')->where('published_at', '<=', now())
                            ->latest('published_at')->take(4)->get();
                    @endphp
                    @forelse($recentPosts as $recent)
                        <li>
                            <a href="{{ route('posts.show', $recent->slug) }}">{{ $recent->title }}</a>
                            <div class="sidebar-meta">
                                <i data-feather="calendar" style="width:12px;"></i> {{ $recent->published_at->format('d M Y') }}
                            </div>
                        </li>
                    @empty
                        <li>Belum ada berita.</li>
                    @endforelse
                </ul>
            </div>

            <!-- SPMB Banner Widget -->
            <div class="sidebar-widget"
                style="background: var(--primary); color: white; text-align: center; padding: 30px 20px;">
                <h3 style="color: white; font-weight: 800; font-size: 1.4rem; margin-bottom: 10px;">PPDB Dibuka!</h3>
                <p style="font-size: 0.9rem; margin-bottom: 20px; opacity: 0.9;">Daftarkan putra-putri Anda sekarang juga.
                </p>
                <a href="{{ \App\Models\Setting::value('contact_ppdb_link') ?? '#' }}" class="btn"
                    style="background: white; color: var(--primary); padding: 10px 20px; font-weight: 700; width: 100%;">Info
                    Selengkapnya</a>
            </div>
        </aside>
    </div>
@endsection