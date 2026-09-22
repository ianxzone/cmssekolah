@extends('frontend.layouts.app')

@section('title', $post->title . ' - ' . config('app.name'))
@section('meta_description', $post->description ?? Str::limit(strip_tags($post->content), 150))
@if($post->image)
@section('meta_image', $post->image_url)
@endif
@section('meta_type', 'article')

@push('styles')
    <style>
        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.88rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
            margin-bottom: 2.25rem;
            flex-wrap: wrap;
        }

        .breadcrumb a {
            color: var(--primary);
            font-weight: 600;
        }

        .breadcrumb a:hover {
            color: var(--primary-dark);
        }

        .breadcrumb .separator {
            color: #cbd5e1;
        }

        .breadcrumb .current {
            color: var(--text-main);
            font-weight: 600;
        }

        /* Jadwal Sholat Widget Bar */
        .single-prayer-bar {
            margin-bottom: 2rem;
        }

        .single-prayer-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            display: grid;
            grid-template-columns: 270px 1fr;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            transition: var(--transition);
        }

        .single-prayer-card:hover {
            box-shadow: var(--shadow-md);
            border-color: #cbd5e1;
        }

        .single-prayer-left {
            background: linear-gradient(135deg, #065f46 0%, #047857 100%);
            color: var(--white);
            padding: 16px 22px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .single-prayer-left .badge-title {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.85);
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 4px;
        }

        .single-prayer-left .next-prayer-row {
            display: flex;
            align-items: baseline;
            gap: 8px;
        }

        .single-prayer-left .next-prayer {
            font-size: 1.35rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
        }

        .single-prayer-left .next-time {
            font-size: 1.05rem;
            font-weight: 700;
            color: #fbbf24;
        }

        .single-prayer-left .prayer-location {
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.75);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .single-prayer-right {
            padding: 14px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            gap: 8px;
        }

        .single-prayer-item {
            text-align: center;
            padding: 6px 14px;
            border-radius: 10px;
            transition: var(--transition);
            flex: 1;
        }

        .single-prayer-item.active {
            background: #ecfdf5;
            border: 1.5px solid #10b981;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15);
        }

        .single-prayer-item span {
            display: block;
            font-size: 0.74rem;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .single-prayer-item strong {
            font-size: 1.08rem;
            color: #1e293b;
            font-weight: 800;
            display: block;
        }

        .single-prayer-item.active strong {
            color: #065f46;
        }

        .single-prayer-item.active span {
            color: #059669;
        }

        @media (max-width: 860px) {
            .single-prayer-card {
                grid-template-columns: 1fr;
            }
            .single-prayer-left {
                padding: 14px 18px;
                text-align: center;
                align-items: center;
            }
            .single-prayer-right {
                padding: 12px 10px;
                overflow-x: auto;
            }
            .single-prayer-item {
                padding: 6px 8px;
                min-width: 54px;
            }
            .single-prayer-item strong {
                font-size: 0.92rem;
            }
        }

        /* Post Layout */
        .post-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 2.5rem;
            align-items: start;
            margin-bottom: 3.5rem;
        }

        /* Main Article */
        .article-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .article-thumbnail {
            width: 100%;
            max-height: 460px;
            object-fit: cover;
            display: block;
        }

        .article-body {
            padding: 2.5rem;
        }

        .article-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .article-category-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ecfdf5;
            color: var(--primary);
            font-weight: 700;
            font-size: 0.82rem;
            padding: 6px 14px;
            border-radius: 50px;
            border: 1px solid #a7f3d0;
            transition: var(--transition);
        }

        .article-category-badge:hover {
            background: var(--primary);
            color: var(--white);
        }

        .article-date {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
            font-size: 0.88rem;
            font-weight: 500;
        }

        .article-title {
            font-size: 2.15rem;
            font-weight: 800;
            line-height: 1.25;
            color: var(--primary-dark);
            margin-bottom: 0.75rem;
        }

        .article-subtitle {
            font-size: 1.15rem;
            color: var(--text-muted);
            font-weight: 400;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .article-divider {
            border: none;
            border-top: 1px solid var(--border-color);
            margin: 0 0 2rem;
        }

        /* Article Content Typography */
        .article-content {
            font-size: 1.05rem;
            line-height: 1.85;
            color: #374151;
        }

        .article-content p {
            margin-bottom: 1.25rem;
        }

        .article-content h2,
        .article-content h3 {
            color: var(--primary-dark);
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 0.75rem;
        }

        .article-content h2 {
            font-size: 1.6rem;
        }

        .article-content h3 {
            font-size: 1.3rem;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: var(--radius-md);
            margin: 1.5rem 0;
        }

        .article-content blockquote {
            border-left: 4px solid var(--primary);
            padding: 1.25rem 1.5rem;
            margin: 1.5rem 0;
            font-style: italic;
            color: var(--text-muted);
            background: #f0fdf4;
            border-radius: 0 var(--radius-md) var(--radius-md) 0;
        }

        .article-content ul,
        .article-content ol {
            padding-left: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .article-content li {
            margin-bottom: 0.5rem;
        }

        .article-content a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: underline;
        }

        .article-content a:hover {
            color: var(--primary-dark);
        }

        /* Share Section (Icon Only) */
        .share-section {
            margin-top: 2.5rem;
            padding-top: 1.75rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .share-label {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .share-buttons {
            display: flex;
            gap: 0.6rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .share-icon-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
            background: var(--white);
            color: var(--text-main);
            cursor: pointer;
            transition: all 0.25s ease;
            text-decoration: none;
        }

        .share-icon-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            color: #ffffff !important;
        }

        .share-icon-btn.whatsapp:hover { background: #25D366; border-color: #25D366; }
        .share-icon-btn.facebook:hover { background: #1877F2; border-color: #1877F2; }
        .share-icon-btn.twitter:hover { background: #000000; border-color: #000000; }
        .share-icon-btn.telegram:hover { background: #24A1DE; border-color: #24A1DE; }
        .share-icon-btn.sms:hover { background: #10b981; border-color: #10b981; }
        .share-icon-btn.tiktok:hover { background: #010101; border-color: #010101; }
        .share-icon-btn.copy:hover { background: var(--primary); border-color: var(--primary); }

        /* ====== COMMENTS SECTION ====== */
        .comments-container {
            margin-top: 2.5rem;
            background: var(--white);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
            padding: 2.25rem 2.5rem;
            box-shadow: var(--shadow-sm);
        }

        .comments-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #ecfdf5;
        }

        .comments-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-toggle-comment {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.88rem;
            background: #ecfdf5;
            color: var(--primary);
            border: 1px solid #a7f3d0;
            cursor: pointer;
            transition: var(--transition);
            font-family: inherit;
        }

        .btn-toggle-comment:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
            transform: translateY(-1px);
        }

        /* Collapsible Form */
        .comment-form-wrapper {
            display: none;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 1.75rem;
            margin-bottom: 2rem;
            animation: fadeIn 0.3s ease;
        }

        .comment-form-wrapper.active {
            display: block;
        }

        .comment-form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .comment-input-group label {
            display: block;
            font-size: 0.84rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.35rem;
        }

        .comment-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.9rem;
            outline: none;
            transition: var(--transition);
            background: var(--white);
            box-sizing: border-box;
        }

        .comment-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(6, 95, 70, 0.12);
        }

        .btn-submit-comment {
            background: var(--primary);
            color: var(--white);
            border: none;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: inherit;
        }

        .btn-submit-comment:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* Comment Item Card */
        .comment-item {
            display: flex;
            gap: 14px;
            padding: 1.25rem 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .comment-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .comment-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #065f46, #10b981);
            color: #ffffff;
            font-weight: 800;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 2px solid #ecfdf5;
        }

        .comment-content-box {
            flex: 1;
            min-width: 0;
        }

        .comment-author-name {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-main);
            margin-bottom: 2px;
        }

        .comment-date {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .comment-body-text {
            font-size: 0.95rem;
            line-height: 1.6;
            color: #374151;
            white-space: pre-line;
        }

        /* ====== SIDEBAR ====== */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .sidebar-widget {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
        }

        .widget-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #ecfdf5;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .widget-title i {
            color: var(--primary-light);
        }

        /* Recent Posts Widget */
        .recent-post-item {
            display: flex;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
            transition: var(--transition);
        }

        .recent-post-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .recent-post-item:first-child {
            padding-top: 0;
        }

        .recent-post-thumb {
            width: 72px;
            height: 56px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
            background: #f1f5f9;
        }

        .recent-post-info {
            flex: 1;
            min-width: 0;
        }

        .recent-post-info h4 {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.35;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .recent-post-info h4 a:hover {
            color: var(--primary);
        }

        .recent-post-info span {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Categories Widget */
        .category-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .category-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--primary);
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            transition: var(--transition);
        }

        .category-pill:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }

        .category-count {
            background: rgba(6, 95, 70, 0.12);
            padding: 1px 7px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .category-pill:hover .category-count {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Agenda Widget */
        .agenda-mini-card {
            display: flex;
            gap: 14px;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
            align-items: center;
        }

        .agenda-mini-card:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .agenda-mini-card:first-child {
            padding-top: 0;
        }

        .agenda-mini-date {
            background: var(--primary);
            color: var(--white);
            padding: 8px 10px;
            border-radius: 10px;
            text-align: center;
            min-width: 54px;
            flex-shrink: 0;
        }

        .agenda-mini-date .day {
            font-size: 1.25rem;
            font-weight: 800;
            display: block;
            line-height: 1;
        }

        .agenda-mini-date .month {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }

        .agenda-mini-info h5 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.35;
            margin-bottom: 3px;
        }

        .agenda-mini-info h5 a:hover {
            color: var(--primary);
        }

        .agenda-mini-info span {
            font-size: 0.78rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* View All Link */
        .widget-view-all {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 1rem;
            padding: 10px;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 0.88rem;
            color: var(--primary);
            background: #f0fdf4;
            transition: var(--transition);
        }

        .widget-view-all:hover {
            background: var(--primary);
            color: var(--white);
        }

        /* Copy notification */
        .copy-toast {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            background: var(--primary-dark);
            color: var(--white);
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: var(--shadow-lg);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 999;
            pointer-events: none;
        }

        .copy-toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        /* Responsive */
        @media (max-width: 960px) {
            .post-layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                order: 2;
            }

            .comments-container {
                padding: 1.5rem;
            }
        }

        @media (max-width: 640px) {
            .article-body {
                padding: 1.5rem;
            }

            .article-title {
                font-size: 1.6rem;
            }

            .article-content {
                font-size: 1rem;
            }

            .comment-form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    {{-- Breadcrumb (Tanpa "Berita") --}}
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        @if($post->category)
            <span class="separator">/</span>
            <a href="{{ route('categories.show', $post->category->slug) }}">{{ $post->category->name }}</a>
        @endif
        <span class="separator">/</span>
        <span class="current">{{ Str::limit($post->title, 50) }}</span>
    </nav>

    {{-- Widget Jadwal Sholat (Aladhan API) --}}
    @if(($settings['home_show_prayer'] ?? '1') == '1')
    <div class="single-prayer-bar">
        <div class="single-prayer-card">
            <div class="single-prayer-left">
                <div class="badge-title">
                    <i data-feather="clock" style="width: 13px; height: 13px;"></i>
                    Jadwal Sholat Hari Ini
                </div>
                <div class="next-prayer-row">
                    <span class="next-prayer" id="next-prayer">Memuat...</span>
                    <span class="next-time" id="next-time">--:--</span>
                </div>
                <div class="prayer-location">
                    <i data-feather="map-pin" style="width: 10px; height: 10px;"></i> Karawang & Sekitarnya
                </div>
                <input type="hidden" id="setting_prayer_lat" value="{{ $settings['prayer_lat'] ?? '-6.3227' }}">
                <input type="hidden" id="setting_prayer_lon" value="{{ $settings['prayer_lon'] ?? '107.3075' }}">
            </div>
            <div class="single-prayer-right">
                <div class="single-prayer-item" id="prayer-Fajr"><span>Subuh</span><strong>--:--</strong></div>
                <div class="single-prayer-item" id="prayer-Dhuhr"><span>Dzuhur</span><strong>--:--</strong></div>
                <div class="single-prayer-item" id="prayer-Asr"><span>Ashar</span><strong>--:--</strong></div>
                <div class="single-prayer-item" id="prayer-Maghrib"><span>Maghrib</span><strong>--:--</strong></div>
                <div class="single-prayer-item" id="prayer-Isha"><span>Isya</span><strong>--:--</strong></div>
            </div>
        </div>
    </div>
    @endif

    <div class="post-layout">
        {{-- Left Column: Main Article & Comments --}}
        <div>
            <article class="article-card">
                @if($post->image)
                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="article-thumbnail">
                @endif

                <div class="article-body">
                    <div class="article-meta">
                        @if($post->category)
                            <a href="{{ route('categories.show', $post->category->slug) }}" class="article-category-badge">
                                <i data-feather="tag" style="width: 14px; height: 14px;"></i>
                                {{ $post->category->name }}
                            </a>
                        @endif
                        <div style="display: flex; align-items: center; gap: 1.25rem; flex-wrap: wrap;">
                            <span style="display: flex; align-items: center; gap: 6px; color: var(--text-muted); font-size: 0.88rem; font-weight: 500;">
                                <i data-feather="user" style="width: 15px; height: 15px; color: var(--primary-light);"></i>
                                {{ $post->author_name }}
                            </span>
                            <span class="article-date">
                                <i data-feather="calendar" style="width: 15px; height: 15px;"></i>
                                {{ $post->published_at ? $post->published_at->translatedFormat('d F Y') : '' }}
                            </span>
                        </div>
                    </div>

                    <h1 class="article-title">{{ $post->title }}</h1>

                    @if($post->subtitle)
                        <p class="article-subtitle">{{ $post->subtitle }}</p>
                    @endif

                    <hr class="article-divider">

                    <div class="article-content">
                        {!! $post->content !!}
                    </div>

                    {{-- Share Section (Icon Only) --}}
                    <div class="share-section">
                        <span class="share-label">
                            <i data-feather="share-2" style="width: 16px; height: 16px; color: var(--primary);"></i>
                            Bagikan:
                        </span>
                        <div class="share-buttons">
                            {{-- WhatsApp --}}
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' — ' . url()->current()) }}"
                               target="_blank" class="share-icon-btn whatsapp" title="Bagikan ke WhatsApp" aria-label="WhatsApp">
                                <i data-feather="message-circle" style="width: 18px; height: 18px;"></i>
                            </a>

                            {{-- Facebook --}}
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                               target="_blank" class="share-icon-btn facebook" title="Bagikan ke Facebook" aria-label="Facebook">
                                <i data-feather="facebook" style="width: 18px; height: 18px;"></i>
                            </a>

                            {{-- Twitter / X --}}
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}"
                               target="_blank" class="share-icon-btn twitter" title="Bagikan ke X (Twitter)" aria-label="X (Twitter)">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>

                            {{-- Telegram --}}
                            <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}"
                               target="_blank" class="share-icon-btn telegram" title="Bagikan ke Telegram" aria-label="Telegram">
                                <i data-feather="send" style="width: 16px; height: 16px;"></i>
                            </a>

                            {{-- SMS --}}
                            <a href="sms:?body={{ urlencode($post->title . ' ' . url()->current()) }}"
                               class="share-icon-btn sms" title="Bagikan via SMS" aria-label="SMS">
                                <i data-feather="smartphone" style="width: 18px; height: 18px;"></i>
                            </a>

                            {{-- TikTok --}}
                            <a href="https://www.tiktok.com" target="_blank" class="share-icon-btn tiktok" title="Bagikan ke TikTok" aria-label="TikTok">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.97v7.54c0 1.94-.53 3.9-1.66 5.46-1.39 1.91-3.66 3.1-6.02 3.18-2.6.09-5.24-.96-6.93-2.9-1.74-2-2.31-4.79-1.57-7.36.7-2.45 2.56-4.41 5.02-5.14.99-.29 2.03-.39 3.06-.31v4.18c-.85-.14-1.75-.07-2.52.27-1.02.45-1.77 1.39-1.95 2.5-.2 1.25.33 2.57 1.34 3.32 1.05.78 2.49.88 3.65.26 1.01-.54 1.6-1.64 1.6-2.79V.02z"/>
                                </svg>
                            </a>

                            {{-- Salin Link --}}
                            <button onclick="copyLink()" class="share-icon-btn copy" title="Salin Tautan Artikel" aria-label="Salin Link">
                                <i data-feather="link" style="width: 17px; height: 17px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </article>

            {{-- Comments Section --}}
            <section class="comments-container">
                <div class="comments-header">
                    <div class="comments-title">
                        <i data-feather="message-square" style="width: 22px; height: 22px; color: var(--primary);"></i>
                        <span>Komentar ({{ $post->approvedComments->count() }})</span>
                    </div>
                    <button type="button" class="btn-toggle-comment" onclick="toggleCommentForm()">
                        <i data-feather="edit-3" style="width: 15px; height: 15px;"></i>
                        <span id="btnToggleText">{{ $errors->any() ? 'Tutup Form' : 'Tulis Komentar' }}</span>
                    </button>
                </div>

                @if(session('comment_success'))
                    <div class="alert alert-success" style="margin-bottom: 1.5rem; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 14px 18px; border-radius: 12px; display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 0.9rem;">
                        <i data-feather="check-circle" style="width: 20px; height: 20px; color: #10b981; flex-shrink: 0;"></i>
                        <span>{{ session('comment_success') }}</span>
                    </div>
                @endif

                {{-- Collapsible Comment Form --}}
                <div class="comment-form-wrapper {{ $errors->any() ? 'active' : '' }}" id="commentFormWrapper" style="{{ $errors->any() ? 'display: block;' : '' }}">
                    <form action="{{ route('posts.comments.store', $post->slug) }}" method="POST">
                        @csrf
                        <h4 style="font-size: 1.05rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 0.35rem;">
                            Tinggalkan Komentar Anda
                        </h4>
                        <p style="font-size: 0.8125rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                            Data email dan nomor HP Anda aman & tidak akan dipublikasikan ke umum. Setiap komentar yang masuk akan melalui proses moderasi admin terlebih dahulu sebelum ditampilkan.
                        </p>

                        <div class="comment-form-grid">
                            <div class="comment-input-group">
                                <label for="comment_name">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                                <input type="text" id="comment_name" name="name" class="comment-input"
                                       placeholder="Contoh: Ahmad Fulan" value="{{ old('name') }}" required>
                                @error('name')
                                    <span style="color: #ef4444; font-size: 0.78rem; margin-top: 4px; display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="comment-input-group">
                                <label for="comment_email">Alamat Email <span style="color: #ef4444;">*</span></label>
                                <input type="email" id="comment_email" name="email" class="comment-input"
                                       placeholder="nama@email.com" value="{{ old('email') }}" required>
                                @error('email')
                                    <span style="color: #ef4444; font-size: 0.78rem; margin-top: 4px; display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="comment-input-group">
                                <label for="comment_phone">Nomor HP / WhatsApp <span style="color: #ef4444;">*</span></label>
                                <input type="tel" id="comment_phone" name="phone" class="comment-input"
                                       placeholder="Contoh: 081234567890" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <span style="color: #ef4444; font-size: 0.78rem; margin-top: 4px; display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="comment-input-group" style="margin-bottom: 1.25rem;">
                            <label for="comment_content">Isi Tanggapan / Komentar <span style="color: #ef4444;">*</span></label>
                            <textarea id="comment_content" name="content" rows="4" class="comment-input"
                                      placeholder="Tuliskan komentar atau pertanyaan Anda secara santun dan bijak..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <span style="color: #ef4444; font-size: 0.78rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="display: flex; gap: 0.75rem; align-items: center;">
                            <button type="submit" class="btn-submit-comment">
                                <i data-feather="send" style="width: 15px; height: 15px;"></i> Kirim Komentar
                            </button>
                            <button type="button" onclick="toggleCommentForm()" style="background: none; border: none; color: var(--text-muted); font-size: 0.85rem; font-weight: 600; cursor: pointer; font-family: inherit;">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Approved Comments List --}}
                <div class="comments-list">
                    @forelse($post->approvedComments as $comment)
                        <div class="comment-item">
                            <div class="comment-avatar">
                                {{ strtoupper(substr($comment->name, 0, 1)) }}
                            </div>
                            <div class="comment-content-box">
                                <div class="comment-author-name">{{ $comment->name }}</div>
                                <div class="comment-date">
                                    <i data-feather="clock" style="width: 12px; height: 12px; vertical-align: middle; margin-right: 2px;"></i>
                                    {{ $comment->created_at->translatedFormat('d F Y, H:i') }}
                                </div>
                                <div class="comment-body-text">{{ $comment->content }}</div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 2rem 1rem; color: var(--text-muted);">
                            <i data-feather="message-circle" style="width: 36px; height: 36px; margin-bottom: 0.5rem; opacity: 0.4;"></i>
                            <p style="font-size: 0.9rem;">Belum ada komentar pada artikel ini. Jadilah yang pertama berkomentar!</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

        {{-- Right Column: Sidebar --}}
        <aside class="sidebar">
            {{-- Recent Posts --}}
            @if(isset($recentPosts) && $recentPosts->count() > 0)
            <div class="sidebar-widget">
                <h3 class="widget-title">
                    <i data-feather="trending-up" style="width: 18px; height: 18px;"></i>
                    Berita Terkini
                </h3>
                @foreach($recentPosts as $recent)
                    <div class="recent-post-item">
                        @if($recent->image)
                            <img src="{{ $recent->image_url }}" alt="{{ $recent->title }}" class="recent-post-thumb" loading="lazy">
                        @else
                            <div class="recent-post-thumb" style="display:flex;align-items:center;justify-content:center;">
                                <i data-feather="image" style="width:20px;height:20px;color:#cbd5e1;"></i>
                            </div>
                        @endif
                        <div class="recent-post-info">
                            <h4><a href="{{ route('posts.show', $recent->slug) }}">{{ $recent->title }}</a></h4>
                            <span>{{ $recent->published_at ? $recent->published_at->translatedFormat('d M Y') : '' }}</span>
                        </div>
                    </div>
                @endforeach
                <a href="{{ route('posts.index') }}" class="widget-view-all">
                    Lihat Semua Berita <i data-feather="arrow-right" style="width:16px;height:16px;"></i>
                </a>
            </div>
            @endif

            {{-- Categories --}}
            @if(isset($categories) && $categories->count() > 0)
            <div class="sidebar-widget">
                <h3 class="widget-title">
                    <i data-feather="folder" style="width: 18px; height: 18px;"></i>
                    Kategori
                </h3>
                <div class="category-pills">
                    @foreach($categories as $cat)
                        <a href="{{ route('categories.show', $cat->slug) }}" class="category-pill">
                            {{ $cat->name }}
                            <span class="category-count">{{ $cat->posts_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Upcoming Events --}}
            @if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
            <div class="sidebar-widget">
                <h3 class="widget-title">
                    <i data-feather="calendar" style="width: 18px; height: 18px;"></i>
                    Agenda Mendatang
                </h3>
                @foreach($upcomingEvents as $event)
                    <div class="agenda-mini-card">
                        <div class="agenda-mini-date">
                            <span class="day">{{ \Carbon\Carbon::parse($event->start_time)->format('d') }}</span>
                            <span class="month">{{ strtoupper(\Carbon\Carbon::parse($event->start_time)->translatedFormat('M')) }}</span>
                        </div>
                        <div class="agenda-mini-info">
                            <h5><a href="{{ route('events.show', $event->id) }}">{{ Str::limit($event->title, 45) }}</a></h5>
                            <span>
                                <i data-feather="clock" style="width:12px;height:12px;"></i>
                                {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB
                            </span>
                        </div>
                    </div>
                @endforeach
                <a href="{{ route('events.index') }}" class="widget-view-all">
                    Lihat Semua Agenda <i data-feather="arrow-right" style="width:16px;height:16px;"></i>
                </a>
            </div>
            @endif
        </aside>
    </div>

    {{-- Copy Toast --}}
    <div class="copy-toast" id="copyToast">
        <i data-feather="check" style="width: 16px; height: 16px; vertical-align: middle;"></i>
        Link berhasil disalin!
    </div>
@endsection

@push('scripts')
    <script>
        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                const toast = document.getElementById('copyToast');
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 2500);
            });
        }

        function toggleCommentForm() {
            const wrapper = document.getElementById('commentFormWrapper');
            const btnText = document.getElementById('btnToggleText');
            if (wrapper.style.display === 'block' || wrapper.classList.contains('active')) {
                wrapper.style.display = 'none';
                wrapper.classList.remove('active');
                if (btnText) btnText.innerText = 'Tulis Komentar';
            } else {
                wrapper.style.display = 'block';
                wrapper.classList.add('active');
                if (btnText) btnText.innerText = 'Tutup Form';
                const input = document.getElementById('comment_name');
                if (input) input.focus();
            }
        }

        // Prayer Times API (Kemenag RI method 20 via Aladhan API)
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            const nextPrayerEl = document.getElementById('next-prayer');
            if (!nextPrayerEl) return;

            const lat = document.getElementById('setting_prayer_lat')?.value || '-6.3227';
            const lon = document.getElementById('setting_prayer_lon')?.value || '107.3075';
            const date = new Date();

            fetch("https://api.aladhan.com/v1/timings/" + Math.floor(date.getTime() / 1000) + "?latitude=" + lat + "&longitude=" + lon + "&method=20")
                .then(r => r.json())
                .then(data => {
                    if (data.code === 200) {
                        const t = data.data.timings;

                        const pfajr = document.querySelector('#prayer-Fajr strong');
                        if (pfajr) pfajr.innerText = t.Fajr;
                        const pdhuhr = document.querySelector('#prayer-Dhuhr strong');
                        if (pdhuhr) pdhuhr.innerText = t.Dhuhr;
                        const pasr = document.querySelector('#prayer-Asr strong');
                        if (pasr) pasr.innerText = t.Asr;
                        const pmagh = document.querySelector('#prayer-Maghrib strong');
                        if (pmagh) pmagh.innerText = t.Maghrib;
                        const pish = document.querySelector('#prayer-Isha strong');
                        if (pish) pish.innerText = t.Isha;

                        const prayers = [
                            { id: 'prayer-Fajr', name: 'Subuh', time: t.Fajr },
                            { id: 'prayer-Dhuhr', name: 'Dzuhur', time: t.Dhuhr },
                            { id: 'prayer-Asr', name: 'Ashar', time: t.Asr },
                            { id: 'prayer-Maghrib', name: 'Maghrib', time: t.Maghrib },
                            { id: 'prayer-Isha', name: 'Isya', time: t.Isha }
                        ];

                        const now = new Date();
                        const currentMin = now.getHours() * 60 + now.getMinutes();

                        let next = prayers[0];
                        for (let p of prayers) {
                            const [h, m] = p.time.split(':').map(Number);
                            if ((h * 60 + m) > currentMin) {
                                next = p;
                                break;
                            }
                        }

                        const np = document.getElementById('next-prayer');
                        if (np) np.innerText = next.name;
                        const nt = document.getElementById('next-time');
                        if (nt) nt.innerText = next.time + ' WIB';

                        prayers.forEach(p => {
                            const el = document.getElementById(p.id);
                            if (el) el.classList.remove('active');
                        });
                        const activeEl = document.getElementById(next.id);
                        if (activeEl) activeEl.classList.add('active');
                    }
                })
                .catch(e => console.log('Prayer API Error'));
        });
    </script>
@endpush