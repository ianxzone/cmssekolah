@extends('admin.layouts.app')

@section('title', 'Tambah Fasilitas')
@section('page_title', 'Fasilitas')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Tambah Fasilitas</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Fasilitas</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="category" class="form-select" required>
                    <option value="class">Ruang Belajar & Kelas</option>
                    <option value="lab">Laboratorium & IT</option>
                    <option value="worship">Sarana Ibadah & Adab</option>
                    <option value="sport">Olahraga & Bermain</option>
                    <option value="service">Layanan & Keamanan</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Badge (Opsional)</label>
                <input type="text" name="badge" class="form-control" value="{{ old('badge') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Icon (Opsional, ex: airplay, cpu)</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="desc" class="form-control" rows="3">{{ old('desc') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar (Opsional)</label>
                <input type="file" name="image_file" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label">Urutan Tampil (Order)</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" checked>
                <label class="form-check-label" for="is_active">Aktif (Tampilkan di halaman depan)</label>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
