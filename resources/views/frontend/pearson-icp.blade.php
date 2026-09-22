@extends('frontend.layouts.app')

@section('title', 'International Class Program (ICP) & Kurikulum Pearson - ' . config('app.name', 'LPP Al Irsyad Karawang'))
@section('meta_description', 'International Class Program (ICP) LPP Al Irsyad Karawang: Mengadopsi Kurikulum Internasional Pearson Edexcel (UK) berpadu dengan adab tauhid Rabbani.')

@push('styles')
<style>
    .page-hero {
        background: linear-gradient(135deg, #064e3b 0%, #022c22 100%);
        color: var(--white);
        padding: 75px 0 55px;
        position: relative;
        overflow: hidden;
    }
    .page-hero::after {
        content: '';
        position: absolute;
        bottom: -50px;
        right: -50px;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(251, 191, 36, 0.18) 0%, transparent 70%);
        pointer-events: none;
    }
    .page-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.88rem;
        color: rgba(255, 255, 255, 0.75);
        margin-bottom: 16px;
    }
    .page-breadcrumb a:hover {
        color: var(--secondary);
    }
    .hero-badge-icp {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(251, 191, 36, 0.18);
        border: 1px solid rgba(251, 191, 36, 0.4);
        color: var(--secondary);
        padding: 6px 18px;
        border-radius: 50px;
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        margin-bottom: 16px;
    }
    .page-hero h1 {
        font-size: 2.6rem;
        font-weight: 800;
        line-height: 1.25;
        margin-bottom: 12px;
        color: var(--white);
    }
    .page-hero p {
        font-size: 1.1rem;
        color: #d1fae5;
        max-width: 780px;
        line-height: 1.6;
        margin: 0;
    }
    .icp-container {
        max-width: 1140px;
        margin: 0 auto;
        padding: 50px 20px 80px;
    }
    .icp-intro-grid {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 40px;
        align-items: center;
        margin-bottom: 55px;
        background: var(--white);
        padding: 40px;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        box-shadow: var(--shadow-sm);
    }
    .icp-intro-text h2 {
        font-size: 1.95rem;
        font-weight: 800;
        color: var(--primary-dark);
        margin-bottom: 16px;
        line-height: 1.3;
    }
    .icp-intro-text p {
        color: #4b5563;
        font-size: 1.02rem;
        line-height: 1.7;
        margin-bottom: 16px;
    }
    .icp-partner-card {
        background: linear-gradient(135deg, #f8fafc 0%, #edf2f7 100%);
        border: 2px dashed rgba(6, 95, 70, 0.3);
        border-radius: 18px;
        padding: 30px;
        text-align: center;
    }
    .icp-partner-card h3 {
        font-size: 1.5rem;
        color: var(--primary-dark);
        font-weight: 800;
        margin-bottom: 8px;
    }
    .icp-partner-card p {
        font-size: 0.92rem;
        color: #64748b;
        margin-bottom: 20px;
        line-height: 1.5;
    }
    .section-title {
        text-align: center;
        margin-bottom: 40px;
    }
    .section-title span {
        color: var(--primary-light);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 0.85rem;
    }
    .section-title h3 {
        font-size: 2.1rem;
        font-weight: 800;
        color: var(--primary-dark);
        margin-top: 6px;
    }
    .icp-pillars-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 55px;
    }
    .icp-pillar-card {
        background: var(--white);
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        padding: 32px 24px;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        border-top: 4px solid var(--secondary);
        box-shadow: var(--shadow-sm);
    }
    .icp-pillar-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: var(--secondary);
    }
    .icp-icon-wrap {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        background: rgba(251, 191, 36, 0.18);
        color: #d97706;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }
    .icp-pillar-card h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 12px;
    }
    .icp-pillar-card p {
        font-size: 0.94rem;
        color: #4b5563;
        line-height: 1.65;
        margin: 0;
    }
    .harmony-box {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #064e3b 100%);
        color: var(--white);
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 45px;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(251, 191, 36, 0.3);
    }
    .harmony-box h3 {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--secondary);
        margin-bottom: 12px;
    }
    .harmony-box p {
        color: #e2e8f0;
        font-size: 1.02rem;
        line-height: 1.7;
        margin-bottom: 18px;
    }
    .harmony-highlights {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-top: 25px;
    }
    .harmony-item {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 16px;
        border-radius: 12px;
        font-size: 0.9rem;
        color: #f3f4f6;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .cta-box-icp {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 20px;
        padding: 40px;
        text-align: center;
    }
    .cta-box-icp h4 {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--primary-dark);
        margin-bottom: 10px;
    }
    .cta-box-icp p {
        color: #64748b;
        max-width: 600px;
        margin: 0 auto 24px;
        font-size: 0.98rem;
    }

    @media (max-width: 992px) {
        .icp-intro-grid {
            grid-template-columns: 1fr;
            padding: 30px 20px;
        }
        .icp-pillars-grid {
            grid-template-columns: 1fr;
        }
        .harmony-highlights {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 768px) {
        .page-hero h1 {
            font-size: 2rem;
        }
        .harmony-box {
            padding: 28px 20px;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Header -->
<section class="page-hero">
    <div class="container">
        <nav class="page-breadcrumb">
            <a href="/">Beranda</a>
            <i data-feather="chevron-right" style="width: 14px; height: 14px;"></i>
            <span>International Class Program</span>
        </nav>
        <div class="hero-badge-icp">
            <i data-feather="award" style="width: 14px; height: 14px;"></i> OFFICIAL PEARSON EDEXCEL PARTNER
        </div>
        <h1>International Class Program (ICP)</h1>
        <p>Menyelenggarakan pendidikan bertaraf internasional yang mengadopsi kurikulum Pearson Edexcel (UK), memadukan keunggulan sains global dengan nilai tauhid dan adab Rabbani.</p>
    </div>
</section>

<div class="icp-container">
    <!-- Intro Grid -->
    <div class="icp-intro-grid">
        <div class="icp-intro-text">
            <h2>Mempersiapkan Generasi Muslim Berdaya Saing Global</h2>
            <p>
                International Class Program (ICP) di LPP Al Irsyad Al Islamiyyah Karawang dirancang khusus untuk memfasilitasi peserta didik yang memiliki potensi dan visi melanjutkan pendidikan tinggi ke taraf internasional, tanpa melepaskan identitas sebagai muslim yang taat dan bertauhid kokoh.
            </p>
            <p>
                Dengan lingkungan *active English immersion*, sertifikasi berkala dari Pearson Edexcel UK, serta asatidz berpengalaman, santri terlatih untuk mandiri, bernalar kritis, dan percaya diri berkomunikasi di forum dunia.
            </p>
        </div>
        <div class="icp-partner-card">
            <div style="width: 70px; height: 70px; border-radius: 20px; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-weight: 800; font-size: 1.4rem;">
                P
            </div>
            <h3>Pearson Edexcel (UK)</h3>
            <p>Lembaga asesmen dan kualifikasi pendidikan terbesar di Inggris Raya, diakui di lebih dari 70 negara di seluruh dunia.</p>
            <a href="https://www.pearson.com" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="border-color: var(--primary); font-size: 0.9rem; padding: 8px 20px;">
                Kunjungi Pearson.com <i data-feather="external-link" style="width: 14px;"></i>
            </a>
        </div>
    </div>

    <!-- 3 Keunggulan ICP -->
    <div class="section-title">
        <span>Keunggulan Utama</span>
        <h3>3 Pilar International Class Program</h3>
    </div>

    <div class="icp-pillars-grid">
        <div class="icp-pillar-card">
            <div class="icp-icon-wrap">
                <i data-feather="award" style="width: 26px; height: 26px;"></i>
            </div>
            <h4>Pearson Edexcel Standards</h4>
            <p>Kurikulum berstandar internasional dari Pearson UK untuk penguasaan sains eksperimental, matematika analitis, dan literasi global yang komprehensif.</p>
        </div>
        <div class="icp-pillar-card">
            <div class="icp-icon-wrap">
                <i data-feather="globe" style="width: 26px; height: 26px;"></i>
            </div>
            <h4>Active English Immersion</h4>
            <p>Lingkungan pembiasaan bahasa Inggris intensif di kelas maupun kegiatan sekolah (daily conversation, academic presentation, seminar, dan public speaking).</p>
        </div>
        <div class="icp-pillar-card">
            <div class="icp-icon-wrap">
                <i data-feather="check-circle" style="width: 26px; height: 26px;"></i>
            </div>
            <h4>Global Qualifications</h4>
            <p>Ujian dan kualifikasi resmi bersertifikat internasional yang diakui universitas ternama dunia, membuka peluang karir dan pendidikan lanjutan yang lebih luas.</p>
        </div>
    </div>

    <!-- Harmony Tauhid & Global -->
    <div class="harmony-box">
        <h3>Harmonisasi Tauhid Rabbani & Kompetensi Dunia</h3>
        <p>
            Di LPP Al Irsyad Karawang, kemampuan global tidak pernah memisahkan santri dari akar agamanya. Seluruh proses sains dan penguasaan bahasa diperkuat dengan hafalan Al-Qur'an (Tahfidz), pembiasaan sholat berjamaah, dan internalisasi adab Rasulullah ﷺ.
        </p>
        <div class="harmony-highlights">
            <div class="harmony-item">
                <i data-feather="shield" style="color: var(--secondary); width: 18px; height: 18px;"></i>
                <span>Benteng Akidah & Adab Nabawiyah</span>
            </div>
            <div class="harmony-item">
                <i data-feather="book-open" style="color: var(--secondary); width: 18px; height: 18px;"></i>
                <span>Tahfidz Mutqin Bersanad</span>
            </div>
            <div class="harmony-item">
                <i data-feather="trending-up" style="color: var(--secondary); width: 18px; height: 18px;"></i>
                <span>Jalur Masuk Kampus Dunia & PTN</span>
            </div>
        </div>
    </div>

    <!-- CTA Box -->
    <div class="cta-box-icp">
        <h4>Siap Antarkan Ananda Menjadi Pemimpin Global?</h4>
        <p>Pendaftaran kelas internasional International Class Program (ICP) dibuka setiap tahun ajaran baru melalui jalur seleksi SPMB Online.</p>
        <div style="display: flex; justify-content: center; gap: 14px; flex-wrap: wrap;">
            <a href="{{ $settings['contact_ppdb_link'] ?? '#' }}" class="btn btn-primary">
                <i data-feather="user-plus" style="width: 16px;"></i> Daftar ICP Online
            </a>
            @php
                $waNumber = preg_replace('/[^0-9]/', '', $settings['ppdb_wa_number'] ?? ($settings['whatsapp_number'] ?? ($settings['contact_phone'] ?? '6281234567890')));
            @endphp
            <a href="https://wa.me/{{ $waNumber }}?text=Halo%20Admin%20Sekolah,%20saya%20ingin%20tanya%20detail%20mengenai%20International%20Class%20Program%20(ICP)." target="_blank" class="btn btn-outline" style="border-color: var(--primary);">
                <i data-feather="message-circle" style="width: 16px;"></i> Konsultasi ICP via WA
            </a>
        </div>
    </div>
</div>
@endsection
