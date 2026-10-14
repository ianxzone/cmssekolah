@extends('admin.layouts.app')

@section('title', 'Dashboard Overview')

@push('styles')
<style>
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 2rem;
    }
    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
    }
    @media (max-width: 540px) {
        .stats-grid { grid-template-columns: 1fr; gap: 0.75rem; margin-bottom: 1.25rem; }
    }
    
    /* Dashboard 2-column Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        align-items: start;
    }
    @media (max-width: 1024px) {
        .dashboard-grid { grid-template-columns: 1fr; gap: 1.25rem; }
    }

    /* Welcome Banner Responsive */
    .welcome-banner {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: white;
        border: none;
        margin-bottom: 1.75rem;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(5, 150, 105, 0.2);
    }
    .welcome-panel-body {
        padding: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    .welcome-text {
        flex: 1;
        min-width: 260px;
    }
    .welcome-title {
        font-size: 1.65rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: white;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .welcome-desc {
        font-size: 0.95rem;
        opacity: 0.92;
        margin-bottom: 0;
        line-height: 1.5;
    }
    .welcome-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .welcome-btn {
        background: rgba(255,255,255,0.18);
        color: white !important;
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 8px;
        font-weight: 600;
        padding: 10px 18px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    .welcome-btn:hover {
        background: rgba(255,255,255,0.3);
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .welcome-panel-body {
            padding: 1.25rem;
            flex-direction: column;
            align-items: stretch;
            gap: 1.25rem;
        }
        .welcome-title {
            font-size: 1.3rem;
            gap: 8px;
        }
        .welcome-title svg {
            width: 22px;
            height: 22px;
        }
        .welcome-desc {
            font-size: 0.85rem;
        }
        .welcome-actions {
            width: 100%;
        }
        .welcome-btn {
            flex: 1;
            justify-content: center;
            font-size: 0.85rem;
            padding: 8px 14px;
        }
    }

    @media (max-width: 420px) {
        .welcome-actions {
            flex-direction: column;
        }
        .welcome-btn {
            width: 100%;
        }
    }

    .chart-container-responsive {
        position: relative;
        height: 320px;
        width: 100%;
    }
    @media (max-width: 640px) {
        .chart-container-responsive {
            height: 240px;
        }
    }

    .activity-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .activity-list li {
        padding: 0.875rem 0;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }
    .activity-list li:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #ecfdf5;
        color: #059669;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .activity-details {
        min-width: 0;
        flex: 1;
    }
    .activity-details h4 {
        margin: 0 0 0.25rem 0;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .activity-details p {
        margin: 0;
        font-size: 0.75rem;
        color: var(--text-secondary);
        line-height: 1.4;
    }
</style>
@endpush

@section('content')
    <!-- Welcome Header -->
    <div class="panel welcome-banner">
        <div class="panel-body welcome-panel-body">
            <div class="welcome-text">
                <h1 class="welcome-title">
                    <i data-feather="monitor" style="opacity: 0.9;"></i> 
                    Selamat Datang di CMS Sekolah
                </h1>
                <p class="welcome-desc">Kelola konten, halaman, form pendaftaran, dan informasi sekolah Anda di satu pusat komando (MATEK).</p>
            </div>
            <div class="welcome-actions">
                <a href="{{ route('admin.posts.create') ?? '#' }}" class="btn welcome-btn">
                    <i data-feather="edit-3" style="width: 16px;"></i> Tulis Post
                </a>
                <a href="{{ route('admin.pages.create') ?? '#' }}" class="btn welcome-btn">
                    <i data-feather="file-text" style="width: 16px;"></i> Buat Halaman
                </a>
            </div>
        </div>
    </div>

    <!-- 4-Column Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i data-feather="file-text"></i>
            </div>
            <div class="stat-details">
                <h3>Total Pages</h3>
                <div class="value">{{ $stats['pages'] ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon success">
                <i data-feather="edit-3"></i>
            </div>
            <div class="stat-details">
                <h3>Total Posts</h3>
                <div class="value">{{ $stats['posts'] ?? 0 }}</div>
            </div>
        </div>

        @php
            $drafts = \App\Models\Post::whereNull('published_at')->count();
        @endphp
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef3c7; color: #d97706;">
                <i data-feather="edit-2"></i>
            </div>
            <div class="stat-details">
                <h3>Drafts Pending</h3>
                <div class="value">{{ $drafts }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #dbeafe; color: #2563eb;">
                <i data-feather="inbox"></i>
            </div>
            <div class="stat-details">
                <h3>Form Submissions</h3>
                <div class="value">{{ $stats['submissions'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    {{-- PPDB & Lead Intelligence Panel (Fase 2) --}}
    <div class="panel" style="margin-bottom: 2rem; border: 1px solid #a7f3d0; background: linear-gradient(to right, #f0fdf4, #ffffff); border-radius: 1rem; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.05);">
        <div class="panel-header" style="background: transparent; border-bottom: 1px solid #d1fae5; display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.75rem; flex-wrap: wrap; gap: 10px;">
            <div>
                <h2 class="panel-title" style="display: flex; align-items: center; gap: 8px; color: #065f46; font-size: 1.15rem; font-weight: 800;">
                    <i data-feather="target" style="color: #059669; width: 20px; height: 20px;"></i>
                    Pusat Komando & Analitik PPDB
                </h2>
                <span style="font-size: 0.8rem; color: #047857; margin-top: 2px; display: block;">Pemantauan minat calon wali murid dan konversi pendaftaran secara real-time.</span>
            </div>
            <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                <span style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                    <span style="width: 7px; height: 7px; background: #10b981; border-radius: 50%; display: inline-block;"></span> Live Lead Tracking
                </span>
                <a href="{{ route('admin.analytics.report') }}" class="btn btn-primary" style="padding: 6px 14px; font-size: 0.78rem; background: #059669; border: 1px solid #047857; color: #ffffff; border-radius: 6px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); text-decoration: none;">
                    <i data-feather="printer" style="width: 14px; height: 14px;"></i> Cetak Laporan (PDF)
                </a>
                <a href="{{ route('admin.settings.index') }}#seo" class="btn" style="padding: 6px 12px; font-size: 0.78rem; background: #ffffff; border: 1px solid #cbd5e1; color: #334155; border-radius: 6px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;">
                    <i data-feather="sliders" style="width: 14px; height: 14px;"></i> Setting PPDB
                </a>
            </div>
        </div>

        <div class="panel-body" style="padding: 1.5rem 1.75rem;">
            <!-- PPDB 4 Key Lead Cards -->
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1rem 1.25rem; border-left: 4px solid #25D366; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px;">
                        <span style="font-size: 0.8rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Klik WhatsApp PPDB</span>
                        <div style="width: 28px; height: 28px; border-radius: 6px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center;">
                            <i data-feather="message-circle" style="width: 16px; height: 16px;"></i>
                        </div>
                    </div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #0f172a; line-height: 1.2;">{{ $ppdbStats['wa_total'] ?? 0 }}</div>
                    <div style="font-size: 0.75rem; color: #16a34a; font-weight: 600; margin-top: 4px;">
                        +{{ $ppdbStats['wa_today'] ?? 0 }} hari ini &bull; {{ $ppdbStats['wa_7days'] ?? 0 }} minggu ini
                    </div>
                </div>

                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1rem 1.25rem; border-left: 4px solid #f59e0b; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px;">
                        <span style="font-size: 0.8rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Klik Portal SPMB</span>
                        <div style="width: 28px; height: 28px; border-radius: 6px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center;">
                            <i data-feather="external-link" style="width: 16px; height: 16px;"></i>
                        </div>
                    </div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #0f172a; line-height: 1.2;">{{ $ppdbStats['spmb_total'] ?? 0 }}</div>
                    <div style="font-size: 0.75rem; color: #d97706; font-weight: 600; margin-top: 4px;">
                        +{{ $ppdbStats['spmb_today'] ?? 0 }} hari ini &bull; {{ $ppdbStats['spmb_7days'] ?? 0 }} minggu ini
                    </div>
                </div>

                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1rem 1.25rem; border-left: 4px solid #3b82f6; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px;">
                        <span style="font-size: 0.8rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Formulir Web Masuk</span>
                        <div style="width: 28px; height: 28px; border-radius: 6px; background: #dbeafe; color: #2563eb; display: flex; align-items: center; justify-content: center;">
                            <i data-feather="file-text" style="width: 16px; height: 16px;"></i>
                        </div>
                    </div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #0f172a; line-height: 1.2;">{{ $stats['submissions'] ?? 0 }}</div>
                    <div style="font-size: 0.75rem; color: #2563eb; font-weight: 600; margin-top: 4px;">
                        Data formulir pra-pendaftaran
                    </div>
                </div>

                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1rem 1.25rem; border-left: 4px solid #8b5cf6; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px;">
                        <span style="font-size: 0.8rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Kunjungan Tamu Offline</span>
                        <div style="width: 28px; height: 28px; border-radius: 6px; background: #ede9fe; color: #7c3aed; display: flex; align-items: center; justify-content: center;">
                            <i data-feather="users" style="width: 16px; height: 16px;"></i>
                        </div>
                    </div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #0f172a; line-height: 1.2;">{{ $ppdbStats['guestbook_total'] ?? 0 }}</div>
                    <div style="font-size: 0.75rem; color: #7c3aed; font-weight: 600; margin-top: 4px;">
                        Tamu check-in di sekolah
                    </div>
                </div>
            </div>

            <!-- Recent PPDB Activity Stream -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.25rem;">
                <h4 style="font-size: 0.9rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem; display: flex; align-items: center; justify-content: space-between;">
                    <span style="display: flex; align-items: center; gap: 6px;">
                        <i data-feather="activity" style="width: 15px; height: 15px; color: #059669;"></i>
                        Aktivitas Minat Calon Wali Murid Terkini
                    </span>
                    <small style="font-weight: 500; color: #64748b; font-size: 0.75rem;">Real-time stream</small>
                </h4>

                @if(isset($recentPpdbLeads) && $recentPpdbLeads->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        @foreach($recentPpdbLeads as $lead)
                            @php
                                $badgeColor = '#dcfce7'; $textColor = '#16a34a'; $icon = 'message-circle'; $leadText = 'Klik Konsultasi WA PPDB';
                                if ($lead->event_name === 'click_spmb_portal') {
                                    $badgeColor = '#fef3c7'; $textColor = '#d97706'; $icon = 'external-link'; $leadText = 'Klik Tombol SPMB Online';
                                } elseif ($lead->event_name === 'download_brosur') {
                                    $badgeColor = '#e0e7ff'; $textColor = '#4338ca'; $icon = 'download'; $leadText = 'Unduh Brosur PPDB';
                                }
                            @endphp
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: #f8fafc; border-radius: 8px; border: 1px solid #f1f5f9; font-size: 0.85rem;">
                                <div style="display: flex; align-items: center; gap: 10px; min-width: 0;">
                                    <div style="width: 28px; height: 28px; border-radius: 50%; background: {{ $badgeColor }}; color: {{ $textColor }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <i data-feather="{{ $icon }}" style="width: 14px; height: 14px;"></i>
                                    </div>
                                    <div style="min-width: 0;">
                                        <div style="font-weight: 700; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $leadText }} &bull; <span style="font-weight: 500; color: #64748b;">{{ $lead->label ?: 'Tombol PPDB' }}</span>
                                        </div>
                                        <div style="font-size: 0.75rem; color: #94a3b8;">
                                            Dari halaman: <code>{{ $lead->url ?: '/' }}</code>
                                        </div>
                                    </div>
                                </div>
                                <span style="font-size: 0.75rem; color: #64748b; font-weight: 600; white-space: nowrap; margin-left: 10px;">
                                    {{ $lead->created_at ? $lead->created_at->diffForHumans() : 'Baru saja' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 1.5rem 1rem; color: #64748b; background: #f8fafc; border-radius: 8px; border: 1px dashed #cbd5e1;">
                        <i data-feather="inbox" style="width: 28px; height: 28px; margin-bottom: 0.5rem; opacity: 0.5;"></i>
                        <p style="font-size: 0.85rem; margin-bottom: 4px; font-weight: 600; color: #334155;">Belum Ada Interaksi Klik PPDB Terekam</p>
                        <p style="font-size: 0.75rem; margin-bottom: 0;">Setiap kali ada pengunjung yang mengklik tombol WhatsApp PPDB, SPMB, atau unduh brosur di web, daftarnya akan otomatis muncul di sini secara real-time.</p>
                    </div>
                @endif
            </div>

            <!-- Matomo Live Reporting API Summary (Fase 3) -->
            @if(!empty($matomoConfig))
                <div style="margin-top: 1.25rem; background: #ffffff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; flex-wrap: wrap; gap: 6px;">
                        <h4 style="font-size: 0.9rem; font-weight: 700; color: #1e3a8a; margin: 0; display: flex; align-items: center; gap: 6px;">
                            <i data-feather="globe" style="width: 15px; height: 15px; color: #2563eb;"></i>
                            Statistik Pengunjung Global (Matomo {{ $matomoConfig['source'] === 'cloud' ? 'Cloud' : 'Self-Hosted' }})
                        </h4>
                        <span style="font-size: 0.72rem; color: #2563eb; background: #eff6ff; padding: 2px 8px; border-radius: 20px; font-weight: 600;">
                            Live 7 Hari Terakhir
                        </span>
                    </div>

                    @if(!empty($matomoSummary) && is_array($matomoSummary))
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.75rem;">
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 14px; text-align: center;">
                                <div style="font-size: 0.75rem; color: #64748b; font-weight: 600;">Total Kunjungan</div>
                                <div style="font-size: 1.35rem; font-weight: 800; color: #0f172a;">{{ number_format($matomoSummary['nb_visits'] ?? 0) }}</div>
                            </div>
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 14px; text-align: center;">
                                <div style="font-size: 0.75rem; color: #64748b; font-weight: 600;">Tampilan Halaman</div>
                                <div style="font-size: 1.35rem; font-weight: 800; color: #0f172a;">{{ number_format($matomoSummary['nb_actions'] ?? 0) }}</div>
                            </div>
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 14px; text-align: center;">
                                <div style="font-size: 0.75rem; color: #64748b; font-weight: 600;">Bounce Rate</div>
                                <div style="font-size: 1.35rem; font-weight: 800; color: #0f172a;">{{ $matomoSummary['bounce_rate'] ?? '0%' }}</div>
                            </div>
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 14px; text-align: center;">
                                <div style="font-size: 0.75rem; color: #64748b; font-weight: 600;">Rata-rata Durasi</div>
                                <div style="font-size: 1.35rem; font-weight: 800; color: #0f172a;">{{ isset($matomoSummary['avg_time_on_site']) ? round($matomoSummary['avg_time_on_site'] / 60, 1) . ' m' : '-' }}</div>
                            </div>
                        </div>
                    @else
                        <div style="padding: 10px 14px; background: #eff6ff; border-radius: 8px; font-size: 0.8rem; color: #1e40af; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                            <span>Token API terpasang. Data metrik pengunjung akan otomatis diperbarui saat server Matomo berhasil sinkronisasi.</span>
                            <a href="{{ $matomoConfig['url'] }}" target="_blank" style="font-weight: 700; color: #2563eb; text-decoration: none;">Buka Matomo Web &rarr;</a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Main Chart -->
        <div class="panel" style="margin-bottom: 0;">
            <div class="panel-header">
                <h2 class="panel-title">Statistik Form Masuk (7 Hari Terakhir)</h2>
            </div>
            <div class="panel-body">
                <div class="chart-container-responsive">
                    <canvas id="submissionsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activities Widget -->
        <div class="panel" style="margin-bottom: 0;">
            <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h2 class="panel-title">Aktivitas Terkini</h2>
                <a href="{{ route('admin.posts.index') }}" style="font-size: 0.75rem; color: #059669; font-weight: 600; text-decoration: none;">Lihat Semua</a>
            </div>
            <div class="panel-body">
                @php
                    $recentPosts = \App\Models\Post::orderBy('created_at', 'desc')->take(5)->get();
                @endphp
                
                @if($recentPosts->count() > 0)
                    <ul class="activity-list">
                        @foreach($recentPosts as $post)
                        @php
                            $isPublished = $post->published_at && $post->published_at <= now();
                            $isScheduled = $post->published_at && $post->published_at > now();
                        @endphp
                        <li>
                            <div class="activity-icon">
                                <i data-feather="{{ $isPublished ? 'check-circle' : ($isScheduled ? 'calendar' : 'edit-2') }}" style="width: 18px; height: 18px;"></i>
                            </div>
                            <div class="activity-details">
                                <h4>{{ \Illuminate\Support\Str::limit($post->title, 40) }}</h4>
                                <p>
                                    @if($isPublished)
                                        <span style="color: #059669; font-weight: 500;">Dipublikasikan</span>
                                    @elseif($isScheduled)
                                        <span style="color: #2563eb; font-weight: 500;">Terjadwal</span>
                                    @else
                                        <span style="color: #d97706; font-weight: 500;">Draft</span>
                                    @endif
                                    oleh {{ $post->author->name ?? 'Admin' }} &bull; {{ $post->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <div style="text-align: center; padding: 2rem 0; color: var(--text-secondary);">
                        <i data-feather="info" style="width: 32px; height: 32px; margin-bottom: 0.5rem; opacity: 0.5;"></i>
                        <p style="font-size: 0.875rem;">Belum ada aktivitas postingan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('submissionsChart').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(5, 150, 105, 0.2)'); // Emerald Green Fade
            gradient.addColorStop(1, 'rgba(5, 150, 105, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($labels ?? []) !!},
                    datasets: [{
                        label: 'Submissions',
                        data: {!! json_encode($chartData ?? []) !!},
                        borderColor: '#059669', // Emerald Green Line
                        backgroundColor: gradient,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#059669',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 12,
                            titleFont: { size: 13, weight: 'normal' },
                            bodyFont: { size: 14, weight: 'bold' },
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                font: { size: 11, color: '#6b7280' }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.04)',
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                font: { size: 11, color: '#6b7280' }
                            },
                            grid: {
                                display: false,
                                drawBorder: false
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush