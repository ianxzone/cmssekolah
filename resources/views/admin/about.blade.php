@extends('admin.layouts.app')

@section('title', 'Tentang CMS & Layanan MATEK')

@push('styles')
<style>
    .about-header {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: white;
        padding: 3rem 2rem;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 2.5rem;
        box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.4);
        position: relative;
        overflow: hidden;
    }
    .about-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        transform: rotate(30deg);
        pointer-events: none;
    }
    .about-icon {
        width: 80px;
        height: 80px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem auto;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }
    .about-header h1 {
        margin: 0 0 0.5rem 0;
        font-size: 2.25rem;
        font-weight: 800;
        letter-spacing: -0.025em;
    }
    .about-header p {
        margin: 0;
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    .service-card {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2rem 1.5rem;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px -5px rgba(0,0,0,0.08);
        border-color: #059669;
    }
    .service-icon {
        width: 60px;
        height: 60px;
        background: #ecfdf5;
        color: #059669;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem auto;
    }
    .service-card h3 {
        margin: 0 0 0.75rem 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    .service-card p {
        margin: 0;
        font-size: 0.9rem;
        color: var(--text-secondary);
        line-height: 1.6;
    }

    .cta-section {
        background: #0f172a;
        color: white;
        border-radius: 12px;
        padding: 3rem 2rem;
        text-align: center;
        margin-top: 3rem;
    }
    .cta-section h2 {
        margin: 0 0 1rem 0;
        font-size: 1.75rem;
        font-weight: 700;
    }
    .cta-section p {
        margin: 0 0 2rem 0;
        font-size: 1.05rem;
        color: #94a3b8;
    }
</style>
@endpush

@section('content')
    <div class="about-header">
        <div class="about-icon">
            <svg xmlns="http://www.w3.org/2000/svg" style="color: #059669; width: 40px; height: 40px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
        </div>
        <h1>CMS Sekolah Modern</h1>
        <p>Versi 1.2.0 &bull; Dikembangkan Eksklusif oleh <strong>MATEK Studio</strong></p>
    </div>

    <div class="panel" style="border: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <div class="panel-body" style="padding: 2.5rem; text-align: center;">
            <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 1.5rem; color: #059669;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 32px; height: 32px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
            </div>
            <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1rem;">Lebih Dari Sekadar CMS</h2>
            <p style="font-size: 1.05rem; color: var(--text-secondary); max-width: 800px; margin: 0 auto; line-height: 1.7;">
                Sistem Manajemen Konten ini didesain khusus untuk institusi pendidikan, memberikan Anda kendali penuh atas website sekolah, penerimaan siswa baru, informasi kegiatan, hingga profil alumni dengan sangat mudah dan terpusat.
            </p>
        </div>
    </div>

    <div style="margin-top: 3.5rem;">
        <div style="text-align: center; margin-bottom: 1rem;">
            <h2 style="font-size: 1.75rem; font-weight: 800; color: var(--text-primary); margin: 0;">Layanan Unggulan MATEK Studio</h2>
            <p style="color: var(--text-secondary); margin-top: 0.5rem; font-size: 1.05rem;">Butuh transformasi digital lebih lanjut? Kami siap membantu sekolah dan bisnis Anda.</p>
        </div>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <i data-feather="layout" style="width: 28px; height: 28px;"></i>
                </div>
                <h3>Pembuatan Website & Web App</h3>
                <p>Website company profile, e-learning, CBT, hingga sistem akademik (SIAKAD) custom sesuai dengan kebutuhan spesifik sekolah Anda.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <i data-feather="smartphone" style="width: 28px; height: 28px;"></i>
                </div>
                <h3>Pengembangan Aplikasi Mobile</h3>
                <p>Hadirkan sekolah Anda di genggaman orang tua siswa. Aplikasi Android & iOS terintegrasi dengan push notification untuk info sekolah.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <i data-feather="server" style="width: 28px; height: 28px;"></i>
                </div>
                <h3>Cloud Hosting & Maintenance</h3>
                <p>Server ngadat saat PPDB? Tinggalkan server lama Anda. Kami menyediakan infrastruktur cloud super cepat dan anti-down 99.9% uptime.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <i data-feather="trending-up" style="width: 28px; height: 28px;"></i>
                </div>
                <h3>SEO & Digital Marketing</h3>
                <p>Tingkatkan eksposur sekolah Anda di Google. Raih lebih banyak pendaftar baru lewat optimasi pencarian dan strategi social media cerdas.</p>
            </div>
        </div>
    </div>

    <div class="cta-section">
        <h2>Siap Berkembang Bersama MATEK?</h2>
        <p>Hubungi tim kami untuk konsultasi gratis mengenai teknologi pendidikan Anda.</p>
        <a href="https://www.murniabadi.co.id" target="_blank" class="btn btn-primary" style="background-color: #059669; border: none; font-size: 1.1rem; font-weight: 600; padding: 12px 32px; display: inline-flex; align-items: center; gap: 8px;">
            <i data-feather="message-circle" style="width: 20px;"></i> Hubungi Kami Sekarang
        </a>
    </div>
@endsection
