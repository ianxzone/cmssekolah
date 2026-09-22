@extends('admin.layouts.app')

@section('title', 'Preview Import WordPress')

@push('styles')
<style>
    /* Info Banner */
    .info-banner {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .info-banner-icon {
        color: #16a34a;
        background: #dcfce7;
        padding: 0.75rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .info-banner-content h4 {
        margin: 0 0 0.25rem 0;
        color: #166534;
        font-size: 1.125rem;
    }
    .info-banner-content p {
        margin: 0;
        color: #15803d;
        font-size: 0.875rem;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .stats-grid { grid-template-columns: 1fr; }
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    @media (max-width: 768px) {
        .form-grid { grid-template-columns: 1fr; }
    }

    /* Checkbox & Radio Styles */
    .custom-control {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
        cursor: pointer;
    }
    .custom-control input[type="checkbox"],
    .custom-control input[type="radio"] {
        width: 1.25rem;
        height: 1.25rem;
        margin-right: 0.75rem;
        accent-color: #059669;
        cursor: pointer;
    }
    .custom-control.disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    .custom-control.disabled input {
        cursor: not-allowed;
    }
    .section-label {
        font-weight: 600;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        color: #374151;
        display: block;
    }

    /* Table Styles */
    .table-container {
        overflow-x: auto;
    }
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    .custom-table th, .custom-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e5e7eb;
    }
    .custom-table th {
        background: #f9fafb;
        font-weight: 600;
        color: #4b5563;
        font-size: 0.875rem;
    }
    .custom-table tbody tr:hover {
        background: #f9fafb;
    }
    .custom-table td {
        font-size: 0.875rem;
        color: #1f2937;
    }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .badge-publish { background: #dcfce7; color: #166534; }
    .badge-draft { background: #f3f4f6; color: #374151; }
    .badge-pending { background: #fef08a; color: #854d0e; }
    .badge-future { background: #dbeafe; color: #1e40af; }
    .badge-default { background: #e5e7eb; color: #374151; }

    /* Tabs */
    .tabs-header {
        display: flex;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 1rem;
        gap: 1rem;
    }
    .tab-btn {
        background: none;
        border: none;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #6b7280;
        cursor: pointer;
        border-bottom: 2px solid transparent;
    }
    .tab-btn.active {
        color: #059669;
        border-bottom-color: #059669;
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        align-items: center;
    }
    
    .spinner {
        display: none;
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid #ffffff;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 0.5rem;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .btn.loading .spinner {
        display: inline-block;
    }
    .btn.loading .btn-text-default {
        display: none;
    }
    .btn.loading .btn-text-loading {
        display: inline;
    }
    .btn-text-loading {
        display: none;
    }

    /* Overlay for loading */
    .loading-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255,255,255,0.7);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    .loading-overlay.active {
        display: flex;
    }
    .overlay-spinner {
        width: 3rem;
        height: 3rem;
        border: 3px solid #059669;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
    <div class="header-container" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h1 style="margin: 0; font-size: 1.5rem; color: #111827;">Preview Import WordPress</h1>
    </div>

    <!-- Site Info -->
    <div class="info-banner">
        <div class="info-banner-icon">
            <i data-feather="globe"></i>
        </div>
        <div class="info-banner-content">
            <h4>{{ $data['site_info']['title'] ?? 'WordPress Site' }}</h4>
            <p>{{ $data['site_info']['description'] ?? '' }} &bull; <a href="{{ $data['site_info']['link'] ?? '#' }}" target="_blank" style="color: inherit; text-decoration: underline;">{{ $data['site_info']['link'] ?? 'Unknown URL' }}</a></p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
            <div style="background: #f3f4f6; color: #4b5563; padding: 1rem; border-radius: 8px;">
                <i data-feather="folder"></i>
            </div>
            <div>
                <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">Categories</div>
                <div style="font-size: 1.5rem; font-weight: 600; color: #111827;">{{ $data['stats']['categories'] ?? 0 }}</div>
            </div>
        </div>
        
        <div class="stat-card" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
            <div style="background: #f3f4f6; color: #4b5563; padding: 1rem; border-radius: 8px;">
                <i data-feather="tag"></i>
            </div>
            <div>
                <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">Tags</div>
                <div style="font-size: 1.5rem; font-weight: 600; color: #111827;">{{ $data['stats']['tags'] ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
            <div style="background: #e0f2fe; color: #0284c7; padding: 1rem; border-radius: 8px;">
                <i data-feather="edit-3"></i>
            </div>
            <div>
                <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">Posts</div>
                <div style="font-size: 1.5rem; font-weight: 600; color: #111827;">{{ $data['stats']['posts'] ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
            <div style="background: #fef3c7; color: #d97706; padding: 1rem; border-radius: 8px;">
                <i data-feather="file-text"></i>
            </div>
            <div>
                <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">Pages</div>
                <div style="font-size: 1.5rem; font-weight: 600; color: #111827;">{{ $data['stats']['pages'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <!-- Import Form -->
    <form action="{{ route('admin.wordpress-import.import') }}" method="POST" id="importForm">
        @csrf
        
        <div class="panel" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 2rem;">
            <div class="panel-header" style="padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb;">
                <h2 style="margin: 0; font-size: 1.125rem; color: #111827;">Opsi Import</h2>
            </div>
            <div class="panel-body" style="padding: 1.5rem;">
                <div class="form-grid">
                    <div>
                        <label class="custom-control {{ empty($data['stats']['categories']) ? 'disabled' : '' }}">
                            <input type="checkbox" name="import_categories" value="1" {{ !empty($data['stats']['categories']) ? 'checked' : 'disabled' }}>
                            <span>Import Categories ({{ $data['stats']['categories'] ?? 0 }})</span>
                        </label>
                        
                        <label class="custom-control {{ empty($data['stats']['tags']) ? 'disabled' : '' }}">
                            <input type="checkbox" name="import_tags" value="1" {{ !empty($data['stats']['tags']) ? 'checked' : 'disabled' }}>
                            <span>Import Tags ({{ $data['stats']['tags'] ?? 0 }})</span>
                        </label>
                        
                        <label class="custom-control {{ empty($data['stats']['posts']) ? 'disabled' : '' }}">
                            <input type="checkbox" name="import_posts" value="1" {{ !empty($data['stats']['posts']) ? 'checked' : 'disabled' }}>
                            <span>Import Posts ({{ $data['stats']['posts'] ?? 0 }})</span>
                        </label>
                        
                        <label class="custom-control {{ empty($data['stats']['pages']) ? 'disabled' : '' }}">
                            <input type="checkbox" name="import_pages" value="1" {{ !empty($data['stats']['pages']) ? 'checked' : 'disabled' }}>
                            <span>Import Pages ({{ $data['stats']['pages'] ?? 0 }})</span>
                        </label>
                    </div>
                    <div>
                        <label class="custom-control">
                            <input type="checkbox" name="download_images" value="1" checked>
                            <span>Download & simpan gambar ke server lokal</span>
                        </label>
                    </div>
                </div>

                <label class="section-label">Duplicate Handling</label>
                <div>
                    <label class="custom-control">
                        <input type="radio" name="duplicate_handling" value="skip" checked>
                        <span>Lewati yang sudah ada (Skip)</span>
                    </label>
                    <label class="custom-control">
                        <input type="radio" name="duplicate_handling" value="rename">
                        <span>Rename slug (tambah suffix -1, -2, dst)</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Preview Konten -->
        <div class="panel" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 2rem;">
            <div class="panel-header" style="padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb;">
                <h2 style="margin: 0; font-size: 1.125rem; color: #111827;">Preview Konten</h2>
            </div>
            <div class="panel-body" style="padding: 1.5rem;">
                
                <div class="tabs-header">
                    <button type="button" class="tab-btn active" onclick="switchTab('posts')">Posts ({{ min(20, $data['stats']['posts'] ?? 0) }})</button>
                    <button type="button" class="tab-btn" onclick="switchTab('pages')">Pages ({{ min(20, $data['stats']['pages'] ?? 0) }})</button>
                </div>

                <!-- Posts Tab -->
                <div id="tab-posts" class="tab-content active">
                    <div class="table-container">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Slug</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(array_slice($data['posts'] ?? [], 0, 20) as $post)
                                    @php
                                        $statusClass = 'badge-default';
                                        if($post['status'] == 'publish') $statusClass = 'badge-publish';
                                        elseif($post['status'] == 'draft') $statusClass = 'badge-draft';
                                        elseif($post['status'] == 'pending') $statusClass = 'badge-pending';
                                        elseif($post['status'] == 'future') $statusClass = 'badge-future';
                                    @endphp
                                    <tr>
                                        <td>{{ $post['title'] ?? 'No Title' }}</td>
                                        <td>{{ $post['post_name'] ?? '' }}</td>
                                        <td>{{ $post['post_date'] !== '0000-00-00 00:00:00' ? date('Y-m-d H:i', strtotime($post['post_date'])) : '-' }}</td>
                                        <td><span class="badge {{ $statusClass }}">{{ ucfirst($post['status'] ?? 'unknown') }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center; color: #6b7280; padding: 2rem;">No posts found to import.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        @if(($data['stats']['posts'] ?? 0) > 20)
                            <div style="padding: 1rem; text-align: center; color: #6b7280; background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                ...dan {{ ($data['stats']['posts'] ?? 0) - 20 }} post lainnya
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pages Tab -->
                <div id="tab-pages" class="tab-content">
                    <div class="table-container">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Slug</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(array_slice($data['pages'] ?? [], 0, 20) as $page)
                                    @php
                                        $statusClass = 'badge-default';
                                        if($page['status'] == 'publish') $statusClass = 'badge-publish';
                                        elseif($page['status'] == 'draft') $statusClass = 'badge-draft';
                                        elseif($page['status'] == 'pending') $statusClass = 'badge-pending';
                                        elseif($page['status'] == 'future') $statusClass = 'badge-future';
                                    @endphp
                                    <tr>
                                        <td>{{ $page['title'] ?? 'No Title' }}</td>
                                        <td>{{ $page['post_name'] ?? '' }}</td>
                                        <td>{{ $page['post_date'] !== '0000-00-00 00:00:00' ? date('Y-m-d H:i', strtotime($page['post_date'])) : '-' }}</td>
                                        <td><span class="badge {{ $statusClass }}">{{ ucfirst($page['status'] ?? 'unknown') }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center; color: #6b7280; padding: 2rem;">No pages found to import.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        @if(($data['stats']['pages'] ?? 0) > 20)
                            <div style="padding: 1rem; text-align: center; color: #6b7280; background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                                ...dan {{ ($data['stats']['pages'] ?? 0) - 20 }} page lainnya
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary" id="btnSubmit" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #059669; color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer;">
                <span class="spinner"></span>
                <i data-feather="download-cloud" class="btn-text-default"></i>
                <span class="btn-text-default">Mulai Import</span>
                <span class="btn-text-loading">Sedang mengimport...</span>
            </button>
            <a href="{{ route('admin.wordpress-import.index') }}" class="btn" style="display: inline-flex; align-items: center; gap: 0.5rem; background: white; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none;">
                <i data-feather="x"></i> Batal
            </a>
        </div>
    </form>

    <div class="loading-overlay" id="loadingOverlay">
        <div class="overlay-spinner"></div>
        <div style="color: #059669; font-weight: 600; font-size: 1.25rem;">Mengimport Data...</div>
        <div style="color: #4b5563; margin-top: 0.5rem;">Mohon tunggu, proses ini mungkin memakan waktu beberapa saat.</div>
    </div>

@endsection

@push('scripts')
<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        
        event.currentTarget.classList.add('active');
        document.getElementById('tab-' + tabId).classList.add('active');
    }

    document.getElementById('importForm').addEventListener('submit', function(e) {
        var btn = document.getElementById('btnSubmit');
        var overlay = document.getElementById('loadingOverlay');
        
        btn.classList.add('loading');
        btn.disabled = true;
        
        overlay.classList.add('active');
    });
</script>
@endpush
