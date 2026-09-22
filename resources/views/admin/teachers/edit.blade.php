@extends('admin.layouts.app')

@section('title', 'Edit Tenaga Pendidik / SDM')

@push('styles')
    <style>
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.875rem;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .text-danger {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }

        .form-hint {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-top: 0.35rem;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        @media (max-width: 640px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: 1.25rem;
            height: 1.25rem;
            accent-color: var(--primary-color);
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="panel" style="max-width: 860px; margin: 0 auto;">
        <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="panel-title">Edit Data SDM: {{ $teacher->name }}</h2>
            <a href="{{ route('admin.teachers.index') }}" class="btn" style="background-color: var(--bg-body); border-color: var(--border-color); font-size: 0.875rem;">
                <i data-feather="arrow-left"></i> Kembali
            </a>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="name">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $teacher->name) }}" required autofocus>
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="role">Jabatan / Amanah <span class="text-danger">*</span></label>
                        <input type="text" id="role" name="role" class="form-control" value="{{ old('role', $teacher->role) }}" required>
                        @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="unit">Unit / Tingkatan</label>
                        <select id="unit" name="unit" class="form-control">
                            <option value="LPP" {{ old('unit', $teacher->unit) == 'LPP' ? 'selected' : '' }}>LPP (Lembaga Pendidikan & Pengajaran)</option>
                            <option value="KB-TK" {{ old('unit', $teacher->unit) == 'KB-TK' ? 'selected' : '' }}>KB-TK IT</option>
                            <option value="SDIT" {{ old('unit', $teacher->unit) == 'SDIT' ? 'selected' : '' }}>SDIT</option>
                            <option value="SMPIT" {{ old('unit', $teacher->unit) == 'SMPIT' ? 'selected' : '' }}>SMPIT</option>
                            <option value="SMAIT" {{ old('unit', $teacher->unit) == 'SMAIT' ? 'selected' : '' }}>SMAIT</option>
                            <option value="Umum" {{ old('unit', $teacher->unit) == 'Umum' ? 'selected' : '' }}>Umum / Manajemen</option>
                        </select>
                        <div class="form-hint">Pilih lingkup penugasan pimpinan / guru.</div>
                        @error('unit') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="order">Urutan Tampilan</label>
                        <input type="number" id="order" name="order" class="form-control" value="{{ old('order', $teacher->order) }}" min="0">
                        <div class="form-hint">Angka lebih kecil tampil lebih dulu di website.</div>
                        @error('order') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="bio">Profil / Keterangan Singkat (Opsional)</label>
                    <textarea id="bio" name="bio" class="form-control" rows="3">{{ old('bio', $teacher->bio) }}</textarea>
                    @error('bio') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="image">Ganti Foto Profil (Opsional)</label>
                    
                    @if($teacher->image_url)
                        <div style="margin-bottom: 0.75rem; display: flex; align-items: center; gap: 1rem;">
                            <img src="{{ $teacher->image_url }}" alt="{{ $teacher->name }}" style="width: 70px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border-color);">
                            <span style="font-size: 0.8rem; color: var(--text-secondary);">Foto saat ini. Pilih file baru di bawah untuk mengganti.</span>
                        </div>
                    @endif

                    <input type="file" id="image" name="image" class="form-control" accept="image/*" onchange="previewImage(this)">
                    <div class="form-hint">Format didukung: JPG, PNG, WEBP. Maks 2MB.</div>
                    <div id="imagePreview" style="margin-top: 1rem; display: none;">
                        <span style="font-size: 0.8rem; color: var(--text-secondary); display: block; margin-bottom: 0.35rem;">Pratinjau Foto Baru:</span>
                        <img id="preview" src="#" alt="Preview" style="max-width: 140px; height: 160px; object-fit: cover; border-radius: 12px; border: 2px solid var(--border-color); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                    </div>
                    @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group checkbox-group" style="padding: 1rem 0; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $teacher->is_active) ? 'checked' : '' }}>
                    <label for="is_active" style="cursor: pointer; font-weight: 500;">Aktifkan (Tampilkan di halaman depan website)</label>
                    @error('is_active') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i data-feather="check-circle"></i> Perbarui Data SDM
                    </button>
                    <a href="{{ route('admin.teachers.index') }}" class="btn" style="background-color: var(--bg-body); border-color: var(--border-color);">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage(input) {
            const previewDiv = document.getElementById('imagePreview');
            const previewImg = document.getElementById('preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewDiv.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                previewImg.src = '#';
                previewDiv.style.display = 'none';
            }
        }
    </script>
@endpush
