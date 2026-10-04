@extends('admin.layouts.app')

@section('title', 'Import Rank Math Selesai')

@push('styles')
<style>
    .import-hero {
        background: linear-gradient(135deg, #059669 0%, #0d9488 100%);
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
    .badge-success { background: #dcfce7; color: #166534; }
    .badge-warning { background: #fef08a; color: #854d0e; }
    .badge-danger { background: #fee2e2; color: #991b1b; }
    .badge-info { background: #dbeafe; color: #1e40af; }
    
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
            <i data-feather="check-circle"></i>
        </div>
        <div class="import-hero-content">
            <h1>Import Rank Math Selesai</h1>
            <p>Pengaturan SEO dari Rank Math telah berhasil diimpor.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
            <div style="background: #dbeafe; color: #1e40af; padding: 1rem; border-radius: 8px;">
                <i data-feather="plus"></i>
            </div>
            <div>
                <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">Total Diimpor</div>
                <div style="font-size: 1.5rem; font-weight: 600; color: #111827;">{{ $log['summary']['imported'] ?? 0 }}</div>
            </div>
        </div>
        
        <div class="stat-card" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
            <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 8px;">
                <i data-feather="refresh-cw"></i>
            </div>
            <div>
                <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">Diperbarui</div>
                <div style="font-size: 1.5rem; font-weight: 600; color: #111827;">{{ $log['summary']['updated'] ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
            <div style="background: #f3f4f6; color: #4b5563; padding: 1rem; border-radius: 8px;">
                <i data-feather="skip-forward"></i>
            </div>
            <div>
                <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">Dilewati</div>
                <div style="font-size: 1.5rem; font-weight: 600; color: #111827;">{{ $log['summary']['skipped'] ?? 0 }}</div>
            </div>
        </div>

        <div class="stat-card" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
            <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px;">
                <i data-feather="x-circle"></i>
            </div>
            <div>
                <div style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">Gagal</div>
                <div style="font-size: 1.5rem; font-weight: 600; color: #111827;">{{ $log['summary']['failed'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <div class="panel" style="background: white; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 2rem;">
        <div class="panel-header" style="padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb;">
            <h2 style="margin: 0; font-size: 1.125rem; color: #111827;">Detail Import</h2>
        </div>
        <div class="panel-body" style="padding: 0;">
            <div style="overflow-x: auto;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Pengaturan</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($log['details'] ?? [] as $detail)
                            <tr>
                                <td>{{ $detail['label'] ?? $detail['key'] ?? 'Unknown' }}</td>
                                <td>
                                    @if(($detail['status'] ?? '') === 'imported')
                                        <span class="badge badge-success">Diimpor</span>
                                    @elseif(($detail['status'] ?? '') === 'updated')
                                        <span class="badge badge-info">Diperbarui</span>
                                    @elseif(($detail['status'] ?? '') === 'skipped')
                                        <span class="badge badge-warning">Dilewati</span>
                                    @else
                                        <span class="badge badge-danger">Gagal</span>
                                    @endif
                                </td>
                                <td>{{ $detail['message'] ?? '' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; color: #6b7280; padding: 2rem;">Tidak ada detail log tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.rankmath-import.index') }}" class="btn" style="display: inline-flex; align-items: center; gap: 0.5rem; background: white; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none;">
            <i data-feather="refresh-ccw"></i> Import Lagi
        </a>
        <a href="{{ route('admin.settings.index') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #059669; color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none;">
            <i data-feather="settings"></i> Lihat Pengaturan SEO
        </a>
    </div>
@endsection
