@extends('install.layout')

@section('content')
    <div style="text-align: center; padding: 20px 0;">
        <div
            style="width: 80px; height: 80px; background: var(--success); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
            <i data-feather="check" style="width: 48px; height: 48px;"></i>
        </div>

        <div class="setup-title">Instalasi Selesai!</div>
        <p class="setup-description">
            Selamat! CMS Sekolah by MATEK telah berhasil diinstal. Anda sekarang dapat masuk ke dashboard admin untuk mulai
            mengelola konten website sekolah.
        </p>

        <div
            style="background: #f8fafc; border-radius: 12px; padding: 20px; text-align: left; margin-bottom: 30px; border: 1px solid #f1f5f9;">
            <h4 style="font-size: 0.9rem; margin-bottom: 15px; color: var(--primary);">Catatan Penting:</h4>
            <ul
                style="font-size: 0.85rem; color: var(--text-muted); list-style: disc; padding-left: 20px; line-height: 1.6;">
                <li>Simpan kredensial admin Anda di tempat yang aman.</li>
                <li>File lock telah dibuat di <code>storage/installed</code> untuk mencegah akses ulang installer.</li>
                <li>Halaman ini tidak akan dapat diakses lagi.</li>
            </ul>
        </div>

        <a href="{{ url('/admin/login') }}" class="btn-setup">
            Lanjut ke Setup Data Sekolah <i data-feather="arrow-right"></i>
        </a>
    </div>
@endsection