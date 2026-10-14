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