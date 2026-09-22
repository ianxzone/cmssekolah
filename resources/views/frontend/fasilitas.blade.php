@extends('frontend.layouts.app')

@section('title', 'Fasilitas & Sarana Prasarana - ' . config('app.name', 'LPP Al Irsyad Karawang'))
@section('meta_description', 'Fasilitas lengkap dan modern di LPP Al Irsyad Karawang mendukung kenyamanan belajar, pembiasaan ibadah, dan prestasi santri.')

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
    .facilities-container {
        max-width: 1140px;
        margin: 0 auto;
        padding: 50px 20px 80px;
    }
    .facility-grid-large {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 26px;
        margin-bottom: 50px;
    }
    .facility-card-pro {
        background: var(--white);
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        overflow: hidden;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        box-shadow: var(--shadow-sm);
    }
    .facility-card-pro:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: var(--secondary);
    }
    .facility-card-media {
        height: 200px;
        position: relative;
        background: #f1f5f9;
        overflow: hidden;
    }
    .facility-card-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .facility-card-pro:hover .facility-card-media img {
        transform: scale(1.06);
    }
    .facility-card-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        background: rgba(6, 95, 70, 0.9);
        backdrop-filter: blur(6px);
        color: var(--secondary);
        border: 1px solid rgba(251, 191, 36, 0.4);
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.76rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .facility-card-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .facility-icon-circle {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(6, 95, 70, 0.1);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
    }
    .facility-card-body h4 {
        font-size: 1.18rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 8px;
    }
    .facility-card-body p {
        font-size: 0.92rem;
        color: #4b5563;
        line-height: 1.6;
        margin: 0;
        flex-grow: 1;
    }
    .tour-box {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #065f46 100%);
        color: var(--white);
        border-radius: 20px;
        padding: 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 30px;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(251, 191, 36, 0.3);
    }
    .tour-text h3 {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--white);
        margin-bottom: 8px;
    }
    .tour-text p {
        color: #e2e8f0;
        font-size: 1.02rem;
        line-height: 1.6;
        margin: 0;
        max-width: 650px;
    }
    .tour-cta {
        display: flex;
        flex-direction: column;
        gap: 12px;
        flex-shrink: 0;
    }

    @media (max-width: 992px) {
        .facility-grid-large {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 768px) {
        .facility-grid-large {
            grid-template-columns: 1fr;
        }
        .tour-box {
            flex-direction: column;
            text-align: center;
            padding: 30px 20px;
        }
        .page-hero h1 {
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<section class="page-hero">
    <div class="container">
        <nav class="page-breadcrumb">
            <a href="/">Beranda</a>
            <i data-feather="chevron-right" style="width: 14px; height: 14px;"></i>
            <span>Fasilitas</span>
        </nav>
        <h1>Fasilitas Modern & Lingkungan Belajar Representatif</h1>
        <p>Menghadirkan lingkungan sarana prasarana sekolah yang aman, islami, nyaman, dan berteknologi tinggi untuk mendukung tumbuh kembang nalar, fisik, serta spiritual peserta didik.</p>
    </div>
</section>

<div class="facilities-container">
    @php
        $facilities = [
            [
                'title' => 'Ruang Kelas Smart AC',
                'badge' => 'Interactive Screen',
                'icon' => 'airplay',
                'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Ruang kelas sejuk ber-AC dilengkapi papan interaktif digital, pencahayaan alami standar kesehatan mata, serta rasio siswa ideal untuk efektivitas pembelajaran.'
            ],
            [
                'title' => 'Laboratorium Sains & Komputer',
                'badge' => 'IT & STEM Lab',
                'icon' => 'cpu',
                'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Fasilitas praktikum eksperimen biologi, kimia, dan fisika yang aman, serta lab komputer canggih untuk penguasaan coding, robotik, dan riset teknologi digital.'
            ],
            [
                'title' => 'Masjid Sekolah yang Luas',
                'badge' => 'Pusat Karakter Adab',
                'icon' => 'sun',
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Masjid representatif sebagai episentrum pembiasaan ibadah harian santri, sholat dhuha & fardhu berjamaah, halaqah tahfidz Al-Qur\'an, dan kajian adab nabawiyah.'
            ],
            [
                'title' => 'Sport Center & Lapangan Terpadu',
                'badge' => 'Futsal & Panahan',
                'icon' => 'activity',
                'image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Arena olahraga multi-fungsi untuk pembinaan kebugaran jasmani, ekstrakurikuler futsal, basket, bulutangkis, panahan (archery), dan bela diri tapak suci.'
            ],
            [
                'title' => 'Perpustakaan & Pojok Baca Digital',
                'badge' => 'Literasi & E-Library',
                'icon' => 'book',
                'image' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Pusat referensi dan literasi dengan ribuan koleksi buku edukatif, ensiklopedia Islam, literatur umum, area baca tenang, dan katalog digital terintegrasi.'
            ],
            [
                'title' => 'Armada Antar-Jemput Nyaman',
                'badge' => 'Transportasi Aman',
                'icon' => 'truck',
                'image' => 'https://images.unsplash.com/photo-1570125909232-eb263c188f7e?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Layanan armada antar-jemput siswa yang terawat, ber-AC, dengan pengemudi berpengalaman dan rute aman menjangkau berbagai wilayah di Karawang.'
            ]
        ];
    @endphp

    <div class="facility-grid-large">
        @foreach($facilities as $f)
        <div class="facility-card-pro">
            <div class="facility-card-media">
                <img src="{{ $f['image'] }}" alt="{{ $f['title'] }}">
                <span class="facility-card-badge">
                    <i data-feather="check-circle" style="width: 12px; height: 12px;"></i> {{ $f['badge'] }}
                </span>
            </div>
            <div class="facility-card-body">
                <div class="facility-icon-circle">
                    <i data-feather="{{ $f['icon'] }}" style="width: 22px; height: 22px;"></i>
                </div>
                <h4>{{ $f['title'] }}</h4>
                <p>{{ $f['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- School Tour Box -->
    <div class="tour-box">
        <div class="tour-text">
            <h3>Ingin Melihat Langsung Fasilitas Kami?</h3>
            <p>Kami mengundang Ayah/Bunda untuk berkunjung ke kampus LPP Al Irsyad Karawang dalam agenda <strong>School Tour</strong>, melihat lingkungan belajar ananda secara langsung dan berdiskusi dengan tim kami.</p>
        </div>
        <div class="tour-cta">
            @php
                $phoneNum = preg_replace('/[^0-9]/', '', $settings['contact_phone'] ?? '6281234567890');
            @endphp
            <a href="https://wa.me/{{ $phoneNum }}?text=Halo%20Admin%20Sekolah,%20saya%20ingin%20jadwalkan%20School%20Tour%20dan%20melihat%20fasilitas%20sekolah." target="_blank" class="btn btn-primary" style="white-space: nowrap;">
                <i data-feather="calendar" style="width: 16px;"></i> Jadwalkan School Tour
            </a>
            <a href="{{ $settings['contact_ppdb_link'] ?? '#' }}" class="btn btn-outline-white" style="white-space: nowrap;">
                Daftar SPMB Online <i data-feather="arrow-right" style="width: 16px;"></i>
            </a>
        </div>
    </div>
</div>
@endsection
