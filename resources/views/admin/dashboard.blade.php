@extends('admin.layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
    <div class="panel"
        style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: white; border: none; margin-bottom: 2rem; border-radius: 1.5rem; overflow: hidden;">
        <div class="panel-body" style="padding: 2.5rem; display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
            <div
                style="flex-shrink: 0; background: rgba(255,255,255,0.2); width: 100px; height: 100px; border-radius: 1.5rem; backdrop-filter: blur(10px); display: flex; align-items: center; justify-content: center;">
                <i data-feather="smile" style="width: 48px; height: 48px;"></i>
            </div>
            <div style="flex: 1; min-width: 300px;">
                <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem; color: white;">Selamat Datang di CMS
                    Sekolah</h1>
                <p style="font-size: 1.1rem; opacity: 0.9; margin-bottom: 1.5rem;">Sistem Manajemen Konten ini dikembangkan
                    secara eksklusif oleh <strong>MATEK</strong> untuk mendukung transformasi digital sekolah Anda. Kelola
                    konten Anda dengan mudah dan efisien.</p>
                <a href="https://www.murniabadi.co.id" target="_blank" class="btn"
                    style="background: white; color: #4f46e5; border-radius: 50px; font-weight: 700; padding: 12px 28px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: transform 0.2s;">
                    Kunjungi Situs MATEK <i data-feather="external-link" style="width: 16px;"></i>
                </a>
            </div>
        </div>
    </div>

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

        <div class="stat-card">
            <div class="stat-icon warning">
                <i data-feather="inbox"></i>
            </div>
            <div class="stat-details">
                <h3>Form Submissions</h3>
                <div class="value">{{ $stats['submissions'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Quick Actions</h2>
        </div>
        <div class="panel-body">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="#" class="btn btn-primary">
                    <i data-feather="plus"></i> New Page
                </a>
                <a href="#" class="btn btn-primary">
                    <i data-feather="plus"></i> New Post
                </a>
                <a href="#" class="btn btn-primary">
                    <i data-feather="plus"></i> New Event
                </a>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Submissions Over Time (Last 7 Days)</h2>
        </div>
        <div class="panel-body">
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="submissionsChart"></canvas>
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
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        label: 'Submissions',
                        data: {!! json_encode($chartData) !!},
                        borderColor: '#4f46e5',
                        backgroundColor: gradient,
                        borderWidth: 2,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#4f46e5',
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
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            }
                        },
                        x: {
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