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
                <input type="file" name="image_file" class="form-control" style="width: 100%; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 6px;" accept="image/*">
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
@push('scripts')
<script>
    function updateIconPreview(val) {
        const preview = document.getElementById('icon-preview');
        preview.innerHTML = `<i data-feather="${val}"></i>`;
        if (window.feather) feather.replace();
    }
</script>
@endpush
@endsection
