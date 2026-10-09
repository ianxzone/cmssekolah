@extends('admin.layouts.app')

@section('title', 'Tambah Fasilitas')

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2 class="panel-title">Tambah Fasilitas</h2>
    </div>
    <div class="panel-body">
        <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data" style="max-width: 800px;">
            @csrf
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nama Fasilitas</label>
                <input type="text" name="title" class="form-control" style="width: 100%; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 6px;" value="{{ old('title') }}" required>
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Kategori</label>
                <select name="category" class="form-control" style="width: 100%; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 6px;" required>
                    <option value="class">Ruang Belajar & Kelas</option>
                    <option value="lab">Laboratorium & IT</option>
                    <option value="worship">Sarana Ibadah & Adab</option>
                    <option value="sport">Olahraga & Bermain</option>
                    <option value="service">Layanan & Keamanan</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Badge (Opsional)</label>
                <input type="text" name="badge" class="form-control" style="width: 100%; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 6px;" value="{{ old('badge') }}">
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Icon (Pilih dari daftar)</label>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <div id="icon-preview" style="padding: 0.625rem; background: var(--surface-color); border: 1px solid var(--border-color); border-radius: 6px; display: flex; align-items: center; justify-content: center; min-width: 48px; min-height: 48px;">
                        <i data-feather="{{ old('icon', 'check-circle') }}"></i>
                    </div>
                    <select name="icon" id="icon-select" class="form-control" style="width: 100%; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 6px;" onchange="updateIconPreview(this.value)">
                        <option value="check-circle" {{ old('icon') == 'check-circle' ? 'selected' : '' }}>Default (Ceklis)</option>
                        
                        <optgroup label="Akademik & Ruang Kelas">
                            <option value="book" {{ old('icon') == 'book' ? 'selected' : '' }}>Buku</option>
                            <option value="book-open" {{ old('icon') == 'book-open' ? 'selected' : '' }}>Buku Terbuka (Perpustakaan)</option>
                            <option value="edit-3" {{ old('icon') == 'edit-3' ? 'selected' : '' }}>Pena/Menulis</option>
                            <option value="award" {{ old('icon') == 'award' ? 'selected' : '' }}>Penghargaan/Prestasi</option>
                        </optgroup>

                        <optgroup label="IT & Laboratorium">
                            <option value="cpu" {{ old('icon') == 'cpu' ? 'selected' : '' }}>CPU/Prosesor (Lab Komputer)</option>
                            <option value="monitor" {{ old('icon') == 'monitor' ? 'selected' : '' }}>Monitor/Layar</option>
                            <option value="airplay" {{ old('icon') == 'airplay' ? 'selected' : '' }}>Airplay/Proyektor (Smart Class)</option>
                            <option value="zap" {{ old('icon') == 'zap' ? 'selected' : '' }}>Listrik/Energi (Lab Sains)</option>
                            <option value="sliders" {{ old('icon') == 'sliders' ? 'selected' : '' }}>Pengaturan/Robotik</option>
                            <option value="globe" {{ old('icon') == 'globe' ? 'selected' : '' }}>Global/Internet (Lab Bahasa)</option>
                            <option value="database" {{ old('icon') == 'database' ? 'selected' : '' }}>Server/Data</option>
                        </optgroup>

                        <optgroup label="Agama & Karakter">
                            <option value="sun" {{ old('icon') == 'sun' ? 'selected' : '' }}>Cahaya/Matahari (Masjid)</option>
                            <option value="users" {{ old('icon') == 'users' ? 'selected' : '' }}>Jamaah/Orang Banyak (Aula)</option>
                            <option value="heart" {{ old('icon') == 'heart' ? 'selected' : '' }}>Hati/Karakter (UKS/Kesehatan)</option>
                            <option value="smile" {{ old('icon') == 'smile' ? 'selected' : '' }}>Senyum (Playgroup/TK)</option>
                        </optgroup>

                        <optgroup label="Olahraga & Fasilitas Fisik">
                            <option value="activity" {{ old('icon') == 'activity' ? 'selected' : '' }}>Aktivitas/Olahraga</option>
                            <option value="droplet" {{ old('icon') == 'droplet' ? 'selected' : '' }}>Air (Kolam Renang)</option>
                            <option value="target" {{ old('icon') == 'target' ? 'selected' : '' }}>Target (Panahan)</option>
                        </optgroup>

                        <optgroup label="Fasilitas Umum & Layanan">
                            <option value="shield" {{ old('icon') == 'shield' ? 'selected' : '' }}>Perisai (Keamanan/CCTV)</option>
                            <option value="truck" {{ old('icon') == 'truck' ? 'selected' : '' }}>Kendaraan (Antar-Jemput)</option>
                            <option value="coffee" {{ old('icon') == 'coffee' ? 'selected' : '' }}>Kopi/Makanan (Kantin)</option>
                            <option value="shopping-cart" {{ old('icon') == 'shopping-cart' ? 'selected' : '' }}>Keranjang (Koperasi/Mart)</option>
                            <option value="briefcase" {{ old('icon') == 'briefcase' ? 'selected' : '' }}>Tas Kerja (Kantor/Admin)</option>
                            <option value="credit-card" {{ old('icon') == 'credit-card' ? 'selected' : '' }}>Kartu (Smart Card)</option>
                            <option value="wifi" {{ old('icon') == 'wifi' ? 'selected' : '' }}>Sinyal WiFi</option>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Deskripsi</label>
                <textarea name="desc" class="form-control" style="width: 100%; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 6px;" rows="3">{{ old('desc') }}</textarea>
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Gambar (Opsional)</label>
                <div style="border: 1px dashed var(--border-color); border-radius: 8px; padding: 1rem; text-align: center; background-color: var(--surface-color); position: relative; max-width: 100%;">
                    <!-- Hidden Inputs for logic -->
                    <input type="hidden" name="featured_image_path" id="featured_image_path" value="{{ old('featured_image_path') }}">
                    <input type="hidden" name="remove_image" id="remove_image" value="0">
                    
                    <!-- Preview Wrapper -->
                    <div id="image-preview-wrapper" style="display: none; position: relative; max-width: 250px; margin: 0 auto 1rem auto;">
                        <img id="preview-img" src="#" alt="Preview" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                        <button type="button" onclick="removeFeaturedImage()" class="btn btn-danger" style="position: absolute; top: -10px; right: -10px; padding: 0.25rem; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; z-index: 10;">
                            <i data-feather="x" style="width: 14px; height: 14px;"></i>
                        </button>
                    </div>

                    <!-- Placeholder Wrapper -->
                    <div id="image-placeholder" style="margin-bottom: 1rem; display: block;">
                        <i data-feather="image" style="margin: 0 auto 0.5rem auto; width: 48px; height: 48px; color: #9ca3af; display: block;"></i>
                        <p style="font-size: 0.8125rem; color: #6b7280; margin: 0 0 0.75rem 0;">Belum ada gambar yang dipilih</p>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
                        <button type="button" class="btn btn-primary" onclick="openFeaturedImageMediaPicker()" style="font-size: 0.8125rem; padding: 0.4rem 0.875rem;">
                            <i data-feather="image" style="width: 15px; height: 15px; margin-right: 4px;"></i> Pilih dari Media
                        </button>
                        <label class="btn" style="font-size: 0.8125rem; padding: 0.4rem 0.875rem; background: #f3f4f6; border: 1px solid #d1d5db; color: #374151; cursor: pointer; margin-bottom: 0;">
                            <i data-feather="upload" style="width: 15px; height: 15px; margin-right: 4px;"></i> Upload File
                            <input type="file" id="image" name="image_file" accept="image/*" style="display: none;" onchange="handleDirectFileSelect(event)">
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Urutan Tampil (Order)</label>
                <input type="number" name="order" class="form-control" style="width: 100px; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 6px;" value="{{ old('order', 0) }}">
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked style="width: 18px; height: 18px;">
                <label class="form-label" for="is_active" style="margin-bottom: 0; font-weight: 500; cursor: pointer;">Aktif (Tampilkan di halaman depan)</label>
            </div>
            
            <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary"><i data-feather="save" style="width: 16px; margin-right: 5px;"></i> Simpan</button>
                <a href="{{ route('admin.facilities.index') }}" class="btn btn-outline-white">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container .select2-selection--single {
    height: 42px !important;
    border: 1px solid var(--border-color) !important;
    border-radius: 6px !important;
    display: flex;
    align-items: center;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 40px !important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: var(--text-primary) !important;
    line-height: normal !important;
    padding-left: 0.625rem !important;
}
</style>
@endpush

@push('scripts')
@include('admin.partials.media-modal')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        function formatIcon(icon) {
            if (!icon.id) {
                return icon.text;
            }
            var svg = '';
            if (window.feather && window.feather.icons[icon.id]) {
                svg = window.feather.icons[icon.id].toSvg({ width: 18, height: 18 });
            }
            var $icon = $(
                '<span style="display: flex; align-items: center; gap: 8px;">' + svg + ' <span>' + icon.text + '</span></span>'
            );
            return $icon;
        }

        $('#icon-select').select2({
            templateResult: formatIcon,
            templateSelection: formatIcon,
            width: '100%'
        });

        $('#icon-select').on('change', function() {
            const val = $(this).val();
            const preview = document.getElementById('icon-preview');
            preview.innerHTML = `<i data-feather="${val}"></i>`;
            if (window.feather) feather.replace();
        });
    });

    // Media Picker Logic
    function openFeaturedImageMediaPicker() {
        if (window.openWpMediaModal) {
            window.openWpMediaModal({
                mode: 'featured',
                onSelect: function(item) {
                    document.getElementById('featured_image_path').value = item.path;
                    document.getElementById('remove_image').value = '0';
                    
                    const previewImg = document.getElementById('preview-img');
                    const previewWrapper = document.getElementById('image-preview-wrapper');
                    const placeholder = document.getElementById('image-placeholder');
                    
                    previewImg.src = item.url ? item.url : `/storage/${item.path}`;
                    previewWrapper.style.display = 'block';
                    placeholder.style.display = 'none';

                    if (window.feather) feather.replace();
                }
            });
        } else {
            alert('Media Library tidak tersedia.');
        }
    }

    function handleDirectFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('image-preview-wrapper').style.display = 'block';
                document.getElementById('image-placeholder').style.display = 'none';
                document.getElementById('remove_image').value = '0';
                document.getElementById('featured_image_path').value = '';
                if (window.feather) feather.replace();
            };
            reader.readAsDataURL(file);
        }
    }

    function removeFeaturedImage() {
        document.getElementById('featured_image_path').value = '';
        document.getElementById('remove_image').value = '1';
        document.getElementById('preview-img').src = '#';
        document.getElementById('image-preview-wrapper').style.display = 'none';
        document.getElementById('image-placeholder').style.display = 'block';
        const fileInput = document.getElementById('image');
        if (fileInput) fileInput.value = '';
    }
</script>
@endpush
@endsection
