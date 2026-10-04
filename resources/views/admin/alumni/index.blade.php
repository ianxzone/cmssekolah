@extends('admin.layouts.app')

@section('title', 'Manajemen Alumni')

@push('styles')
<style>
    .tab-link {
        padding: 1rem 1.5rem;
        font-weight: 500;
        color: var(--text-secondary);
        border-bottom: 2px solid transparent;
        transition: all var(--transition-fast);
        display: inline-block;
    }
    .tab-link:hover {
        color: var(--text-primary);
        background: #f8fafc;
    }
    .tab-link.active {
        color: var(--primary-color);
        border-bottom-color: var(--primary-color);
        background: #fff;
    }
    
    .modal {
        display: none; 
        position: fixed; 
        z-index: 1000; 
        left: 0; 
        top: 0; 
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgba(0,0,0,0.5);
        backdrop-filter: blur(2px);
    }
    .modal.show {
        display: block;
    }
    .modal-content {
        background-color: #fff; 
        margin: 2% auto; 
        padding: 2rem; 
        border-radius: var(--border-radius); 
        width: 100%; 
        max-width: 700px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        position: relative;
        animation: slideDown 0.3s ease-out;
    }
    @keyframes slideDown {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }
    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
    }
    .close-modal {
        color: #94a3b8;
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
    }
    .close-modal:hover {
        color: var(--danger-color);
        background: #fee2e2;
    }
    .form-group {
        margin-bottom: 1.25rem;
    }
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-primary);
        font-size: 0.875rem;
    }
    .form-control {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 0.875rem;
        transition: border-color var(--transition-fast);
    }
    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .checkbox-group input[type="checkbox"] {
        width: 16px;
        height: 16px;
    }
    .form-row {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .form-col {
        flex: 1;
        min-width: 200px;
    }
    .invalid-feedback {
        color: var(--danger-color);
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .badge-success { background: #dcfce7; color: #15803d; }
    .badge-danger { background: #fee2e2; color: #b91c1c; }
    .badge-warning { background: #fef08a; color: #854d0e; }
    
    .table-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
    }
    .btn-icon {
        padding: 0.5rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-edit { color: var(--primary-color); background-color: rgba(79, 70, 229, 0.1); }
    .btn-delete { color: var(--danger-color); background-color: rgba(239, 68, 68, 0.1); }
</style>
@endpush

@section('content')
    <div class="panel">
        <div class="panel-header" style="flex-direction: column; align-items: flex-start; gap: 1rem;">
            <div>
                <h2 class="panel-title">Manajemen Data Alumni</h2>
                <p style="font-size: 0.875rem; color: var(--text-secondary); margin-top: 4px;">
                    Kelola data angkatan, video alumni, dan pengaturan tampilan halaman alumni.
                </p>
            </div>
            
            <div style="display: flex; width: 100%; border-bottom: 1px solid var(--border-color); background: var(--bg-body); border-radius: 8px 8px 0 0; overflow: hidden;">
                <a href="?tab=angkatan" class="tab-link {{ $tab == 'angkatan' ? 'active' : '' }}">Data Angkatan</a>
                <a href="?tab=video" class="tab-link {{ $tab == 'video' ? 'active' : '' }}">Video YouTube</a>
                <a href="?tab=settings" class="tab-link {{ $tab == 'settings' ? 'active' : '' }}">Pengaturan</a>
            </div>
        </div>

        <div class="panel-body">
            @if($tab == 'angkatan')
                <!-- TAB ANGKATAN -->
                <div style="margin-bottom: 1.5rem; display: flex; justify-content: flex-end;">
                    <button class="btn btn-primary" onclick="openAngkatanModal()">
                        <i data-feather="plus"></i> Tambah Angkatan
                    </button>
                </div>
                
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color); background: var(--bg-body);">
                                <th style="padding: 1rem; color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase;">Tahun</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase;">Nama Angkatan</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase;">Persentase Kelulusan</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase;">Flyer</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase;">Status</th>
                                <th style="padding: 1rem; text-align: right; color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($angkatanList as $angkatan)
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="padding: 1rem; font-weight: 600;">{{ $angkatan->tahun_lulus }}</td>
                                    <td style="padding: 1rem;">
                                        <div style="font-weight: 600;">{{ $angkatan->nama_angkatan }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-secondary);">Angkatan ke-{{ $angkatan->nomor_angkatan }}</div>
                                    </td>
                                    <td style="padding: 1rem; font-size: 0.875rem;">
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4px;">
                                            <div>PTN: <strong>{{ $angkatan->persen_ptn }}%</strong></div>
                                            <div>PTS: <strong>{{ $angkatan->persen_pts }}%</strong></div>
                                            <div>PTLN: <strong>{{ $angkatan->persen_ptln }}%</strong></div>
                                            <div>Kedinasan: <strong>{{ $angkatan->persen_kedinasan }}%</strong></div>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem;">
                                        @if($angkatan->flyer_image)
                                            @php
                                                $adminFlyerUrl = \Illuminate\Support\Str::startsWith($angkatan->flyer_image, ['http://', 'https://'])
                                                    ? $angkatan->flyer_image
                                                    : Storage::url($angkatan->flyer_image);
                                            @endphp
                                            <a href="{{ $adminFlyerUrl }}" target="_blank">
                                                <img src="{{ $adminFlyerUrl }}" alt="Flyer" style="height: 48px; border-radius: 4px; border: 1px solid var(--border-color); object-fit: cover;">
                                            </a>
                                        @else
                                            <span style="color: var(--text-secondary); font-size: 0.75rem; font-style: italic;">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; flex-direction: column; gap: 4px; align-items: flex-start;">
                                            @if($angkatan->is_highlighted)
                                                <span class="badge badge-warning"><i data-feather="star" style="width: 12px; height: 12px;"></i> Unggulan</span>
                                            @endif
                                            @if($angkatan->is_active)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-danger">Nonaktif</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div class="table-actions">
                                            <button type="button" onclick="editAngkatan({{ json_encode($angkatan) }})" class="btn-icon btn-edit" title="Edit">
                                                <i data-feather="edit-2" style="width: 16px; height: 16px;"></i>
                                            </button>
                                            <form action="{{ route('admin.alumni.angkatan.destroy', $angkatan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data angkatan ini?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-icon btn-delete" title="Hapus">
                                                    <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 3rem 1rem; color: var(--text-secondary);">
                                        <i data-feather="users" style="width: 48px; height: 48px; opacity: 0.2; margin-bottom: 1rem;"></i>
                                        <p>Belum ada data angkatan alumni.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @elseif($tab == 'video')
                <!-- TAB VIDEO -->
                <div style="margin-bottom: 1.5rem; display: flex; justify-content: flex-end;">
                    <button class="btn btn-primary" onclick="openVideoModal()">
                        <i data-feather="plus"></i> Tambah Video
                    </button>
                </div>
                
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color); background: var(--bg-body);">
                                <th style="padding: 1rem; color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase;">Judul & Info</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase;">URL YouTube</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase;">Tahun</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase;">Status</th>
                                <th style="padding: 1rem; text-align: right; color: var(--text-secondary); font-size: 0.85rem; text-transform: uppercase;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($videoList as $video)
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="padding: 1rem;">
                                        <div style="font-weight: 600;">{{ $video->judul }}</div>
                                        @if($video->deskripsi)
                                            <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 4px; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $video->deskripsi }}</div>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem;">
                                        <a href="{{ $video->youtube_url }}" target="_blank" style="color: var(--primary-color); font-size: 0.875rem; display: inline-flex; align-items: center; gap: 4px;">
                                            <i data-feather="external-link" style="width: 14px; height: 14px;"></i> Buka Link
                                        </a>
                                    </td>
                                    <td style="padding: 1rem; font-weight: 600;">
                                        {{ $video->tahun ?? '-' }}
                                    </td>
                                    <td style="padding: 1rem;">
                                        @if($video->is_active)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div class="table-actions">
                                            <button type="button" onclick="editVideo({{ json_encode($video) }})" class="btn-icon btn-edit" title="Edit">
                                                <i data-feather="edit-2" style="width: 16px; height: 16px;"></i>
                                            </button>
                                            <form action="{{ route('admin.alumni.video.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus video ini?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-icon btn-delete" title="Hapus">
                                                    <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 3rem 1rem; color: var(--text-secondary);">
                                        <i data-feather="video" style="width: 48px; height: 48px; opacity: 0.2; margin-bottom: 1rem;"></i>
                                        <p>Belum ada data video alumni.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @elseif($tab == 'settings')
                <!-- TAB SETTINGS -->
                <form action="{{ route('admin.alumni.settings.update') }}" method="POST" style="max-width: 800px;">
                    @csrf
                    
                    <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem;">
                        <h3 style="font-size: 1rem; margin-bottom: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem;">Status Halaman Alumni</h3>
                        <div class="form-group checkbox-group" style="margin-bottom: 0;">
                            <input type="hidden" name="alumni_is_active" value="0">
                            <input type="checkbox" id="alumni_is_active" name="alumni_is_active" value="1" {{ ($settings['alumni_is_active'] ?? '1') == '1' ? 'checked' : '' }}>
                            <label for="alumni_is_active" style="font-weight: 500; cursor: pointer;">Aktifkan Halaman Alumni</label>
                        </div>
                        <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 4px; margin-left: 24px;">Jika nonaktif, halaman alumni tidak dapat diakses oleh publik.</p>
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <h3 style="font-size: 1.125rem; margin-bottom: 1rem;">Hero Section</h3>
                        
                        <div class="form-group">
                            <label class="form-label" for="alumni_hero_title">Judul Hero (Title)</label>
                            <input type="text" id="alumni_hero_title" name="alumni_hero_title" class="form-control" value="{{ old('alumni_hero_title', $settings['alumni_hero_title'] ?? '') }}" placeholder="Contoh: Merajut Masa Depan Bersama">
                            @error('alumni_hero_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="alumni_hero_subtitle">Sub Judul Hero (Subtitle)</label>
                            <input type="text" id="alumni_hero_subtitle" name="alumni_hero_subtitle" class="form-control" value="{{ old('alumni_hero_subtitle', $settings['alumni_hero_subtitle'] ?? '') }}" placeholder="Contoh: ALUMNI SEKOLAH BINTANG MADANI">
                            @error('alumni_hero_subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="alumni_hero_description">Deskripsi Hero</label>
                            <textarea id="alumni_hero_description" name="alumni_hero_description" class="form-control" rows="3" placeholder="Deskripsi singkat...">{{ old('alumni_hero_description', $settings['alumni_hero_description'] ?? '') }}</textarea>
                            @error('alumni_hero_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <h3 style="font-size: 1.125rem; margin-bottom: 1rem;">Section Judul</h3>
                        
                        <div class="form-group">
                            <label class="form-label" for="alumni_stats_title">Judul Statistik (Statistik Keberhasilan)</label>
                            <input type="text" id="alumni_stats_title" name="alumni_stats_title" class="form-control" value="{{ old('alumni_stats_title', $settings['alumni_stats_title'] ?? 'Statistik Keberhasilan') }}">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="alumni_flyer_title">Judul Flyer (Flyer Arsip Kelulusan)</label>
                            <input type="text" id="alumni_flyer_title" name="alumni_flyer_title" class="form-control" value="{{ old('alumni_flyer_title', $settings['alumni_flyer_title'] ?? 'Flyer Arsip Kelulusan') }}">
                        </div>
                    </div>

                    @php
                        $navLinks = json_decode($settings['alumni_navbar_links'] ?? '[]', true);
                        if (empty($navLinks)) {
                            $navLinks = [
                                ['label' => 'Beranda', 'url' => url('/')],
                                ['label' => 'Profil', 'url' => url('/#welcome')],
                                ['label' => 'Berita', 'url' => route('posts.index')],
                                ['label' => 'Alumni', 'url' => route('alumni.index')],
                            ];
                        }
                    @endphp

                    <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.75rem;">
                            <div>
                                <h3 style="font-size: 1.05rem; margin: 0;">Menu Navbar Khusus Halaman Alumni</h3>
                                <p style="font-size: 0.75rem; color: var(--text-secondary); margin: 2px 0 0;">Sesuaikan daftar menu navigasi dan tombol CTA di bagian atas halaman Alumni.</p>
                            </div>
                            <button type="button" class="btn" style="background: #e2e8f0; color: #1e293b; font-size: 0.8rem; padding: 6px 12px;" onclick="addAlumniNavRow()">
                                <i data-feather="plus" style="width: 14px; height: 14px;"></i> Tambah Menu
                            </button>
                        </div>

                        <div class="form-row">
                            <div class="form-group form-col">
                                <label class="form-label" for="alumni_brand_title">Teks Brand Utama</label>
                                <input type="text" id="alumni_brand_title" name="alumni_brand_title" class="form-control" value="{{ old('alumni_brand_title', $settings['alumni_brand_title'] ?? 'LAJNAH PENDIDIKAN') }}">
                            </div>
                            <div class="form-group form-col">
                                <label class="form-label" for="alumni_brand_subtitle">Sub-teks Brand</label>
                                <input type="text" id="alumni_brand_subtitle" name="alumni_brand_subtitle" class="form-control" value="{{ old('alumni_brand_subtitle', $settings['alumni_brand_subtitle'] ?? 'AL IRSYAD AL ISLAMIYYAH KARAWANG') }}">
                            </div>
                        </div>

                        <div id="alumniNavContainer" style="margin-bottom: 1rem;">
                            @foreach($navLinks as $link)
                                <div class="form-row alumni-nav-row" style="align-items: center; margin-bottom: 0.5rem;">
                                    <div class="form-col" style="flex: 1;">
                                        <input type="text" name="nav_labels[]" class="form-control" value="{{ $link['label'] }}" placeholder="Label Menu (mis. Beranda)">
                                    </div>
                                    <div class="form-col" style="flex: 1.5;">
                                        <input type="text" name="nav_urls[]" class="form-control" value="{{ $link['url'] }}" placeholder="URL Tujuan (mis. / atau /berita)">
                                    </div>
                                    <div style="flex: 0 0 auto;">
                                        <button type="button" class="btn-icon btn-delete" onclick="this.closest('.alumni-nav-row').remove()" title="Hapus Menu">
                                            <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-row" style="border-top: 1px dashed #cbd5e1; padding-top: 1rem;">
                            <div class="form-group form-col" style="margin-bottom: 0;">
                                <label class="form-label" for="alumni_cta_text">Teks Tombol Kanan (CTA)</label>
                                <input type="text" id="alumni_cta_text" name="alumni_cta_text" class="form-control" value="{{ old('alumni_cta_text', $settings['alumni_cta_text'] ?? 'PPDB Online') }}" placeholder="PPDB Online">
                            </div>
                            <div class="form-group form-col" style="margin-bottom: 0;">
                                <label class="form-label" for="alumni_cta_url">URL Tombol Kanan (CTA)</label>
                                <input type="text" id="alumni_cta_url" name="alumni_cta_url" class="form-control" value="{{ old('alumni_cta_url', $settings['alumni_cta_url'] ?? ($settings['contact_ppdb_link'] ?? 'https://smart.alirsyad.sch.id/pendaftaran')) }}" placeholder="https://smart.alirsyad.sch.id/pendaftaran">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i data-feather="save"></i> Simpan Pengaturan
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- MODAL ANGKATAN -->
    @if($tab == 'angkatan')
        <div id="angkatanModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="angkatanModalTitle">Tambah Angkatan</h3>
                    <button type="button" class="close-modal" onclick="closeAngkatanModal()"><i data-feather="x"></i></button>
                </div>
                <form id="angkatanForm" method="POST" action="{{ route('admin.alumni.angkatan.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div id="angkatanMethod"></div>
                    
                    <div class="form-row">
                        <div class="form-group form-col">
                            <label class="form-label" for="tahun_lulus">Tahun Lulus <span style="color:red;">*</span></label>
                            <input type="number" id="tahun_lulus" name="tahun_lulus" class="form-control" required placeholder="YYYY">
                        </div>
                        <div class="form-group form-col">
                            <label class="form-label" for="nama_angkatan">Nama Angkatan <span style="color:red;">*</span></label>
                            <input type="text" id="nama_angkatan" name="nama_angkatan" class="form-control" required placeholder="Misal: Angkatan IV">
                        </div>
                        <div class="form-group form-col">
                            <label class="form-label" for="nomor_angkatan">Angkatan Ke- <span style="color:red;">*</span></label>
                            <input type="number" id="nomor_angkatan" name="nomor_angkatan" class="form-control" required min="1">
                        </div>
                    </div>

                    <h4 style="font-size: 0.875rem; color: var(--text-secondary); margin: 1rem 0 0.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Persentase Kelulusan (%)</h4>
                    <div class="form-row">
                        <div class="form-group form-col">
                            <label class="form-label" for="persen_ptn">PTN</label>
                            <input type="number" step="0.01" id="persen_ptn" name="persen_ptn" class="form-control" value="0">
                        </div>
                        <div class="form-group form-col">
                            <label class="form-label" for="persen_pts">PTS</label>
                            <input type="number" step="0.01" id="persen_pts" name="persen_pts" class="form-control" value="0">
                        </div>
                        <div class="form-group form-col">
                            <label class="form-label" for="persen_ptln">PT Luar Negeri</label>
                            <input type="number" step="0.01" id="persen_ptln" name="persen_ptln" class="form-control" value="0">
                        </div>
                        <div class="form-group form-col">
                            <label class="form-label" for="persen_kedinasan">Kedinasan</label>
                            <input type="number" step="0.01" id="persen_kedinasan" name="persen_kedinasan" class="form-control" value="0">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="flyer_image">Flyer Kelulusan (Gambar)</label>
                        <input type="file" id="flyer_image" name="flyer_image" class="form-control" accept="image/*">
                        <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 4px;">Biarkan kosong jika tidak ingin mengubah/menambahkan flyer.</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="catatan">Catatan / Keterangan</label>
                        <textarea id="catatan" name="catatan" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="form-row" style="margin-top: 1.5rem; background: #f8fafc; padding: 1rem; border-radius: 8px;">
                        <div class="form-group checkbox-group form-col" style="margin-bottom: 0;">
                            <input type="hidden" name="is_highlighted" value="0">
                            <input type="checkbox" id="is_highlighted" name="is_highlighted" value="1">
                            <label for="is_highlighted" style="font-weight: 500; cursor: pointer;">Tandai sebagai Unggulan <i data-feather="star" style="width: 14px; height: 14px; color: #f59e0b;"></i></label>
                        </div>
                        <div class="form-group checkbox-group form-col" style="margin-bottom: 0;">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label for="is_active" style="font-weight: 500; cursor: pointer;">Status Aktif (Tampil)</label>
                        </div>
                    </div>

                    <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
                        <button type="button" class="btn" style="background: #e2e8f0; color: #475569;" onclick="closeAngkatanModal()">Batal</button>
                        <button type="submit" class="btn btn-primary"><i data-feather="save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- MODAL VIDEO -->
    @if($tab == 'video')
        <div id="videoModal" class="modal">
            <div class="modal-content" style="max-width: 500px;">
                <div class="modal-header">
                    <h3 class="modal-title" id="videoModalTitle">Tambah Video</h3>
                    <button type="button" class="close-modal" onclick="closeVideoModal()"><i data-feather="x"></i></button>
                </div>
                <form id="videoForm" method="POST" action="{{ route('admin.alumni.video.store') }}">
                    @csrf
                    <div id="videoMethod"></div>
                    
                    <div class="form-group">
                        <label class="form-label" for="judul">Judul Video <span style="color:red;">*</span></label>
                        <input type="text" id="judul" name="judul" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="youtube_url">URL YouTube <span style="color:red;">*</span></label>
                        <input type="url" id="youtube_url" name="youtube_url" class="form-control" required placeholder="https://youtube.com/...">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tahun">Tahun <span style="color:red;">*</span></label>
                        <input type="number" id="tahun" name="tahun" class="form-control" required placeholder="YYYY">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="deskripsi">Deskripsi Singkat</label>
                        <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group checkbox-group" style="margin-top: 1.5rem; background: #f8fafc; padding: 1rem; border-radius: 8px;">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" id="video_is_active" name="is_active" value="1" checked>
                        <label for="video_is_active" style="font-weight: 500; cursor: pointer;">Status Aktif (Tampil)</label>
                    </div>

                    <div style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
                        <button type="button" class="btn" style="background: #e2e8f0; color: #475569;" onclick="closeVideoModal()">Batal</button>
                        <button type="submit" class="btn btn-primary"><i data-feather="save"></i> Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    // Tab Angkatan Scripts
    @if($tab == 'angkatan')
        const angkatanModal = document.getElementById('angkatanModal');
        const angkatanForm = document.getElementById('angkatanForm');
        const angkatanModalTitle = document.getElementById('angkatanModalTitle');
        const angkatanMethod = document.getElementById('angkatanMethod');

        function openAngkatanModal() {
            angkatanForm.reset();
            angkatanForm.action = "{{ route('admin.alumni.angkatan.store') }}";
            angkatanMethod.innerHTML = '';
            angkatanModalTitle.innerText = 'Tambah Data Angkatan';
            
            // Set default values
            document.getElementById('is_active').checked = true;
            document.getElementById('is_highlighted').checked = false;
            
            angkatanModal.classList.add('show');
        }

        function closeAngkatanModal() {
            angkatanModal.classList.remove('show');
        }

        function editAngkatan(data) {
            angkatanForm.action = "{{ url('admin/alumni/angkatan') }}/" + data.id;
            angkatanMethod.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            angkatanModalTitle.innerText = 'Edit Data Angkatan';
            
            document.getElementById('tahun_lulus').value = data.tahun_lulus;
            document.getElementById('nama_angkatan').value = data.nama_angkatan;
            document.getElementById('nomor_angkatan').value = data.nomor_angkatan;
            document.getElementById('persen_ptn').value = data.persen_ptn;
            document.getElementById('persen_pts').value = data.persen_pts;
            document.getElementById('persen_ptln').value = data.persen_ptln;
            document.getElementById('persen_kedinasan').value = data.persen_kedinasan;
            document.getElementById('catatan').value = data.catatan || '';
            
            document.getElementById('is_highlighted').checked = data.is_highlighted;
            document.getElementById('is_active').checked = data.is_active;
            
            angkatanModal.classList.add('show');
        }
    @endif

    // Tab Video Scripts
    @if($tab == 'video')
        const videoModal = document.getElementById('videoModal');
        const videoForm = document.getElementById('videoForm');
        const videoModalTitle = document.getElementById('videoModalTitle');
        const videoMethod = document.getElementById('videoMethod');

        function openVideoModal() {
            videoForm.reset();
            videoForm.action = "{{ route('admin.alumni.video.store') }}";
            videoMethod.innerHTML = '';
            videoModalTitle.innerText = 'Tambah Video';
            
            document.getElementById('video_is_active').checked = true;
            
            videoModal.classList.add('show');
        }

        function closeVideoModal() {
            videoModal.classList.remove('show');
        }

        function editVideo(data) {
            videoForm.action = "{{ url('admin/alumni/video') }}/" + data.id;
            videoMethod.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            videoModalTitle.innerText = 'Edit Video';
            
            document.getElementById('judul').value = data.judul;
            document.getElementById('youtube_url').value = data.youtube_url;
            document.getElementById('tahun').value = data.tahun;
            document.getElementById('deskripsi').value = data.deskripsi || '';
            document.getElementById('video_is_active').checked = data.is_active;
            
            videoModal.classList.add('show');
        }
    @endif

    // Close modals when clicking outside
    window.onclick = function(event) {
        @if($tab == 'angkatan')
            if (event.target == angkatanModal) {
                closeAngkatanModal();
            }
        @endif
        @if($tab == 'video')
            if (event.target == videoModal) {
                closeVideoModal();
            }
        @endif
    }

    function addAlumniNavRow() {
        const container = document.getElementById('alumniNavContainer');
        if (!container) return;
        const row = document.createElement('div');
        row.className = 'form-row alumni-nav-row';
        row.style.cssText = 'align-items: center; margin-bottom: 0.5rem;';
        row.innerHTML = `
            <div class="form-col" style="flex: 1;">
                <input type="text" name="nav_labels[]" class="form-control" placeholder="Label Menu (mis. Beranda)">
            </div>
            <div class="form-col" style="flex: 1.5;">
                <input type="text" name="nav_urls[]" class="form-control" placeholder="URL Tujuan (mis. / atau /berita)">
            </div>
            <div style="flex: 0 0 auto;">
                <button type="button" class="btn-icon btn-delete" onclick="this.closest('.alumni-nav-row').remove()" title="Hapus Menu">
                    <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }
</script>
@endpush
