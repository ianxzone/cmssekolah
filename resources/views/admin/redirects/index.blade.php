@extends('admin.layouts.app')

@section('title', 'Redirections Manager (SEO)')

@push('styles')
<style>
    .page-header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .header-btn-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .stats-grid { grid-template-columns: 1fr; }
    }

    .stat-card-custom {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .stat-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon-blue { background: #eff6ff; color: #2563eb; }
    .stat-icon-green { background: #ecfdf5; color: #059669; }
    .stat-icon-purple { background: #f5f3ff; color: #7c3aed; }
    .stat-icon-amber { background: #fffbeb; color: #d97706; }

    /* Filter Card */
    .filter-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr auto;
        gap: 0.75rem;
        align-items: center;
    }
    @media (max-width: 1024px) {
        .filter-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 640px) {
        .filter-grid { grid-template-columns: 1fr; }
    }

    .form-control-custom {
        width: 100%;
        padding: 0.55rem 0.85rem;
        font-size: 0.875rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        outline: none;
        transition: border-color 0.2s;
        box-sizing: border-box;
    }
    .form-control-custom:focus {
        border-color: #059669;
    }

    /* Table */
    .table-container {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow-x: auto;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .redirect-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.875rem;
    }
    .redirect-table th {
        background: #f8fafc;
        padding: 12px 16px;
        font-weight: 600;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    .redirect-table td {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
        vertical-align: middle;
    }
    .redirect-table tr:last-child td {
        border-bottom: none;
    }
    .redirect-table tr:hover {
        background-color: #f8fafc;
    }

    .url-chip {
        font-family: monospace;
        font-size: 0.8125rem;
        padding: 2px 6px;
        border-radius: 4px;
        word-break: break-all;
    }
    .source-chip {
        background: #fee2e2;
        color: #991b1b;
    }
    .target-chip {
        background: #dcfce7;
        color: #166534;
    }

    .badge-code {
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }
    .code-301 { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .code-302 { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .code-307 { background: #fdf4ff; color: #86198f; border: 1px solid #f0abfc; }
    .code-410 { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

    .badge-match {
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        background: #f1f5f9;
        color: #475569;
    }

    /* Modals */
    .custom-modal {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    .custom-modal.active {
        display: flex;
    }
    .modal-box {
        background: white;
        border-radius: 16px;
        width: 100%;
        max-width: 560px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        animation: modalScale 0.2s ease-out;
    }
    @keyframes modalScale {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    .modal-close {
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 4px;
        border-radius: 6px;
    }
    .modal-close:hover {
        background: #f1f5f9;
        color: #334155;
    }
    .modal-body {
        padding: 1.5rem;
        max-height: 75vh;
        overflow-y: auto;
    }
    .modal-footer {
        padding: 1rem 1.5rem;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.35rem;
    }
    .form-help {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 0.25rem;
    }

    .btn-action-icon {
        padding: 6px;
        border: none;
        background: none;
        border-radius: 6px;
        cursor: pointer;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s;
    }
    .btn-action-icon:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .btn-action-icon.text-danger:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    .switch-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .switch-active {
        background: #dcfce7;
        color: #166534;
    }
    .switch-inactive {
        background: #f1f5f9;
        color: #64748b;
    }
</style>
@endpush

@section('content')

    <div class="page-header-actions">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: #0f172a; margin: 0 0 0.25rem 0;">Redirections Manager</h1>
            <p style="font-size: 0.875rem; color: #64748b; margin: 0;">Kelola pengalihan URL (301/302) & migrasi link dari Rank Math SEO WordPress.</p>
        </div>
        <div class="header-btn-group">
            <button type="button" class="btn" style="background: white; border: 1px solid #cbd5e1; color: #334155;" onclick="openModal('modalImport')">
                <i data-feather="upload" style="width: 16px; height: 16px; margin-right: 6px;"></i> Import Rank Math
            </button>
            <a href="{{ route('admin.redirects.export') }}" class="btn" style="background: white; border: 1px solid #cbd5e1; color: #334155;">
                <i data-feather="download" style="width: 16px; height: 16px; margin-right: 6px;"></i> Export CSV
            </a>
            <button type="button" class="btn btn-primary" onclick="openCreateModal()">
                <i data-feather="plus" style="width: 16px; height: 16px; margin-right: 6px;"></i> Tambah Redirect
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card-custom">
            <div class="stat-icon-wrap stat-icon-blue">
                <i data-feather="corner-up-right"></i>
            </div>
            <div>
                <div style="font-size: 0.8125rem; color: #64748b; font-weight: 500;">Total Aturan</div>
                <div style="font-size: 1.375rem; font-weight: 700; color: #0f172a;">{{ number_format($stats['total'] ?? 0) }}</div>
            </div>
        </div>
        <div class="stat-card-custom">
            <div class="stat-icon-wrap stat-icon-green">
                <i data-feather="check-circle"></i>
            </div>
            <div>
                <div style="font-size: 0.8125rem; color: #64748b; font-weight: 500;">Redirect Aktif</div>
                <div style="font-size: 1.375rem; font-weight: 700; color: #0f172a;">{{ number_format($stats['active'] ?? 0) }}</div>
            </div>
        </div>
        <div class="stat-card-custom">
            <div class="stat-icon-wrap stat-icon-purple">
                <i data-feather="activity"></i>
            </div>
            <div>
                <div style="font-size: 0.8125rem; color: #64748b; font-weight: 500;">Total Kunjungan Dialihkan</div>
                <div style="font-size: 1.375rem; font-weight: 700; color: #0f172a;">{{ number_format($stats['total_hits'] ?? 0) }}</div>
            </div>
        </div>
        <div class="stat-card-custom">
            <div class="stat-icon-wrap stat-icon-amber">
                <i data-feather="shield"></i>
            </div>
            <div>
                <div style="font-size: 0.8125rem; color: #64748b; font-weight: 500;">301 Permanent (SEO)</div>
                <div style="font-size: 1.375rem; font-weight: 700; color: #0f172a;">{{ number_format($stats['type_301'] ?? 0) }}</div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="filter-card">
        <form action="{{ route('admin.redirects.index') }}" method="GET">
            <div class="filter-grid">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control-custom" placeholder="Cari URL asal, tujuan, atau catatan...">
                </div>
                <div>
                    <select name="code" class="form-control-custom">
                        <option value="">Semua Tipe Kode</option>
                        <option value="301" {{ request('code') == '301' ? 'selected' : '' }}>301 Permanent</option>
                        <option value="302" {{ request('code') == '302' ? 'selected' : '' }}>302 Temporary</option>
                        <option value="307" {{ request('code') == '307' ? 'selected' : '' }}>307 Temporary</option>
                        <option value="410" {{ request('code') == '410' ? 'selected' : '' }}>410 Content Deleted</option>
                    </select>
                </div>
                <div>
                    <select name="match_type" class="form-control-custom">
                        <option value="">Semua Kecocokan</option>
                        <option value="exact" {{ request('match_type') == 'exact' ? 'selected' : '' }}>Exact (Persis)</option>
                        <option value="prefix" {{ request('match_type') == 'prefix' ? 'selected' : '' }}>Prefix (Awalan)</option>
                        <option value="regex" {{ request('match_type') == 'regex' ? 'selected' : '' }}>RegEx</option>
                    </select>
                </div>
                <div>
                    <select name="status" class="form-control-custom">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 0.55rem 1rem;">Filter</button>
                    @if(request()->hasAny(['search', 'code', 'match_type', 'status']))
                        <a href="{{ route('admin.redirects.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.55rem 0.85rem;" title="Reset Filter">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="table-container">
        <table class="redirect-table">
            <thead>
                <tr>
                    <th width="35%">URL Asal (Source)</th>
                    <th width="35%">URL Tujuan (Destination)</th>
                    <th width="8%">Kode</th>
                    <th width="8%">Pencocokan</th>
                    <th width="8%">Hits</th>
                    <th width="8%">Status</th>
                    <th width="8%" style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($redirects as $redirect)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <span class="url-chip source-chip">{{ $redirect->source_url }}</span>
                                <a href="{{ url($redirect->source_url) }}" target="_blank" title="Uji link asal" style="color: #94a3b8;">
                                    <i data-feather="external-link" style="width: 12px; height: 12px;"></i>
                                </a>
                            </div>
                            @if($redirect->notes)
                                <div style="font-size: 0.75rem; color: #64748b; margin-top: 3px;">
                                    {{ $redirect->notes }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <i data-feather="arrow-right" style="width: 12px; height: 12px; color: #94a3b8; flex-shrink: 0;"></i>
                                <span class="url-chip target-chip">{{ $redirect->target_url }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge-code code-{{ $redirect->status_code }}">
                                {{ $redirect->status_code }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-match">{{ $redirect->match_type }}</span>
                        </td>
                        <td>
                            <span style="font-weight: 600; color: #334155;">{{ number_format($redirect->hits) }}</span>
                        </td>
                        <td>
                            <form action="{{ route('admin.redirects.toggle', $redirect) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="switch-btn {{ $redirect->is_active ? 'switch-active' : 'switch-inactive' }}" title="Klik untuk ubah status">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></span>
                                    {{ $redirect->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td style="text-align: right; white-space: nowrap;">
                            <button type="button" class="btn-action-icon" title="Edit" 
                                onclick="openEditModal({{ json_encode($redirect) }})">
                                <i data-feather="edit-2" style="width: 15px; height: 15px;"></i>
                            </button>
                            <form action="{{ route('admin.redirects.destroy', $redirect) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aturan redirect ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-icon text-danger" title="Hapus">
                                    <i data-feather="trash-2" style="width: 15px; height: 15px;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 3rem; color: #64748b;">
                            <i data-feather="corner-up-right" style="width: 40px; height: 40px; margin-bottom: 0.75rem; opacity: 0.4;"></i>
                            <div style="font-weight: 600; font-size: 1rem; color: #334155;">Belum ada aturan pengalihan URL</div>
                            <p style="margin: 0.25rem 0 1rem 0; font-size: 0.875rem;">Tambahkan redirect baru atau import dari file CSV/JSON Rank Math WordPress.</p>
                            <button type="button" class="btn btn-primary" onclick="openCreateModal()">Tambah Redirect Pertama</button>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $redirects->links() }}
    </div>

    <!-- Modal Form (Tambah / Edit) -->
    <div class="custom-modal" id="modalForm">
        <div class="modal-box">
            <form id="redirectForm" method="POST" action="{{ route('admin.redirects.store') }}">
                @csrf
                <div id="methodContainer"></div>

                <div class="modal-header">
                    <h3 class="modal-title" id="formModalTitle">Tambah Aturan Redirect</h3>
                    <button type="button" class="modal-close" onclick="closeModal('modalForm')">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">URL Asal (Source URL) <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="source_url" id="field_source_url" required class="form-control-custom" placeholder="contoh: /2023/05/kegiatan-sekolah/ atau berita-lama">
                        <div class="form-help">Link lama di WordPress yang ingin dialihkan. Boleh diawali tanda '/' atau tanpa slash.</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">URL Tujuan (Destination URL) <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="target_url" id="field_target_url" required class="form-control-custom" placeholder="contoh: /kegiatan-sekolah atau https://domain.com/halaman">
                        <div class="form-help">Halaman baru di CMS atau URL eksternal tujuan pengalihan.</div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Tipe Pengalihan</label>
                            <select name="status_code" id="field_status_code" class="form-control-custom">
                                <option value="301">301 - Permanent Move (Direkomendasikan)</option>
                                <option value="302">302 - Temporary Move</option>
                                <option value="307">307 - Temporary Redirect</option>
                                <option value="410">410 - Content Deleted (Permanen Dihapus)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tipe Pencocokan</label>
                            <select name="match_type" id="field_match_type" class="form-control-custom">
                                <option value="exact">Exact (Persis sama)</option>
                                <option value="prefix">Prefix (Awalan URL)</option>
                                <option value="regex">RegEx (Regular Expression)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Catatan / Keterangan (Opsional)</label>
                        <input type="text" name="notes" id="field_notes" class="form-control-custom" placeholder="misal: Migrasi artikel lama WP 2023">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.875rem;">
                            <input type="checkbox" name="is_active" id="field_is_active" value="1" checked style="width: 16px; height: 16px; accent-color: #059669;">
                            <span style="font-weight: 500;">Aktifkan redirect ini langsung</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" style="background: white; border: 1px solid #cbd5e1; color: #475569;" onclick="closeModal('modalForm')">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitForm">Simpan Aturan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Import Rank Math -->
    <div class="custom-modal" id="modalImport">
        <div class="modal-box">
            <form action="{{ route('admin.redirects.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h3 class="modal-title">Import dari Rank Math SEO</h3>
                    <button type="button" class="modal-close" onclick="closeModal('modalImport')">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 1rem; margin-bottom: 1.25rem;">
                        <div style="font-weight: 600; color: #166534; font-size: 0.875rem; margin-bottom: 4px;">Cara Ekspor di WordPress:</div>
                        <ol style="margin: 0; padding-left: 18px; font-size: 0.8125rem; color: #15803d; line-height: 1.5;">
                            <li>Buka WordPress &rarr; menu <strong>Rank Math &rarr; Redirections</strong></li>
                            <li>Klik tab <strong>Import & Export</strong></li>
                            <li>Pilih format <strong>CSV</strong> atau <strong>JSON</strong> & klik Export</li>
                            <li>Upload file hasil download tersebut di bawah ini</li>
                        </ol>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pilih Berkas CSV / JSON <span style="color: #ef4444;">*</span></label>
                        <input type="file" name="import_file" required accept=".csv,.json,.txt" class="form-control-custom">
                        <div class="form-help">Mendukung format ekspor standar Rank Math SEO (.csv atau .json). Maksimal 20MB.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" style="background: white; border: 1px solid #cbd5e1; color: #475569;" onclick="closeModal('modalImport')">Batal</button>
                    <button type="submit" class="btn btn-primary">Mulai Import Data</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.add('active');
        if (typeof feather !== 'undefined') feather.replace();
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }

    function openCreateModal() {
        const form = document.getElementById('redirectForm');
        form.action = "{{ route('admin.redirects.store') }}";
        document.getElementById('methodContainer').innerHTML = '';
        document.getElementById('formModalTitle').textContent = 'Tambah Aturan Redirect';
        document.getElementById('btnSubmitForm').textContent = 'Simpan Aturan';

        document.getElementById('field_source_url').value = '';
        document.getElementById('field_target_url').value = '';
        document.getElementById('field_status_code').value = '301';
        document.getElementById('field_match_type').value = 'exact';
        document.getElementById('field_notes').value = '';
        document.getElementById('field_is_active').checked = true;

        openModal('modalForm');
    }

    function openEditModal(data) {
        const form = document.getElementById('redirectForm');
        form.action = "{{ url('admin/redirects') }}/" + data.id;
        document.getElementById('methodContainer').innerHTML = '@method("PUT")';
        document.getElementById('formModalTitle').textContent = 'Edit Aturan Redirect';
        document.getElementById('btnSubmitForm').textContent = 'Perbarui Aturan';

        document.getElementById('field_source_url').value = data.source_url || '';
        document.getElementById('field_target_url').value = data.target_url || '';
        document.getElementById('field_status_code').value = data.status_code || '301';
        document.getElementById('field_match_type').value = data.match_type || 'exact';
        document.getElementById('field_notes').value = data.notes || '';
        document.getElementById('field_is_active').checked = Boolean(data.is_active);

        openModal('modalForm');
    }

    // Close on background click
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('custom-modal')) {
            e.target.classList.remove('active');
        }
    });
</script>
@endpush
