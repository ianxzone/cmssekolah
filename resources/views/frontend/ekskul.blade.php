@extends('frontend.layouts.app')

@section('title', 'Ekstrakurikuler & Pembinaan Bakat - ' . config('app.name', 'LPP Al Irsyad Karawang'))
@section('meta_description', 'Katalog lengkap kegiatan ekstrakurikuler di LPP Al Irsyad Karawang untuk mengasah minat, bakat, kepemimpinan, dan potensi santri.')

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

    .ekskul-container {
        max-width: 1180px;
        margin: 0 auto;
        padding: 50px 20px 80px;
    }

    /* Interactive Filter Tabs */
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

    /* Ekskul Grid */
    .ekskul-catalog-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 26px;
        margin-bottom: 60px;
    }
    .ekskul-card-item {
        background: var(--white);
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        position: relative;
    }
    .ekskul-card-item:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 32px rgba(0,0,0,0.08);
        border-color: var(--secondary);
    }
    .ekskul-card-item.hidden-item {
        display: none;
    }

    .ekskul-media-header {
        height: 180px;
        position: relative;
        background: #064e3b;
        overflow: hidden;
    }
    .ekskul-media-header img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .ekskul-card-item:hover .ekskul-media-header img {
        transform: scale(1.08);
    }
    .ekskul-cat-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(6, 95, 70, 0.9);
        backdrop-filter: blur(8px);
        color: var(--secondary);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 4px 12px;
        border-radius: 50px;
        border: 1px solid rgba(251, 191, 36, 0.4);
    }
    .ekskul-icon-floating {
        position: absolute;
        bottom: -22px;
        right: 20px;
        width: 48px;
        height: 48px;
        background: var(--secondary);
        color: var(--primary-dark);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        font-size: 1.2rem;
        z-index: 2;
    }

    .ekskul-card-body {
        padding: 28px 24px 24px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .ekskul-levels {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 12px;
    }
    .level-tag {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 6px;
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .ekskul-card-body h3 {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 10px;
        line-height: 1.35;
    }
    .ekskul-card-body p {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 18px;
        flex-grow: 1;
    }

    .ekskul-meta-info {
        border-top: 1px dashed #e2e8f0;
        padding-top: 14px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        font-size: 0.82rem;
        color: #475569;
    }
    .ekskul-meta-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .ekskul-meta-row i {
        color: var(--primary);
        flex-shrink: 0;
    }
    .achievement-highlight {
        background: #fffbeb;
        border: 1px solid #fef3c7;
        border-radius: 8px;
        padding: 6px 10px;
        color: #92400e;
        font-weight: 600;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 4px;
    }

    /* FAQ Section */
    .ekskul-faq-section {
        background: #f8fafc;
        border-radius: 24px;
        padding: 44px;
        border: 1px solid #e2e8f0;
        margin-bottom: 50px;
    }
    .ekskul-faq-section h2 {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--primary-dark);
        text-align: center;
        margin-bottom: 30px;
    }
    .faq-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .faq-box {
        background: var(--white);
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px 24px;
    }
    .faq-box h4 {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .faq-box h4 i {
        color: var(--secondary);
    }
    .faq-box p {
        font-size: 0.88rem;
        color: #64748b;
        line-height: 1.6;
        margin: 0;
    }

    /* CTA Box */
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
        .ekskul-catalog-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .faq-grid {
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
        .ekskul-catalog-grid {
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
<!-- Hero Header -->
<section class="page-hero">
    <div class="container">
        <nav class="page-breadcrumb">
            <a href="/">Beranda</a>
            <i data-feather="chevron-right" style="width: 14px; height: 14px;"></i>
            <span>Ekstrakurikuler</span>
        </nav>
        <h1>Ekstrakurikuler & Pembinaan Bakat Santri</h1>
        <p>Mengakomodasi ragam potensi, minat, kepemimpinan, dan kreativitas santri melalui lebih dari 18 ekstrakurikuler unggulan yang dibina oleh para pelatih profesional dan berakhlak mulia.</p>
    </div>
</section>

<div class="ekskul-container">
    <!-- Category Filter Tabs -->
    <div class="filter-tabs-wrapper">
        <button class="filter-tab-btn active" data-filter="all">
            <i data-feather="grid" style="width: 16px; height: 16px;"></i> Semua Ekskul (18)
        </button>
        <button class="filter-tab-btn" data-filter="quran">
            <i data-feather="book-open" style="width: 16px; height: 16px;"></i> Qur'ani & Keislaman
        </button>
        <button class="filter-tab-btn" data-filter="stem">
            <i data-feather="cpu" style="width: 16px; height: 16px;"></i> Sains & Teknologi
        </button>
        <button class="filter-tab-btn" data-filter="sport">
            <i data-feather="activity" style="width: 16px; height: 16px;"></i> Olahraga & Beladiri
        </button>
        <button class="filter-tab-btn" data-filter="leadership">
            <i data-feather="award" style="width: 16px; height: 16px;"></i> Bahasa & Kepemimpinan
        </button>
    </div>

    @php
        $ekskuls = [
            // Qur'ani & Keislaman
            [
                'title' => 'Tahfidz & Tahsin Bersanad',
                'category' => 'quran',
                'cat_label' => 'Qur\'ani & Keagamaan',
                'icon' => 'book',
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Bimbingan intensif hafalan Al-Qur\'an dengan metode talaqqi dan sanad tajwid oleh Asatidz bersanad, tasmi\' akbar rutin, serta mutaba\'ah harian.',
                'schedule' => 'Senin – Kamis Ba\'da Ashar',
                'coach' => 'Ustadz Bersanad Qira\'ah ' . 'Al-Qur\'an',
                'achievement' => 'Juara 1 MHQ Tingkat Kabupaten & Provinsi'
            ],
            [
                'title' => 'Khitobah Tiga Bahasa',
                'category' => 'quran',
                'cat_label' => 'Qur\'ani & Keagamaan',
                'icon' => 'mic',
                'image' => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Latihan retorika dakwah dan public speaking dalam tiga bahasa (Arab, Inggris, dan Indonesia) untuk mencetak calon da\'i dan pemimpin muda muslim.',
                'schedule' => 'Jumat Sore & Sabtu Pagi',
                'coach' => 'Tim Pembina Dakwah Santri LPP',
                'achievement' => 'Juara Pidato Bahasa Arab se-Jawa Barat'
            ],
            [
                'title' => 'Kajian Adab & Siroh Nabawiyah',
                'category' => 'quran',
                'cat_label' => 'Qur\'ani & Keagamaan',
                'icon' => 'heart',
                'image' => 'https://images.unsplash.com/photo-1584697964190-7bb9b1f23788?auto=format&fit=crop&q=80&w=600',
                'levels' => ['TK', 'SDIT', 'SMPIT'],
                'desc' => 'Penanaman keteladanan akhlak Rasulullah SAW dan para sahabat, fikih ibadah praktis, serta pembiasaan adab harian islami.',
                'schedule' => 'Sabtu Pagi (Dwi-Mingguan)',
                'coach' => 'Tim Asatidz Pendidikan Karakter',
                'achievement' => 'Pembentukan Karakter Teladan & Mandiri'
            ],

            // Sains & Teknologi
            [
                'title' => 'Robotik & IoT Innovation',
                'category' => 'stem',
                'cat_label' => 'Sains & Teknologi',
                'icon' => 'cpu',
                'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Eksplorasi perakitan mikrokontroler, pemrograman sensor arduino, robot line follower, hingga automasi cerdas berbasis Internet of Things.',
                'schedule' => 'Sabtu 08.00 – 10.30 WIB',
                'coach' => 'Instruktur Profesional Robotika',
                'achievement' => 'Gold Medal Lomba Robotik Tingkat Nasional'
            ],
            [
                'title' => 'Coding & Game Development',
                'category' => 'stem',
                'cat_label' => 'Sains & Teknologi',
                'icon' => 'code',
                'image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Pengenalan computational thinking, logika pemrograman Scratch untuk usia dini, serta Python & Web Development untuk jenjang lanjutan.',
                'schedule' => 'Sabtu 10.30 – 12.00 WIB',
                'coach' => 'Praktisi IT & Software Engineer',
                'achievement' => 'Finalis Edu-Game Creator Cup'
            ],
            [
                'title' => 'Kelompok Ilmiah Remaja (KIR)',
                'category' => 'stem',
                'cat_label' => 'Sains & Teknologi',
                'icon' => 'activity',
                'image' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SMPIT', 'SMAIT'],
                'desc' => 'Praktikum riset ilmiah di laboratorium modern, penelitian lingkungan hidup sekitar Karawang, dan penulisan karya tulis ilmiah terstruktur.',
                'schedule' => 'Rabu Ba\'da Ashar',
                'coach' => 'Guru Sains & Praktisi Riset',
                'achievement' => 'Juara Olimpiade Penelitian Siswa Daerah'
            ],
            [
                'title' => 'Desain Grafis & Multimedia',
                'category' => 'stem',
                'cat_label' => 'Sains & Teknologi',
                'icon' => 'image',
                'image' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SMPIT', 'SMAIT'],
                'desc' => 'Pembelajaran dasar tipografi, Canva, Adobe Illustrator, editing video kreatif, hingga pembuatan infografis edukasi dakwah santri.',
                'schedule' => 'Kamis Ba\'da Ashar',
                'coach' => 'Creative Designer & Video Editor',
                'achievement' => 'Kreator Konten Dakwah Digital Santri'
            ],

            // Olahraga & Beladiri
            [
                'title' => 'Panahan Sunnah (Archery)',
                'category' => 'sport',
                'cat_label' => 'Olahraga & Beladiri',
                'icon' => 'target',
                'image' => 'https://images.unsplash.com/photo-1511067007772-9da29974ce44?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Menghidupkan olahraga sunnah dengan melatih fokus mental, kestabilan pernapasan, postur tubuh, serta teknik bidik standar nasional (Perpani).',
                'schedule' => 'Sabtu Pagi 07.30 WIB',
                'coach' => 'Pelatih Berlisensi PERPANI',
                'achievement' => 'Medali Emas Kejurkab Panahan Pelajar'
            ],
            [
                'title' => 'Tapak Suci Putera Muhammadiyah',
                'category' => 'sport',
                'cat_label' => 'Olahraga & Beladiri',
                'icon' => 'shield',
                'image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Seni beladiri pencak silat berakidah tauhid, mengasah ketahanan fisik, jurus tanding, dan pertahanan diri santri berjiwa kesatria.',
                'schedule' => 'Selasa & Jumat Sore',
                'coach' => 'Pendekar & Wasit Juri Berlisensi',
                'achievement' => 'Juara Umum Pencak Silat Antar-Pelajar'
            ],
            [
                'title' => 'Taekwondo Teladan',
                'category' => 'sport',
                'cat_label' => 'Olahraga & Beladiri',
                'icon' => 'zap',
                'image' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Olahraga beladiri asal Korea yang melatih kekuatan tendangan, kecepatan reaksi fisik, dan kedisiplinan jenjang sabuk hingga kyorugi tanding.',
                'schedule' => 'Kamis Sore & Minggu Pagi',
                'coach' => 'Sabeum Nim Taekwondo Indonesia',
                'achievement' => 'Medali Perak Kejuaraan Terbuka Jawa Barat'
            ],
            [
                'title' => 'Futsal & Mini Soccer Club',
                'category' => 'sport',
                'cat_label' => 'Olahraga & Beladiri',
                'icon' => 'circle',
                'image' => 'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Pembinaan taktik dasar, kerjasama regu, stamina, dan sportivitas santri di lapangan representatif LPP Al Irsyad Karawang.',
                'schedule' => 'Senin & Kamis Sore',
                'coach' => 'Pelatih Futsal Berlisensi AFC/FFI',
                'achievement' => 'Juara 1 Turnamen Futsal Antar-Sekolah Islam'
            ],
            [
                'title' => 'Basket Ball Club',
                'category' => 'sport',
                'cat_label' => 'Olahraga & Beladiri',
                'icon' => 'disc',
                'image' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SMPIT', 'SMAIT'],
                'desc' => 'Latihan teknik dribble, passing, lay-up, dan strategi defense di Sporthall tertutup dengan ring dan lapangan standar kejuaraan.',
                'schedule' => 'Rabu Sore & Sabtu Pagi',
                'coach' => 'Pelatih Perbasi Karawang',
                'achievement' => 'Semifinalis Kejuaraan Basket Pelajar'
            ],
            [
                'title' => 'Renang (Irsyadin Water Pool)',
                'category' => 'sport',
                'cat_label' => 'Olahraga & Beladiri',
                'icon' => 'droplet',
                'image' => 'https://images.unsplash.com/photo-1530549387789-4c1017266635?auto=format&fit=crop&q=80&w=600',
                'levels' => ['TK', 'SDIT', 'SMPIT'],
                'desc' => 'Olahraga sunnah renang di kolam renang privat Irsyadin Water Pool dengan pelatih profesional, jadwal ikhwan dan akhwat terpisah.',
                'schedule' => 'Sesi Khusus Terjadwal per Kelas',
                'coach' => 'Instruktur Renang Bersertifikat',
                'achievement' => 'Kemampuan Akuatik & Ketahanan Fisik Prima'
            ],

            // Bahasa, Seni & Kepemimpinan
            [
                'title' => 'Pramuka SIT (Sekolah Islam Terpadu)',
                'category' => 'leadership',
                'cat_label' => 'Bahasa & Kepemimpinan',
                'icon' => 'compass',
                'image' => 'https://images.unsplash.com/photo-1504851149312-7a075b496cc7?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Gerakan kepanduan khas SIT yang menggembleng kemandirian, kecakapan survival alam terbuka, tali-temali, dan kepedulian sosial kemanusiaan.',
                'schedule' => 'Jumat Siang (Wajib/Inti)',
                'coach' => 'Pembina Pramuka Kwarda Jabar',
                'achievement' => 'Kontingen Terbaik Jambore Daerah SIT'
            ],
            [
                'title' => 'English Conversation Club',
                'category' => 'leadership',
                'cat_label' => 'Bahasa & Kepemimpinan',
                'icon' => 'globe',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Pengasahan kelancaran bercakap bahasa Inggris melalui debat, drama edukasi, storytelling, dan persiapan sertifikasi Pearson Edexcel UK.',
                'schedule' => 'Kamis Ba\'da Ashar',
                'coach' => 'Native & Pearson Certified Teacher',
                'achievement' => 'Top 3 English Storytelling se-Karawang'
            ],
            [
                'title' => 'Nadi Al-Lughah (Arabic Club)',
                'category' => 'leadership',
                'cat_label' => 'Bahasa & Kepemimpinan',
                'icon' => 'message-square',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Pembiasaan muhadatsah harian bahasa Arab fusha, pengenalan qawa\'id terapan, hafalan mufrodat tematik, dan lagu anak islami.',
                'schedule' => 'Selasa Ba\'da Ashar',
                'coach' => 'Alumni LIPIA & Timur Tengah',
                'achievement' => 'Apresiasi Lomba Muhadatsah Karawang'
            ],
            [
                'title' => 'Jurnalistik & Podcast Santri',
                'category' => 'leadership',
                'cat_label' => 'Bahasa & Kepemimpinan',
                'icon' => 'radio',
                'image' => 'https://images.unsplash.com/photo-1590602847861-f357a9332bbc?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SMPIT', 'SMAIT'],
                'desc' => 'Pelatihan liputan berita sekolah, teknik wawancara narasumber, penulisan artikel buletin, serta produksi siaran podcast edukatif santri.',
                'schedule' => 'Sabtu 13.00 – 15.00 WIB',
                'coach' => 'Jurnalis & Produser Konten Media',
                'achievement' => 'Penerbitan Majalah Dinding & Podcast Santri'
            ],
            [
                'title' => 'Montessori Practical Life & Cooking',
                'category' => 'leadership',
                'cat_label' => 'Bahasa & Kepemimpinan',
                'icon' => 'smile',
                'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&q=80&w=600',
                'levels' => ['Daycare', 'TK Islam'],
                'desc' => 'Aktivitas motorik mandiri anak usia dini: menyajikan makanan sehat, merapikan perlengkapan sendiri, dan mengenal ragam tekstur bahan dapur halal.',
                'schedule' => 'Jumat Pagi Terjadwal',
                'coach' => 'Guru Montessori Bersertifikat',
                'achievement' => 'Kemandirian & Disiplin Diri Sejak Dini'
            ]
        ];
    @endphp

    <!-- Ekskul Catalog Grid -->
    <div class="ekskul-catalog-grid" id="ekskulCatalog">
        @foreach($ekskuls as $item)
        <div class="ekskul-card-item" data-category="{{ $item['category'] }}">
            <div class="ekskul-media-header">
                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" loading="lazy">
                <span class="ekskul-cat-badge">{{ $item['cat_label'] }}</span>
                <div class="ekskul-icon-floating">
                    <i data-feather="{{ $item['icon'] }}"></i>
                </div>
            </div>
            <div class="ekskul-card-body">
                <div class="ekskul-levels">
                    @foreach($item['levels'] as $lvl)
                    <span class="level-tag">{{ $lvl }}</span>
                    @endforeach
                </div>
                <h3>{{ $item['title'] }}</h3>
                <p>{{ $item['desc'] }}</p>

                <div class="ekskul-meta-info">
                    <div class="ekskul-meta-row">
                        <i data-feather="clock" style="width: 14px; height: 14px;"></i>
                        <span>{{ $item['schedule'] }}</span>
                    </div>
                    <div class="ekskul-meta-row">
                        <i data-feather="user-check" style="width: 14px; height: 14px;"></i>
                        <span>{{ $item['coach'] }}</span>
                    </div>
                    @if(!empty($item['achievement']))
                    <div class="achievement-highlight">
                        <i data-feather="award" style="width: 14px; height: 14px;"></i>
                        <span>{{ $item['achievement'] }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- FAQ Section -->
    <div class="ekskul-faq-section">
        <h2>Pertanyaan Seputar Ekstrakurikuler</h2>
        <div class="faq-grid">
            <div class="faq-box">
                <h4><i data-feather="help-circle" style="width: 18px; height: 18px;"></i> Apakah santri wajib mengikuti ekskul?</h4>
                <p>Setiap santri wajib mengikuti 1 ekskul wajib (seperti Pramuka SIT / Tahfidz Halaqah) dan dibebaskan memilih 1 hingga maksimal 2 ekskul pilihan sesuai bakat dan minat pribadinya.</p>
            </div>
            <div class="faq-box">
                <h4><i data-feather="help-circle" style="width: 18px; height: 18px;"></i> Apakah jadwal ekskul bentrok dengan KBM?</h4>
                <p>Tidak. Seluruh kegiatan ekskul dijadwalkan di luar jam belajar intrakurikuler (sore hari ba'da Ashar atau hari Sabtu pagi), sehingga capaian akademik santri tetap terjaga optimal.</p>
            </div>
            <div class="faq-box">
                <h4><i data-feather="help-circle" style="width: 18px; height: 18px;"></i> Bagaimana pembagian ikhwan dan akhwat?</h4>
                <p>Untuk ekskul olahraga fisik seperti renang, beladiri, dan futsal, jadwal latihan serta pembina/pelatih dipisahkan antara santri ikhwan (putra) dan akhwat (putri) sesuai adab syar'i.</p>
            </div>
            <div class="faq-box">
                <h4><i data-feather="help-circle" style="width: 18px; height: 18px;"></i> Apakah ada kesempatan mengikuti turnamen resmi?</h4>
                <p>Ya. Santri yang tergabung dalam ekskul prestasi akan mendapatkan bimbingan intensif dan didaftarkan dalam kejuaraan resmi tingkat daerah, provinsi, hingga olimpiade nasional.</p>
            </div>
        </div>
    </div>

    <!-- CTA Box -->
    <div class="tour-box">
        <div class="tour-text">
            <h3>Konsultasi Minat & Bakat Calon Santri</h3>
            <p>Bingung menentukan ekskul yang paling tepat untuk mengoptimalkan potensi Ananda? Konsultasikan bersama tim konselor pendidikan dan pendaftaran santri baru LPP Al Irsyad Karawang.</p>
        </div>
        <div class="tour-cta">
            @php
                $phoneNum = preg_replace('/[^0-9]/', '', $settings['contact_phone'] ?? '6281234567890');
            @endphp
            <a href="https://wa.me/{{ $phoneNum }}?text=Halo%20Admin%20Sekolah,%20saya%20ingin%20konsultasi%20program%20ekstrakurikuler%20dan%20pembinaan%20bakat%20santri." target="_blank" class="btn btn-primary" style="white-space: nowrap;">
                <i data-feather="message-circle" style="width: 16px;"></i> Konsultasi via WhatsApp
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
        const cards = document.querySelectorAll('.ekskul-card-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all
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
