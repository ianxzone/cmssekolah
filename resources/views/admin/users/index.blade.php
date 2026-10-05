@extends('admin.layouts.app')

@section('title', 'Kelola Pengguna (Users)')

@section('content')
    <div class="panel">
        <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="panel-title">Semua Pengguna</h2>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i data-feather="plus"></i> Tambah Pengguna
            </a>
        </div>
        <div class="panel-body">
            @if(session('success'))
                <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($users->count() > 0)
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color);">
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Nama</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Email</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Role</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500; text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="padding: 1rem; font-weight: 600; color: var(--text-primary);">{{ $user->name }}</td>
                                    <td style="padding: 1rem; color: var(--text-secondary);">{{ $user->email }}</td>
                                    <td style="padding: 1rem;">
                                        @php
                                            $rolesList = \App\Models\User::getRolesList();
                                            $roleColor = $rolesList[$user->role]['badge_color'] ?? '#6b7280';
                                            $roleName = $rolesList[$user->role]['name'] ?? ucfirst($user->role);
                                        @endphp
                                        <span style="background-color: {{ $roleColor }}20; color: {{ $roleColor }}; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                            {{ $roleName }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; text-align: right;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline" style="padding: 0.5rem;" title="Edit">
                                                <i data-feather="edit-2"></i>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" style="padding: 0.5rem;" title="Hapus">
                                                    <i data-feather="trash-2"></i>
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
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div style="padding: 3rem; text-align: center; color: var(--text-secondary);">
                    <i data-feather="users" style="width: 48px; height: 48px; margin-bottom: 1rem; opacity: 0.5;"></i>
                    <h3>Belum ada data pengguna</h3>
                </div>
            @endif
        </div>
    </div>
@endsection
