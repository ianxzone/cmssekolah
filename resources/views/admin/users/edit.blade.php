@extends('admin.layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Edit Pengguna: {{ $user->name }}</h2>
        </div>
        <div class="panel-body">
            @if($errors->any())
                <div style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="role" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Role (Hak Akses)</label>
                    <select id="role" name="role" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; background-color: white;">
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $key => $role)
                            <option value="{{ $key }}" {{ old('role', $user->role) === $key ? 'selected' : '' }}>
                                {{ $role['name'] }} - {{ $role['description'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 1.5rem; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px; background-color: #f9fafb;">
                    <h4 style="margin-top: 0; margin-bottom: 1rem; color: var(--text-secondary);">Ganti Password (Opsional)</h4>
                    <p style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 1rem;">Biarkan kosong jika tidak ingin mengubah password.</p>
                    
                    <div style="margin-bottom: 1rem;">
                        <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Password Baru</label>
                        <input type="password" id="password" name="password" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                    </div>

                    <div>
                        <label for="password_confirmation" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
