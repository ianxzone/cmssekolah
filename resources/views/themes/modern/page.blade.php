@extends('theme::layouts.app')

@section('title', $page->title . ' - ' . config('app.name'))
@section('meta_description', $page->seo_description ?? Str::limit(strip_tags($page->content), 150))

@push('styles')
    <style>
        .layout-container {
            max-width: 900px;
            margin: -60px auto 60px;
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }

        /* MAIN CONTENT */
        .page-container {
            background: var(--bg-surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .page-header {
            padding: 2.5rem 2.5rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-light);
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
            color: var(--text-main);
        }

        .page-content p,
        .page-content ul,
        .page-content ol,
        .page-content li {
            margin-bottom: 1.5rem;
            color: inherit;
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
            <h1>Halaman Informasi</h1>
            <div class="subpage-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <i data-feather="chevron-right" style="width: 14px;"></i>
                <span>{{ Str::limit($page->title, 40) }}</span>
            </div>
        </div>
    </section>
@endsection

@section('content')
    {{-- Old page-header-bg removed --}}

    <div class="layout-container">
        <!-- Main Content -->
        <div class="page-column">
            <article class="page-container">
                <header class="page-header">
                    <h1 class="page-title">{{ $page->title }}</h1>
                </header>

                <div class="page-content trix-content">
                    {!! \App\Helpers\ShortcodeHelper::parse($page->content) !!}
                </div>
            </article>
        </div>
    </div>
@endsection