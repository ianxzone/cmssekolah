@extends('admin.layouts.app')

@section('title', 'Profil & Keamanan 2FA')

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2 class="panel-title">Pengaturan Keamanan Akun</h2>
    </div>
    <div class="panel-body">
        <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 300px;">
                <h3 style="margin-bottom: 1rem; color: var(--text-primary);">Two-Factor Authentication (2FA)</h3>
                <p style="color: var(--text-secondary); margin-bottom: 1.5rem; line-height: 1.6;">
                    Two-Factor Authentication (2FA) memberikan lapisan keamanan tambahan pada akun Anda. 
                    Ketika diaktifkan, Anda akan diminta memasukkan kode enam digit dari aplikasi authenticator (seperti Google Authenticator) setiap kali login.
                </p>

                @if($user->google2fa_enabled)
                    <div style="background-color: #d1fae5; border: 1px solid #10b981; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 1rem; color: #065f46; margin-bottom: 1rem;">
                            <i data-feather="check-circle" style="width: 24px; height: 24px;"></i>
                            <h4 style="margin: 0;">2FA Saat Ini Aktif</h4>
                        </div>
                        <p style="margin: 0; color: #065f46; font-size: 0.875rem;">Akun Anda saat ini terlindungi dengan autentikasi dua faktor.</p>
                    </div>

                    <form action="{{ route('admin.security.profile.disable') }}" method="POST" style="background-color: #f9fafb; padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border-color);">
                        @csrf
                        <h4 style="margin-top: 0; margin-bottom: 1rem; color: var(--text-primary);">Nonaktifkan 2FA</h4>
                        <p style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 1rem;">Untuk menonaktifkan 2FA, silakan masukkan kode OTP Anda saat ini.</p>
                        
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Kode OTP (6 digit)</label>
                            <input type="text" name="otp" required autocomplete="off" style="width: 100%; max-width: 200px; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; font-size: 1.125rem; letter-spacing: 2px;">
                        </div>
                        
                        <button type="submit" class="btn btn-danger">Nonaktifkan 2FA</button>
                    </form>
                @else
                    <div style="background-color: #fef3c7; border: 1px solid #f59e0b; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 1rem; color: #92400e; margin-bottom: 1rem;">
                            <i data-feather="alert-triangle" style="width: 24px; height: 24px;"></i>
                            <h4 style="margin: 0;">2FA Belum Aktif</h4>
                        </div>
                        <p style="margin: 0; color: #92400e; font-size: 0.875rem;">Kami sangat menyarankan Anda mengaktifkan 2FA untuk melindungi akun Administrator Anda dari pencurian kata sandi.</p>
                    </div>

                    <form action="{{ route('admin.security.profile.enable') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Aktifkan 2FA Sekarang</button>
                    </form>
                @endif
            </div>

            <div style="flex: 1; min-width: 300px; padding: 1.5rem; border-radius: 8px; background-color: #f8fafc; border: 1px solid #e2e8f0;">
                <h4 style="margin-top: 0; margin-bottom: 1rem; color: var(--text-primary);">Informasi Akun</h4>
                <div style="margin-bottom: 1rem;">
                    <strong>Nama:</strong><br>
                    <span style="color: var(--text-secondary);">{{ $user->name }}</span>
                </div>
                <div style="margin-bottom: 1rem;">
                    <strong>Email:</strong><br>
                    <span style="color: var(--text-secondary);">{{ $user->email }}</span>
                </div>
                <div style="margin-bottom: 1rem;">
                    <strong>Role:</strong><br>
                    <span style="color: var(--text-secondary);">{{ ucfirst($user->role) }}</span>
                </div>
                <div style="margin-top: 2rem;">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline" style="width: 100%; text-align: center;">Edit Profil & Password</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
