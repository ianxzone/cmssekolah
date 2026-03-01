@extends('theme::layouts.app')

@section('title', $event->title . ' - Agenda Kegiatan')
@section('meta_description', Str::limit(strip_tags($event->description), 150))

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

        .article-title {
            font-size: 2.2rem;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
        }

        .event-meta-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            background: var(--bg-light);
            padding: 1.5rem;
            border-radius: var(--radius-md);
            margin-bottom: 1rem;
            border: 1px solid var(--border-color);
        }

        .meta-box {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .meta-icon {
            width: 32px;
            height: 32px;
            background: var(--primary-light);
            color: var(--white);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .meta-info label {
            display: block;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            font-weight: 700;
            margin-bottom: 2px;
        }

        .meta-info span {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--primary);
        }

        .article-thumbnail {
            width: 100%;
            max-height: 450px;
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

        .event-section-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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

        .sidebar-list a {
            color: var(--text-main);
            font-weight: 500;
            display: block;
            line-height: 1.4;
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

            .article-content,
            .article-header {
                padding: 1.5rem;
            }

            .event-meta-grid {
                grid-template-columns: 1fr;
            }

            .article-title {
                font-size: 1.8rem;
            }
        }

        /* Add to Calendar Styling */
        .calendar-sync-section {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px dashed var(--border-color);
            flex-wrap: wrap;
        }

        .calendar-sync-label {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sync-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-sync {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none !important;
        }

        .btn-google-cal {
            background: #fff;
            color: #4285F4;
            border: 1px solid #4285F4;
        }

        .btn-google-cal:hover {
            background: #4285F4;
            color: #fff;
        }

        .btn-ics {
            background: #fff;
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-ics:hover {
            background: var(--primary);
            color: #fff;
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
            <h1>Agenda Kegiatan</h1>
            <div class="subpage-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <i data-feather="chevron-right" style="width: 14px;"></i>
                <a href="{{ route('events.index') }}">Agenda</a>
                <i data-feather="chevron-right" style="width: 14px;"></i>
                <span>Detail</span>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <div class="layout-container">
        <!-- Main Content -->
        <div class="article-column">
            <article class="article-container">
                @if($event->image)
                    <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="article-thumbnail">
                @endif

                <header class="article-header">
                    <h1 class="article-title">{{ $event->title }}</h1>

                    <div class="event-meta-grid">
                        <div class="meta-box">
                            <div class="meta-icon"><i data-feather="calendar" style="width:16px;"></i></div>
                            <div class="meta-info">
                                <label>Hari & Tanggal</label>
                                <span>{{ $event->start_time->format('l, d F Y') }}</span>
                            </div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-icon"><i data-feather="clock" style="width:16px;"></i></div>
                            <div class="meta-info">
                                <label>Waktu</label>
                                <span>
                                    {{ $event->start_time->format('H:i') }}
                                    @if($event->end_time)
                                        - {{ $event->end_time->format('H:i') }}
                                    @endif
                                    WIB
                                </span>
                            </div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-icon"><i data-feather="{{ $event->type == 'online' ? 'link' : 'map-pin' }}"
                                    style="width:16px;"></i></div>
                            <div class="meta-info">
                                <label>{{ $event->type == 'online' ? 'Link Meeting' : 'Lokasi' }}</label>
                                @if($event->type == 'online')
                                    @if($event->meeting_link)
                                        <a href="{{ $event->meeting_link }}" target="_blank"
                                            style="color: var(--primary); font-weight: 600;">Gabung Meeting</a>
                                    @else
                                        <span>Link belum tersedia</span>
                                    @endif
                                @else
                                    <span>{{ $event->location ?? 'Lokasi akan diumumkan' }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-icon"><i data-feather="user" style="width:16px;"></i></div>
                            <div class="meta-info">
                                <label>Penyelenggara</label>
                                <span>{{ $event->organizer_name ?? 'SDIT Al Irsyad' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="calendar-sync-section">
                        <span class="calendar-sync-label">
                            <i data-feather="plus-circle" style="width:16px;"></i> Simpan ke Kalender:
                        </span>
                        <div class="sync-buttons">
                            <a href="{{ $googleCalendarUrl }}" target="_blank" class="btn-sync btn-google-cal">
                                <i data-feather="external-link" style="width:14px;"></i> Google Calendar
                            </a>
                            <a href="{{ route('events.ics', $event->id) }}" class="btn-sync btn-ics">
                                <i data-feather="download" style="width:14px;"></i> Download .ics
                            </a>
                        </div>
                    </div>
                </header>

                <div class="article-content trix-content">
                    <h3 class="event-section-title"><i data-feather="info" style="width:18px;"></i> Detail Kegiatan</h3>
                    {!! \App\Helpers\ShortcodeHelper::parse($event->description) !!}

                    @if($event->type == 'offline' && $event->map_link)
                        <div style="margin-top: 2.5rem;">
                            <h3 class="event-section-title"><i data-feather="map" style="width:18px;"></i> Lokasi Acara</h3>
                            <div style="border-radius: 12px; overflow: hidden; border: 1px solid var(--border-color);">
                                @if(Str::startsWith($event->map_link, '<iframe'))
                                    {!! $event->map_link !!}
                                @else
                                    <iframe width="100%" height="350" frameborder="0" style="border:0" src="{{ $event->map_link }}"
                                        allowfullscreen></iframe>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- SPMB Banner -->
            <div class="sidebar-widget"
                style="background: var(--primary); color: white; text-align: center; padding: 30px 20px;">
                <h3 style="color: white; font-weight: 800; font-size: 1.4rem; margin-bottom: 10px;">
                    {{ $settings['sidebar_ppdb_title'] ?? 'PPDB Dibuka!' }}
                </h3>
                <p style="font-size: 0.9rem; margin-bottom: 20px; opacity: 0.9;">
                    {{ $settings['sidebar_ppdb_desc'] ?? 'Daftarkan putra-putri Anda sekarang juga.' }}
                </p>
                <a href="{{ $settings['contact_ppdb_link'] ?? '#' }}" class="btn"
                    style="background: white; color: var(--primary); padding: 10px 20px; font-weight: 700; width: 100%;">{{ $settings['sidebar_ppdb_btn_text'] ?? 'Info Selengkapnya' }}</a>
            </div>

            <!-- Other Events -->
            <div class="sidebar-widget">
                <h3 class="sidebar-title"><i data-feather="calendar" style="width:18px;"></i> Agenda Lainnya</h3>
                <ul class="sidebar-list">
                    @forelse($otherEvents as $other)
                        <li>
                            <a href="{{ route('events.show', $other->id) }}">{{ $other->title }}</a>
                            <div class="sidebar-meta">
                                <i data-feather="calendar" style="width:12px;"></i> {{ $other->start_time->format('d M Y') }}
                            </div>
                        </li>
                    @empty
                        <li>Belum ada agenda lain.</li>
                    @endforelse
                </ul>
            </div>

            <!-- News Widget -->
            <div class="sidebar-widget">
                <h3 class="sidebar-title"><i data-feather="book-open" style="width:18px;"></i> Berita Terbaru</h3>
                <ul class="sidebar-list">
                    @php
                        $latestNews = \App\Models\Post::whereNotNull('published_at')->latest('published_at')->take(3)->get();
                    @endphp
                    @foreach($latestNews as $news)
                        <li>
                            <a href="{{ route('posts.show', $news->slug) }}">{{ $news->title }}</a>
                            <div class="sidebar-meta">
                                <i data-feather="calendar" style="width:12px;"></i> {{ $news->published_at->format('d M Y') }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
@endsection