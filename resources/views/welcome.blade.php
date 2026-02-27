<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SMA Islam Teladan Al Irsyad Al Islamiyyah Karawang' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        :root { --primary: #065f46; --primary-dark: #064e3b; --primary-light: #10b981; --secondary: #fbbf24; --text-main: #1f2937; --text-muted: #6b7280; --bg-light: #f9fafb; --white: #ffffff; --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.05); --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1); --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1); --radius-md: 12px; --radius-lg: 24px; --container-max: 1200px; --transition: all 0.3s ease; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Outfit', sans-serif; color: var(--text-main); background-color: var(--white); line-height: 1.6; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; transition: var(--transition); }
        ul { list-style: none; }
        img { max-width: 100%; height: auto; display: block; }
        .container { max-width: var(--container-max); margin: 0 auto; padding: 0 20px; }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 12px 28px; border-radius: 50px; font-weight: 600; cursor: pointer; transition: var(--transition); border: none; gap: 8px; }
        .btn-primary { background-color: var(--secondary); color: var(--primary-dark); box-shadow: 0 4px 14px rgba(251, 191, 36, 0.4); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(251, 191, 36, 0.6); }
        .btn-white { background-color: var(--white); color: var(--primary); }
        .btn-white:hover { background-color: #f3f4f6; transform: translateY(-2px); }
        .btn-outline { background: transparent; border: 2px solid var(--primary); color: var(--primary); }
        .btn-outline:hover { background: var(--primary); color: var(--white); }
        .btn-outline-white { background: transparent; border: 2px solid var(--white); color: var(--white); }
        .btn-outline-white:hover { background: var(--white); color: var(--primary); }
        section { padding: 80px 0; }
        .section-header { text-align: center; margin-bottom: 50px; }
        .section-header span { color: var(--primary-light); text-transform: uppercase; font-weight: 700; letter-spacing: 2px; font-size: 0.85rem; display: block; margin-bottom: 10px; }
        .section-header h2 { font-size: 2.5rem; color: var(--primary-dark); font-weight: 800; }
        
        .topbar { background: var(--primary-dark); color: var(--white); padding: 10px 0; font-size: 0.85rem; }
        .topbar .container { display: flex; justify-content: space-between; align-items: center; }
        .topbar-info { display: flex; gap: 20px; }
        .topbar-info div { display: flex; align-items: center; gap: 6px; }
        
        .navbar { background: var(--white); padding: 15px 0; position: sticky; top: 0; z-index: 1000; box-shadow: var(--shadow-sm); transition: var(--transition); }
        .navbar.sticky-active { padding: 10px 0; box-shadow: var(--shadow-md); }
        .navbar .container { display: flex; justify-content: space-between; align-items: center; }
        .logo { display: flex; align-items: center; gap: 12px; }
        .logo img { height: 50px; }
        .logo-text h1 { font-size: 1.25rem; color: var(--primary-dark); font-weight: 800; line-height: 1; }
        .logo-text p { font-size: 0.75rem; color: var(--primary-light); font-weight: 600; letter-spacing: 1px; margin-bottom: 0; }
        .nav-menu { display: flex; gap: 30px; align-items: center; }
        .nav-link { font-weight: 600; color: var(--text-main); font-size: 0.95rem; }
        .nav-link:hover { color: var(--primary); }
        .nav-spmb { background: var(--primary); color: var(--white) !important; padding: 10px 24px; border-radius: 50px; font-weight: 600;}
        .nav-spmb:hover { background: var(--primary-dark); transform: scale(1.05); }
        .mobile-toggle { display: none; cursor: pointer; color: var(--primary-dark); }
        
        .hero { position: relative; height: 85vh; display: flex; align-items: center; color: var(--white); margin-top: -1px; }
        .hero-overlay { position: absolute; inset: 0; background: linear-gradient(to right, rgba(6,78,59,0.95), rgba(6,78,59,0.5)); z-index: 0; }
        .hero .container { position: relative; z-index: 1; }
        .hero-content { max-width: 800px; }
        .hero-badge { background: rgba(255,255,255,0.1); backdrop-filter: blur(5px); padding: 8px 20px; border-radius: 50px; display: inline-block; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.2); font-weight: 600; font-size: 0.9rem; }
        .hero h2 { font-size: 4rem; font-weight: 800; line-height: 1.1; margin-bottom: 20px; }
        .hero p { font-size: 1.2rem; margin-bottom: 35px; opacity: 0.9; max-width: 700px; }
        .hero-btns { display: flex; gap: 15px; }
        
        .prayer-bar { background: transparent; margin-top: -60px; position: relative; z-index: 10; padding: 0; }
        .prayer-card { background: var(--white); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); display: grid; grid-template-columns: 1fr 2fr; overflow: hidden; border: 1px solid #f3f4f6; }
        .prayer-left { background: var(--primary); color: var(--white); padding: 30px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; }
        .prayer-left h3 { font-size: 1rem; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8; margin-bottom: 5px; }
        .prayer-left .next-prayer { font-size: 2.5rem; font-weight: 800; }
        .prayer-left .next-time { font-size: 1.25rem; font-weight: 600; color: var(--secondary); }
        .prayer-right { padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; }
        .prayer-item { text-align: center; }
        .prayer-item span { display: block; font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; }
        .prayer-item strong { font-size: 1.1rem; color: var(--primary-dark); font-weight: 700; }
        
        .stats { padding: 60px 0; background: #f8fafc; }
        .stats-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 30px; }
        .stat-card { text-align: center; padding: 20px; border-right: 1px solid #e2e8f0; }
        .stat-card:last-child { border-right: none; }
        .stat-number { font-size: 2.5rem; font-weight: 800; color: var(--primary); margin-bottom: 5px; }
        .stat-label { color: var(--text-muted); font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; }
        
        .welcome-section { background: var(--white); }
        .welcome-grid { display: grid; grid-template-columns: 1fr 1.5fr; gap: 60px; align-items: center; }
        .welcome-img { position: relative; }
        .welcome-img img { border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); width: 100%; }
        .welcome-img::after { content: ''; position: absolute; bottom: -20px; right: -20px; width: 100%; height: 100%; border: 5px solid var(--secondary); border-radius: var(--radius-lg); z-index: -1; }
        .welcome-txt h2 { font-size: 2.5rem; color: var(--primary-dark); margin-bottom: 20px; font-weight: 800; }
        .welcome-txt p { color: var(--text-muted); margin-bottom: 20px; font-size: 1.1rem; }
        .welcome-name { margin-top: 30px; }
        .welcome-name h4 { font-size: 1.25rem; color: var(--primary); font-weight: 700; margin-bottom: 2px;}
        .welcome-name span { color: var(--text-muted); font-size: 0.9rem; }
        
        .vision-mission { background: var(--primary-dark); color: var(--white); }
        .vision-box { background: rgba(255,255,255,0.05); padding: 40px; border-radius: var(--radius-lg); text-align: center; margin-bottom: 50px; border: 1px solid rgba(255,255,255,0.1); }
        .vision-box h3 { color: var(--secondary); font-size: 1.5rem; margin-bottom: 15px; text-transform: uppercase; }
        .mission-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .mission-item { display: flex; gap: 15px; background: rgba(255,255,255,0.03); padding: 20px; border-radius: var(--radius-md); transition: var(--transition); }
        .mission-item:hover { background: rgba(255,255,255,0.08); transform: translateX(5px); }
        .mission-num { background: var(--secondary); color: var(--primary-dark); width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; flex-shrink: 0; }
        
        .programs { background: var(--bg-light); }
        .program-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; }
        .program-card { background: var(--white); padding: 40px 30px; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); text-align: center; transition: var(--transition); border: 1px solid transparent; }
        .program-card:hover { transform: translateY(-10px); box-shadow: var(--shadow-lg); border-color: var(--primary-light); }
        .program-icon { width: 70px; height: 70px; background: var(--primary-light); color: var(--white); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; }
        .program-card h3 { margin-bottom: 15px; color: var(--primary-dark); font-size: 1.2rem; font-weight: 700;}
        .program-card p { color: var(--text-muted); font-size: 0.9rem; }
        
        .agenda { background: var(--white); }
        .agenda-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; }
        .agenda-card { display: flex; gap: 20px; padding: 25px; background: #f1f5f9; border-radius: var(--radius-md); align-items: center; border: 1px solid #e2e8f0;}
        .agenda-date { background: var(--primary); color: var(--white); padding: 15px; border-radius: 12px; text-align: center; min-width: 80px; }
        .agenda-date .day { font-size: 1.5rem; font-weight: 800; display: block; }
        .agenda-date .month { font-size: 0.8rem; text-transform: uppercase; font-weight: 700; }
        .agenda-info { flex-grow: 1; }
        .agenda-info h4 { font-size: 1.1rem; margin-bottom: 5px; color: var(--primary-dark); font-weight: 700;}
        .agenda-info h4 a { color: inherit; }
        .agenda-info h4 a:hover { color: var(--primary); }
        .agenda-info p { font-size: 0.85rem; color: var(--text-muted); display:flex; align-items:center; gap: 5px; margin-bottom: 3px;}
        .agenda-link { display: flex; align-items: center; color: var(--primary); justify-content: flex-end; }
        
        .teachers { background: var(--bg-light); }
        .teacher-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 25px; }
        .teacher-card { text-align: center; background: var(--white); padding: 20px; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);}
        .teacher-img { border-radius: var(--radius-md); overflow: hidden; margin-bottom: 15px; aspect-ratio: 1/1; }
        .teacher-img img { width: 100%; height: 100%; object-fit: cover; transition: var(--transition); }
        .teacher-card:hover img { transform: scale(1.1); }
        .teacher-info h4 { color: var(--primary-dark); font-weight: 700; margin-bottom: 2px; }
        .teacher-info p { color: var(--text-muted); font-size: 0.85rem; font-weight: 600; }
        
        .spmb-banner { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); padding: 60px 0; color: var(--white); text-align: center; }
        .spmb-banner h2 { font-size: 2.2rem; margin-bottom: 15px; font-weight: 800; }
        .spmb-banner p { font-size: 1.1rem; margin-bottom: 30px; opacity: 0.9; max-width: 700px; margin-left: auto; margin-right: auto;}
        
        .news { background: var(--white); }
        .news-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
        .news-card { background: var(--white); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm); transition: var(--transition); border: 1px solid #f1f5f9; display: flex; flex-direction: column;}
        .news-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); }
        .news-img { height: 220px; overflow: hidden; }
        .news-img img { width: 100%; height: 100%; object-fit: cover; }
        .news-content { padding: 25px; flex-grow: 1; display: flex; flex-direction: column;}
        .news-meta { font-size: 0.8rem; color: var(--primary-light); font-weight: 600; margin-bottom: 10px; display: flex; gap: 15px;}
        .news-meta span { display: flex; align-items: center; gap: 5px; }
        .news-content h3 { font-size: 1.2rem; margin-bottom: 12px; line-height: 1.4; color: var(--primary-dark); font-weight: 700;}
        .news-content p { color: var(--text-muted); font-size: 0.9rem; margin-bottom: 20px; flex-grow: 1;}
        .news-link { font-weight: 700; color: var(--primary); display: flex; align-items: center; gap: 5px; margin-top: auto;}
        
        .testimonials { background: var(--primary-dark); color: var(--white); }
        .testi-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
        .testi-card { background: rgba(255,255,255,0.05); padding: 40px; border-radius: var(--radius-lg); text-align: center; position: relative; border: 1px solid rgba(255,255,255,0.1); }
        .testi-quote { position: absolute; top: 20px; right: 20px; color: rgba(255,255,255,0.1); width: 60px; height: 60px; }
        .testi-img { width: 80px; height: 80px; border-radius: 50%; overflow: hidden; margin: 0 auto 20px; border: 3px solid var(--secondary); }
        .testi-img img { width: 100%; height: 100%; object-fit: cover; }
        .testi-card p { font-size: 1rem; font-style: italic; margin-bottom: 20px; opacity: 0.9; }
        .testi-card h4 { color: var(--secondary); font-size: 1.1rem; font-weight: 700; margin-bottom: 2px;}
        .testi-card span { font-size: 0.85rem; opacity: 0.7; }
        
        .facilities { background: var(--white); }
        .fac-ekskul-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; }
        .feature-list { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .feature-item { display: flex; align-items: center; gap: 10px; color: var(--text-main); font-weight: 500; padding: 10px; background: var(--bg-light); border-radius: 8px;}
        .feature-item i { color: var(--primary); width: 20px; }
        .ekskul-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; }
        .ekskul-card { background: var(--bg-light); padding: 15px; border-radius: var(--radius-md); text-align: center; font-weight: 600; font-size: 0.9rem; color: var(--text-main); border: 1px solid #e2e8f0; display:flex; align-items:center; justify-content:center;}
        .ekskul-special { background: var(--primary-light); color: var(--white); border: none; flex-direction: column; gap: 5px;}
        .ekskul-special span { background: var(--secondary); color:#fff; font-size: 0.6rem; padding: 2px 6px; border-radius: 4px; text-transform: uppercase; letter-spacing: 1px;}
        
        footer { background: #0f172a; color: #cbd5e1; padding: 80px 0 20px; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 40px; margin-bottom: 50px; }
        .footer-logo h3 { color: var(--white); font-size: 1.5rem; margin-bottom: 15px; font-weight: 800; }
        .footer-logo p { margin-bottom: 20px; font-size: 0.95rem; }
        .social-links { display: flex; gap: 10px; }
        .social-links a { width: 40px; height: 40px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--white); transition: var(--transition); }
        .social-links a:hover { background: var(--secondary); color: var(--primary-dark); }
        .footer-col h4 { color: var(--white); font-size: 1.2rem; margin-bottom: 25px; font-weight: 700; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a:hover { color: var(--secondary); padding-left: 5px; }
        .contact-list li { display: flex; gap: 15px; margin-bottom: 15px; align-items: flex-start; }
        .contact-list i { color: var(--secondary); margin-top: 5px; width: 18px;}
        .footer-bottom { text-align: center; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.9rem; display: flex; flex-direction: column; gap: 5px;}
        
        @media (max-width: 1024px) {
            .hero h2 { font-size: 3rem; }
            .prayer-card { grid-template-columns: 1fr 1.5fr; }
            .stats-grid { grid-template-columns: repeat(3, 1fr); }
            .stat-card:nth-child(3) { border-right: none; }
            .program-grid { grid-template-columns: repeat(2, 1fr); }
            .teacher-grid { grid-template-columns: repeat(2, 1fr); }
            .news-grid { grid-template-columns: repeat(2, 1fr); }
            .testi-grid { grid-template-columns: repeat(2, 1fr); }
            .fac-ekskul-grid { grid-template-columns: 1fr; gap: 40px; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .topbar { display: none; }
            .mobile-toggle { display: block; }
            .nav-menu { position: absolute; top: 100%; left: 0; width: 100%; background: var(--white); flex-direction: column; padding: 20px; display: none; box-shadow: var(--shadow-md); }
            .nav-menu.active { display: flex; }
            .hero-btns { flex-direction: column; }
            .hero h2 { font-size: 2.2rem; }
            .prayer-card { grid-template-columns: 1fr; }
            .prayer-right { flex-direction: column; gap: 20px; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .welcome-grid { grid-template-columns: 1fr; }
            .mission-grid { grid-template-columns: 1fr; }
            .program-grid { grid-template-columns: 1fr; }
            .agenda-grid { grid-template-columns: 1fr; }
            .teacher-grid { grid-template-columns: 1fr; }
            .news-grid { grid-template-columns: 1fr; }
            .testi-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .feature-list { grid-template-columns: 1fr; }
            .ekskul-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

    <!-- 1. TOPBAR -->
    <div class="topbar">
        <div class="container">
            <div class="topbar-info">
                <div><i data-feather="phone" style="width: 14px;"></i> {{ $settings['contact_phone'] ?? '(0267) 1234-567' }}</div>
                <div><i data-feather="mail" style="width: 14px;"></i> {{ $settings['contact_email'] ?? 'info@alirsyadkarawang.sch.id' }}</div>
            </div>
            <div>Jam Operasional: {{ $settings['contact_hours'] ?? 'Senin - Jumat (07:00 - 15:30)' }}</div>
        </div>
    </div>

    <!-- 2. NAVBAR -->
    <nav class="navbar" id="mainNavbar">
        <div class="container">
            <a href="/" class="logo">
                <img src="{{ !empty($settings['home_headmaster_image']) ? Storage::url($settings['home_headmaster_image']) : asset('images/logo.png') }}" onerror="this.src='https://via.placeholder.com/50'" alt="Logo">
                <div class="logo-text">
                    <h1>{{ explode(' ', $settings['hero_title'] ?? 'AL IRSYAD')[0] ?? 'AL IRSYAD' }}</h1>
                    <p>SMA ISLAM TELADAN</p>
                </div>
            </a>
            <ul class="nav-menu" id="navMenu">
                @php
                    $navLinks = json_decode($settings['navbar_links'] ?? '[]', true);
                    if (empty($navLinks)) {
                        $navLinks = [
                            ['label' => 'Beranda', 'url' => '/'],
                            ['label' => 'Profil', 'url' => '#'],
                            ['label' => 'Visi Misi', 'url' => '#'],
                            ['label' => 'Akademik', 'url' => '#'],
                            ['label' => 'Berita', 'url' => route('posts.index')]
                        ];
                    }
                @endphp
                @foreach($navLinks as $link)
                    <li><a href="{{ $link['url'] }}" class="nav-link">{{ $link['label'] }}</a></li>
                @endforeach
                <li><a href="{{ $settings['contact_ppdb_link'] ?? '#' }}" class="nav-spmb">SPMB Online</a></li>
            </ul>
            <div class="mobile-toggle" onclick="toggleMenu()">
                <i data-feather="menu"></i>
            </div>
        </div>
    </nav>

    <!-- 3. HERO SECTION -->
    @php
        $bgType = $settings['hero_bg_type'] ?? 'image';
        $bgImage = $settings['hero_bg_image'] ?? 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&q=80&w=1920';
        if ($bgType == 'image') {
            if (Str::startsWith($bgImage, 'http')) {
                $heroBg = "url('".$bgImage."')";
            } else {
                $heroBg = "url('".Storage::url($bgImage)."')";
            }
        } else {
            $heroBg = 'none';
        }
    @endphp
    <div class="hero" style="background-image: {{ $heroBg }}; background-size: cover; background-position: center;">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">{{ $settings['ppdb_title'] ?? 'Penerimaan Murid Baru TA 2025/2026' }}</div>
                <h2>{!! nl2br(e($settings['hero_title'] ?? "SMA Islam Teladan \n Al Irsyad Karawang")) !!}</h2>
                <p>{{ $settings['hero_subtitle'] ?? 'Menjadi Sekolah Islam Teladan Yang Berakhlakul Karimah, Unggul Dalam Prestasi & Berdaya Guna Di Masyarakat.' }}</p>
                <div class="hero-btns">
                    <a href="{{ $settings['hero_btn_link'] ?? '#' }}" class="btn btn-primary">{{ $settings['hero_btn_text'] ?? 'Daftar Sekarang' }} <i data-feather="chevron-right"></i></a>
                    <a href="#" class="btn btn-outline-white">Jelajahi Profil</a>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. PRAYER TIMES -->
    @if(($settings['home_show_prayer'] ?? '1') == '1')
    <div class="prayer-bar">
        <div class="container">
            <div class="prayer-card">
                <div class="prayer-left">
                    <h3>Jadwal Sholat</h3>
                    <div class="next-prayer" id="next-prayer">Memuat...</div>
                    <div class="next-time" id="next-time">--:--</div>
                    <!-- Hidden elements for JS to read settings -->
                    <input type="hidden" id="setting_prayer_lat" value="{{ $settings['prayer_lat'] ?? '-6.3227' }}">
                    <input type="hidden" id="setting_prayer_lon" value="{{ $settings['prayer_lon'] ?? '107.3075' }}">
                </div>
                <div class="prayer-right">
                    <div class="prayer-item" id="prayer-Fajr"><span>Subuh</span><strong>--:--</strong></div>
                    <div class="prayer-item" id="prayer-Dhuhr"><span>Dzuhur</span><strong>--:--</strong></div>
                    <div class="prayer-item" id="prayer-Asr"><span>Ashar</span><strong>--:--</strong></div>
                    <div class="prayer-item" id="prayer-Maghrib"><span>Maghrib</span><strong>--:--</strong></div>
                    <div class="prayer-item" id="prayer-Isha"><span>Isya</span><strong>--:--</strong></div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- 5. STATS -->
    @if(($settings['home_show_stats'] ?? '1') == '1')
    <div class="stats">
        <div class="container">
            <div class="stats-grid">
                @php
                    $stats = json_decode($settings['stats_data'] ?? '[]', true);
                    if (empty($stats)) {
                        $stats = [
                            ['num' => '450+', 'label' => 'Siswa Aktif'],
                            ['num' => '45+', 'label' => 'Tenaga Pendidik'],
                            ['num' => '120+', 'label' => 'Prestasi Diraih'],
                            ['num' => 'A', 'label' => 'Akreditasi'],
                            ['num' => 'AKTIF', 'label' => 'Dapodik']
                        ];
                    }
                @endphp
                @foreach($stats as $stat)
                <div class="stat-card">
                    <div class="stat-number">{{ $stat['num'] }}</div>
                    <div class="stat-label">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- 6. HEADMASTER -->
    @if(($settings['home_show_headmaster'] ?? '1') == '1')
    <section class="welcome-section">
        <div class="container">
            <div class="welcome-grid">
                <div class="welcome-img">
                    <img src="{{ !empty($settings['home_headmaster_image']) ? Storage::url($settings['home_headmaster_image']) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=600' }}" alt="Kepala Sekolah">
                </div>
                <div class="welcome-txt">
                    <div class="section-header" style="text-align: left; margin-bottom: 20px;">
                        <span>Sambutan Resmi</span>
                        <h2>Kepala Sekolah</h2>
                    </div>
                    @if(isset($settings['home_headmaster_welcome']) && !empty($settings['home_headmaster_welcome']))
                        <div class="mb-4">{!! $settings['home_headmaster_welcome'] !!}</div>
                    @else
                        <p>Selamat datang di SMA Islam Teladan Al Irsyad Al Islamiyyah Karawang. Kami berkomitmen untuk menyelenggarakan pendidikan yang memadukan keunggulan akademik dengan penguatan karakter Islami (Akhlakul Karimah).</p>
                    @endif
                    <div class="welcome-name">
                        <h4>{{ $settings['home_headmaster_name'] ?? 'Ustadz Ahmad Fauzi, S.Pd.I' }}</h4>
                        <span>Kepala Sekolah SMA Islam Teladan</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- 7. VISION MISSION -->
    <section class="vision-mission">
        <div class="container">
            <div class="section-header">
                <span>Focus & Future</span>
                <h2 style="color: var(--white);">Visi & Misi Sekolah</h2>
            </div>
            <div class="vision-box">
                <h3>Visi</h3>
                <p>"{{ $settings['school_vision'] ?? 'Menjadi Sekolah Islam Teladan Yang Berakhlakul Karimah, Unggul Dalam Prestasi & Berdaya Guna Di Masyarakat.' }}"</p>
            </div>
            <div class="mission-grid">
                @php
                    $missions = json_decode($settings['school_missions'] ?? '[]', true);
                    if (empty($missions)) {
                        $missions = [
                            ['text' => 'Mewujudkan lingkungan sekolah yang religius.'],
                            ['text' => 'Mengembangkan kurikulum berstandar internasional.'],
                            ['text' => 'Meningkatkan kompetensi literasi dan numerasi.'],
                            ['text' => 'Mencetak lulusan yang hafidz quran minimal 2 juz.']
                        ];
                    }
                    $alpha = range('A', 'Z');
                @endphp
                @foreach($missions as $index => $mission)
                <div class="mission-item">
                    <div class="mission-num">{{ $alpha[$index % 26] }}</div>
                    <p>{{ $mission['text'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 8. PROGRAMS -->
    <section class="programs">
        <div class="container">
            <div class="section-header">
                <span>Education Path</span>
                <h2>Program Unggulan</h2>
            </div>
            <div class="program-grid">
                @php
                    $programs = json_decode($settings['superior_programs'] ?? '[]', true);
                    if (empty($programs)) {
                        $programs = [
                            ['icon' => 'globe', 'title' => 'English Assessment', 'desc' => 'Standarisasi kemampuan bahasa Inggris dengan kurikulum berkualitas.'],
                            ['icon' => 'book', 'title' => 'Kurikulum Khas', 'desc' => 'Kurikulum khusus Al Irsyad menyeimbangkan dunia dan akhirat.'],
                            ['icon' => 'heart', 'title' => 'Tahsin & Tahfidz', 'desc' => 'Program perbaikan bacaan dan hafalan Al-Qur\'an secara intensif.'],
                            ['icon' => 'monitor', 'title' => 'Coding Dev', 'desc' => 'Pelatihan logika pemrograman dasar dan web development.']
                        ];
                    }
                @endphp
                @foreach($programs as $prog)
                <div class="program-card">
                    <div class="program-icon"><i data-feather="{{ $prog['icon'] ?? 'star' }}"></i></div>
                    <h3>{{ $prog['title'] }}</h3>
                    <p>{{ $prog['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 9. AGENDA -->
    @if(($settings['home_show_events'] ?? '1') == '1')
    <section class="agenda">
        <div class="container">
            <div class="section-header" style="display: flex; justify-content: space-between; align-items: flex-end;">
                <div style="text-align: left;">
                    <span>Mark Your Calendar</span>
                    <h2 style="margin-bottom:0;">Agenda Mendatang</h2>
                </div>
                <a href="{{ route('events.index') }}" class="btn btn-outline" style="padding: 8px 20px; font-size: 0.9rem;">Lihat Semua <i data-feather="arrow-right" style="width: 14px;"></i></a>
            </div>
            
            @php $agendaStyle = $settings['agenda_style'] ?? 'grid'; @endphp
            
            <div class="agenda-grid" style="{{ $agendaStyle === 'list' ? 'grid-template-columns: 1fr;' : '' }}">
                @forelse($events as $event)
                <div class="agenda-card">
                    <div class="agenda-date" style="{{ $agendaStyle === 'list' ? 'background: transparent; color: var(--primary); padding: 0; min-width: 60px;' : '' }}">
                        <span class="day" style="{{ $agendaStyle === 'list' ? 'font-size: 2rem;' : '' }}">{{ \Carbon\Carbon::parse($event->start_time)->format('d') }}</span>
                        <span class="month" style="{{ $agendaStyle === 'list' ? 'color: var(--text-muted);' : '' }}">{{ strtoupper(\Carbon\Carbon::parse($event->start_time)->translatedFormat('M Y')) }}</span>
                    </div>
                    <div class="agenda-info">
                        <h4><a href="{{ route('events.show', $event->id) }}">{{ $event->title }}</a></h4>
                        <p><i data-feather="clock" style="width:14px;"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} | <i data-feather="map-pin" style="width:14px;"></i> {{ Str::limit($event->location, 40) }}</p>
                    </div>
                    @if($agendaStyle === 'list')
                    <div class="agenda-link">
                        <a href="{{ route('events.show', $event->id) }}"><i data-feather="chevron-right"></i></a>
                    </div>
                    @endif
                </div>
                @empty
                <div class="agenda-card" style="grid-column: span {{ $agendaStyle === 'list' ? '1' : '2' }}; justify-content: center; background: #fff; text-align: center; flex-direction: column; padding: 40px;">
                    <i data-feather="calendar" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 10px;"></i>
                    <p style="color: var(--text-muted);">Belum ada agenda terdekat.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    <!-- 10. TEACHERS -->
    @if(($settings['home_show_teachers'] ?? '1') == '1')
    <section class="teachers">
        <div class="container">
            <div class="section-header">
                <span>Our Professionals</span>
                <h2>Guru & Tenaga Kependidikan</h2>
            </div>
            <div class="teacher-grid">
                @php
                    $teachers = json_decode($settings['teachers_data'] ?? '[]', true);
                    if (empty($teachers)) {
                        $teachers = [
                            ['name' => 'Ustadz Ahmad', 'role' => 'Kepala Sekolah', 'image' => 'https://via.placeholder.com/300'],
                            ['name' => 'Ustadz Budi', 'role' => 'Guru Quran', 'image' => 'https://via.placeholder.com/300'],
                            ['name' => 'Ustadzah Siti', 'role' => 'Guru Matematika', 'image' => 'https://via.placeholder.com/300'],
                            ['name' => 'Ustadzah Sarah', 'role' => 'Guru Inggris', 'image' => 'https://via.placeholder.com/300']
                        ];
                    }
                @endphp
                @foreach($teachers as $t)
                <div class="teacher-card">
                    <div class="teacher-img">
                        <img src="{{ isset($t['image']) && $t['image'] ? Storage::url($t['image']) : 'https://via.placeholder.com/300' }}" alt="{{ $t['name'] }}" onerror="this.src='https://via.placeholder.com/300'">
                    </div>
                    <div class="teacher-info">
                        <h4>{{ $t['name'] }}</h4>
                        <p>{{ $t['role'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- 11. BANNER -->
    <div class="spmb-banner">
        <div class="container">
            <h2>{{ $settings['ppdb_title'] ?? 'Pendaftaran Gelombang II Telah Dibuka!' }}</h2>
            <p>{{ $settings['ppdb_desc'] ?? 'Raih kesempatan bergabung dengan SMA Islam Teladan Al Irsyad Karawang.' }}</p>
            <a href="{{ $settings['hero_btn_link'] ?? '#' }}" class="btn btn-primary" style="padding: 15px 40px; font-size: 1.1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2);">Daftar Sekarang <i data-feather="arrow-right"></i></a>
        </div>
    </div>

    <!-- 12. NEWS -->
    @if(($settings['home_show_news'] ?? '1') == '1')
    <section class="news bg-light">
        <div class="container">
            <div class="section-header">
                <span>Whats New</span>
                <h2>Berita & Artikel Terkini</h2>
            </div>
            
            @php $newsStyle = $settings['news_style'] ?? 'grid3'; @endphp
            
            <div class="news-grid" style="{{ $newsStyle === 'slider' ? 'display: flex; gap: 1.5rem; overflow-x: auto; padding-bottom: 2rem; scroll-snap-type: x mandatory;' : '' }}">
                @forelse($posts as $post)
                <article class="news-card" style="{{ $newsStyle === 'slider' ? 'min-width: 320px; flex: 0 0 auto; scroll-snap-align: start;' : '' }}">
                    <div class="news-img">
                        <img src="{{ $post->thumbnail ? Storage::url($post->thumbnail) : 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?auto=format&fit=crop&q=80&w=800' }}" alt="{{ $post->title }}">
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span><i data-feather="calendar" style="width:14px;"></i>{{ $post->created_at->format('d M Y') }}</span>
                            <span><i data-feather="tag" style="width:14px;"></i>{{ $post->category->name ?? 'Berita' }}</span>
                        </div>
                        <h3><a href="{{ route('posts.show', $post->slug) }}" style="color: inherit;">{{ Str::limit($post->title, 50) }}</a></h3>
                        <p>{{ Str::limit(strip_tags($post->content), 80) }}</p>
                        <a href="{{ route('posts.show', $post->slug) }}" class="news-link">Selengkapnya <i data-feather="arrow-right" style="width:16px;"></i></a>
                    </div>
                </article>
                @empty
                <div style="grid-column: span 3; text-align: center;"><p>Belum ada berita dipublikasikan.</p></div>
                @endforelse
            </div>
            
            @if($newsStyle === 'slider' && $posts->count() > 0)
                <div style="text-align: center; color: var(--text-muted); font-size: 0.8rem; margin-top: -10px; margin-bottom: 20px;">
                    <i data-feather="arrow-left" style="width: 12px; vertical-align: middle;"></i> Geser untuk melihat lainnya <i data-feather="arrow-right" style="width: 12px; vertical-align: middle;"></i>
                </div>
            @endif
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('posts.index') }}" class="btn btn-outline" style="border-radius: 50px;">Lihat Semua Berita</a>
            </div>
        </div>
    </section>
    @endif

    <!-- 13. TESTIMONIALS -->
    @if(($settings['home_show_testimonials'] ?? '1') == '1')
    <section class="testimonials">
        <div class="container">
            <div class="section-header">
                <span>Testimonials</span>
                <h2 style="color: var(--white);">Apa Kata Mereka?</h2>
            </div>
            <div class="testi-grid">
                @forelse($testimonials as $testi)
                <div class="testi-card">
                    <i data-feather="message-square" class="testi-quote"></i>
                    <div class="testi-img">
                        <img src="{{ $testi->image ? Storage::url($testi->image) : 'https://i.pravatar.cc/100' }}" alt="avatar">
                    </div>
                    <p>"{{ $testi->content }}"</p>
                    <h4>{{ $testi->name }}</h4>
                    <span>{{ $testi->role }}</span>
                </div>
                @empty
                <div class="testi-card" style="grid-column: span 3; text-align: center;">
                    <p>Belum ada testimoni.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    <!-- 14. FACILITIES -->
    @if(($settings['home_show_facilities'] ?? '1') == '1')
    <section class="facilities">
        <div class="container">
            <div class="fac-ekskul-grid">
                <div>
                    <div class="section-header" style="text-align: left; margin-bottom: 30px;">
                        <span>Modern Campus</span>
                        <h2>Fasilitas Sekolah</h2>
                    </div>
                    <ul class="feature-list">
                        @php
                            $facilities = json_decode($settings['facilities_list'] ?? '[]', true);
                            if (empty($facilities)) {
                                $facilities = [
                                    ['name' => 'Masjid Jami Al Irsyad'], ['name' => 'Lab Komputer (iMac)'],
                                    ['name' => 'Perpustakaan Digital'], ['name' => 'Laboratorium IPA'],
                                    ['name' => 'Lapangan Olahraga luas'], ['name' => 'Kelas AC & Smart TV']
                                ];
                            }
                        @endphp
                        @foreach($facilities as $f)
                        <li class="feature-item"><i data-feather="check-circle"></i> {{ $f['name'] }}</li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <div class="section-header" style="text-align: left; margin-bottom: 30px;">
                        <span>Student Activities</span>
                        <h2>Ekstrakurikuler</h2>
                    </div>
                    <div class="ekskul-grid">
                        @php
                            $eskuls = json_decode($settings['extracurriculars_list'] ?? '[]', true);
                            if (empty($eskuls)) {
                                $eskuls = [
                                    ['name' => 'Coding & Dev', 'highlight' => '1'],
                                    ['name' => 'Design Grafis', 'highlight' => '1'],
                                    ['name' => 'Basket', 'highlight' => '0'],
                                    ['name' => 'Pramuka', 'highlight' => '0']
                                ];
                            }
                        @endphp
                        @foreach($eskuls as $e)
                        <div class="ekskul-card {{ (isset($e['highlight']) && $e['highlight'] == '1') ? 'ekskul-special' : '' }}">
                            {{ $e['name'] }}
                            @if(isset($e['highlight']) && $e['highlight'] == '1')
                                <span>Unggulan</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- 15. FOOTER -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-logo">
                    <h3 style="display: flex; align-items: center; gap: 10px;">
                        <img src="{{ !empty($settings['home_headmaster_image']) ? Storage::url($settings['home_headmaster_image']) : asset('images/logo.png') }}" onerror="this.src='https://via.placeholder.com/50'" alt="Logo" style="height: 40px;">
                        {{ explode(' ', $settings['hero_title'] ?? 'AL IRSYAD')[0] }}
                    </h3>
                    <p style="color: #94a3b8; font-size: 0.9rem;">SMA Islam Teladan Al Irsyad merupakan sekolah Islam unggulan di Karawang yang fokus pada pembinaan akhlak, akademik, dan teknologi.</p>
                    <div class="social-links">
                        <a href="{{ $settings['social_facebook'] ?? '#' }}"><i data-feather="facebook"></i></a>
                        <a href="{{ $settings['social_instagram'] ?? '#' }}"><i data-feather="instagram"></i></a>
                        <a href="{{ $settings['social_youtube'] ?? '#' }}"><i data-feather="youtube"></i></a>
                        <a href="{{ $settings['social_twitter'] ?? '#' }}"><i data-feather="twitter"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Tautan Cepat</h4>
                    <ul class="footer-links">
                        <li><a href="/">Beranda</a></li>
                        <li><a href="#">Profil Sekolah</a></li>
                        <li><a href="#">Visi & Misi</a></li>
                        <li><a href="{{ route('posts.index') }}">Berita & Artikel</a></li>
                        <li><a href="#">SPMB Online</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Layanan</h4>
                    <ul class="footer-links">
                        <li><a href="#">SIAKAD Sekolah</a></li>
                        <li><a href="#">E-Learning</a></li>
                        <li><a href="#">Perpustakaan Digital</a></li>
                        <li><a href="#">Galeri Kegiatan</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Hubungi Kami</h4>
                    <ul class="contact-list">
                        <li><i data-feather="map-pin"></i> <span>{{ $settings['contact_address'] ?? 'Jl. Raya Telukjambe, RT.01/RW.01, Sukaluyu, Karawang' }}</span></li>
                        <li><i data-feather="phone"></i> <span>{{ $settings['contact_phone'] ?? '(0267) 1234-567' }}</span></li>
                        <li><i data-feather="mail"></i> <span>{{ $settings['contact_email'] ?? 'info@alirsyadkarawang.sch.id' }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} SMA Islam Teladan Al Irsyad Al Islamiyyah Karawang. All rights reserved.</p>
                <span id="credit-link">Developed by <a href="https://www.murniabadi.co.id" target="_blank" style="color: var(--secondary); font-weight: 700;">MATEK</a></span>
            </div>
        </div>
    </footer>

    <script>
        feather.replace();

        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 50) {
                navbar.classList.add('sticky-active');
            } else {
                navbar.classList.remove('sticky-active');
            }
        });

        function toggleMenu() {
            const menu = document.getElementById('navMenu');
            menu.classList.toggle('active');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const lat = document.getElementById('setting_prayer_lat')?.value || '-6.3227';
            const lon = document.getElementById('setting_prayer_lon')?.value || '107.3075';
            
            function fetchPrayerTimes() {
                const date = new Date();
                fetch("https://api.aladhan.com/v1/timings/" + Math.floor(date.getTime() / 1000) + "?latitude=" + lat + "&longitude=" + lon + "&method=20")
                    .then(r => r.json())
                    .then(data => {
                        if (data.code === 200) {
                            const t = data.data.timings;
                            
                            const pfajr = document.querySelector('#prayer-Fajr strong');
                            if(pfajr) pfajr.innerText = t.Fajr;
                            const pdhuhr = document.querySelector('#prayer-Dhuhr strong');
                            if(pdhuhr) pdhuhr.innerText = t.Dhuhr;
                            const pasr = document.querySelector('#prayer-Asr strong');
                            if(pasr) pasr.innerText = t.Asr;
                            const pmagh = document.querySelector('#prayer-Maghrib strong');
                            if(pmagh) pmagh.innerText = t.Maghrib;
                            const pish = document.querySelector('#prayer-Isha strong');
                            if(pish) pish.innerText = t.Isha;

                            const prayers = [
                                { name: 'Subuh', time: t.Fajr },
                                { name: 'Dzuhur', time: t.Dhuhr },
                                { name: 'Ashar', time: t.Asr },
                                { name: 'Maghrib', time: t.Maghrib },
                                { name: 'Isya', time: t.Isha }
                            ];

                            const now = new Date();
                            const currentMin = now.getHours() * 60 + now.getMinutes();

                            let next = prayers[0];
                            for (let p of prayers) {
                                const [h, m] = p.time.split(':').map(Number);
                                if ((h * 60 + m) > currentMin) {
                                    next = p;
                                    break;
                                }
                            }

                            const np = document.getElementById('next-prayer');
                            if(np) np.innerText = next.name;
                            const nt = document.getElementById('next-time');
                            if(nt) nt.innerText = next.time;
                        }
                    }).catch(e => console.log('Prayer API Error'));
            }
            if(document.getElementById('next-prayer')) fetchPrayerTimes();
        });

        (function() {
            function checkCredit() {
                const credit = document.getElementById('credit-link');
                const link = credit ? credit.querySelector('a') : null;
                if (!credit || !link || link.getAttribute('href') !== 'https://www.murniabadi.co.id' || link.innerText.trim() !== 'MATEK') {
                    document.body.innerHTML = '<div style="background: #000; color: #fff; height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; font-family: sans-serif; padding: 20px;"><div><h1>System Dependency Error</h1><p>This template requires original attribution to function. Please restore the footer credit to MATEK.</p></div></div>';
                }
            }
            setInterval(checkCredit, 3000);
            window.addEventListener('load', checkCredit);
        })();
    </script>
</body>
</html>