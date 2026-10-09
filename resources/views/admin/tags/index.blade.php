@extends('admin.layouts.app')

@section('title', 'Manajemen Tags')

@section('content')
    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
        
        <!-- Kolom Kiri: Form Tambah -->
        <div class="panel" style="height: fit-content;">
            <div class="panel-header">
                <h2 class="panel-title">Tambah Tag Baru</h2>
            </div>
            <div class="panel-body">
                <form action="{{ route('admin.tags.store') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 1.5rem;">
                        <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nama Tag</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Contoh: Prestasi" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label for="slug" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Slug URL (Opsional)</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug') }}" placeholder="contoh: prestasi-sekolah" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                        <p style="font-size: 0.8rem; color: #6b7280; margin-top: 0.25rem;">Biarkan kosong untuk generate otomatis dari nama tag.</p>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #4b5563; padding-top: 1rem; border-top: 1px solid #e5e7eb;">Pengaturan SEO (Opsional)</label>
                        <label for="description" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem;">Deskripsi Singkat</label>
                        <textarea id="description" name="description" rows="2" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 1rem;">{{ old('description') }}</textarea>

                        <label for="meta_title" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem;">Meta Title</label>
                        <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 1rem;">

                        <label for="meta_description" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem;">Meta Description</label>
                        <textarea id="meta_description" name="meta_description" rows="2" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 1rem;">{{ old('meta_description') }}</textarea>

                        <label for="meta_keywords" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem;">Meta Keywords</label>
                        <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}" placeholder="pisahkan dengan koma" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Simpan Tag</button>
                </form>
            </div>
        </div>

        <!-- Kolom Kanan: Tabel -->
        <div class="panel">
            <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h2 class="panel-title">Daftar Tags</h2>
                <form action="{{ route('admin.tags.index') }}" method="GET" style="display: flex; gap: 0.5rem;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tag..." style="padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 6px;">
                    <button type="submit" class="btn btn-outline" style="padding: 0.5rem 1rem;">Cari</button>
                </form>
            </div>
            <div class="panel-body">
                @if($tags->count() > 0)
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left;">
                            <thead>
                                <tr style="border-bottom: 2px solid var(--border-color);">
                                    <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Nama</th>
                                    <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Slug</th>
                                    <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Jumlah Post</th>
                                    <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500; text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tags as $tag)
                                    <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.15s ease;" onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor='transparent'">
                                        <td style="padding: 1rem; font-weight: 500; color: var(--text-primary);">{{ $tag->name }}</td>
                                        <td style="padding: 1rem; color: var(--text-secondary);">{{ $tag->slug }}</td>
                                        
                                        <!-- Kolom Statis -->
                                        <td style="padding: 1rem;">
                                            <span style="background: #f3f4f6; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.875rem;">{{ $tag->posts_count }} post</span>
                                        </td>
                                        <td style="padding: 1rem; text-align: right;">
                                            <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                                <a href="{{ route('admin.tags.edit', $tag->id) }}" class="btn btn-outline" style="padding: 0.4rem 0.75rem;" title="Edit">
                                                    <i data-feather="edit-2" style="width: 14px; height: 14px;"></i>
                                                </a>
                                                <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tag ini? Semua relasi pada post akan hilang.');" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline" style="padding: 0.4rem 0.75rem; color: var(--danger-color); border-color: #fee2e2;" title="Hapus">
                                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 1.5rem;">
                        {{ $tags->links() }}
                    </div>
                @else
                    <div style="text-align: center; padding: 3rem 1rem; color: var(--text-secondary);">
                        <i data-feather="hash" style="width: 48px; height: 48px; opacity: 0.5; margin-bottom: 1rem;"></i>
                        <p>Belum ada tag yang ditambahkan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
