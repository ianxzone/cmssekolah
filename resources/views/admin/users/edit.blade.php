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

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 500; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} style="width: 1.25rem; height: 1.25rem; cursor: pointer;">
                        Akun Aktif (Dapat Login)
                    </label>
                    <p style="margin-top: 0.25rem; font-size: 0.875rem; color: #6b7280;">Jika dimatikan, pengguna tidak akan bisa login ke dalam sistem.</p>
                </div>

                <div style="margin-bottom: 1.5rem; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 8px; background-color: #f9fafb;">
                    <h4 style="margin-top: 0; margin-bottom: 1rem; color: var(--text-secondary);">Ganti Password (Opsional)</h4>
                    <p style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 1rem;">Biarkan kosong jika tidak ingin mengubah password. Minimal 8 karakter, huruf besar & kecil, angka, dan simbol.</p>
                    
                    <div style="margin-bottom: 1rem;">
                        <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Password Baru</label>
                        <input type="password" id="password" name="password" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                    </div>

                    <div>
                        <label for="password_confirmation" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                    </div>
                </div>

                                <div style="margin-top: 2.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">
                    <h3 style="font-size: 1.125rem; font-weight: 600;">Informasi Profil Tambahan (Opsional)</h3>
                    <p style="font-size: 0.875rem; color: #6b7280;">Lengkapi profil pengguna, berguna untuk halaman Penulis atau Guru.</p>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="avatar" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Foto Profil / Avatar (URL)</label>
                    <div style="display: flex; gap: 0.5rem;" x-data="{ avatarUrl: '{{ old('avatar', $user->avatar ? Storage::url($user->avatar) : '') }}' }">
                        <input type="text" id="avatar" name="avatar" x-model="avatarUrl" placeholder="Pilih dari Media Manager..." style="flex: 1; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; background: #f9fafb;" readonly>
                        <button type="button" @click="$dispatch('open-media-picker', { callback: 'setAvatar' })" class="btn btn-primary" style="display: flex; align-items: center; gap: 0.5rem;">
                            <i data-feather="image" style="width: 16px; height: 16px;"></i> Browse
                        </button>
                        
                        <div x-show="avatarUrl" style="margin-top: 0.5rem; position: relative; display: inline-block; width: 100%; display:none;">
                            <img :src="avatarUrl.startsWith('http') ? avatarUrl : (avatarUrl.startsWith('/') ? avatarUrl : '/' + avatarUrl)" alt="Preview" style="max-height: 150px; border-radius: 8px; border: 1px solid var(--border-color); object-fit: cover;">
                            <button type="button" @click="avatarUrl = ''" style="position: absolute; top: -10px; right: -10px; width: 24px; height: 24px; border-radius: 50%; background: var(--danger-color); color: white; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                <i data-feather="x" style="width: 14px; height: 14px;"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div style="margin-bottom: 1.5rem;">
                        <label for="job_title" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Jabatan / Profesi</label>
                        <input type="text" id="job_title" name="job_title" value="{{ old('job_title', $user->job_title) }}" placeholder="e.g. Guru Matematika" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label for="phone" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">No. WhatsApp / Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. 08123456789" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="bio" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Biografi Singkat</label>
                    <textarea id="bio" name="bio" rows="4" placeholder="Tuliskan biografi singkat tentang pengguna ini..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <div style="margin-top: 1rem; margin-bottom: 1rem; font-weight: 500;">Tautan Media Sosial</div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <label for="facebook_url" style="font-size: 0.875rem;">Facebook URL</label>
                        <input type="url" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $user->facebook_url) }}" placeholder="https://facebook.com/..." style="padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <label for="twitter_url" style="font-size: 0.875rem;">Twitter / X URL</label>
                        <input type="url" id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $user->twitter_url) }}" placeholder="https://x.com/..." style="padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <label for="instagram_url" style="font-size: 0.875rem;">Instagram URL</label>
                        <input type="url" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $user->instagram_url) }}" placeholder="https://instagram.com/..." style="padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <label for="linkedin_url" style="font-size: 0.875rem;">LinkedIn URL</label>
                        <input type="url" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $user->linkedin_url) }}" placeholder="https://linkedin.com/in/..." style="padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
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

@push('scripts')
<script>
    window.setAvatar = function(media) {
        const input = document.getElementById('avatar');
        input.value = '/storage/' + media.path;
        input.dispatchEvent(new Event('input'));
    };
</script>
@endpush
