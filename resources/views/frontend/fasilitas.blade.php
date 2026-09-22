@extends('frontend.layouts.app')

@section('title', 'Fasilitas & Sarana Prasarana - ' . config('app.name', 'LPP Al Irsyad Karawang'))
@section('meta_description', 'Fasilitas lengkap, modern, dan representatif di LPP Al Irsyad Karawang mendukung kenyamanan belajar, pembiasaan ibadah, dan prestasi santri.')

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
        max-width: 1180px;
        margin: 0 auto;
        padding: 50px 20px 80px;
    }

    /* Filter Tabs */
    .filter-tabs-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        margin-bottom: 40px;
    }
    .filter-tab-btn {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        padding: 10px 22px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.92rem;
        cursor: pointer;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .filter-tab-btn:hover {
        background: #e2e8f0;
        color: var(--primary-dark);
    }
    .filter-tab-btn.active {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(6, 95, 70, 0.25);
    }

    /* Facilities Grid */
    .facility-grid-large {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 26px;
        margin-bottom: 60px;
    }
    .facility-card-pro {
        background: var(--white);
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .facility-card-pro:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 32px rgba(0,0,0,0.08);
        border-color: var(--secondary);
    }
    .facility-card-pro.hidden-item {
        display: none;
    }
    .facility-card-media {
        height: 200px;
        position: relative;
        background: #064e3b;
        overflow: hidden;
    }
    .facility-card-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .facility-card-pro:hover .facility-card-media img {
        transform: scale(1.08);
    }
    .facility-card-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        background: rgba(6, 95, 70, 0.9);
        backdrop-filter: blur(8px);
        color: var(--secondary);
        border: 1px solid rgba(251, 191, 36, 0.4);
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .facility-card-body {
        padding: 26px 24px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .facility-icon-circle {
        width: 44px;
        height: 44px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: var(--primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
    }
    .facility-card-body h4 {
        font-size: 1.22rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
        line-height: 1.35;
    }
    .facility-card-body p {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.6;
        margin: 0;
        flex-grow: 1;
    }

    /* 26 Complete Directory Box */
    .master-inventory-box {
        background: #f8fafc;
        border-radius: 24px;
        padding: 44px;
        border: 1px solid #e2e8f0;
        margin-bottom: 50px;
    }
    .master-inventory-header {
        text-align: center;
        margin-bottom: 36px;
    }
    .master-inventory-header h2 {
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--primary-dark);
        margin-bottom: 8px;
    }
    .master-inventory-header p {
        font-size: 0.95rem;
        color: #64748b;
        max-width: 680px;
        margin: 0 auto;
    }
    .inventory-columns {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }
    .inv-col {
        background: var(--white);
        border-radius: 16px;
        padding: 24px 22px;
        border: 1px solid #e2e8f0;
    }
    .inv-col-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--primary-dark);
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .inv-col-title i {
        color: var(--secondary);
    }
    .inv-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .inv-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 0.88rem;
        color: #334155;
        font-weight: 500;
        line-height: 1.45;
    }
    .inv-item i {
        color: var(--primary);
        font-size: 14px;
        margin-top: 2px;
        flex-shrink: 0;
    }

    /* School Tour Box */
    .tour-box {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: 24px;
        padding: 40px 48px;
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 30px;
        box-shadow: 0 16px 36px rgba(6, 95, 70, 0.22);
    }
    .tour-text h3 {
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: 8px;
        color: var(--white);
    }
    .tour-text p {
        font-size: 0.98rem;
        color: #d1fae5;
        line-height: 1.6;
        margin: 0;
        max-width: 620px;
    }
    .tour-cta {
        display: flex;
        gap: 12px;
        flex-shrink: 0;
    }

    @media (max-width: 992px) {
        .facility-grid-large {
            grid-template-columns: repeat(2, 1fr);
        }
        .inventory-columns {
            grid-template-columns: 1fr;
        }
        .tour-box {
            flex-direction: column;
            text-align: center;
            padding: 32px 24px;
        }
        .tour-cta {
            width: 100%;
            justify-content: center;
            flex-wrap: wrap;
        }
    }
    @media (max-width: 640px) {
        .page-hero h1 {
            font-size: 2rem;
        }
        .facility-grid-large {
            grid-template-columns: 1fr;
        }
        .filter-tab-btn {
            font-size: 0.82rem;
            padding: 8px 16px;
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
        <p>Menghadirkan lingkungan sarana prasarana sekolah yang aman, islami, nyaman, dan berteknologi tinggi untuk mendukung tumbuh kembang nalar, fisik, serta spiritual santri LPP Al Irsyad Karawang.</p>
    </div>
</section>

<div class="facilities-container">
    <!-- Interactive Category Filter Tabs -->
    <div class="filter-tabs-wrapper">
        <button class="filter-tab-btn active" data-filter="all">
            <i data-feather="grid" style="width: 16px; height: 16px;"></i> Semua Fasilitas (26+)
        </button>
        <button class="filter-tab-btn" data-filter="class">
            <i data-feather="home" style="width: 16px; height: 16px;"></i> Ruang Belajar & Kelas
        </button>
        <button class="filter-tab-btn" data-filter="lab">
            <i data-feather="cpu" style="width: 16px; height: 16px;"></i> Laboratorium & IT
        </button>
        <button class="filter-tab-btn" data-filter="worship">
            <i data-feather="sun" style="width: 16px; height: 16px;"></i> Sarana Ibadah & Adab
        </button>
        <button class="filter-tab-btn" data-filter="sport">
            <i data-feather="activity" style="width: 16px; height: 16px;"></i> Olahraga & Bermain
        </button>
        <button class="filter-tab-btn" data-filter="service">
            <i data-feather="shield" style="width: 16px; height: 16px;"></i> Layanan & Keamanan
        </button>
    </div>

    @php
        $facilities = [
            // Ruang Belajar & Kelas
            [
                'title' => 'Ruang Kelas Smart AC',
                'category' => 'class',
                'badge' => 'Smart Interactive TV',
                'icon' => 'airplay',
                'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Ruang kelas sejuk ber-AC lengkap dengan Smart TV interaktif, pencahayaan alami standar optik mata, loker santri, serta rasio siswa ideal untuk efektivitas KBM.'
            ],
            [
                'title' => 'Sentra Montessori & Daycare',
                'category' => 'class',
                'badge' => 'Ramah Anak & Stimulasi',
                'icon' => 'smile',
                'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Lingkungan eksplorasi motorik untuk usia Daycare (bayi/balita) dan Playgroup/TK dengan aparatus Montessori orisinal, lantai busa empuk, dan zona tidur higienis.'
            ],
            [
                'title' => 'Perpustakaan & Pojok Baca Digital',
                'category' => 'class',
                'badge' => 'E-Library & Literasi',
                'icon' => 'book',
                'image' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Koleksi ribuan buku referensi ensiklopedia Islam, literatur sains dunia, pojok baca lesehan yang nyaman, dan komputer katalog e-library.'
            ],
            [
                'title' => 'Laboratorium Bahasa Modern',
                'category' => 'class',
                'badge' => 'Bilingual Immersion',
                'icon' => 'globe',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Dilengkapi headset audio-interaktif mandiri untuk praktikum listening, TOEFL/IELTS preparation, dan muhadatsah bahasa Arab fusha.'
            ],

            // Laboratorium & IT
            [
                'title' => 'Laboratorium Komputer iMac & Multimedia',
                'category' => 'lab',
                'badge' => 'Apple & High-Spec PC',
                'icon' => 'cpu',
                'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Fasilitas perangkat iMac dan workstation mutakhir dengan akses internet serat optik berkecepatan tinggi untuk materi coding, AI, desain, dan CBT exam.'
            ],
            [
                'title' => 'Laboratorium Fisika & Bio-Kimia',
                'category' => 'lab',
                'badge' => 'STEM & Eksperimen',
                'icon' => 'zap',
                'image' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Ruang praktikum terstandarisasi keamanan tinggi dengan mikroskop digital, glassware lengkap, reagen aman, dan bimbingan laboran berpengalaman.'
            ],
            [
                'title' => 'Studio Robotika & Coding Lab',
                'category' => 'lab',
                'badge' => 'Inovasi Robotik',
                'icon' => 'sliders',
                'image' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Pusat riset dan perakitan mikrokontroler, robotik arena pertandingan, dan 3D printing untuk mengasah nalar komputasi generasi masa depan.'
            ],
            [
                'title' => 'Student Smart Card Integrated System',
                'category' => 'lab',
                'badge' => 'Sistem Digital',
                'icon' => 'credit-card',
                'image' => 'https://images.unsplash.com/photo-1556742049-0a67e5574f73?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Kartu pintar santri multifungsi untuk presensi tap digital, peminjaman buku perpustakaan, hingga transaksi nontunai di Irsyadin Mart.'
            ],

            // Sarana Ibadah & Adab
            [
                'title' => 'Masjid Jami Al Irsyad',
                'category' => 'worship',
                'badge' => 'Episentrum Ibadah',
                'icon' => 'sun',
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Masjid megah ber-AC sebagai pusat sholat fardhu berjamaah, pembiasaan sholat dhuha, halaqah tahfidz Al-Qur\'an bersanad, dan kajian adab nabawiyah.'
            ],
            [
                'title' => 'Auditorium & Aula Serbaguna',
                'category' => 'worship',
                'badge' => 'Kapasitas 1.000 Santri',
                'icon' => 'users',
                'image' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Gedung pertemuan bertaraf nasional berpendingin sentral untuk wisuda tahfidz akbar, seminar parenting, khitobah panggung, dan pameran karya siswa.'
            ],

            // Olahraga & Bermain
            [
                'title' => 'Irsyadin Water Pool (Kolam Renang)',
                'category' => 'sport',
                'badge' => 'Renang Sunnah Privat',
                'icon' => 'droplet',
                'image' => 'https://images.unsplash.com/photo-1530549387789-4c1017266635?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Kolam renang representatif berstandar kebersihan tinggi khusus santri LPP Al Irsyad, dengan jadwal dan pengawasan ketat terpisah ikhwan/akhwat.'
            ],
            [
                'title' => 'Sporthall & Lapangan Olahraga Terpadu',
                'category' => 'sport',
                'badge' => 'Futsal, Basket, Voli',
                'icon' => 'activity',
                'image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Arena lapangan olahraga multi-fungsi berlantai standar turnamen untuk basket, voli, bulutangkis, futsal, serta arena beladiri Tapak Suci dan Taekwondo.'
            ],
            [
                'title' => 'Playground Outdoor & Indoor Tematik',
                'category' => 'sport',
                'badge' => 'Zona Anak Aman',
                'icon' => 'smile',
                'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Wahana bermain interaktif untuk merangsang motorik kasar dan ketangkasan fisik anak usia dini, dilengkapi pelindung benturan dan pengawasan guru.'
            ],

            // Layanan & Keamanan
            [
                'title' => 'Sistem Pengawasan CCTV 24 Jam',
                'category' => 'service',
                'badge' => 'Keamanan Terpadu',
                'icon' => 'shield',
                'image' => 'https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Titik kamera pengawas berteknologi tinggi di seluruh koridor, ruang publik, pintu gerbang, dan area bermain untuk menjamin rasa aman santri dan walisantri.'
            ],
            [
                'title' => 'Armada Antar-Jemput Siswa Nyaman',
                'category' => 'service',
                'badge' => 'Mitra Transportasi Resmi',
                'icon' => 'truck',
                'image' => 'https://images.unsplash.com/photo-1570125909232-eb263c188f7e?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Layanan antar-jemput ber-AC terawat dengan pengemudi berpengalaman, rute teratur menjangkau seluruh kawasan perumahan strategis di Karawang.'
            ],
            [
                'title' => 'UKS & Layanan Dokter Sekolah',
                'category' => 'service',
                'badge' => 'Kesehatan Santri',
                'icon' => 'heart',
                'image' => 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Klinik UKS representatif dengan tempat tidur medis, stok obat pertolongan pertama, dan pemeriksaan kesehatan gigi serta fisik berkala oleh dokter mitra.'
            ],
            [
                'title' => 'Cafetaria Sehat, Irsyadin Mart & Catering',
                'category' => 'service',
                'badge' => 'Halalan Thayyiban',
                'icon' => 'coffee',
                'image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Penyediaan asupan gizi higienis bersertifikasi halal, bebas pengawet berbahaya, serta minimarket sekolah untuk kebutuhan santri dan walisantri.'
            ],
            [
                'title' => 'Admission Office & Ruang Tunggu VIP',
                'category' => 'service',
                'badge' => 'Pelayanan Ramah',
                'icon' => 'briefcase',
                'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Pusat layanan informasi SPMB terpadu yang nyaman, ber-AC, dan staf ramah siap melayani konsultasi pendaftaran santri baru dan tamu sekolah.'
            ]
        ];
    @endphp

    <!-- Facility Cards Grid -->
    <div class="facility-grid-large" id="facilityGrid">
        @foreach($facilities as $f)
        <div class="facility-card-pro" data-category="{{ $f['category'] }}">
            <div class="facility-card-media">
                <img src="{{ $f['image'] }}" alt="{{ $f['title'] }}" loading="lazy">
                <span class="facility-card-badge">
                    <i data-feather="check-circle" style="width: 12px; height: 12px; vertical-align: middle;"></i> {{ $f['badge'] }}
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

    <!-- 26 Complete Facility Inventory Checklist -->
    <div class="master-inventory-box">
        <div class="master-inventory-header">
            <h2>Daftar Lengkap 26+ Sarana & Prasarana Kampus</h2>
            <p>Standar fasilitas terintegrasi di seluruh unit pendidikan LPP Al Irsyad Al Islamiyyah Karawang untuk menjamin lingkungan belajar yang unggul dan kondusif.</p>
        </div>
        <div class="inventory-columns">
            <!-- Col 1: Akademik & Riset -->
            <div class="inv-col">
                <div class="inv-col-title">
                    <i data-feather="book-open"></i> Akademik & Riset Sains
                </div>
                <ul class="inv-list">
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Ruang kelas ber-AC, nyaman & ramah anak</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Smart TV & Interactive Board KBM</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Perpustakaan Digital & Katalog Komputer</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Pojok Baca Lesehan di Tiap Lantai</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Laboratorium Komputer iMac Modern</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Laboratorium Fisika & Eksperimen Sains</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Laboratorium Bio-Kimia Terstandar</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Laboratorium Bahasa Audio-Digital</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Sentra Montessori Lengkap (Usia Dini)</span></li>
                </ul>
            </div>

            <!-- Col 2: Ibadah & Olahraga -->
            <div class="inv-col">
                <div class="inv-col-title">
                    <i data-feather="activity"></i> Ibadah & Sarana Olahraga
                </div>
                <ul class="inv-list">
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Masjid Jami Al Irsyad (Episentrum Ibadah)</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Auditorium & Aula Serbaguna (1.000 Orang)</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Ruang Khusus Halaqah Tahfidz Al-Qur'an</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Irsyadin Water Pool (Kolam Renang Privat)</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Sporthall Indoor Gedung Tertutup</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Lapangan Futsal & Basket Terpadu</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Playground Outdoor Rumput & Wahana Bermain</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Playground Indoor Busa Aman Balita</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Ruang Seni & Kaligrafi Islami</span></li>
                </ul>
            </div>

            <!-- Col 3: Layanan & Keamanan -->
            <div class="inv-col">
                <div class="inv-col-title">
                    <i data-feather="shield"></i> Layanan & Keamanan Kampus
                </div>
                <ul class="inv-list">
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Pengawasan CCTV 24 Jam Terintegrasi</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Student Smart Card System Presensi</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Armada Antar-Jemput Resmi Ber-AC</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Klinik UKS & Dokter Sekolah Berkala</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Cafetaria Sehat & Menu Halal Higienis</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Irsyadin Mart (Kebutuhan Santri)</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>ATM Center Kawasan Sekolah</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Admission Office & Ruang Konsultasi SPMB</span></li>
                    <li class="inv-item"><i data-feather="check-circle"></i> <span>Area Parkir Luas & Keamanan Pos Satpam</span></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- School Tour Box -->
    <div class="tour-box">
        <div class="tour-text">
            <h3>Ingin Melihat Langsung Fasilitas Kami?</h3>
            <p>Kami mengundang Ayah/Bunda untuk berkunjung ke kampus LPP Al Irsyad Karawang dalam agenda <strong>School Tour</strong>, melihat langsung ruang kelas, kolam renang, dan laboratorium serta berdiskusi dengan tim pendaftaran.</p>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-tab-btn');
        const cards = document.querySelectorAll('.facility-card-pro');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');

                cards.forEach(card => {
                    const cardCat = card.getAttribute('data-category');
                    if (filterValue === 'all' || cardCat === filterValue) {
                        card.classList.remove('hidden-item');
                        card.style.opacity = '0';
                        setTimeout(() => {
                            card.style.transition = 'opacity 0.35s ease';
                            card.style.opacity = '1';
                        }, 20);
                    } else {
                        card.classList.add('hidden-item');
                    }
                });

                if (window.feather) {
                    feather.replace();
                }
            });
        });
    });
</script>
@endpush
@endsection
