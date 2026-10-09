@extends('admin.layouts.app')

@section('title', 'Edit Fasilitas')

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2 class="panel-title">Edit Fasilitas</h2>
    </div>
    <div class="panel-body">
        <form action="{{ route('admin.facilities.update', $facility->id) }}" method="POST" enctype="multipart/form-data" style="max-width: 800px;">
            @csrf @method('PUT')
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nama Fasilitas</label>
                <input type="text" name="title" class="form-control" style="width: 100%; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 6px;" value="{{ old('title', $facility->title) }}" required>
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Kategori</label>
                <select name="category" class="form-control" style="width: 100%; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 6px;" required>
                    <option value="class" {{ $facility->category == 'class' ? 'selected' : '' }}>Ruang Belajar & Kelas</option>
                    <option value="lab" {{ $facility->category == 'lab' ? 'selected' : '' }}>Laboratorium & IT</option>
                    <option value="worship" {{ $facility->category == 'worship' ? 'selected' : '' }}>Sarana Ibadah & Adab</option>
                    <option value="sport" {{ $facility->category == 'sport' ? 'selected' : '' }}>Olahraga & Bermain</option>
                    <option value="service" {{ $facility->category == 'service' ? 'selected' : '' }}>Layanan & Keamanan</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Badge (Opsional)</label>
                <input type="text" name="badge" class="form-control" style="width: 100%; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 6px;" value="{{ old('badge', $facility->badge) }}">
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Icon (Pilih dari daftar)</label>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <div id="icon-preview" style="padding: 0.625rem; background: var(--surface-color); border: 1px solid var(--border-color); border-radius: 6px; display: flex; align-items: center; justify-content: center; min-width: 48px; min-height: 48px;">
                        <i data-feather="{{ old('icon', $facility->icon ?? 'check-circle') }}"></i>
                    </div>
                    <select name="icon" id="icon-select" class="form-control" style="width: 100%; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 6px;" onchange="updateIconPreview(this.value)">
                        <option value="check-circle" {{ old('icon', $facility->icon) == 'check-circle' ? 'selected' : '' }}>Default (Ceklis)</option>
                        
                        <optgroup label="Akademik & Ruang Kelas">
                            <option value="book" {{ old('icon', $facility->icon) == 'book' ? 'selected' : '' }}>Buku</option>
                            <option value="book-open" {{ old('icon', $facility->icon) == 'book-open' ? 'selected' : '' }}>Buku Terbuka (Perpustakaan)</option>
                            <option value="edit-3" {{ old('icon', $facility->icon) == 'edit-3' ? 'selected' : '' }}>Pena/Menulis</option>
                            <option value="award" {{ old('icon', $facility->icon) == 'award' ? 'selected' : '' }}>Penghargaan/Prestasi</option>
                        </optgroup>

                        <optgroup label="IT & Laboratorium">
                            <option value="cpu" {{ old('icon', $facility->icon) == 'cpu' ? 'selected' : '' }}>CPU/Prosesor (Lab Komputer)</option>
                            <option value="monitor" {{ old('icon', $facility->icon) == 'monitor' ? 'selected' : '' }}>Monitor/Layar</option>
                            <option value="airplay" {{ old('icon', $facility->icon) == 'airplay' ? 'selected' : '' }}>Airplay/Proyektor (Smart Class)</option>
                            <option value="zap" {{ old('icon', $facility->icon) == 'zap' ? 'selected' : '' }}>Listrik/Energi (Lab Sains)</option>
                            <option value="sliders" {{ old('icon', $facility->icon) == 'sliders' ? 'selected' : '' }}>Pengaturan/Robotik</option>
                            <option value="globe" {{ old('icon', $facility->icon) == 'globe' ? 'selected' : '' }}>Global/Internet (Lab Bahasa)</option>
                            <option value="database" {{ old('icon', $facility->icon) == 'database' ? 'selected' : '' }}>Server/Data</option>
                        </optgroup>

                        <optgroup label="Agama & Karakter">
                            <option value="sun" {{ old('icon', $facility->icon) == 'sun' ? 'selected' : '' }}>Cahaya/Matahari (Masjid)</option>
                            <option value="users" {{ old('icon', $facility->icon) == 'users' ? 'selected' : '' }}>Jamaah/Orang Banyak (Aula)</option>
                            <option value="heart" {{ old('icon', $facility->icon) == 'heart' ? 'selected' : '' }}>Hati/Karakter (UKS/Kesehatan)</option>
                            <option value="smile" {{ old('icon', $facility->icon) == 'smile' ? 'selected' : '' }}>Senyum (Playgroup/TK)</option>
                        </optgroup>

                        <optgroup label="Olahraga & Fasilitas Fisik">
                            <option value="activity" {{ old('icon', $facility->icon) == 'activity' ? 'selected' : '' }}>Aktivitas/Olahraga</option>
                            <option value="droplet" {{ old('icon', $facility->icon) == 'droplet' ? 'selected' : '' }}>Air (Kolam Renang)</option>
                            <option value="target" {{ old('icon', $facility->icon) == 'target' ? 'selected' : '' }}>Target (Panahan)</option>
                        </optgroup>

                        <optgroup label="Fasilitas Umum & Layanan">
                            <option value="shield" {{ old('icon', $facility->icon) == 'shield' ? 'selected' : '' }}>Perisai (Keamanan/CCTV)</option>
                            <option value="truck" {{ old('icon', $facility->icon) == 'truck' ? 'selected' : '' }}>Kendaraan (Antar-Jemput)</option>
                            <option value="coffee" {{ old('icon', $facility->icon) == 'coffee' ? 'selected' : '' }}>Kopi/Makanan (Kantin)</option>
                            <option value="shopping-cart" {{ old('icon', $facility->icon) == 'shopping-cart' ? 'selected' : '' }}>Keranjang (Koperasi/Mart)</option>
                            <option value="briefcase" {{ old('icon', $facility->icon) == 'briefcase' ? 'selected' : '' }}>Tas Kerja (Kantor/Admin)</option>
                            <option value="credit-card" {{ old('icon', $facility->icon) == 'credit-card' ? 'selected' : '' }}>Kartu (Smart Card)</option>
                            <option value="wifi" {{ old('icon', $facility->icon) == 'wifi' ? 'selected' : '' }}>Sinyal WiFi</option>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Deskripsi</label>
                <textarea name="desc" class="form-control" style="width: 100%; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 6px;" rows="3">{{ old('desc', $facility->desc) }}</textarea>
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Gambar (Opsional)</label>
                @if($facility->image)
                    <div style="margin-bottom: 0.5rem;">
                        <img src="{{ $facility->image }}" alt="Preview" width="120" style="border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    </div>
                @endif
                <input type="file" name="image_file" class="form-control" style="width: 100%; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 6px;" accept="image/*">
                <small style="color: var(--text-secondary); display: block; margin-top: 0.25rem;">Biarkan kosong jika tidak ingin mengubah gambar.</small>
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Urutan Tampil (Order)</label>
                <input type="number" name="order" class="form-control" style="width: 100px; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 6px;" value="{{ old('order', $facility->order) }}">
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $facility->is_active ? 'checked' : '' }} style="width: 18px; height: 18px;">
                <label class="form-label" for="is_active" style="margin-bottom: 0; font-weight: 500; cursor: pointer;">Aktif (Tampilkan di halaman depan)</label>
            </div>
            
            <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary"><i data-feather="save" style="width: 16px; margin-right: 5px;"></i> Update</button>
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
