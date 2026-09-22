@extends('admin.layouts.app')

@section('title', 'Kelola Data SDM & Pimpinan')

@section('content')
    <div class="panel">
        <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 class="panel-title">Data SDM & Pimpinan Lembaga</h2>
                <p style="font-size: 0.875rem; color: var(--text-secondary); margin-top: 4px;">
                    Kelola profil pimpinan, asatidz, dan tenaga pendidik yang ditampilkan di homepage.
                </p>
            </div>
            <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
                <i data-feather="plus"></i> Tambah Data SDM
            </a>
        </div>

        <!-- Filter & Search Bar -->
        <div style="padding: 1rem 1.5rem; background: var(--bg-body); border-bottom: 1px solid var(--border-color);">
            <form action="{{ route('admin.teachers.index') }}" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
                <div style="flex: 1; min-width: 220px;">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau jabatan..." value="{{ request('search') }}">
                </div>
                <div style="width: 180px;">
                    <select name="unit" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Unit</option>
                        @foreach(['LPP', 'KB-TK', 'SDIT', 'SMPIT', 'SMAIT', 'Umum'] as $u)
                            <option value="{{ $u }}" {{ request('unit') == $u ? 'selected' : '' }}>{{ $u }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-secondary">
                    <i data-feather="search"></i> Cari
                </button>
                @if(request()->hasAny(['search', 'unit']))
                    <a href="{{ route('admin.teachers.index') }}" class="btn" style="background: #e2e8f0; color: #475569;">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="panel-body" style="padding: 0;">
            @if($teachers->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color); background: var(--bg-body);">
                                <th style="padding: 1rem 1.5rem; color: var(--text-secondary); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Profil & Nama</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Jabatan / Amanah</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Unit</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; text-align: center;">Urutan</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; text-align: center;">Status</th>
                                <th style="padding: 1rem 1.5rem; color: var(--text-secondary); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $teacher)
                                <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.15s ease;"
                                    onmouseover="this.style.backgroundColor='#f8fafc'"
                                    onmouseout="this.style.backgroundColor='transparent'">
                                    <td style="padding: 1rem 1.5rem;">
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            @if($teacher->image_url)
                                                <img src="{{ $teacher->image_url }}" alt="{{ $teacher->name }}"
                                                    style="width: 48px; height: 48px; border-radius: 12px; object-fit: cover; border: 2px solid var(--border-color); box-shadow: 0 2px 6px rgba(0,0,0,0.06);">
                                            @else
                                                <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #065f46 0%, #064e3b 100%); display: flex; align-items: center; justify-content: center; color: #fbbf24; font-weight: 700; font-size: 1rem; box-shadow: 0 2px 6px rgba(0,0,0,0.06);">
                                                    {{ strtoupper(substr($teacher->name, 0, 2)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div style="font-weight: 700; color: var(--text-primary); font-size: 0.95rem;">
                                                    {{ $teacher->name }}
                                                </div>
                                                @if($teacher->bio)
                                                    <div style="font-size: 0.78rem; color: var(--text-secondary); max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                        {{ $teacher->bio }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem; font-weight: 500; color: #334155;">
                                        {{ $teacher->role }}
                                    </td>
                                    <td style="padding: 1rem;">
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.65rem; border-radius: 6px; font-size: 0.75rem; font-weight: 700; background: #e0f2fe; color: #0369a1;">
                                            {{ $teacher->unit ?? 'LPP' }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; text-align: center; font-weight: 700; color: #64748b;">
                                        {{ $teacher->order }}
                                    </td>
                                    <td style="padding: 1rem; text-align: center;">
                                        @if($teacher->is_active)
                                            <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: #dcfce7; color: #15803d;">
                                                Aktif
                                            </span>
                                        @else
                                            <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: #f1f5f9; color: #64748b;">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem 1.5rem; text-align: right;">
                                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                            <a href="{{ route('admin.teachers.edit', $teacher) }}"
                                                style="padding: 0.5rem; color: var(--primary-color); background-color: rgba(79, 70, 229, 0.1); border-radius: 6px; display: inline-flex; align-items: center;"
                                                title="Edit">
                                                <i data-feather="edit-2" style="width: 16px; height: 16px;"></i>
                                            </a>
                                            <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data SDM ini?');"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="padding: 0.5rem; color: var(--danger-color); background-color: rgba(239, 68, 68, 0.1); border: none; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center;"
                                                    title="Hapus">
                                                    <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="padding: 1.5rem; border-top: 1px solid var(--border-color);">
                    {{ $teachers->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 4rem 1rem;">
                    <div style="color: var(--text-secondary); margin-bottom: 1rem;">
                        <i data-feather="users" style="width: 56px; height: 56px; opacity: 0.4;"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                        Belum ada data SDM
                    </h3>
                    <p style="color: var(--text-secondary); margin-bottom: 1.5rem; max-width: 400px; margin-left: auto; margin-right: auto;">
                        Mulai tambahkan data pimpinan lembaga, asatidz, dan tenaga kependidikan untuk ditampilkan pada halaman utama.
                    </p>
                    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
                        <i data-feather="plus"></i> Tambah Data Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
