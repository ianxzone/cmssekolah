@extends('admin.layouts.app')

@section('title', 'Kelola Slide: ' . $slider->name)

@push('styles')
<style>
    .slider-items-topbar {
        background: linear-gradient(135deg, #022c19 0%, #004d28 100%);
        border-radius: 16px;
        padding: 1.5rem 2rem;
        color: #ffffff;
        margin-bottom: 2rem;
        box-shadow: 0 10px 25px -5px rgba(2, 44, 25, 0.25);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.25rem;
    }
    .topbar-info h2 {
        font-size: 1.45rem;
        font-weight: 800;
        margin: 0 0 0.35rem 0;
        display: flex;
        align-items: center;
        gap: 10px;
        letter-spacing: -0.02em;
    }
    .topbar-info p {
        margin: 0;
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.875rem;
    }
    .topbar-nav-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .btn-back-sliders {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.25);
        padding: 0.7rem 1.2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    .btn-back-sliders:hover {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }
    .btn-add-slide {
        background: #FBB03B;
        color: #022c19;
        font-weight: 700;
        padding: 0.7rem 1.3rem;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(251, 176, 59, 0.3);
    }
    .btn-add-slide:hover {
        background: #f59e0b;
        transform: translateY(-1px);
        color: #022c19;
    }

    /* Active Theme Notice */
    .theme-status-bar {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .theme-status-bar.is-active-bar {
        border-left: 4px solid #006837;
        background: #f0fdf4;
    }

    /* Slide Cards List */
    .slides-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-bottom: 3rem;
    }
    .slide-item-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        display: grid;
        grid-template-columns: 280px 1fr auto;
        transition: all 0.25s ease;
    }
    .slide-item-card:hover {
        box-shadow: 0 10px 20px -3px rgba(0, 0, 0, 0.08);
        border-color: #cbd5e1;
    }
    .slide-item-card.is-inactive {
        opacity: 0.7;
        background: #f8fafc;
    }

    /* Thumbnail Preview Column */
    .slide-visual-preview {
        position: relative;
        height: 100%;
        min-height: 200px;
        background-color: #0f172a;
        background-size: cover;
        background-position: center;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 12px;
    }
    .slide-visual-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 100%);
        z-index: 1;
    }
    .slide-order-pill {
        position: relative;
        z-index: 2;
        background: rgba(0, 0, 0, 0.65);
        backdrop-filter: blur(4px);
        color: #ffffff;
        font-weight: 800;
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
        align-self: flex-start;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .slide-side-thumb {
        position: absolute;
        bottom: 8px;
        right: 8px;
        z-index: 2;
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    /* Content Column */
    .slide-details {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .slide-badge-text {
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #006837;
        margin-bottom: 6px;
        display: inline-block;
    }
    .slide-heading {
        margin: 0 0 8px 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.35;
    }
    .slide-sub {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.5;
        margin: 0 0 1rem 0;
    }
    .slide-btns-preview {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 0.75rem;
    }
    .btn-preview-tag {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
        background: #f1f5f9;
        color: #334155;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .slide-pills-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }
    .slide-pill-tag {
        font-size: 0.72rem;
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 2px 8px;
        border-radius: 20px;
        font-weight: 600;
    }

    /* Actions Column */
    .slide-actions-col {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 8px;
        border-left: 1px solid #f1f5f9;
        background: #fafbfc;
        min-width: 140px;
    }
    .action-btn {
        width: 100%;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .action-btn:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .action-btn.edit-btn:hover {
        background: #006837;
        color: #ffffff;
        border-color: #006837;
    }
    .action-btn.toggle-btn.btn-active {
        color: #059669;
        border-color: #a7f3d0;
        background: #ecfdf5;
    }
    .action-btn.toggle-btn.btn-inactive {
        color: #94a3b8;
        border-color: #e2e8f0;
        background: #f8fafc;
    }
    .action-btn.delete-btn:hover {
        background: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
    }

    /* Modal Form Elements */
    .form-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    @media (max-width: 900px) {
        .slide-item-card {
            grid-template-columns: 1fr;
        }
        .slide-visual-preview {
            height: 180px;
        }
        .slide-actions-col {
            border-left: none;
            border-top: 1px solid #f1f5f9;
            flex-direction: row;
        }
        .form-row-2 {
            grid-template-columns: 1fr;
        }
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
    <div class="slider-items-topbar">
        <div class="topbar-info">
            <h2><i data-feather="film" style="color: #FBB03B;"></i> Kelola Slide: {{ $slider->name }}</h2>
            <p>
                Daftar slide yang ada di dalam tema ini. Anda dapat menambah, mengedit, mengunggah foto, mengatur tombol link, dan mengubah urutan tampilan.
            </p>
        </div>
        <div class="topbar-nav-actions">
            <a href="{{ route('admin.sliders.index') }}" class="btn-back-sliders">
                <i data-feather="arrow-left"></i> Kembali ke Daftar Tema
            </a>
            <button type="button" class="btn-add-slide" onclick="openAddSlideModal()">
                <i data-feather="plus-circle"></i> Tambah Slide Baru
            </button>
        </div>
    </div>

    <!-- Theme Status Bar -->
    <div class="theme-status-bar {{ $slider->is_active ? 'is-active-bar' : '' }}">
        <div style="display:flex; align-items:center; gap:12px;">
            @if($slider->is_active)
            <span style="background:#006837; color:#ffffff; padding:4px 12px; border-radius:20px; font-size:0.8rem; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                <span style="width:8px; height:8px; border-radius:50%; background:#4ade80;"></span>
                TEMA SEDANG AKTIF DI BERANDA
            </span>
            <span style="color:#065f46; font-size:0.85rem; font-weight:600;">Slide pada tema ini otomatis tampil di hero banner beranda utama.</span>
            @else
            <span style="background:#e2e8f0; color:#475569; padding:4px 12px; border-radius:20px; font-size:0.8rem; font-weight:700;">
                TEMA TIDAK AKTIF DI BERANDA
            </span>
            <span style="color:#64748b; font-size:0.85rem;">Tema ini sedang tidak tayang di beranda. Anda dapat mengaktifkannya kapan saja.</span>
            @endif
        </div>
        @if(!$slider->is_active)
        <form action="{{ route('admin.sliders.active', $slider->id) }}" method="POST" onsubmit="return confirm('Aktifkan tema ini di Beranda?');">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn" style="background:#006837; color:#ffffff; font-weight:700; padding:6px 14px; border-radius:8px; border:none; cursor:pointer; font-size:0.85rem; display:inline-flex; align-items:center; gap:6px;">
                <i data-feather="check" style="width:16px; height:16px;"></i> Aktifkan Tema Ini Sekarang
            </button>
        </form>
        @endif
    </div>

    <!-- Slides List -->
    <div class="slides-container">
        @forelse($slider->items as $index => $item)
        <div class="slide-item-card {{ !$item->is_active ? 'is-inactive' : '' }}">
            <!-- Visual Column -->
            <div class="slide-visual-preview" style="background-image: url('{{ $item->image_url }}');">
                <div class="slide-visual-overlay"></div>
                <div class="slide-order-pill">
                    Slide #{{ $index + 1 }} (Urutan: {{ $item->sort_order }})
                </div>
                @if($item->side_image_url)
                <img src="{{ $item->side_image_url }}" alt="Side Visual" class="slide-side-thumb" title="Gambar Santri / Visual Samping">
                @endif
            </div>

            <!-- Content Column -->
            <div class="slide-details">
                <div>
                    @if($item->badge)
                    <span class="slide-badge-text">{{ $item->badge }}</span>
                    @endif
                    <h3 class="slide-heading">{{ $item->title ?: '(Tanpa Judul)' }}</h3>
                    <p class="slide-sub">{{ $item->subtitle ?: 'Tidak ada teks subjudul.' }}</p>
                </div>

                <div>
                    <div class="slide-btns-preview">
                        @if($item->btn_text)
                        <span class="btn-preview-tag" title="Link: {{ $item->btn_link }}">
                            <i data-feather="link-2" style="width:12px; height:12px;"></i>
                            <strong>Tombol 1:</strong> {{ $item->btn_text }} &rarr; <span style="font-family:monospace;">{{ Str::limit($item->btn_link, 30) }}</span>
                        </span>
                        @endif
                        @if($item->btn2_text)
                        <span class="btn-preview-tag" title="Link 2: {{ $item->btn2_link }}">
                            <i data-feather="link-2" style="width:12px; height:12px;"></i>
                            <strong>Tombol 2:</strong> {{ $item->btn2_text }} &rarr; <span style="font-family:monospace;">{{ Str::limit($item->btn2_link, 30) }}</span>
                        </span>
                        @endif
                    </div>

                    @if(!empty($item->pills) && is_array($item->pills))
                    <div class="slide-pills-list">
                        @foreach($item->pills as $pill)
                        <span class="slide-pill-tag"><i data-feather="check" style="width:10px; height:10px;"></i> {{ $pill }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions Column -->
            <div class="slide-actions-col">
                <button type="button" class="action-btn edit-btn" onclick="openEditSlideModal({{ json_encode($item) }})">
                    <i data-feather="edit-2" style="width:14px; height:14px;"></i> Edit
                </button>

                <form action="{{ route('admin.sliders.items.toggle', [$slider->id, $item->id]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="action-btn toggle-btn {{ $item->is_active ? 'btn-active' : 'btn-inactive' }}" title="Ubah status tampil">
                        <i data-feather="{{ $item->is_active ? 'eye' : 'eye-off' }}" style="width:14px; height:14px;"></i>
                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                    </button>
                </form>

                <form action="{{ route('admin.sliders.items.destroy', [$slider->id, $item->id]) }}" method="POST" onsubmit="return confirm('Hapus slide ini dari tema?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn delete-btn">
                        <i data-feather="trash-2" style="width:14px; height:14px;"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div style="text-align: center; padding: 4rem 2rem; background: #ffffff; border-radius: 16px; border: 2px dashed #cbd5e1;">
            <i data-feather="image" style="width: 48px; height: 48px; color: #94a3b8; margin-bottom: 1rem;"></i>
            <h3 style="margin: 0 0 0.5rem 0; color: #1e293b;">Belum Ada Slide pada Tema Ini</h3>
            <p style="color: #64748b; margin-bottom: 1.5rem;">Tambahkan slide pertama untuk tema "{{ $slider->name }}".</p>
            <button type="button" class="btn-add-slide" onclick="openAddSlideModal()">
                <i data-feather="plus-circle"></i> Tambah Slide Sekarang
            </button>
        </div>
        @endforelse
    </div>

</div>

<!-- Modal Tambah Slide Baru -->
<div class="slider-modal" id="addSlideModal">
    <div class="slider-modal-content" style="max-width: 680px;">
        <form action="{{ route('admin.sliders.items.store', $slider->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="slider-modal-header">
                <h4><i data-feather="plus-circle" style="width:18px; height:18px; color:#006837;"></i> Tambah Slide Baru ke Tema</h4>
                <button type="button" style="background:none; border:none; cursor:pointer;" onclick="closeAddSlideModal()">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="slider-modal-body" style="max-height: 75vh; overflow-y: auto;">
                <div class="form-group-custom">
                    <label class="form-label-custom">Badge / Label Atas (Opsional)</label>
                    <input type="text" name="badge" class="form-control-custom" placeholder="Contoh: OFFICIAL PEARSON EDEXCEL PARTNER">
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Judul Utama Slide <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="title" class="form-control-custom" placeholder="Contoh: Kurikulum Internasional Pearson (UK)" required>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Deskripsi / Subjudul</label>
                    <textarea name="subtitle" rows="2" class="form-control-custom" placeholder="Penjelasan ringkas mengenai slide..."></textarea>
                </div>

                <!-- Gambar Background -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; padding:12px 14px; border-radius:10px; margin-bottom:1.25rem;">
                    <label class="form-label-custom" style="margin-bottom:8px;">
                        <i data-feather="image" style="width:14px; height:14px; color:#006837;"></i>
                        Foto / Background Slide (Landscape)
                    </label>
                    <div class="form-row-2">
                        <div>
                            <span style="font-size:0.75rem; color:#64748b; display:block; margin-bottom:4px;">Upload File Gambar:</span>
                            <input type="file" name="image_file" accept="image/*" class="form-control-custom" style="padding:4px 6px;">
                        </div>
                        <div>
                            <span style="font-size:0.75rem; color:#64748b; display:block; margin-bottom:4px;">Atau Masukkan URL Gambar:</span>
                            <input type="text" name="image_url" class="form-control-custom" placeholder="https://images.unsplash.com/...">
                        </div>
                    </div>
                </div>

                <!-- Gambar Visual Samping -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; padding:12px 14px; border-radius:10px; margin-bottom:1.25rem;">
                    <label class="form-label-custom" style="margin-bottom:8px;">
                        <i data-feather="user" style="width:14px; height:14px; color:#006837;"></i>
                        Gambar Santri / Visual Samping (Opsional, format PNG transparan disarankan)
                    </label>
                    <div class="form-row-2">
                        <div>
                            <span style="font-size:0.75rem; color:#64748b; display:block; margin-bottom:4px;">Upload File PNG:</span>
                            <input type="file" name="side_image_file" accept="image/*" class="form-control-custom" style="padding:4px 6px;">
                        </div>
                        <div>
                            <span style="font-size:0.75rem; color:#64748b; display:block; margin-bottom:4px;">Atau Masukkan Path / URL:</span>
                            <input type="text" name="side_image_url" class="form-control-custom" placeholder="images/hero-students.png">
                        </div>
                    </div>
                </div>

                <!-- Tombol 1 -->
                <div class="form-row-2">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Teks Tombol 1</label>
                        <input type="text" name="btn_text" class="form-control-custom" placeholder="Contoh: Pelajari Pearson ICP">
                    </div>
                    <div class="form-group-custom">
                        <label class="form-label-custom">Link Tombol 1</label>
                        <input type="text" name="btn_link" class="form-control-custom" placeholder="Contoh: /pearson-icp atau https://...">
                    </div>
                </div>

                <!-- Tombol 2 (Opsional) -->
                <div class="form-row-2">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Teks Tombol 2 (Opsional)</label>
                        <input type="text" name="btn2_text" class="form-control-custom" placeholder="Contoh: Hubungi Kami">
                    </div>
                    <div class="form-group-custom">
                        <label class="form-label-custom">Link Tombol 2</label>
                        <input type="text" name="btn2_link" class="form-control-custom" placeholder="Contoh: #contact">
                    </div>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Poin Fitur / Pills Keunggulan</label>
                    <input type="text" name="pills_raw" class="form-control-custom" placeholder="Pisahkan dengan koma, contoh: Akreditasi A, Tahfidz Bersanad, Coding & Robotik">
                    <small style="color:#64748b; font-size:0.75rem;">Akan ditampilkan sebagai tag fitur di bawah slide.</small>
                </div>

                <div class="form-row-2" style="align-items:center;">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Urutan Tampil (Sort Order)</label>
                        <input type="number" name="sort_order" class="form-control-custom" value="{{ $slider->items->count() + 1 }}" min="1">
                    </div>
                    <div class="form-group-custom" style="padding-top:1.2rem;">
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-weight:600; font-size:0.9rem;">
                            <input type="checkbox" name="is_active" value="1" checked style="width:18px; height:18px; accent-color:#006837;">
                            Aktifkan Slide Ini
                        </label>
                    </div>
                </div>
            </div>
            <div class="slider-modal-footer">
                <button type="button" class="btn" style="background:#e2e8f0; color:#475569; padding:8px 16px; border-radius:8px; border:none; cursor:pointer;" onclick="closeAddSlideModal()">Batal</button>
                <button type="submit" class="btn" style="background:#006837; color:#ffffff; padding:8px 20px; border-radius:8px; border:none; cursor:pointer; font-weight:700;">Simpan Slide</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Slide -->
<div class="slider-modal" id="editSlideModal">
    <div class="slider-modal-content" style="max-width: 680px;">
        <form id="editSlideForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="slider-modal-header">
                <h4><i data-feather="edit-2" style="width:18px; height:18px; color:#006837;"></i> Edit Slide</h4>
                <button type="button" style="background:none; border:none; cursor:pointer;" onclick="closeEditSlideModal()">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="slider-modal-body" style="max-height: 75vh; overflow-y: auto;">
                <div class="form-group-custom">
                    <label class="form-label-custom">Badge / Label Atas</label>
                    <input type="text" name="badge" id="edit_slide_badge" class="form-control-custom">
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Judul Utama Slide <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="title" id="edit_slide_title" class="form-control-custom" required>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Deskripsi / Subjudul</label>
                    <textarea name="subtitle" id="edit_slide_subtitle" rows="2" class="form-control-custom"></textarea>
                </div>

                <!-- Gambar Background -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; padding:12px 14px; border-radius:10px; margin-bottom:1.25rem;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                        <label class="form-label-custom" style="margin:0;">
                            <i data-feather="image" style="width:14px; height:14px; color:#006837;"></i>
                            Foto / Background Slide (Landscape)
                        </label>
                        <span id="current_image_preview_box" style="font-size:0.75rem; color:#006837; font-weight:600;"></span>
                    </div>
                    <div class="form-row-2">
                        <div>
                            <span style="font-size:0.75rem; color:#64748b; display:block; margin-bottom:4px;">Ganti dengan Upload File Baru:</span>
                            <input type="file" name="image_file" accept="image/*" class="form-control-custom" style="padding:4px 6px;">
                        </div>
                        <div>
                            <span style="font-size:0.75rem; color:#64748b; display:block; margin-bottom:4px;">Atau Perbarui URL Gambar:</span>
                            <input type="text" name="image_url" id="edit_slide_image_url" class="form-control-custom">
                        </div>
                    </div>
                </div>

                <!-- Gambar Visual Samping -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; padding:12px 14px; border-radius:10px; margin-bottom:1.25rem;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                        <label class="form-label-custom" style="margin:0;">
                            <i data-feather="user" style="width:14px; height:14px; color:#006837;"></i>
                            Gambar Santri / Visual Samping (Opsional)
                        </label>
                        <span id="current_side_preview_box" style="font-size:0.75rem; color:#006837; font-weight:600;"></span>
                    </div>
                    <div class="form-row-2">
                        <div>
                            <span style="font-size:0.75rem; color:#64748b; display:block; margin-bottom:4px;">Upload File PNG Baru:</span>
                            <input type="file" name="side_image_file" accept="image/*" class="form-control-custom" style="padding:4px 6px;">
                        </div>
                        <div>
                            <span style="font-size:0.75rem; color:#64748b; display:block; margin-bottom:4px;">Atau Path/URL:</span>
                            <input type="text" name="side_image_url" id="edit_slide_side_image_url" class="form-control-custom">
                        </div>
                    </div>
                </div>

                <!-- Tombol 1 -->
                <div class="form-row-2">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Teks Tombol 1</label>
                        <input type="text" name="btn_text" id="edit_slide_btn_text" class="form-control-custom">
                    </div>
                    <div class="form-group-custom">
                        <label class="form-label-custom">Link Tombol 1</label>
                        <input type="text" name="btn_link" id="edit_slide_btn_link" class="form-control-custom">
                    </div>
                </div>

                <!-- Tombol 2 -->
                <div class="form-row-2">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Teks Tombol 2 (Opsional)</label>
                        <input type="text" name="btn2_text" id="edit_slide_btn2_text" class="form-control-custom">
                    </div>
                    <div class="form-group-custom">
                        <label class="form-label-custom">Link Tombol 2</label>
                        <input type="text" name="btn2_link" id="edit_slide_btn2_link" class="form-control-custom">
                    </div>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Poin Fitur / Pills Keunggulan</label>
                    <input type="text" name="pills_raw" id="edit_slide_pills" class="form-control-custom">
                </div>

                <div class="form-row-2" style="align-items:center;">
                    <div class="form-group-custom">
                        <label class="form-label-custom">Urutan Tampil (Sort Order)</label>
                        <input type="number" name="sort_order" id="edit_slide_sort_order" class="form-control-custom" min="1">
                    </div>
                    <div class="form-group-custom" style="padding-top:1.2rem;">
                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-weight:600; font-size:0.9rem;">
                            <input type="checkbox" name="is_active" id="edit_slide_is_active" value="1" style="width:18px; height:18px; accent-color:#006837;">
                            Aktifkan Slide Ini
                        </label>
                    </div>
                </div>
            </div>
            <div class="slider-modal-footer">
                <button type="button" class="btn" style="background:#e2e8f0; color:#475569; padding:8px 16px; border-radius:8px; border:none; cursor:pointer;" onclick="closeEditSlideModal()">Batal</button>
                <button type="submit" class="btn" style="background:#006837; color:#ffffff; padding:8px 20px; border-radius:8px; border:none; cursor:pointer; font-weight:700;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openAddSlideModal() {
        document.getElementById('addSlideModal').classList.add('show');
    }
    function closeAddSlideModal() {
        document.getElementById('addSlideModal').classList.remove('show');
    }

    function openEditSlideModal(slide) {
        const form = document.getElementById('editSlideForm');
        form.action = "{{ url('admin/sliders/' . $slider->id . '/items') }}/" + slide.id;

        document.getElementById('edit_slide_badge').value = slide.badge || '';
        document.getElementById('edit_slide_title').value = slide.title || '';
        document.getElementById('edit_slide_subtitle').value = slide.subtitle || '';
        document.getElementById('edit_slide_image_url').value = slide.image || '';
        document.getElementById('edit_slide_side_image_url').value = slide.side_image || '';
        document.getElementById('edit_slide_btn_text').value = slide.btn_text || '';
        document.getElementById('edit_slide_btn_link').value = slide.btn_link || '';
        document.getElementById('edit_slide_btn2_text').value = slide.btn2_text || '';
        document.getElementById('edit_slide_btn2_link').value = slide.btn2_link || '';
        document.getElementById('edit_slide_sort_order').value = slide.sort_order || 1;
        document.getElementById('edit_slide_is_active').checked = slide.is_active == 1;

        if (Array.isArray(slide.pills)) {
            document.getElementById('edit_slide_pills').value = slide.pills.join(', ');
        } else {
            document.getElementById('edit_slide_pills').value = '';
        }

        document.getElementById('editSlideModal').classList.add('show');
    }
    function closeEditSlideModal() {
        document.getElementById('editSlideModal').classList.remove('show');
    }

    window.addEventListener('click', function(e) {
        const addModal = document.getElementById('addSlideModal');
        const editModal = document.getElementById('editSlideModal');
        if (e.target === addModal) closeAddSlideModal();
        if (e.target === editModal) closeEditSlideModal();
    });
</script>
@endpush
@endsection
