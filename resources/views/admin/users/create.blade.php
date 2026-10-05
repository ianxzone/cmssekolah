@extends('admin.layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Tambah Pengguna Baru</h2>
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

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1.5rem;">
                    <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="role" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Role (Hak Akses)</label>
                    <select id="role" name="role" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; background-color: white;">
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $key => $role)
                            <option value="{{ $key }}" {{ old('role') === $key ? 'selected' : '' }}>
                                {{ $role['name'] }} - {{ $role['description'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Password</label>
                    <input type="password" id="password" name="password" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                </div>

                <div style="margin-bottom: 2rem;">
                    <label for="password_confirmation" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
