@extends('admin.layouts.app')

@section('title', 'Manajemen Ekstrakurikuler')

@section('content')
<div class="panel">
    <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h2 class="panel-title">Daftar Ekstrakurikuler</h2>
        <a href="{{ route('admin.extracurriculars.create') }}" class="btn btn-primary">
            <i data-feather="plus"></i> Tambah Ekstrakurikuler
        </a>
    </div>
    <div class="panel-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="table-responsive">
            <table class="table" style="width: 100%; border-collapse: collapse; margin-bottom: 1rem;">
                <thead style="background-color: var(--surface-color); border-bottom: 2px solid var(--border-color);">
                    <tr>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-secondary); width: 80px;">Urutan</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-secondary); width: 100px;">Gambar</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-secondary);">Nama Ekstrakurikuler</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-secondary);">Kategori</th>
                        <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-secondary);">Status</th>
                        <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--text-secondary);">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($extracurriculars as $f)
                    <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor='transparent'">
                        <td style="padding: 1rem; font-weight: 600; color: var(--text-primary);">{{ $f->order }}</td>
                        <td style="padding: 1rem;">
                            @if($f->image)
                                @php
                                    $imgUrl = (str_starts_with($f->image, 'http') || str_starts_with($f->image, '/')) ? url($f->image) : asset('storage/' . $f->image);
                                @endphp
                                <img src="{{ $imgUrl }}" alt="{{ $f->title }}" width="60" height="40" style="object-fit:cover; border-radius:6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            @else
                                <span style="font-size: 12px; color: #999;">No Image</span>
                            @endif
                        </td>
                        <td style="padding: 1rem; font-weight: 600; color: var(--text-primary);">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                @if($f->icon)
                                    <i data-feather="{{ $f->icon }}" style="width: 16px; height: 16px; color: var(--primary-color);"></i>
                                @endif
                                <span>{{ $f->title }}</span>
                            </div>
                            <span style="font-size: 12px; font-weight: 400; color: var(--text-secondary);">{{ Str::limit(strip_tags($f->desc), 50) }}</span>
                        </td>
                        <td style="padding: 1rem;">
                            <span style="background-color: #e0e7ff; color: #4338ca; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                {{ $f->category }}
                            </span>
                        </td>
                        <td style="padding: 1rem;">
                            @if($f->is_active)
                                <span style="display: inline-flex; align-items: center; gap: 5px; background-color: rgba(16, 185, 129, 0.1); color: #059669; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Aktif</span>
                            @else
                                <span style="display: inline-flex; align-items: center; gap: 5px; background-color: rgba(107, 114, 128, 0.12); color: #4b5563; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Nonaktif</span>
                            @endif
                        </td>
                        <td style="padding: 1rem; text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                <a href="{{ route('admin.extracurriculars.edit', $f->id) }}" style="padding: 0.5rem; color: var(--primary-color); background-color: rgba(79, 70, 229, 0.1); border-radius: 6px;" title="Edit">
                                    <i data-feather="edit-2" style="width: 18px; height: 18px;"></i>
                                </a>
                                <form action="{{ route('admin.extracurriculars.destroy', $f->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="padding: 0.5rem; color: var(--danger-color); background-color: rgba(239, 68, 68, 0.1); border: none; border-radius: 6px; cursor: pointer;" title="Hapus">
                                        <i data-feather="trash-2" style="width: 18px; height: 18px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
