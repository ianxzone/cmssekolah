@extends('admin.layouts.app')

@section('title', 'Edit Fasilitas')
@section('page_title', 'Fasilitas')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Fasilitas</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.facilities.update', $facility->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Fasilitas</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $facility->title) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="category" class="form-select" required>
                    <option value="class" {{ $facility->category == 'class' ? 'selected' : '' }}>Ruang Belajar & Kelas</option>
                    <option value="lab" {{ $facility->category == 'lab' ? 'selected' : '' }}>Laboratorium & IT</option>
                    <option value="worship" {{ $facility->category == 'worship' ? 'selected' : '' }}>Sarana Ibadah & Adab</option>
                    <option value="sport" {{ $facility->category == 'sport' ? 'selected' : '' }}>Olahraga & Bermain</option>
                    <option value="service" {{ $facility->category == 'service' ? 'selected' : '' }}>Layanan & Keamanan</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Badge (Opsional)</label>
                <input type="text" name="badge" class="form-control" value="{{ old('badge', $facility->badge) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Icon (Opsional)</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon', $facility->icon) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="desc" class="form-control" rows="3">{{ old('desc', $facility->desc) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar (Opsional)</label>
                @if($facility->image)
                    <div class="mb-2">
                        <img src="{{ $facility->image }}" alt="Preview" width="120" class="rounded">
                    </div>
                @endif
                <input type="file" name="image_file" class="form-control" accept="image/*">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Urutan Tampil (Order)</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $facility->order) }}">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ $facility->is_active ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktif (Tampilkan di halaman depan)</label>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
