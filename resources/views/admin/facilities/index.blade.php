@extends('admin.layouts.app')

@section('title', 'Manajemen Fasilitas')
@section('page_title', 'Fasilitas')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Fasilitas</h5>
        <a href="{{ route('admin.facilities.create') }}" class="btn btn-primary btn-sm">Tambah Fasilitas</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Urutan</th>
                        <th>Gambar</th>
                        <th>Nama Fasilitas</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($facilities as $f)
                    <tr>
                        <td>{{ $f->order }}</td>
                        <td>
                            @if($f->image)
                                <img src="{{ $f->image }}" alt="{{ $f->title }}" width="60" style="border-radius:5px;">
                            @else
                                <span class="badge bg-secondary">No Image</span>
                            @endif
                        </td>
                        <td>{{ $f->title }}</td>
                        <td>{{ $f->category }}</td>
                        <td>
                            @if($f->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.facilities.edit', $f->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.facilities.destroy', $f->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
