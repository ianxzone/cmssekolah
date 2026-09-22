@extends('frontend.layouts.app')

@section('title', 'Kurikulum Khas Terpadu - ' . config('app.name', 'LPP Al Irsyad Karawang'))
@section('meta_description', 'Kurikulum Khas Terpadu LPP Al Irsyad Karawang: Memadukan standar nasional, nilai Qurani bersanad, adab nabawiyah, dan wawasan global.')

@push('styles')
<style>
    .page-hero {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #022c22 100%);
        color: var(--white);
        padding: 70px 0 50px;
        position: relative;
        overflow: hidden;
    }
    .page-hero::after {
        content: '';
        position: absolute;
        bottom: -60px;
        right: -60px;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(251, 191, 36, 0.15) 0%, transparent 70%);
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
    .page-hero h1 {
        font-size: 2.6rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 12px;
        color: var(--white);
    }
    .page-hero p {
        font-size: 1.1rem;
        color: #d1fae5;
        max-width: 760px;
        line-height: 1.6;
        margin: 0;
    }
    .kurikulum-container {
        max-width: 1140px;
        margin: 0 auto;
        padding: 50px 20px 80px;
    }
    .overview-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: var(--shadow-sm);
        border: 1px solid #e5e7eb;
        padding: 35px 30px;
        margin-bottom: 45px;
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 35px;
        align-items: center;
    }
    .overview-text h2 {
        font-size: 1.9rem;
        font-weight: 800;
        color: var(--primary-dark);
        margin-bottom: 15px;
        line-height: 1.3;
    }
    .overview-text p {
        color: #4b5563;
        font-size: 1.02rem;
        line-height: 1.7;
        margin-bottom: 16px;
    }
    .overview-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(6, 95, 70, 0.08);
        color: var(--primary);
        padding: 6px 16px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.82rem;
        margin-bottom: 15px;
    }
    .overview-img {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        height: 280px;
    }
    .overview-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .section-title {
        text-align: center;
        margin-bottom: 35px;
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
    .pillars-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 22px;
        margin-bottom: 50px;
    }
    .pillar-card {
        background: var(--white);
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        padding: 28px 24px;
        transition: var(--transition);
        position: relative;
        display: flex;
        flex-direction: column;
        border-top: 4px solid var(--primary);
    }
    .pillar-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-top-color: var(--secondary);
    }
    .pillar-icon-wrap {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: rgba(6, 95, 70, 0.1);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
    }
    .pillar-card:hover .pillar-icon-wrap {
        background: rgba(251, 191, 36, 0.2);
        color: #d97706;
    }
    .pillar-card h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 10px;
    }
    .pillar-card p {
        font-size: 0.94rem;
        color: #4b5563;
        line-height: 1.6;
        margin: 0;
    }
    .pearson-banner-box {
        background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
        color: var(--white);
        border-radius: 20px;
        padding: 35px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 25px;
        margin-bottom: 45px;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(251, 191, 36, 0.3);
    }
    .pearson-banner-text h4 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--secondary);
        margin-bottom: 8px;
    }
    .pearson-banner-text p {
        color: #e2e8f0;
        font-size: 0.98rem;
        line-height: 1.6;
        margin: 0;
        max-width: 650px;
    }
    .cta-footer-box {
        background: #f8fafc;
        border-radius: 20px;
        border: 1px dashed #cbd5e1;
        padding: 35px;
        text-align: center;
    }
    .cta-footer-box h4 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary-dark);
        margin-bottom: 10px;
    }
    .cta-footer-box p {
        color: #64748b;
        max-width: 580px;
        margin: 0 auto 22px;
        font-size: 0.98rem;
    }
    .cta-actions {
        display: flex;
        justify-content: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    @media (max-width: 860px) {
        .overview-card {
            grid-template-columns: 1fr;
            padding: 25px 20px;
        }
        .overview-img {
            height: 220px;
        }
        .pillars-grid {
            grid-template-columns: 1fr;
        }
        .pearson-banner-box {
            flex-direction: column;
            text-align: center;
            padding: 28px 20px;
        }
        .page-hero h1 {
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Page Header / Hero -->
<section class="page-hero">
    <div class="container">
        <nav class="page-breadcrumb">
            <a href="/">Beranda</a>
            <i data-feather="chevron-right" style="width: 14px; height: 14px;"></i>
            <span>Kurikulum Khas</span>
        </nav>
        <h1>Kurikulum Khas Terpadu Al Irsyad</h1>
        <p>Integrasi harmonis antara capaian akademik Kurikulum Merdeka Nasional, penguatan nilai Qur'ani bersanad, adab nabawiyah, dan wawasan global berstandar internasional.</p>
    </div>
</section>

<div class="kurikulum-container">
    <!-- Overview Card -->
    <div class="overview-card">
        <div class="overview-text">
            <span class="overview-badge">
                <i data-feather="award" style="width: 14px; height: 14px;"></i> STANDAR MUTU PENDIDIKAN TERPADU
            </span>
            <h2>Fondasi Adab Rabbani & Nalar Keilmuan Unggul</h2>
            <p>
                Kurikulum Khas LPP Al Irsyad Al Islamiyyah Karawang dirancang khusus agar santri tidak hanya cerdas secara kognitif, melainkan juga tangguh dalam akidah tauhid, terbiasa berakhlak mulia (adab nabawiyah), serta fasih berkomunikasi dengan bahasa internasional.
            </p>
            <p>
                Melalui ekosistem belajar yang menyenangkan dan terintegrasi dari jenjang KB-TK, SDIT, SMPIT hingga SMAIT, peserta didik disiapkan menjadi pribadi muslim yang siap memimpin peradaban.
            </p>
        </div>
        <div class="overview-img">
            <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&q=80&w=800" alt="Siswa Belajar Kurikulum Khas">
        </div>
    </div>

    <!-- 4 Pilar Kurikulum -->
    <div class="section-title">
        <span>Framework Pembelajaran</span>
        <h3>4 Pilar Kurikulum Khas Al Irsyad</h3>
    </div>

    @php
        $pillars = json_decode($settings['curriculum_pillars'] ?? '[]', true);
        if (empty($pillars)) {
            $pillars = [
                [
                    'icon' => 'book-open',
                    'title' => 'Tahfidz & Tahsin Al-Qur\'an Bersanad',
                    'desc' => 'Bimbingan talaqqi intensif bersama asatidz bersanad, pembiasaan hafalan mutqin, ujian munaqosyah berstandar, tasmi\' akbar, dan penerbitan syahadah resmi.'
                ],
                [
                    'icon' => 'heart',
                    'title' => 'Bina Pribadi Islami (BPI) & Adab Nabawiyah',
                    'desc' => 'Penanaman akhlakul karimah sehari-hari, sholat wajib & dhuha berjamaah, pembiasaan dzikir pagi-petang (al-matsurat), serta penanaman birrul walidain.'
                ],
                [
                    'icon' => 'globe',
                    'title' => 'Bilingual Immersion (Arab & Inggris)',
                    'desc' => 'Program habituasi bahasa internasional melalui percakapan harian (daily conversation), muhadhoroh/public speaking, English assessment, dan penguasaan mufradat.'
                ],
                [
                    'icon' => 'cpu',
                    'title' => 'STEAM & Computational Thinking',
                    'desc' => 'Pengembangan nalar kritis lewat praktikum sains berbasis fenomena alam ciptaan Allah, logika coding pemula, robotika dasar, dan literasi teknologi digital.'
                ]
            ];
        }
    @endphp

    <div class="pillars-grid">
        @foreach($pillars as $p)
        <div class="pillar-card">
            <div class="pillar-icon-wrap">
                <i data-feather="{{ $p['icon'] ?? 'check-circle' }}" style="width: 24px; height: 24px;"></i>
            </div>
            <h4>{{ $p['title'] ?? '' }}</h4>
            <p>{{ $p['desc'] ?? '' }}</p>
        </div>
        @endforeach
    </div>

    <!-- Pearson Link Banner -->
    <div class="pearson-banner-box">
        <div class="pearson-banner-text">
            <h4>Kolaborasi Internasional Pearson Edexcel (UK)</h4>
            <p>Untuk santri yang dipersiapkan menembus panggung dunia, kami juga menyelenggarakan International Class Program (ICP) yang resmi bermitra dengan Pearson UK.</p>
        </div>
        <a href="{{ route('pearson.index') }}" class="btn btn-primary" style="white-space: nowrap;">
            Pelajari Kelas Pearson ICP <i data-feather="arrow-right" style="width: 16px;"></i>
        </a>
    </div>

    <!-- CTA Section -->
    <div class="cta-footer-box">
        <h4>Tertarik dengan Kurikulum Khas Al Irsyad?</h4>
        <p>Konsultasikan kebutuhan pendidikan putra-putri Anda bersama tim akademik kami atau daftarkan ananda sekarang juga di portal SPMB Online.</p>
        <div class="cta-actions">
            <a href="{{ $settings['contact_ppdb_link'] ?? '#' }}" class="btn btn-primary">
                <i data-feather="user-plus" style="width: 16px;"></i> Daftar SPMB Online
            </a>
            @php
                $waNumber = preg_replace('/[^0-9]/', '', $settings['ppdb_wa_number'] ?? ($settings['whatsapp_number'] ?? ($settings['contact_phone'] ?? '6281234567890')));
            @endphp
            <a href="https://wa.me/{{ $waNumber }}?text=Halo%20Admin%20Sekolah,%20saya%20ingin%20konsultasi%20mengenai%20Kurikulum%20Khas%20Al%20Irsyad." target="_blank" class="btn btn-outline" style="border-color: var(--primary);">
                <i data-feather="message-circle" style="width: 16px;"></i> Konsultasi via WhatsApp
            </a>
        </div>
    </div>
</div>
@endsection
