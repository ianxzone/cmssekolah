@extends('admin.layouts.app')

@section('title', 'Preview Import Rank Math')

@push('styles')
<style>
    .import-hero {
        background: linear-gradient(135deg, #d97706 0%, #ea580c 100%);
        border-radius: 8px;
        padding: 30px;
        color: #fff;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .import-hero-icon {
        background: rgba(255, 255, 255, 0.2);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .import-hero-icon svg {
        width: 48px;
        height: 48px;
        color: #fff;
    }
    
    .import-hero-content h1 {
        margin: 0 0 10px 0;
        font-size: 24px;
        font-weight: 600;
        color: #fff;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
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

    .badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .badge-new { background: #dbeafe; color: #1e40af; }
    .badge-update { background: #fef08a; color: #854d0e; }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        align-items: center;
    }
</style>
@endpush

@section('content')
    <div class="import-hero">
        <div class="import-hero-icon">
            <i data-feather="zap"></i>
        </div>
        <div class="import-hero-content">
            <h1>Preview Import Rank Math</h1>
            <p>Tinjau pengaturan yang akan diimpor sebelum melanjutkannya.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
            <div style="background: #fef3c7; color: #d97706; padding: 1rem; border-radius: 8px;">
                <i data-feather="settings"></i>
            </div>
            <div>
                <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">Total Pengaturan</div>
                <div style="font-size: 1.5rem; font-weight: 600; color: #111827;">{{ $preview['settings_count'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    @if(empty($preview['items']))
        <div class="alert alert-info" style="margin-bottom: 20px; padding: 15px; border-radius: 4px; background-color: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; display: flex; align-items: center; gap: 10px;">
            <i data-feather="info" style="width: 20px; height: 20px;"></i>
            Tidak ada pengaturan valid yang ditemukan untuk diimpor.
        </div>
    @else
        <form action="{{ route('admin.rankmath-import.import') }}" method="POST" id="importForm">
            @csrf
            
            <div class="panel" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 2rem;">
                <div class="panel-header" style="padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <h2 style="margin: 0; font-size: 1.125rem; color: #111827;">Daftar Pengaturan</h2>
                </div>
                <div class="panel-body" style="padding: 0;">
                    <div style="overflow-x: auto;">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Pengaturan</th>
                                    <th>Nilai Rank Math</th>
                                    <th>Nilai Saat Ini</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($preview['items'] as $item)
                                    <tr>
                                        <td>{{ $item['label'] }}</td>
                                        <td>
                                            @if(is_array($item['value']))
                                                <pre style="margin: 0; font-size: 0.75rem;">{{ json_encode($item['value'], JSON_PRETTY_PRINT) }}</pre>
                                            @else
                                                {{ $item['value'] ?? '—' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($item['current_value'] === null)
                                                <span style="color: #9ca3af; font-style: italic;">— Belum diisi —</span>
                                            @elseif(is_array($item['current_value']))
                                                <pre style="margin: 0; font-size: 0.75rem;">{{ json_encode($item['current_value'], JSON_PRETTY_PRINT) }}</pre>
                                            @else
                                                {{ $item['current_value'] }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($item['current_value'] === null)
                                                <span class="badge badge-new">Baru</span>
                                            @else
                                                <span class="badge badge-update">Update</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.rankmath-import.index') }}" class="btn" style="display: inline-flex; align-items: center; gap: 0.5rem; background: white; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none;">
                    <i data-feather="arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary" id="btnSubmit" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #059669; color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer;">
                    <i data-feather="download"></i> Import Sekarang
                </button>
            </div>
        </form>
    @endif
@endsection
