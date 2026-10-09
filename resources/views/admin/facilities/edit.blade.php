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
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Icon (Opsional)</label>
                <input type="text" name="icon" class="form-control" style="width: 100%; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 6px;" value="{{ old('icon', $facility->icon) }}">
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
@endsection
