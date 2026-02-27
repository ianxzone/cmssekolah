@extends('admin.layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
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