@extends('admin.layouts.app')

@section('title', 'Sliders & Banner Manager')

@push('styles')
<style>
    .slider-banner-top {
        background: linear-gradient(135deg, #022c19 0%, #004d28 100%);
        border-radius: 16px;
        padding: 1.75rem 2rem;
        color: #ffffff;
        margin-bottom: 2rem;
        box-shadow: 0 10px 25px -5px rgba(2, 44, 25, 0.25);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.25rem;
    }
    .slider-banner-title h2 {
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0 0 0.35rem 0;
        display: flex;
        align-items: center;
        gap: 10px;
        letter-spacing: -0.02em;
    }
    .slider-banner-title p {
        margin: 0;
        color: rgba(255, 255, 255, 0.82);
        font-size: 0.9rem;
        max-width: 650px;
        line-height: 1.45;
    }
    .btn-create-theme {
        background: #FBB03B;
        color: #022c19;
        font-weight: 700;
        padding: 0.75rem 1.4rem;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(251, 176, 59, 0.3);
    }
    .btn-create-theme:hover {
        background: #f59e0b;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(251, 176, 59, 0.4);
        color: #022c19;
    }

    /* Grid of Slider Themes */
    .slider-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    .slider-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: all 0.25s ease;
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .slider-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -4px rgba(0, 0, 0, 0.1);
        border-color: #cbd5e1;
    }
    .slider-card.is-active-theme {
        border: 2px solid #006837;
        box-shadow: 0 10px 25px -5px rgba(0, 104, 55, 0.15);
    }
    .slider-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        background: #fafbfc;
    }
    .slider-card.is-active-theme .slider-card-header {
        background: #f0fdf4;
        border-bottom-color: #dcfce7;
    }
    .theme-title-area h3 {
        margin: 0 0 4px 0;
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
    }
    .theme-slug-badge {
        font-family: monospace;
        font-size: 0.75rem;
        background: #e2e8f0;
        color: #475569;
        padding: 2px 8px;
        border-radius: 6px;
        display: inline-block;
    }
    .active-ribbon {
        background: #006837;
        color: #ffffff;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 4px 10px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        box-shadow: 0 2px 6px rgba(0, 104, 55, 0.3);
    }
    .active-dot-pulse {
        width: 8px;
        height: 8px;
        background-color: #4ade80;
        border-radius: 50%;
        display: inline-block;
        animation: pulseDot 1.5s infinite;
    }
    @keyframes pulseDot {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.7); }
        70% { transform: scale(1.1); box-shadow: 0 0 0 6px rgba(74, 222, 128, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(74, 222, 128, 0); }
    }

    .slider-card-body {
        padding: 1.25rem 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .slider-desc {
        font-size: 0.875rem;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 1.25rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .slider-meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        padding-top: 1rem;
        border-top: 1px dashed #e2e8f0;
        margin-bottom: 1.25rem;
    }
    .meta-tag {
        font-size: 0.8rem;
        color: #475569;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f8fafc;
        padding: 4px 10px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .meta-tag strong {
        color: #0f172a;
    }

    .slider-card-footer {
        padding: 1rem 1.5rem;
        background: #fafbfc;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }
    .btn-manage-slides {
        background: #006837;
        color: #ffffff;
        font-size: 0.85rem;
        font-weight: 700;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    .btn-manage-slides:hover {
        background: #022c19;
        color: #ffffff;
        transform: translateY(-1px);
    }
    .action-btn-group {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .btn-icon-action {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-icon-action:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .btn-icon-action.btn-activate {
        color: #059669;
        border-color: #a7f3d0;
        background: #ecfdf5;
    }
    .btn-icon-action.btn-activate:hover {
        background: #059669;
        color: #ffffff;
    }
    .btn-icon-action.btn-delete:hover {
        background: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
    }

    /* Modal Styling */
    .slider-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }
    .slider-modal.show {
        display: flex;
    }
    .slider-modal-content {
        background: #ffffff;
        border-radius: 16px;
        max-width: 540px;
        width: 100%;
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        animation: modalFadeIn 0.25s ease-out;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .slider-modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .slider-modal-header h4 {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
    }
    .slider-modal-body {
        padding: 1.5rem;
    }
    .slider-modal-footer {
        padding: 1rem 1.5rem;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .form-group-custom {
        margin-bottom: 1.2rem;
    }
    .form-label-custom {
        display: block;
        font-weight: 600;
        font-size: 0.85rem;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-control-custom {
        width: 100%;
        padding: 0.65rem 0.85rem;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 0.9rem;
        color: #0f172a;
        outline: none;
        transition: border-color 0.2s;
    }
    .form-control-custom:focus {
        border-color: #006837;
        box-shadow: 0 0 0 3px rgba(0, 104, 55, 0.15);
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">

    @if(session('success'))
    <div class="alert alert-success" style="background:#ecfdf5; border-left:4px solid #10b981; color:#065f46; padding:1rem 1.25rem; border-radius:8px; margin-bottom:1.5rem; display:flex; align-items:center; justify-content:space-between;">
        <div style="display:flex; align-items:center; gap:10px;">
            <i data-feather="check-circle" style="color:#10b981;"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:#065f46; cursor:pointer;"><i data-feather="x"></i></button>
    </div>
    @endif

    @if(isset($errors) && $errors->any())
    <div class="alert alert-danger" style="background:#fef2f2; border-left:4px solid #ef4444; color:#991b1b; padding:1rem 1.25rem; border-radius:8px; margin-bottom:1.5rem;">
        <ul style="margin:0; padding-left:1.25rem;">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Top Action Bar -->
    <div class="slider-banner-top">
        <div class="slider-banner-title">
            <h2><i data-feather="sliders" style="color: #FBB03B;"></i> Manajemen Slider & Banner Tema</h2>
            <p>
                Sistem slider bertingkat ala <strong>Slider Revolution</strong>: Setiap "Tema Slider" memiliki kumpulan slide tersendiri. Anda dapat berganti tema beranda (misal tema reguler, tema SPMB/PPDB, atau tema Ramadhan) hanya dengan 1 klik!
            </p>
        </div>
        <div>
            <button type="button" class="btn-create-theme" onclick="openCreateModal()">
                <i data-feather="plus-circle"></i> Tambah Tema Slider Baru
            </button>
        </div>
    </div>

    <!-- Sliders Cards Grid -->
    <div class="slider-grid">
        @forelse($sliders as $slider)
        <div class="slider-card {{ $slider->is_active ? 'is-active-theme' : '' }}">
            <div class="slider-card-header">
                <div class="theme-title-area">
                    <h3>{{ $slider->name }}</h3>
                    <span class="theme-slug-badge">code: {{ $slider->slug }}</span>
                </div>
                @if($slider->is_active)
                <span class="active-ribbon">
                    <span class="active-dot-pulse"></span> Aktif di Beranda
                </span>
                @else
                <span style="font-size:0.75rem; color:#94a3b8; font-weight:600; padding:4px 8px; background:#f1f5f9; border-radius:6px;">Tidak Aktif</span>
                @endif
            </div>

            <div class="slider-card-body">
                <div class="slider-desc">
                    {{ $slider->description ?: 'Tidak ada deskripsi khusus untuk tema slider ini.' }}
                </div>

                <div class="slider-meta-row">
                    <div class="meta-tag">
                        <i data-feather="layers" style="width:14px; height:14px; color:#006837;"></i>
                        <span>Total: <strong>{{ $slider->items_count }} Slide</strong></span>
                    </div>
                    <div class="meta-tag">
                        <i data-feather="check-circle" style="width:14px; height:14px; color:#10b981;"></i>
                        <span>Aktif: <strong>{{ $slider->active_items_count }} Slide</strong></span>
                    </div>
                    <div class="meta-tag">
                        <i data-feather="clock" style="width:14px; height:14px; color:#f59e0b;"></i>
                        <span>Delay: <strong>{{ number_format(($slider->delay ?: 6000) / 1000, 1) }}s</strong></span>
                    </div>
                    <div class="meta-tag">
                        <i data-feather="play-circle" style="width:14px; height:14px; color:#6366f1;"></i>
                        <span>Autoplay: <strong>{{ $slider->auto_play ? 'Ya' : 'Tidak' }}</strong></span>
                    </div>
                </div>
            </div>

            <div class="slider-card-footer">
                <a href="{{ route('admin.sliders.items', $slider->id) }}" class="btn-manage-slides">
                    <i data-feather="edit"></i> Kelola Isi Slide ({{ $slider->items_count }})
                </a>

                <div class="action-btn-group">
                    @if(!$slider->is_active)
                    <form action="{{ route('admin.sliders.active', $slider->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Aktifkan tema slider ini sebagai banner utama Beranda?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-icon-action btn-activate" title="Aktifkan di Beranda">
                            <i data-feather="check"></i>
                        </button>
                    </form>
                    @endif

                    <button type="button" class="btn-icon-action" title="Edit Pengaturan Tema" onclick="openEditModal({{ json_encode($slider) }})">
                        <i data-feather="settings"></i>
                    </button>

                    <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus tema slider ini beserta seluruh isinya?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon-action btn-delete" title="Hapus Tema Slider">
                            <i data-feather="trash-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; background: #ffffff; border-radius: 16px; border: 2px dashed #cbd5e1;">
            <i data-feather="sliders" style="width: 48px; height: 48px; color: #94a3b8; margin-bottom: 1rem;"></i>
            <h3 style="margin: 0 0 0.5rem 0; color: #1e293b;">Belum Ada Tema Slider</h3>
            <p style="color: #64748b; margin-bottom: 1.5rem;">Buat tema slider pertama Anda untuk menampilkan carousel banner di halaman beranda.</p>
            <button type="button" class="btn-create-theme" onclick="openCreateModal()">
                <i data-feather="plus-circle"></i> Tambah Tema Slider Sekarang
            </button>
        </div>
        @endforelse
    </div>

</div>

<!-- Modal Create Slider Theme -->
<div class="slider-modal" id="createSliderModal">
    <div class="slider-modal-content">
        <form action="{{ route('admin.sliders.store') }}" method="POST">
            @csrf
            <div class="slider-modal-header">
                <h4><i data-feather="plus" style="width:18px; height:18px; color:#006837;"></i> Buat Tema Slider Baru</h4>
                <button type="button" style="background:none; border:none; cursor:pointer;" onclick="closeCreateModal()">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="slider-modal-body">
                <div class="form-group-custom">
                    <label class="form-label-custom">Nama Tema Slider <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="name" class="form-control-custom" placeholder="Contoh: Tema Ramadhan 1447H / Promo PPDB" required>
                </div>
                <div class="form-group-custom">
                    <label class="form-label-custom">Kode Slug / Identifier (Opsional)</label>
                    <input type="text" name="slug" class="form-control-custom" placeholder="Otomatis dibuat jika dikosongkan (contoh: tema-ramadhan)">
                </div>
                <div class="form-group-custom">
                    <label class="form-label-custom">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" class="form-control-custom" placeholder="Keterangan tema slider ini..."></textarea>
                </div>
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Durasi Pergantian Slide (ms)</label>
                        <input type="number" name="delay" class="form-control-custom" value="6000" min="1000" step="500">
                        <small style="color:#64748b; font-size:0.75rem;">6000 ms = 6 detik</small>
                    </div>
                    <div class="form-group-custom" style="padding-top:1.8rem;">
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:0.9rem; font-weight:600;">
                            <input type="checkbox" name="auto_play" value="1" checked style="width:18px; height:18px; accent-color:#006837;">
                            Autoplay Otomatis
                        </label>
                    </div>
                </div>
                <div class="form-group-custom" style="margin-top:0.5rem; background:#f0fdf4; border:1px solid #bbf7d0; padding:10px 14px; border-radius:8px;">
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:0.9rem; font-weight:700; color:#065f46;">
                        <input type="checkbox" name="is_active" value="1" style="width:18px; height:18px; accent-color:#006837;">
                        Langsung jadikan Tema Aktif di Beranda
                    </label>
                </div>
            </div>
            <div class="slider-modal-footer">
                <button type="button" class="btn" style="background:#e2e8f0; color:#475569; padding:8px 16px; border-radius:8px; border:none; cursor:pointer;" onclick="closeCreateModal()">Batal</button>
                <button type="submit" class="btn" style="background:#006837; color:#ffffff; padding:8px 20px; border-radius:8px; border:none; cursor:pointer; font-weight:700;">Simpan & Lanjut ke Slide</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Slider Theme -->
<div class="slider-modal" id="editSliderModal">
    <div class="slider-modal-content">
        <form id="editSliderForm" method="POST">
            @csrf
            @method('PUT')
            <div class="slider-modal-header">
                <h4><i data-feather="settings" style="width:18px; height:18px; color:#006837;"></i> Edit Pengaturan Tema Slider</h4>
                <button type="button" style="background:none; border:none; cursor:pointer;" onclick="closeEditModal()">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="slider-modal-body">
                <div class="form-group-custom">
                    <label class="form-label-custom">Nama Tema Slider <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="name" id="edit_name" class="form-control-custom" required>
                </div>
                <div class="form-group-custom">
                    <label class="form-label-custom">Kode Slug / Identifier <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="slug" id="edit_slug" class="form-control-custom" required>
                </div>
                <div class="form-group-custom">
                    <label class="form-label-custom">Deskripsi</label>
                    <textarea name="description" id="edit_description" rows="3" class="form-control-custom"></textarea>
                </div>
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px;">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Durasi Slide (ms)</label>
                        <input type="number" name="delay" id="edit_delay" class="form-control-custom" min="1000" step="500">
                    </div>
                    <div class="form-group-custom" style="padding-top:1.8rem;">
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:0.9rem; font-weight:600;">
                            <input type="checkbox" name="auto_play" id="edit_auto_play" value="1" style="width:18px; height:18px; accent-color:#006837;">
                            Autoplay Otomatis
                        </label>
                    </div>
                </div>
                <div class="form-group-custom" style="margin-top:0.5rem; background:#f0fdf4; border:1px solid #bbf7d0; padding:10px 14px; border-radius:8px;">
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:0.9rem; font-weight:700; color:#065f46;">
                        <input type="checkbox" name="is_active" id="edit_is_active" value="1" style="width:18px; height:18px; accent-color:#006837;">
                        Aktifkan di Beranda Utama
                    </label>
                </div>
            </div>
            <div class="slider-modal-footer">
                <button type="button" class="btn" style="background:#e2e8f0; color:#475569; padding:8px 16px; border-radius:8px; border:none; cursor:pointer;" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn" style="background:#006837; color:#ffffff; padding:8px 20px; border-radius:8px; border:none; cursor:pointer; font-weight:700;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openCreateModal() {
        document.getElementById('createSliderModal').classList.add('show');
    }
    function closeCreateModal() {
        document.getElementById('createSliderModal').classList.remove('show');
    }

    function openEditModal(slider) {
        const form = document.getElementById('editSliderForm');
        form.action = "{{ url('admin/sliders') }}/" + slider.id;
        document.getElementById('edit_name').value = slider.name;
        document.getElementById('edit_slug').value = slider.slug;
        document.getElementById('edit_description').value = slider.description || '';
        document.getElementById('edit_delay').value = slider.delay || 6000;
        document.getElementById('edit_auto_play').checked = slider.auto_play == 1;
        document.getElementById('edit_is_active').checked = slider.is_active == 1;

        document.getElementById('editSliderModal').classList.add('show');
    }
    function closeEditModal() {
        document.getElementById('editSliderModal').classList.remove('show');
    }

    // Close on click backdrop
    window.addEventListener('click', function(e) {
        const createModal = document.getElementById('createSliderModal');
        const editModal = document.getElementById('editSliderModal');
        if (e.target === createModal) closeCreateModal();
        if (e.target === editModal) closeEditModal();
    });
</script>
@endpush
@endsection
