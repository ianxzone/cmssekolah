@extends('admin.layouts.app')

@section('title', 'Hasil Import WordPress')

@push('styles')
<style>
    .import-banner {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        color: white;
        padding: 24px;
        border-radius: 8px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .import-banner-icon {
        background: rgba(255, 255, 255, 0.2);
        padding: 16px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .import-banner-content h2 {
        margin: 0 0 8px 0;
        font-size: 24px;
        font-weight: 600;
        color: white;
    }
    .import-banner-content p {
        margin: 0;
        opacity: 0.9;
        font-size: 15px;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
    }
    .stat-card.accent-green { border-left: 4px solid #10b981; }
    .stat-card.accent-orange { border-left: 4px solid #f97316; }
    .stat-card.accent-red { border-left: 4px solid #ef4444; }
    
    .stat-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
    }
    
    .filter-group {
        display: flex;
        gap: 8px;
        margin-bottom: 16px;
    }
    .filter-btn {
        padding: 6px 12px;
        border: 1px solid #d1d5db;
        background: white;
        border-radius: 6px;
        font-size: 13px;
        cursor: pointer;
        color: #374151;
        transition: all 0.2s;
    }
    .filter-btn:hover { background: #f3f4f6; }
    .filter-btn.active {
        background: #f3f4f6;
        border-color: #9ca3af;
        font-weight: 600;
    }
    
    .log-container {
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
    }
    .log-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    .log-table th {
        background: #f9fafb;
        padding: 12px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #4b5563;
        border-bottom: 1px solid #e5e7eb;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .log-table td {
        padding: 12px 16px;
        font-size: 14px;
        border-bottom: 1px solid #e5e7eb;
        color: #1f2937;
    }
    .log-table tr:nth-child(even) { background-color: #f9fafb; }
    .log-table tr:hover { background-color: #f3f4f6; }
    
    .badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        border: 1px solid;
    }
    .badge-imported {
        background-color: #ecfdf5;
        border-color: #a7f3d0;
        color: #065f46;
    }
    .badge-skipped {
        background-color: #fff7ed;
        border-color: #fed7aa;
        color: #9a3412;
    }
    .badge-failed {
        background-color: #fef2f2;
        border-color: #fecaca;
        color: #991b1b;
    }
    
    .type-icon {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #6b7280;
        font-size: 13px;
    }
    
    .actions-bar {
        display: flex;
        gap: 12px;
        margin-top: 24px;
        flex-wrap: wrap;
    }
</style>
@endpush

@section('content')

<div class="import-banner">
    <div class="import-banner-icon">
        <i data-feather="check-circle" style="width: 32px; height: 32px; color: white;"></i>
    </div>
    <div class="import-banner-content">
        <h2>Import Selesai!</h2>
        <p>Proses migrasi dari WordPress telah selesai. Berikut ringkasan hasilnya.</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card accent-green">
        <div class="stat-label">Categories Imported</div>
        <div class="stat-value">{{ $log['summary']['categories_imported'] ?? 0 }}</div>
    </div>
    <div class="stat-card accent-green">
        <div class="stat-label">Tags Imported</div>
        <div class="stat-value">{{ $log['summary']['tags_imported'] ?? 0 }}</div>
    </div>
    <div class="stat-card accent-green">
        <div class="stat-label">Posts Imported</div>
        <div class="stat-value">{{ $log['summary']['posts_imported'] ?? 0 }}</div>
    </div>
    <div class="stat-card accent-green">
        <div class="stat-label">Pages Imported</div>
        <div class="stat-value">{{ $log['summary']['pages_imported'] ?? 0 }}</div>
    </div>
</div>

@php
    $totalSkipped = ($log['summary']['categories_skipped'] ?? 0) + ($log['summary']['tags_skipped'] ?? 0) + ($log['summary']['posts_skipped'] ?? 0) + ($log['summary']['pages_skipped'] ?? 0);
    $totalFailed = ($log['summary']['posts_failed'] ?? 0) + ($log['summary']['pages_failed'] ?? 0);
@endphp

<div class="stats-grid">
    <div class="stat-card accent-orange">
        <div class="stat-label">Items Skipped</div>
        <div class="stat-value">{{ $totalSkipped }}</div>
    </div>
    <div class="stat-card accent-red">
        <div class="stat-label">Items Failed</div>
        <div class="stat-value">{{ $totalFailed }}</div>
    </div>
    <div class="stat-card accent-green">
        <div class="stat-label">Images Downloaded</div>
        <div class="stat-value">{{ $log['summary']['images_downloaded'] ?? 0 }}</div>
    </div>
    <div class="stat-card accent-red">
        <div class="stat-label">Images Failed</div>
        <div class="stat-value">{{ $log['summary']['images_failed'] ?? 0 }}</div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h3 class="panel-title">Detail Log Import</h3>
    </div>
    <div class="panel-body">
        
        <div class="filter-group">
            <button class="filter-btn active" data-filter="all">Semua</button>
            <button class="filter-btn" data-filter="imported">Imported</button>
            <button class="filter-btn" data-filter="skipped">Skipped</button>
            <button class="filter-btn" data-filter="failed">Failed</button>
        </div>

        <div class="log-container">
            @if(isset($log['details']) && count($log['details']) > 0)
                <table class="log-table">
                    <thead>
                        <tr>
                            <th width="15%">Type</th>
                            <th width="45%">Title/Name</th>
                            <th width="15%">Status</th>
                            <th width="25%">Message</th>
                        </tr>
                    </thead>
                    <tbody id="logTableBody">
                        @foreach($log['details'] as $detail)
                            <tr class="log-row" data-status="{{ strtolower($detail['status'] ?? 'unknown') }}">
                                <td>
                                    <div class="type-icon">
                                        @if(($detail['type'] ?? '') == 'category')
                                            <i data-feather="folder" style="width: 14px; height: 14px;"></i> Category
                                        @elseif(($detail['type'] ?? '') == 'tag')
                                            <i data-feather="tag" style="width: 14px; height: 14px;"></i> Tag
                                        @elseif(($detail['type'] ?? '') == 'post')
                                            <i data-feather="edit-3" style="width: 14px; height: 14px;"></i> Post
                                        @elseif(($detail['type'] ?? '') == 'page')
                                            <i data-feather="file-text" style="width: 14px; height: 14px;"></i> Page
                                        @elseif(($detail['type'] ?? '') == 'image')
                                            <i data-feather="image" style="width: 14px; height: 14px;"></i> Image
                                        @else
                                            <i data-feather="file" style="width: 14px; height: 14px;"></i> {{ ucfirst($detail['type'] ?? 'Unknown') }}
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $detail['title'] ?? '-' }}</td>
                                <td>
                                    @php
                                        $status = strtolower($detail['status'] ?? '');
                                    @endphp
                                    @if($status == 'imported')
                                        <span class="badge badge-imported"><i data-feather="check" style="width: 12px; height: 12px;"></i> Imported</span>
                                    @elseif($status == 'skipped')
                                        <span class="badge badge-skipped"><i data-feather="alert-triangle" style="width: 12px; height: 12px;"></i> Skipped</span>
                                    @elseif($status == 'failed')
                                        <span class="badge badge-failed"><i data-feather="x" style="width: 12px; height: 12px;"></i> Failed</span>
                                    @else
                                        <span class="badge">{{ ucfirst($status) }}</span>
                                    @endif
                                </td>
                                <td><span style="font-size: 13px; color: #6b7280;">{{ $detail['message'] ?? '-' }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="padding: 30px; text-align: center; color: #6b7280;">
                    <i data-feather="info" style="margin-bottom: 10px; color: #9ca3af;"></i>
                    <p>Tidak ada detail log.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="actions-bar">
    <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">
        <i data-feather="edit-3" style="width: 16px; height: 16px; margin-right: 6px;"></i> Lihat Posts
    </a>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-primary">
        <i data-feather="file-text" style="width: 16px; height: 16px; margin-right: 6px;"></i> Lihat Pages
    </a>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
        <i data-feather="folder" style="width: 16px; height: 16px; margin-right: 6px;"></i> Lihat Categories
    </a>
    <a href="{{ route('admin.wordpress-import.index') }}" class="btn" style="background: white; border: 1px solid #d1d5db;">
        <i data-feather="upload-cloud" style="width: 16px; height: 16px; margin-right: 6px;"></i> Import Lagi
    </a>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        const filterBtns = document.querySelectorAll('.filter-btn');
        const logRows = document.querySelectorAll('.log-row');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');

                logRows.forEach(row => {
                    if (filterValue === 'all' || row.getAttribute('data-status') === filterValue) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush
