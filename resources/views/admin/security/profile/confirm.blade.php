@extends('admin.layouts.app')

@section('title', 'Konfirmasi 2FA')

@section('content')
<div class="panel" style="max-width: 600px; margin: 0 auto;">
    <div class="panel-header">
        <h2 class="panel-title">Langkah Terakhir: Konfirmasi 2FA</h2>
    </div>
    <div class="panel-body">
        <div style="text-align: center; margin-bottom: 2rem;">
            <p style="color: var(--text-secondary); margin-bottom: 1.5rem; line-height: 1.6;">
                1. Buka aplikasi Google Authenticator (atau aplikasi 2FA lainnya) di HP Anda.<br>
                2. Scan QR Code di bawah ini.
            </p>
            
            <div style="display: inline-block; padding: 1rem; background: white; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 1.5rem;">
                {!! $qrCodeSvg !!}
            </div>

            <p style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 2rem;">
                Atau masukkan secret key ini secara manual:<br>
                <strong style="font-size: 1.125rem; color: var(--text-primary); letter-spacing: 2px;">{{ $secret }}</strong>
            </p>

            <form action="{{ route('admin.security.profile.confirm') }}" method="POST" style="background-color: #f9fafb; padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border-color); text-align: left;">
                @csrf
                <h4 style="margin-top: 0; margin-bottom: 1rem; color: var(--text-primary);">3. Masukkan Kode OTP</h4>
                <p style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 1rem;">
                    Masukkan 6 digit kode yang muncul di aplikasi authenticator Anda untuk memverifikasi pemasangan.
                </p>
                
                <div style="margin-bottom: 1.5rem;">
                    <input type="text" name="otp" required autocomplete="off" placeholder="Contoh: 123456" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; font-size: 1.125rem; letter-spacing: 2px; text-align: center;">
                </div>
                
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Verifikasi & Aktifkan</button>
                    <a href="{{ route('admin.security.profile') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
