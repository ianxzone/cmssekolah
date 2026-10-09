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
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Icon (Opsional, ex: airplay, cpu)</label>
                <input type="text" name="icon" class="form-control" style="width: 100%; padding: 0.625rem; border: 1px solid var(--border-color); border-radius: 6px;" value="{{ old('icon') }}">
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
@endsection
