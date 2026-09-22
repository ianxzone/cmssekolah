<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="theme-color" content="#065f46">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="{{ asset('pwa-192x192.png') }}">
    <title>{{ $title ?? 'LPP Al Irsyad Al Islamiyyah Karawang - Lajnah Pendidikan & Pengajaran' }}</title>

    @if(\App\Models\Setting::get('seo_google_site_verification'))
    <meta name="google-site-verification" content="{{ \App\Models\Setting::get('seo_google_site_verification') }}" />
    @endif

    @include('partials.analytics')

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
        .logo-emblem {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(10, 77, 60, 0.2);
            flex-shrink: 0;
            border: 2px solid var(--secondary);
        }
        .logo-emblem span {
            font-size: 0.88rem;
            font-weight: 900;
            letter-spacing: 0.5px;
            color: #ffffff;
        }
        .logo-text h1 { font-size: 1.25rem; color: var(--primary-dark); font-weight: 800; line-height: 1; }
        .logo-text p { font-size: 0.75rem; color: var(--primary-light); font-weight: 600; letter-spacing: 1px; margin-bottom: 0; }
        .nav-menu { display: flex; gap: 30px; align-items: center; }
        .nav-link { font-weight: 600; color: var(--text-main); font-size: 0.95rem; }
        .nav-link:hover { color: var(--primary); }
        .nav-spmb { background: var(--primary); color: var(--white) !important; padding: 10px 24px; border-radius: 50px; font-weight: 600;}
        .nav-spmb:hover { background: var(--primary-dark); transform: scale(1.05); }
        .mobile-toggle { display: none; cursor: pointer; color: var(--primary-dark); }
        
        .hero-slider-wrapper { position: relative; overflow: hidden; min-height: 85vh; background-color: var(--primary-dark); margin-top: -1px; }
        .hero-slider { position: relative; width: 100%; min-height: 85vh; }
        .hero-slide { position: absolute; inset: 0; opacity: 0; visibility: hidden; transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), transform 0.8s cubic-bezier(0.4, 0, 0.2, 1); transform: scale(1.03); display: flex; align-items: center; background-size: cover; background-position: center; color: var(--white); padding: 90px 0 100px 0; }
        .hero-slide.active { opacity: 1; visibility: visible; transform: scale(1); z-index: 2; }
        .hero-overlay { position: absolute; inset: 0; background: linear-gradient(105deg, rgba(6,78,59,0.96) 0%, rgba(6,78,59,0.85) 55%, rgba(6,78,59,0.5) 100%); z-index: 1; }
        .hero-slide .container { position: relative; z-index: 2; width: 100%; }
        .hero-content { max-width: 860px; }
        .hero-badge { background: rgba(255,255,255,0.12); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); padding: 8px 22px; border-radius: 50px; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.25); font-weight: 600; font-size: 0.9rem; color: var(--secondary); letter-spacing: 0.5px; }
        .hero-badge .badge-pulse { width: 8px; height: 8px; background-color: var(--secondary); border-radius: 50%; box-shadow: 0 0 0 0 rgba(251, 191, 36, 0.7); animation: heroPulseDot 1.8s infinite; display: inline-block; }
        @keyframes heroPulseDot { 0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(251, 191, 36, 0.7); } 70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(251, 191, 36, 0); } 100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(251, 191, 36, 0); } }
        .hero h2 { font-size: 3.5rem; font-weight: 800; line-height: 1.15; margin-bottom: 18px; text-shadow: 0 2px 10px rgba(0,0,0,0.3); }
        .hero p { font-size: 1.15rem; margin-bottom: 28px; opacity: 0.92; max-width: 750px; line-height: 1.6; }
        .hero-btns { display: flex; flex-wrap: wrap; gap: 14px; margin-bottom: 22px; }
        
        .hero-pills { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 5px; }
        .hero-pill-item { background: rgba(255,255,255,0.1); backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.2); padding: 6px 14px; border-radius: 50px; font-size: 0.85rem; font-weight: 500; color: #f3f4f6; display: flex; align-items: center; gap: 6px; }
        
        /* Hero Slide 1 Split Grid & Visual Card */
        .hero-split-grid { display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 40px; align-items: center; width: 100%; }
        .hero-visual-card { position: relative; display: flex; justify-content: center; align-items: center; }
        .hero-visual-img-wrapper { position: relative; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 45px rgba(0, 0, 0, 0.45); border: 3px solid rgba(255, 255, 255, 0.22); background: rgba(255, 255, 255, 0.06); backdrop-filter: blur(10px); max-width: 440px; width: 100%; aspect-ratio: 1/1; }
        .hero-visual-img-wrapper img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.6s ease; }
        .hero-visual-img-wrapper:hover img { transform: scale(1.04); }
        .hero-float-badge { position: absolute; background: rgba(6, 78, 59, 0.94); backdrop-filter: blur(10px); border: 1px solid rgba(251, 191, 36, 0.45); color: #ffffff; padding: 10px 18px; border-radius: 50px; display: flex; align-items: center; gap: 10px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35); z-index: 3; font-size: 0.85rem; font-weight: 700; white-space: nowrap; }
        .hero-float-badge.top-right { top: -14px; right: -14px; }
        .hero-float-badge.bottom-left { bottom: -14px; left: -14px; }
        .hero-float-badge i { color: var(--secondary); width: 18px; height: 18px; }
        
        /* Hero Clean Subtitle & Action */
        .hero-subtitle { font-size: 1.18rem; margin-bottom: 26px; opacity: 0.95; max-width: 680px; line-height: 1.55; color: #f1f5f9; }
        
        /* Slider Navigation & Dots */
        .hero-nav { position: absolute; top: 50%; transform: translateY(-50%); width: 46px; height: 46px; border-radius: 50%; background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.25); color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; transition: var(--transition); }
        .hero-nav:hover { background: var(--secondary); color: var(--primary-dark); border-color: var(--secondary); transform: translateY(-50%) scale(1.08); }
        .hero-prev { left: 25px; }
        .hero-next { right: 25px; }
        .hero-indicators { position: absolute; bottom: 85px; left: 50%; transform: translateX(-50%); display: flex; gap: 10px; z-index: 10; }
        .hero-dot { width: 32px; height: 6px; border-radius: 3px; background: rgba(255,255,255,0.35); border: none; cursor: pointer; transition: all 0.35s ease; padding: 0; }
        .hero-dot.active { width: 56px; background: var(--secondary); box-shadow: 0 0 10px rgba(251,191,36,0.6); }
        
        @media (max-width: 992px) {
            .hero-split-grid { grid-template-columns: 1fr; }
            .hero-visual-card { display: none; }
            .hero h2 { font-size: 2.8rem; }
        }
        @media (max-width: 768px) {
            .hero-slider-wrapper, .hero-slider { min-height: 78vh; }
            .hero-slide { padding: 60px 0 100px 0; }
            .hero h2 { font-size: 2.15rem; }
            .hero-subtitle { font-size: 0.98rem; margin-bottom: 20px; line-height: 1.5; }
            .hero-nav { display: none; }
            .hero-indicators { bottom: 65px; }
        }

        /* ------------------------------------------------------------
           QUICK ACCESS SECTION
        ------------------------------------------------------------ */
        .quick-access {
            padding: 35px 0 15px;
            background: #ffffff;
            position: relative;
            z-index: 5;
        }
        .quick-access-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }
        .quick-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 20px 18px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: var(--transition);
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
            text-decoration: none;
            color: var(--text-main);
        }
        .quick-card:hover {
            transform: translateY(-4px);
            border-color: var(--secondary);
            box-shadow: 0 10px 20px -5px rgba(6, 95, 70, 0.12);
        }
        .quick-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(6, 95, 70, 0.08);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: var(--transition);
        }
        .quick-card:hover .quick-card-icon {
            background: rgba(251, 191, 36, 0.2);
            color: #d97706;
            transform: scale(1.06);
        }
        .quick-card-text {
            flex-grow: 1;
        }
        .quick-card-text h4 {
            font-size: 1.02rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin: 0 0 3px 0;
            line-height: 1.3;
        }
        .quick-card-text span {
            font-size: 0.8rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 500;
        }
        .quick-card:hover .quick-card-text span {
            color: var(--primary);
        }

        /* ------------------------------------------------------------
           MENGAPA LPP AL IRSYAD? (VALUE PROPOSITION)
        ------------------------------------------------------------ */
        .why-us {
            padding: 70px 0 60px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }
        .why-us-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }
        .why-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 26px 22px;
            display: flex;
            gap: 18px;
            align-items: flex-start;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
        .why-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -6px rgba(6, 95, 70, 0.12);
            border-color: var(--secondary);
        }
        .why-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            background: rgba(6, 95, 70, 0.08);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .why-card:hover .why-icon {
            background: rgba(251, 191, 36, 0.2);
            color: #d97706;
        }
        .why-body h4 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 6px;
        }
        .why-body p {
            font-size: 0.92rem;
            color: #4b5563;
            line-height: 1.6;
            margin: 0 0 10px 0;
        }
        .why-link {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .why-link:hover {
            color: #d97706;
            gap: 8px;
        }

        @media (max-width: 992px) {
            .quick-access-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 680px) {
            .why-us-grid {
                grid-template-columns: 1fr;
            }
            .quick-access-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
            .quick-card {
                padding: 14px 12px;
                gap: 12px;
            }
            .quick-card-icon {
                width: 40px;
                height: 40px;
            }
            .quick-card-text h4 {
                font-size: 0.92rem;
            }
            .quick-card-text span {
                font-size: 0.74rem;
            }
            .why-card {
                padding: 20px 16px;
            }
        }
        
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
        .vision-box { background: rgba(255,255,255,0.05); padding: 40px; border-radius: var(--radius-lg); text-align: center; margin-bottom: 40px; border: 1px solid rgba(255,255,255,0.12); box-shadow: 0 10px 25px rgba(0,0,0,0.15); }
        .vision-box h3 { color: var(--secondary); font-size: 1.5rem; margin-bottom: 15px; text-transform: uppercase; }
        .mission-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; }
        .mission-item { display: flex; gap: 16px; background: rgba(255,255,255,0.04); padding: 20px 22px; border-radius: var(--radius-md); transition: var(--transition); align-items: flex-start; border: 1px solid rgba(255,255,255,0.08); }
        .mission-item:hover { background: rgba(255,255,255,0.09); transform: translateY(-3px); border-color: rgba(251, 191, 36, 0.4); box-shadow: 0 6px 16px rgba(0,0,0,0.2); }
        .mission-num { background: var(--secondary); color: var(--primary-dark); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.95rem; flex-shrink: 0; margin-top: 1px; }
        .mission-item p { color: #f1f5f9; font-size: 0.96rem; line-height: 1.55; margin-bottom: 0; font-weight: 500; }
        @media (max-width: 768px) {
            .mission-grid { grid-template-columns: 1fr; }
        }
        
        .programs { background: var(--bg-light); }
        .program-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; }
        .program-card { background: var(--white); padding: 40px 30px; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); text-align: center; transition: var(--transition); border: 1px solid transparent; }
        .program-card:hover { transform: translateY(-10px); box-shadow: var(--shadow-lg); border-color: var(--primary-light); }
        .program-icon { width: 70px; height: 70px; background: var(--primary-light); color: var(--white); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; }
        .program-card h3 { margin-bottom: 15px; color: var(--primary-dark); font-size: 1.2rem; font-weight: 700;}
        .program-card p { color: var(--text-muted); font-size: 0.9rem; }
        
        .curriculum-showcase { background: linear-gradient(135deg, var(--primary-dark) 0%, #022c22 100%); border-radius: var(--radius-lg); padding: 45px; color: var(--white); margin-bottom: 50px; box-shadow: var(--shadow-lg); border: 1px solid rgba(251, 191, 36, 0.25); position: relative; overflow: hidden; }
        .curriculum-showcase::after { content: ''; position: absolute; top: -60px; right: -60px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(251, 191, 36, 0.15) 0%, rgba(251, 191, 36, 0) 70%); pointer-events: none; }
        .curriculum-showcase-grid { display: grid; grid-template-columns: 1fr 1.35fr; gap: 40px; align-items: center; position: relative; z-index: 1; }
        .curriculum-tag { background: rgba(251, 191, 36, 0.2); color: var(--secondary); border: 1px solid rgba(251, 191, 36, 0.4); padding: 6px 16px; border-radius: 50px; font-size: 0.82rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 15px; }
        .curriculum-showcase h3 { font-size: 2.1rem; font-weight: 800; line-height: 1.25; margin-bottom: 15px; color: var(--white); }
        .curriculum-showcase p { color: #cbd5e1; font-size: 1.02rem; line-height: 1.65; margin-bottom: 22px; }
        .curriculum-pillars { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .curriculum-pillar-item { background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.12); padding: 18px 20px; border-radius: 14px; border-left: 4px solid var(--secondary); transition: var(--transition); }
        .curriculum-pillar-item:hover { background: rgba(255, 255, 255, 0.12); transform: translateY(-3px); border-color: var(--secondary); }
        .curriculum-pillar-item h5 { font-size: 1.02rem; color: var(--secondary); font-weight: 700; margin-bottom: 6px; display: flex; align-items: center; gap: 8px; }
        .curriculum-pillar-item p { font-size: 0.84rem; color: #e2e8f0; margin-bottom: 0; line-height: 1.45; }
        
        @media (max-width: 992px) {
            .curriculum-showcase-grid { grid-template-columns: 1fr; gap: 30px; }
        }
        @media (max-width: 640px) {
            .curriculum-pillars { grid-template-columns: 1fr; }
            .curriculum-showcase { padding: 30px 20px; }
            .curriculum-showcase h3 { font-size: 1.6rem; }
        }
        
        /* ------------------------------------------------------------
           UNIT PENDIDIKAN (PROFESSIONAL EDUCATION SHOWCASE)
        ------------------------------------------------------------ */
        .units-section {
            padding: 90px 0;
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
            position: relative;
        }
        .units-section-header {
            text-align: center;
            max-width: 760px;
            margin: 0 auto 50px;
        }
        .units-section-tag {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(6, 95, 70, 0.08);
            color: var(--primary);
            border: 1px solid rgba(6, 95, 70, 0.2);
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin-bottom: 14px;
        }
        .units-section-header h2 {
            font-size: 2.5rem;
            color: var(--primary-dark);
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 14px;
        }
        .units-section-header p {
            color: #64748b;
            font-size: 1.05rem;
            line-height: 1.6;
            margin: 0;
        }
        .units-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .unit-card-pro {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 18px rgba(15, 23, 42, 0.06);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .unit-card-pro:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 35px -8px rgba(6, 95, 70, 0.18);
            border-color: rgba(6, 95, 70, 0.35);
        }
        .unit-img-wrapper {
            position: relative;
            height: 190px;
            overflow: hidden;
            background-color: #064e3b;
        }
        .unit-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .unit-card-pro:hover .unit-img-wrapper img {
            transform: scale(1.08);
        }
        .unit-img-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0.35) 0%, transparent 45%, rgba(0,0,0,0.65) 100%);
            pointer-events: none;
        }
        .unit-badge-stage {
            position: absolute;
            top: 14px;
            left: 14px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 800;
            padding: 5px 12px;
            border-radius: 6px;
            letter-spacing: 0.5px;
            border: 1px solid rgba(251, 191, 36, 0.4);
            box-shadow: 0 4px 10px rgba(0,0,0,0.25);
            z-index: 2;
        }
        .unit-badge-age {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: rgba(15, 23, 42, 0.82);
            backdrop-filter: blur(4px);
            color: #f8fafc;
            font-size: 0.74rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            z-index: 2;
            border: 1px solid rgba(255,255,255,0.15);
        }
        .unit-body-pro {
            padding: 24px 22px 22px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .unit-info-main {
            margin-bottom: 18px;
        }
        .unit-body-pro h4 {
            font-size: 1.22rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 8px;
            line-height: 1.3;
        }
        .unit-desc-pro {
            font-size: 0.88rem;
            color: #64748b;
            line-height: 1.55;
            margin-bottom: 16px;
        }
        .unit-pills-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 6px;
        }
        .unit-pill-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 4px 9px;
            border-radius: 6px;
            font-size: 0.76rem;
            font-weight: 600;
        }
        .unit-pill-tag i {
            color: #15803d;
        }
        .unit-btn-pro {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 18px;
            border-radius: 12px;
            background: #f1f5f9;
            color: var(--primary-dark);
            font-weight: 700;
            font-size: 0.9rem;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            text-decoration: none;
            margin-top: 14px;
        }
        .unit-card-pro:hover .unit-btn-pro {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 4px 14px rgba(6, 95, 70, 0.3);
        }
        .unit-btn-pro i {
            transition: transform 0.3s ease;
        }
        .unit-card-pro:hover .unit-btn-pro i {
            transform: translateX(4px);
            color: var(--secondary);
        }
        @media (max-width: 1100px) {
            .units-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; }
        }
        @media (max-width: 640px) {
            .units-grid { grid-template-columns: 1fr; gap: 18px; }
            .unit-img-wrapper { height: 175px; }
            .units-section { padding: 60px 0; }
            .units-section-header h2 { font-size: 1.9rem; }
        }
        
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
        
        .teachers { background: #f8fafc; position: relative; }
        .teacher-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
        .teacher-card {
            text-align: center;
            background: var(--white);
            padding: 24px 20px 20px;
            border-radius: var(--radius-lg);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            border: 1px solid #e2e8f0;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        .teacher-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 35px -8px rgba(6, 95, 70, 0.16);
            border-color: rgba(6, 95, 70, 0.3);
        }
        .teacher-img {
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 18px;
            aspect-ratio: 1/1;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            position: relative;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .teacher-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .teacher-card:hover .teacher-img img {
            transform: scale(1.08);
        }
        .teacher-avatar-fallback {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #065f46 0%, #064e3b 60%, #022c22 100%);
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }
        .teacher-avatar-fallback::before {
            content: '';
            position: absolute;
            width: 140%;
            height: 140%;
            background: radial-gradient(circle, rgba(251, 191, 36, 0.18) 0%, transparent 60%);
            top: -20%;
            left: -20%;
            pointer-events: none;
        }
        .teacher-fallback-circle {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 2px solid rgba(251, 191, 36, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
            z-index: 2;
        }
        .teacher-fallback-circle span {
            font-size: 1.85rem;
            font-weight: 800;
            color: #fbbf24;
            letter-spacing: 1px;
            font-family: 'Outfit', sans-serif;
        }
        .teacher-fallback-pattern {
            color: rgba(255, 255, 255, 0.7);
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .teacher-unit-pill {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(6, 78, 59, 0.9);
            backdrop-filter: blur(6px);
            color: #fbbf24;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            padding: 3px 9px;
            border-radius: 50px;
            border: 1px solid rgba(251, 191, 36, 0.35);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            z-index: 3;
        }
        .teacher-info {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }
        .teacher-info h4 {
            color: var(--primary-dark);
            font-size: 1.05rem;
            font-weight: 800;
            margin-bottom: 4px;
            line-height: 1.35;
        }
        .teacher-info .teacher-role {
            color: #047857;
            font-size: 0.84rem;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 6px;
        }
        .teacher-info .teacher-bio {
            color: #64748b;
            font-size: 0.78rem;
            line-height: 1.45;
            margin-top: 4px;
            opacity: 0.9;
        }
        
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
        
        .testimonials { background: var(--primary-dark); color: var(--white); position: relative; overflow: hidden; }
        .testi-carousel-container { position: relative; width: 100%; margin: 0 auto; }
        .testi-slider {
            display: flex;
            gap: 24px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            padding: 10px 4px 20px;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .testi-slider::-webkit-scrollbar { display: none; }
        .testi-card {
            flex: 0 0 calc((100% - 48px) / 3);
            min-width: 300px;
            scroll-snap-align: start;
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(8px);
            padding: 36px 28px 30px;
            border-radius: var(--radius-lg);
            text-align: center;
            position: relative;
            border: 1px solid rgba(255,255,255,0.12);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-sizing: border-box;
        }
        .testi-card:hover {
            transform: translateY(-6px);
            background: rgba(255,255,255,0.09);
            border-color: rgba(251, 191, 36, 0.4);
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        }
        .testi-quote { position: absolute; top: 20px; right: 20px; color: rgba(255,255,255,0.12); width: 44px; height: 44px; }
        .testi-img { width: 75px; height: 75px; border-radius: 50%; overflow: hidden; margin: 0 auto 18px; border: 3px solid var(--secondary); box-shadow: 0 4px 12px rgba(0,0,0,0.25); }
        .testi-img img { width: 100%; height: 100%; object-fit: cover; }
        .testi-card p { font-size: 0.96rem; font-style: italic; margin-bottom: 20px; opacity: 0.92; line-height: 1.6; flex-grow: 1; }
        .testi-card h4 { color: var(--secondary); font-size: 1.12rem; font-weight: 700; margin-bottom: 3px;}
        .testi-card .testi-occupation { color: #ffffff; font-size: 0.82rem; font-weight: 600; margin-bottom: 6px; opacity: 0.95; display: inline-flex; align-items: center; justify-content: center; gap: 5px; }
        .testi-card .testi-occupation i { width: 13px; height: 13px; color: var(--secondary); }
        .testi-card .testi-role { font-size: 0.78rem; opacity: 0.8; text-transform: capitalize; background: rgba(255,255,255,0.12); padding: 2px 12px; border-radius: 20px; display: inline-block; }

        .testi-nav-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            margin-top: 25px;
        }
        .testi-nav-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.25s ease;
        }
        .testi-nav-btn:hover {
            background: var(--secondary);
            color: var(--primary-dark);
            transform: scale(1.08);
            box-shadow: 0 4px 14px rgba(251, 191, 36, 0.4);
        }
        .testi-indicators {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .testi-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            padding: 0;
        }
        .testi-dot.active {
            width: 24px;
            border-radius: 12px;
            background: var(--secondary);
        }

        @media (max-width: 1024px) {
            .testi-card { flex: 0 0 calc((100% - 24px) / 2); }
        }
        @media (max-width: 640px) {
            .testi-card { flex: 0 0 88%; min-width: 260px; padding: 28px 20px 24px; }
        }
        
        /* Facilities & Ekskul Showcase */
        .facilities { background: #f8fafc; padding: 80px 0; border-top: 1px solid #f1f5f9; }
        .facilities-highlight-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .fac-mini-card {
            background: var(--white);
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
        }
        .fac-mini-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 28px rgba(0,0,0,0.08);
            border-color: var(--secondary);
        }
        .fac-mini-media {
            height: 145px;
            position: relative;
            background: #064e3b;
            overflow: hidden;
        }
        .fac-mini-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .fac-mini-card:hover .fac-mini-media img {
            transform: scale(1.08);
        }
        .fac-mini-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(6, 95, 70, 0.9);
            backdrop-filter: blur(6px);
            color: var(--secondary);
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 3px 9px;
            border-radius: 50px;
            border: 1px solid rgba(251, 191, 36, 0.4);
        }
        .fac-mini-body {
            padding: 16px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .fac-mini-body h4 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
            line-height: 1.35;
        }
        .fac-mini-body p {
            font-size: 0.84rem;
            color: #64748b;
            line-height: 1.5;
            margin: 0;
            flex-grow: 1;
        }

        /* 4-Pill Categories */
        .fac-categories-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            background: var(--white);
            padding: 24px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }
        .fac-cat-box {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .fac-cat-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: #ecfdf5;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .fac-cat-info h5 {
            font-size: 0.92rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 3px;
        }
        .fac-cat-info span {
            font-size: 0.8rem;
            color: #64748b;
            line-height: 1.45;
            display: block;
        }

        /* Ekstrakurikuler Carousel */
        .ekskul-section-wrapper {
            margin-top: 60px;
            padding-top: 60px;
            border-top: 1px solid #e2e8f0;
        }
        .ekskul-header-flex {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 25px;
        }
        .ekskul-slider-container {
            position: relative;
            overflow: hidden;
            margin: 0 -6px;
            padding: 8px 6px 18px;
        }
        .ekskul-slider-track {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding-bottom: 6px;
        }
        .ekskul-slider-track::-webkit-scrollbar {
            display: none;
        }
        .ekskul-slider-item {
            flex: 0 0 calc((100% - 80px) / 6);
            min-width: 160px;
            scroll-snap-align: start;
        }
        .ekskul-card-mini {
            background: var(--white);
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 22px 14px;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
            text-decoration: none;
        }
        .ekskul-card-mini:hover {
            transform: translateY(-5px);
            border-color: var(--secondary);
            box-shadow: 0 12px 24px rgba(0,0,0,0.07);
        }
        .ekskul-icon-wrapper {
            width: 52px;
            height: 52px;
            background: #f0fdf4;
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            transition: all 0.3s ease;
        }
        .ekskul-card-mini:hover .ekskul-icon-wrapper {
            background: var(--primary);
            color: var(--white);
            transform: scale(1.1);
        }
        .ekskul-card-mini h4 {
            font-size: 0.94rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
            line-height: 1.3;
        }
        .ekskul-card-mini .ekskul-cat-tag {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #059669;
            background: #ecfdf5;
            padding: 2px 8px;
            border-radius: 20px;
            border: 1px solid #a7f3d0;
        }
        .slider-nav-btns {
            display: flex;
            gap: 8px;
        }
        .slider-nav-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid #cbd5e1;
            background: var(--white);
            color: #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
        }
        .slider-nav-btn:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }
        
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
            .facilities-highlight-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
            .fac-categories-strip { grid-template-columns: repeat(2, 1fr); gap: 14px; }
            .ekskul-slider-item { flex: 0 0 calc((100% - 48px) / 4); min-width: 150px; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .topbar { display: none; }
            .mobile-toggle { display: block; }
            .nav-menu { position: absolute; top: 100%; left: 0; width: 100%; background: var(--white); flex-direction: column; padding: 16px 20px 24px; display: none; box-shadow: 0 15px 30px rgba(0,0,0,0.12); border-top: 1px solid #f1f5f9; }
            .nav-menu.active { display: flex; animation: navSlideDown 0.25s ease-out; }
            @keyframes navSlideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
            .nav-menu li { width: 100%; border-bottom: 1px solid #f8fafc; padding: 10px 0; }
            .nav-menu li:last-child { border-bottom: none; padding-top: 15px; }
            .nav-spmb { display: block; text-align: center; width: 100%; }
            .hero-btns { flex-direction: column; }
            .hero-btns .btn { width: 100%; }
            .hero h2 { font-size: 2.2rem; }
            .prayer-card { grid-template-columns: 1fr; }
            .prayer-left { padding: 20px 15px; }
            .prayer-left .next-prayer { font-size: 2rem; }
            .prayer-right { display: grid; grid-template-columns: repeat(5, 1fr); gap: 6px; padding: 14px 10px; }
            .prayer-item { padding: 6px 2px; }
            .prayer-item span { font-size: 0.68rem; }
            .prayer-item strong { font-size: 0.92rem; }
            .stats-grid { grid-template-columns: 1fr 1fr; gap: 15px; }
            .stat-card:last-child { grid-column: span 2; border-right: none; }
            .welcome-grid { grid-template-columns: 1fr; gap: 30px; }
            .mission-grid { grid-template-columns: 1fr; }
            .program-grid { grid-template-columns: 1fr; }
            .agenda-grid { grid-template-columns: 1fr; }
            .teacher-grid { grid-template-columns: 1fr; }
            .news-grid { grid-template-columns: 1fr; }
            .facilities-highlight-grid { grid-template-columns: 1fr; gap: 16px; }
            .fac-categories-strip { grid-template-columns: 1fr; gap: 12px; padding: 18px 16px; }
            .ekskul-slider-item { flex: 0 0 calc((100% - 16px) / 2); min-width: 140px; }
            .ekskul-header-flex { flex-direction: column; align-items: flex-start; gap: 14px; }
            .ekskul-section-wrapper { margin-top: 40px; padding-top: 40px; }
            .footer-grid { grid-template-columns: 1fr; gap: 30px; }
            section { padding: 50px 0; }
            .section-header { margin-bottom: 30px; }
            .section-header h2 { font-size: 2rem; }
        }

        @media (max-width: 480px) {
            .hero h2 { font-size: 1.85rem; line-height: 1.2; }
            .hero p { font-size: 0.95rem; }
            .hero-badge { font-size: 0.78rem; padding: 6px 14px; }
            .prayer-right { grid-template-columns: repeat(5, 1fr); gap: 4px; padding: 12px 6px; }
            .prayer-item span { font-size: 0.62rem; }
            .prayer-item strong { font-size: 0.85rem; }
            .stat-number { font-size: 1.85rem; }
            .stat-label { font-size: 0.72rem; }
            .curriculum-showcase { padding: 25px 16px; border-radius: 16px; }
            .curriculum-showcase h3 { font-size: 1.45rem; }
            .curriculum-pillar-item { padding: 14px 14px; }
            .curriculum-pillar-item h5 { font-size: 0.92rem; }
            .curriculum-pillar-item p { font-size: 0.78rem; }
            .mobile-fab-whatsapp { bottom: 16px; right: 16px; padding: 10px 16px; font-size: 0.84rem; }
        }

        /* Floating WhatsApp Button for Mobile & Quick Contact */
        .mobile-fab-whatsapp {
            position: fixed;
            bottom: 24px;
            right: 20px;
            z-index: 999;
            background: #25D366;
            color: #ffffff !important;
            border-radius: 50px;
            padding: 12px 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4);
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .mobile-fab-whatsapp:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 12px 28px rgba(37, 211, 102, 0.55);
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
                <div class="logo-emblem">
                    <span>LPP</span>
                </div>
                <div class="logo-text">
                    <h1>LPP AL IRSYAD</h1>
                    <p>LAJNAH PENDIDIKAN & PENGAJARAN</p>
                </div>
            </a>
            <ul class="nav-menu" id="navMenu">
                @php
                    $navLinks = json_decode($settings['navbar_links'] ?? '[]', true);
                    if (empty($navLinks)) {
                        $navLinks = [
                            ['label' => 'Beranda', 'url' => '/'],
                            ['label' => 'Ketua LPP', 'url' => '#welcome'],
                            ['label' => 'Unit Pendidikan', 'url' => '#unit-pendidikan'],
                            ['label' => 'Kurikulum Khas', 'url' => '#kurikulum-khas'],
                            ['label' => 'Fasilitas', 'url' => '#programs'],
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
        $defaultHeroImage = 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&q=80&w=1920';
        $bgImageSetting = trim($settings['hero_bg_image'] ?? '');
        $bgType = $settings['hero_bg_type'] ?? 'image';
        
        if (!empty($bgImageSetting)) {
            if (Str::startsWith($bgImageSetting, 'http')) {
                $heroBg = "url('".$bgImageSetting."')";
            } elseif (file_exists(public_path($bgImageSetting))) {
                $heroBg = "url('".asset($bgImageSetting)."')";
            } else {
                $heroBg = "url('".Storage::url($bgImageSetting)."')";
            }
        } else {
            $heroBg = "url('".$defaultHeroImage."')";
        }
    @endphp
    <div class="hero-slider-wrapper" id="heroSliderWrapper">
        <div class="hero-slider" id="heroSlider">
            <!-- SLIDE 1: Profil Utama & SPMB -->
            <div class="hero-slide active" style="background-image: {{ $heroBg }};">
                <div class="hero-overlay"></div>
                <div class="container">
                    <div class="hero-split-grid">
                        <div class="hero-content">
                            <div class="hero-badge">
                                <span class="badge-pulse"></span>
                                {{ $settings['ppdb_badge'] ?? ($settings['ppdb_title'] ?? 'SPMB TA 2025/2026 - LPP Al Irsyad Karawang') }}
                            </div>
                            <h2>{!! nl2br(e($settings['hero_title'] ?? "Pendidikan Islam Terpadu & Rabbani\nLPP Al Irsyad Al Islamiyyah")) !!}</h2>
                            <p class="hero-subtitle">{{ $settings['hero_subtitle'] ?? 'Membina generasi Rabbani dari usia emas anak (Daycare sejak lahir, Playgroup & TK Montessori) hingga SDIT, SMPIT, dan SMAIT berpadu akidah tauhid dan adab nabawiyah.' }}</p>
                            <div class="hero-btns">
                                <a href="{{ $settings['hero_btn_link'] ?? ($settings['contact_ppdb_link'] ?? '#') }}" class="btn btn-primary">
                                    {{ $settings['hero_btn_text'] ?? 'Daftar SPMB Online' }} <i data-feather="chevron-right"></i>
                                </a>
                            </div>
                            <div class="hero-pills">
                                <span class="hero-pill-item"><i data-feather="award" style="width:14px; height:14px; color:var(--secondary);"></i> Akreditasi A Unggul</span>
                                <span class="hero-pill-item"><i data-feather="book-open" style="width:14px; height:14px; color:var(--secondary);"></i> Tahfidz Bersanad</span>
                                <span class="hero-pill-item"><i data-feather="globe" style="width:14px; height:14px; color:var(--secondary);"></i> Kelas Internasional ICP</span>
                            </div>
                        </div>

                        <!-- Featured Visual Card -->
                        <div class="hero-visual-card">
                            <div class="hero-float-badge top-right">
                                <i data-feather="award"></i>
                                <span>Akreditasi A (Unggul)</span>
                            </div>
                            <div class="hero-visual-img-wrapper">
                                <img src="{{ asset('images/hero-students.png') }}" alt="Santri & Siswa LPP Al Irsyad Karawang" onerror="this.src='https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&q=80&w=800'">
                            </div>
                            <div class="hero-float-badge bottom-left">
                                <i data-feather="check-circle"></i>
                                <span>SPMB Dibuka</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SLIDE 2: Kurikulum Internasional Pearson (UK) -->
            <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=1920');">
                <div class="hero-overlay"></div>
                <div class="container">
                    <div class="hero-content">
                        <div class="hero-badge">
                            <span class="badge-pulse"></span>
                            {{ $settings['pearson_slide_badge'] ?? 'OFFICIAL PEARSON EDEXCEL PARTNER' }}
                        </div>
                        <h2>{{ $settings['pearson_slide_title'] ?? 'Kurikulum Internasional Pearson (UK)' }}</h2>
                        <p class="hero-subtitle">International Class Program (ICP) berstandar global Pearson Edexcel UK, memadukan sains internasional dengan adab tauhid Rabbani.</p>
                        <div class="hero-btns">
                            <a href="{{ route('pearson.index') }}" class="btn btn-primary">
                                Pelajari Pearson ICP <i data-feather="arrow-right"></i>
                            </a>
                        </div>
                        <div class="hero-pills">
                            <span class="hero-pill-item"><i data-feather="check" style="width:14px; height:14px; color:var(--secondary);"></i> Pearson Edexcel UK</span>
                            <span class="hero-pill-item"><i data-feather="check" style="width:14px; height:14px; color:var(--secondary);"></i> Active English Immersion</span>
                            <span class="hero-pill-item"><i data-feather="check" style="width:14px; height:14px; color:var(--secondary);"></i> Global Qualifications</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SLIDE 3: Kurikulum Khas & Keunggulan Akademik -->
            <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&q=80&w=1920');">
                <div class="hero-overlay"></div>
                <div class="container">
                    <div class="hero-content">
                        <div class="hero-badge">
                            <span class="badge-pulse"></span>
                            KURIKULUM KHAS TERPADU AL IRSYAD
                        </div>
                        <h2>Integrasi Nilai Qur'ani, Sains & Adab Nabawiyah</h2>
                        <p class="hero-subtitle">Memadukan Kurikulum Merdeka Nasional dengan bimbingan tahfidz bersanad, pembiasaan adab harian, dan bilingual habit aktif.</p>
                        <div class="hero-btns">
                            <a href="{{ route('kurikulum.index') }}" class="btn btn-primary">
                                Pelajari Kurikulum Khas <i data-feather="arrow-right"></i>
                            </a>
                        </div>
                        <div class="hero-pills">
                            <span class="hero-pill-item"><i data-feather="book-open" style="width:14px; height:14px; color:var(--secondary);"></i> Tahfidz Bersanad</span>
                            <span class="hero-pill-item"><i data-feather="heart" style="width:14px; height:14px; color:var(--secondary);"></i> Bina Pribadi Islami</span>
                            <span class="hero-pill-item"><i data-feather="code" style="width:14px; height:14px; color:var(--secondary);"></i> STEAM & Coding</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SLIDE 4: Fasilitas Unggulan Sekolah -->
            <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&q=80&w=1920');">
                <div class="hero-overlay"></div>
                <div class="container">
                    <div class="hero-content">
                        <div class="hero-badge">
                            <span class="badge-pulse"></span>
                            SARANA & PRASARANA MODERN
                        </div>
                        <h2>Fasilitas Lengkap & Lingkungan Belajar Representatif</h2>
                        <p class="hero-subtitle">Menghadirkan lingkungan belajar yang aman, nyaman, dan berteknologi tinggi untuk memaksimalkan potensi nalar dan ibadah santri.</p>
                        <div class="hero-btns">
                            <a href="{{ route('fasilitas.index') }}" class="btn btn-primary">
                                Lihat Seluruh Fasilitas <i data-feather="arrow-right"></i>
                            </a>
                        </div>
                        <div class="hero-pills">
                            <span class="hero-pill-item"><i data-feather="airplay" style="width:14px; height:14px; color:var(--secondary);"></i> Smart Classroom AC</span>
                            <span class="hero-pill-item"><i data-feather="cpu" style="width:14px; height:14px; color:var(--secondary);"></i> Lab Sains & Komputer</span>
                            <span class="hero-pill-item"><i data-feather="sun" style="width:14px; height:14px; color:var(--secondary);"></i> Masjid Luas & Representatif</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SLIDE 5: Kepercayaan Stakeholder & Tokoh Karawang -->
            <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=1920');">
                <div class="hero-overlay"></div>
                <div class="container">
                    <div class="hero-content">
                        <div class="hero-badge">
                            <span class="badge-pulse"></span>
                            KEPERCAYAAN STAKEHOLDER KARAWANG
                        </div>
                        <h2>Pilihan Utama Tokoh, Pejabat & Profesional Karawang</h2>
                        <p class="hero-subtitle">Amanah kehormatan dipercaya oleh kalangan pejabat pemda, dokter spesialis, akademisi, dan profesional industri di Karawang.</p>
                        <div class="hero-btns">
                            <a href="#testimonials" class="btn btn-primary">
                                Lihat Testimoni Tokoh <i data-feather="message-square"></i>
                            </a>
                        </div>
                        <div class="hero-pills">
                            <span class="hero-pill-item"><i data-feather="users" style="width:14px; height:14px; color:var(--secondary);"></i> Pejabat Pemda & ASN</span>
                            <span class="hero-pill-item"><i data-feather="activity" style="width:14px; height:14px; color:var(--secondary);"></i> Dokter & Tenaga Medis</span>
                            <span class="hero-pill-item"><i data-feather="briefcase" style="width:14px; height:14px; color:var(--secondary);"></i> Profesional Industri & BUMN</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slider Navigation Arrows -->
        <button class="hero-nav hero-prev" id="heroPrevBtn" aria-label="Slide Sebelumnya">
            <i data-feather="chevron-left"></i>
        </button>
        <button class="hero-nav hero-next" id="heroNextBtn" aria-label="Slide Berikutnya">
            <i data-feather="chevron-right"></i>
        </button>

        <!-- Slider Indicators -->
        <div class="hero-indicators" id="heroIndicators">
            <button class="hero-dot active" data-slide="0" aria-label="Slide 1: Profil & PPDB"></button>
            <button class="hero-dot" data-slide="1" aria-label="Slide 2: Kurikulum Internasional Pearson"></button>
            <button class="hero-dot" data-slide="2" aria-label="Slide 3: Kurikulum Khas"></button>
            <button class="hero-dot" data-slide="3" aria-label="Slide 4: Fasilitas Unggulan"></button>
            <button class="hero-dot" data-slide="4" aria-label="Slide 5: Kepercayaan Stakeholder"></button>
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

    <!-- QUICK ACCESS NAVIGATION -->
    <section class="quick-access">
        <div class="container">
            <div class="quick-access-grid">
                <a href="{{ route('kurikulum.index') }}" class="quick-card">
                    <div class="quick-card-icon">
                        <i data-feather="book-open" style="width: 22px; height: 22px;"></i>
                    </div>
                    <div class="quick-card-text">
                        <h4>Kurikulum Khas</h4>
                        <span>Pelajari Pilar <i data-feather="chevron-right" style="width: 13px; height: 13px;"></i></span>
                    </div>
                </a>

                <a href="{{ route('fasilitas.index') }}" class="quick-card">
                    <div class="quick-card-icon">
                        <i data-feather="home" style="width: 22px; height: 22px;"></i>
                    </div>
                    <div class="quick-card-text">
                        <h4>Fasilitas Sekolah</h4>
                        <span>Lihat Sarana <i data-feather="chevron-right" style="width: 13px; height: 13px;"></i></span>
                    </div>
                </a>

                <a href="#unit-pendidikan" class="quick-card">
                    <div class="quick-card-icon">
                        <i data-feather="layers" style="width: 22px; height: 22px;"></i>
                    </div>
                    <div class="quick-card-text">
                        <h4>Unit Pendidikan</h4>
                        <span>TK hingga SMA <i data-feather="chevron-right" style="width: 13px; height: 13px;"></i></span>
                    </div>
                </a>

                <a href="{{ route('pearson.index') }}" class="quick-card">
                    <div class="quick-card-icon">
                        <i data-feather="globe" style="width: 22px; height: 22px;"></i>
                    </div>
                    <div class="quick-card-text">
                        <h4>Pearson ICP</h4>
                        <span>Kelas Global <i data-feather="chevron-right" style="width: 13px; height: 13px;"></i></span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- 5. STATS -->
    @if(($settings['home_show_stats'] ?? '1') == '1')
    <div class="stats">
        <div class="container">
            <div class="stats-grid">
                @php
                    $stats = json_decode($settings['stats_data'] ?? '[]', true);
                    if (empty($stats)) {
                        $stats = [
                            ['num' => '4', 'label' => 'Unit Pendidikan (TK-SMA)'],
                            ['num' => '1.500+', 'label' => 'Santri & Siswa Aktif'],
                            ['num' => '120+', 'label' => 'Asatidz & Pendidik'],
                            ['num' => 'A', 'label' => 'Akreditasi Unggul'],
                            ['num' => '300+', 'label' => 'Prestasi & Penghargaan']
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

    <!-- VALUE PROPOSITION: MENGAPA LPP AL IRSYAD? -->
    <section class="why-us">
        <div class="container">
            <div class="section-header" style="text-align: center; margin-bottom: 40px;">
                <span style="color: var(--primary-light); text-transform: uppercase; font-weight: 700; letter-spacing: 2px; font-size: 0.85rem; display: block; margin-bottom: 8px;">Keunggulan Lembaga</span>
                <h2 style="font-size: 2.3rem; color: var(--primary-dark); font-weight: 800;">Mengapa Memilih LPP Al Irsyad?</h2>
                <p style="color: var(--text-muted); max-width: 680px; margin: 8px auto 0; font-size: 1rem;">
                    Dedikasi puluhan tahun menyelenggarakan ekosistem pendidikan Islam terpadu yang kokoh dalam akidah tauhid dan unggul dalam prestasi dunia.
                </p>
            </div>

            <div class="why-us-grid">
                <div class="why-card">
                    <div class="why-icon">
                        <i data-feather="award" style="width: 24px; height: 24px;"></i>
                    </div>
                    <div class="why-body">
                        <h4>Akreditasi A (Unggul) & Standar Mutu</h4>
                        <p>Seluruh unit pendidikan binaan LPP Al Irsyad telah meraih predikat Akreditasi A (Unggul) dengan tata kelola profesional dan asatidz tersertifikasi.</p>
                        <a href="#unit-pendidikan" class="why-link">Lihat Unit Pendidikan <i data-feather="arrow-right" style="width: 14px;"></i></a>
                    </div>
                </div>

                <div class="why-card">
                    <div class="why-icon">
                        <i data-feather="book-open" style="width: 24px; height: 24px;"></i>
                    </div>
                    <div class="why-body">
                        <h4>Tahfidz Al-Qur'an Bersanad Mutqin</h4>
                        <p>Metode talaqqi intensif bersama asatidz pemegang sanad resmi, ujian munaqosyah berjenjang, dan pembiasaan adab nabawiyah sehari-hari.</p>
                        <a href="{{ route('kurikulum.index') }}" class="why-link">Pelajari Kurikulum Khas <i data-feather="arrow-right" style="width: 14px;"></i></a>
                    </div>
                </div>

                <div class="why-card">
                    <div class="why-icon">
                        <i data-feather="globe" style="width: 24px; height: 24px;"></i>
                    </div>
                    <div class="why-body">
                        <h4>Kelas Internasional Pearson Edexcel (UK)</h4>
                        <p>Membuka International Class Program (ICP) dengan kualifikasi internasional Pearson UK, English immersion, dan peluang kuliah dunia.</p>
                        <a href="{{ route('pearson.index') }}" class="why-link">Info Kelas Internasional <i data-feather="arrow-right" style="width: 14px;"></i></a>
                    </div>
                </div>

                <div class="why-card">
                    <div class="why-icon">
                        <i data-feather="users" style="width: 24px; height: 24px;"></i>
                    </div>
                    <div class="why-body">
                        <h4>Pilihan Tokoh & Profesional Karawang</h4>
                        <p>Dipercaya oleh para pimpinan kedinasan daerah, aparatur negara, dokter spesialis, dan kalangan pimpinan industri di Karawang.</p>
                        <a href="#testimonials" class="why-link">Lihat Testimoni Tokoh <i data-feather="arrow-right" style="width: 14px;"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. KETUA LPP -->
    @if(($settings['home_show_headmaster'] ?? '1') == '1')
    <section class="welcome-section" id="welcome">
        <div class="container">
            <div class="welcome-grid">
                <div class="welcome-img">
                    <img src="{{ !empty($settings['home_headmaster_image']) ? Storage::url($settings['home_headmaster_image']) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=600' }}" alt="Ketua LPP Al Irsyad Karawang">
                </div>
                <div class="welcome-txt">
                    <div class="section-header" style="text-align: left; margin-bottom: 20px;">
                        <span>Sambutan Pimpinan Lembaga</span>
                        <h2>Ketua LPP Al Irsyad</h2>
                    </div>
                    @if(isset($settings['home_headmaster_welcome']) && !empty($settings['home_headmaster_welcome']))
                        <div class="mb-4">{!! $settings['home_headmaster_welcome'] !!}</div>
                    @else
                        <p><em>Bismillahirrohmanirrohim. Assalamu'alaikum Warahmatullahi Wabarakatuh.</em></p>
                        <p>Segala puji bagi Allah Subhanahu wa Ta'ala, Rabb semesta alam. Shalawat dan salam senantiasa tercurah kepada Baginda Rasulullah Muhammad ﷺ, keluarga, sahabat, dan umatnya hingga akhir zaman.</p>
                        <p>Selamat datang di portal resmi <strong>LPP (Lajnah Pendidikan dan Pengajaran) Al Irsyad Al Islamiyyah Karawang</strong>. Sebagai lembaga pengelola dan pembina seluruh satuan unit pendidikan Al Irsyad di Kabupaten Karawang—mulai dari layanan usia dini (Daycare sejak bayi lahir, Playgroup, TK Montessori), SDIT, SMPIT, hingga SMAIT—kami memegang amanah luhur untuk mencetak generasi Rabbani yang kokoh dalam akidah tauhid, beradab mulia (Akhlakul Karimah), unggul dalam sains teknologi, serta berdaya saing global.</p>
                        <p>Melalui kurikulum khas terpadu, pembinaan Tahfidz Al-Qur'an bersanad, penguasaan dwi-bahasa (Arab & Inggris), serta didukung oleh asatidz dan fasilitas modern terintegrasi, LPP Al Irsyad Karawang terus berikhtiar memberikan ekosistem pendidikan terbaik bagi keluarga muslim di Karawang dan sekitarnya.</p>
                    @endif
                    <div class="welcome-name">
                        <h4>{{ !empty($settings['home_headmaster_name']) ? $settings['home_headmaster_name'] : 'Ketua LPP Al Irsyad Karawang' }}</h4>
                        <span>Ketua Lajnah Pendidikan & Pengajaran (LPP) Al Irsyad Al Islamiyyah Karawang</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- 7. VISION MISSION -->
    <section class="vision-mission" id="visi-misi">
        <div class="container">
            <div class="section-header" style="margin-bottom: 40px;">
                <span style="color: var(--secondary); font-size: 1rem; letter-spacing: 2px; font-weight: 700;">Terdepan Dalam Akhlak & Prestasi</span>
                <h2 style="color: var(--white); font-size: 2.5rem; margin-top: 5px;">Visi dan Misi</h2>
            </div>
            <div class="vision-box">
                <h3 style="color: var(--secondary); font-size: 1.5rem; font-weight: 800; letter-spacing: 2px; margin-bottom: 15px;">VISI</h3>
                <p style="font-size: 1.25rem; font-weight: 600; line-height: 1.6; max-width: 900px; margin: 0 auto; color: #ffffff;">
                    "{{ $settings['school_vision'] ?? 'Menjadi Lembaga Dakwah Pendidikan Terdepan Dalam Akhlak & Prestasi Serta Menjadi Teladan Bagi Lembaga Lain' }}"
                </p>
            </div>

            <div style="text-align: center; margin-bottom: 25px;">
                <h3 style="color: var(--secondary); font-size: 1.5rem; font-weight: 800; letter-spacing: 2px;">MISI</h3>
            </div>

            <div class="mission-grid">
                @php
                    $missions = json_decode($settings['school_missions'] ?? '[]', true);
                    if (empty($missions)) {
                        $missions = [
                            ['text' => 'Menjalankan pendidikan terbaik dalam Akhlak, Al quran, Bahasa Arab dan Bahasa Inggris'],
                            ['text' => 'Menciptakan lingkungan yang mendukung LPP, guru dan siswa untuk berprestasi ditingkat Nasional maupun Internasional'],
                            ['text' => 'Memiliki lembaga training yang mensupport pendidikan di internal maupun eksternal'],
                            ['text' => 'Meningkatkan kualifikasi dan kompetensi SDM dan memiliki karakter da\'i dibidang pendidikan'],
                            ['text' => 'Meningkatkan system pendidikan hingga bertaraf Internasional'],
                            ['text' => 'Melakukan pengembangan lembaga untuk meningkatkan layanan pendidikan kepada masyarakat luas'],
                            ['text' => 'Menyiapkan sarana prasarana pendidikan yang memadai'],
                            ['text' => 'Layak menjadi teladan bagi lembaga lain']
                        ];
                    }
                @endphp
                @foreach($missions as $index => $mission)
                <div class="mission-item">
                    <div class="mission-num">{{ $index + 1 }}</div>
                    <p>{{ $mission['text'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- UNIT PENDIDIKAN LPP AL IRSYAD -->
    @if(($settings['home_show_units'] ?? '1') == '1')
    <section class="units-section" id="unit-pendidikan">
        <div class="container">
            <div class="units-section-header">
                <span class="units-section-tag">
                    <i data-feather="layers" style="width:14px; height:14px;"></i> {{ $settings['units_section_tag'] ?? 'JENJANG PENDIDIKAN TERPADU' }}
                </span>
                <h2>{{ $settings['units_section_title'] ?? 'Unit Pendidikan LPP Al Irsyad' }}</h2>
                <p>
                    {{ $settings['units_section_desc'] ?? 'LPP Al Irsyad Al Islamiyyah Karawang menyelenggarakan pendidikan berjenjang dan berkelanjutan dalam satu atap: mulai dari layanan usia emas anak (Daycare sejak bayi lahir, Playgroup, dan TK Islam Montessori) hingga kematangan akademik tingkat menengah atas.' }}
                </p>
            </div>

            <div class="units-grid">
                @php
                    $units = json_decode($settings['units_data'] ?? '[]', true);
                    if (empty($units)) {
                        $units = [
                            [
                                'badge' => 'DAYCARE, KB & TK',
                                'age' => 'Usia 0 - 6 Thn (Sejak Lahir)',
                                'title' => 'Daycare, Playgroup & TK Islam Al Irsyad',
                                'desc' => 'Layanan terpadu pengasuhan & pendidikan usia emas anak dalam 1 unit: Daycare sejak bayi (newborn/brojol), Playgroup, dan TK Islam berbasis metode Montessori Islami, stimulasi sensori motorik, serta adab nabawiyah sejak dini.',
                                'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&q=80&w=600',
                                'pills' => 'Daycare Sejak Bayi, Metode Montessori, Playgroup & TK, Tahfidz Balita',
                                'spmb_link' => ''
                            ],
                            [
                                'badge' => 'SEKOLAH DASAR',
                                'age' => 'Kelas 1 - 6 SD',
                                'title' => 'SDIT Al Irsyad 01 & 02',
                                'desc' => 'Sekolah Dasar Islam Terpadu berakreditasi A (Unggul), mengintegrasikan kurikulum nasional, tahfidz intensif, dan pembelajaran sains aplikatif.',
                                'image' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&q=80&w=600',
                                'pills' => 'Akreditasi A Unggul, Tahfidz 2-3 Juz, Kelas Internasional (ICP)',
                                'spmb_link' => ''
                            ],
                            [
                                'badge' => 'MENENGAH PERTAMA',
                                'age' => 'Kelas 7 - 9 SMP',
                                'title' => 'SMPIT Al Irsyad Karawang',
                                'desc' => 'Pembinaan karakter pemuda Rabbani melalui program Bina Pribadi Islami (BPI), bilingual habit aktif, bimbingan tahfidz, dan eksplorasi STEAM.',
                                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&q=80&w=600',
                                'pills' => 'Bina Pribadi Islami, Bilingual Arab & Inggris, Kelas Internasional (ICP)',
                                'spmb_link' => ''
                            ],
                            [
                                'badge' => 'MENENGAH ATAS',
                                'age' => 'Kelas 10 - 12 SMA',
                                'title' => 'SMAIT Al Irsyad Karawang',
                                'desc' => 'Mencetak kader pemimpin dan da\'i berprestasi tinggi yang siap menembus PTN favorit, kedinasan, kampus Timur Tengah, maupun perguruan tinggi dunia.',
                                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=600',
                                'pills' => 'Lulusan PTN & Kedinasan, Sanad Tahfidz Lanjutan, Riset & Kelas Internasional',
                                'spmb_link' => ''
                            ]
                        ];
                    }
                @endphp

                @foreach($units as $unit)
                    @php
                        $unitLink = !empty($unit['spmb_link']) ? $unit['spmb_link'] : ($settings['contact_ppdb_link'] ?? '#');
                        $unitImage = !empty($unit['image']) ? $unit['image'] : 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&q=80&w=600';
                        $pillList = [];
                        if (!empty($unit['pills'])) {
                            $pillList = is_array($unit['pills']) ? $unit['pills'] : array_filter(array_map('trim', explode(',', $unit['pills'])));
                        }
                    @endphp
                    <div class="unit-card-pro">
                        <div class="unit-img-wrapper">
                            <img src="{{ $unitImage }}" alt="{{ $unit['title'] ?? 'Unit Pendidikan' }}" onerror="this.src='https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&q=80&w=600'">
                            <div class="unit-img-overlay"></div>
                            @if(!empty($unit['badge']))
                                <span class="unit-badge-stage">{{ $unit['badge'] }}</span>
                            @endif
                            @if(!empty($unit['age']))
                                <span class="unit-badge-age"><i data-feather="clock" style="width:12px; height:12px;"></i> {{ $unit['age'] }}</span>
                            @endif
                        </div>
                        <div class="unit-body-pro">
                            <div class="unit-info-main">
                                <h4>{{ $unit['title'] ?? '' }}</h4>
                                <p class="unit-desc-pro">
                                    {{ $unit['desc'] ?? '' }}
                                </p>
                                @if(!empty($pillList))
                                    <div class="unit-pills-wrap">
                                        @foreach($pillList as $pill)
                                            <span class="unit-pill-tag"><i data-feather="check" style="width:12px; height:12px;"></i> {{ $pill }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <a href="{{ $unitLink }}" class="unit-btn-pro">
                                <span>Daftar SPMB {{ $unit['title'] ?? '' }}</span>
                                <i data-feather="arrow-right" style="width:16px; height:16px;"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- 8. PROGRAMS & KURIKULUM KHAS -->
    @if(($settings['home_show_curriculum'] ?? '1') == '1')
    <section class="programs" id="kurikulum-khas">
        <div class="container">
            <div class="section-header">
                <span>Distinctive Curriculum & Programs</span>
                <h2>Kurikulum Khas & Program Unggulan</h2>
                <p style="color: var(--text-muted); max-width: 720px; margin: 10px auto 0; font-size: 1.05rem;">
                    Perpaduan harmonis antara kurikulum nasional, penguatan karakter Islami berakar adab Qur'ani, dan kompetensi global untuk mencetak calon pemimpin masa depan.
                </p>
            </div>

            <!-- Showcase Kurikulum Khas Al Irsyad -->
            <div class="curriculum-showcase">
                <div class="curriculum-showcase-grid">
                    <div>
                        <span class="curriculum-tag"><i data-feather="award" style="width:14px; height:14px;"></i> {{ $settings['curriculum_tag'] ?? 'KURIKULUM KHAS TERPADU' }}</span>
                        <h3>{{ $settings['curriculum_headline'] ?? 'Fondasi Adab Qur\'ani & Keunggulan Intelektual' }}</h3>
                        <p>
                            {{ $settings['curriculum_desc'] ?? 'Kurikulum Khas dirancang secara komprehensif untuk memastikan setiap peserta didik menguasai capaian akademik Kurikulum Merdeka Nasional sekaligus memiliki hafalan Al-Qur\'an bersanad, kemampuan bilingual aktif (Arab & Inggris), serta adab luhur sesuai teladan Rasulullah ﷺ.' }}
                        </p>
                        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                            <a href="{{ $settings['contact_ppdb_link'] ?? '#' }}" class="btn btn-primary" style="padding: 10px 22px; font-size: 0.95rem;">
                                Daftar SPMB Sekarang <i data-feather="arrow-right" style="width:16px;"></i>
                            </a>
                            @php
                                $contactWA = preg_replace('/[^0-9]/', '', $settings['ppdb_wa_number'] ?? ($settings['whatsapp_number'] ?? ($settings['contact_phone'] ?? '6281234567890')));
                            @endphp
                            <a href="https://wa.me/{{ $contactWA }}?text=Halo%20Admin%20Sekolah,%20saya%20ingin%20tanya%20detail%20mengenai%20Kurikulum%20Khas%20Sekolah." target="_blank" class="btn btn-outline-white" style="padding: 10px 22px; font-size: 0.95rem;">
                                <i data-feather="message-circle" style="width:16px;"></i> Konsultasi Kurikulum
                            </a>
                        </div>
                    </div>

                    @php
                        $pillars = json_decode($settings['curriculum_pillars'] ?? '[]', true);
                        if (empty($pillars)) {
                            $pillars = [
                                ['icon' => 'book-open', 'title' => '1. Tahfidz & Tahsin Bersanad', 'desc' => 'Bimbingan talaqqi intensif, munaqosyah bersanad, tasmi\' berkala, dan sertifikasi tahfidz mutqin.'],
                                ['icon' => 'heart', 'title' => '2. Bina Pribadi Islami (BPI)', 'desc' => 'Pembiasaan adab nabawiyah, sholat fardhu & dhuha berjamaah, dzikir matsurat, serta adab birrul walidain.'],
                                ['icon' => 'globe', 'title' => '3. Pearson Curriculum & Bilingual', 'desc' => 'Adopsi kurikulum internasional Pearson (UK), daily immersion bahasa Inggris & Arab, dan persiapan kualifikasi global.'],
                                ['icon' => 'cpu', 'title' => '4. STEAM & Coding Literacy', 'desc' => 'Eksperimen sains aplikatif, nalar berpikir komputasi, robotic dasar, dan literasi teknologi era digital.']
                            ];
                        }
                    @endphp

                    <div class="curriculum-pillars">
                        @foreach($pillars as $p)
                        <div class="curriculum-pillar-item">
                            <h5><i data-feather="{{ $p['icon'] ?? 'star' }}" style="width:18px; height:18px;"></i> {{ $p['title'] ?? '' }}</h5>
                            <p>{{ $p['desc'] ?? '' }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 25px; text-align: left;">
                <h3 style="font-size: 1.4rem; color: var(--primary-dark); font-weight: 800;">Fokus Pengembangan & Program Unggulan</h3>
            </div>
            <div class="program-grid">
                @php
                    $programs = json_decode($settings['superior_programs'] ?? '[]', true);
                    if (empty($programs)) {
                        $programs = [
                            ['icon' => 'globe', 'title' => 'Pearson International Curriculum', 'desc' => 'Kurikulum internasional Pearson (UK) untuk penguasaan bahasa Inggris, matematika, dan sains global.'],
                            ['icon' => 'book', 'title' => 'Kurikulum Khas Al Irsyad', 'desc' => 'Kurikulum khusus Al Irsyad menyeimbangkan dunia dan akhirat berakar adab Qur\'ani.'],
                            ['icon' => 'heart', 'title' => 'Tahsin & Tahfidz Bersanad', 'desc' => 'Program perbaikan bacaan dan hafalan Al-Qur\'an secara intensif hingga bersanad mutqin.'],
                            ['icon' => 'monitor', 'title' => 'STEAM & Coding Dev', 'desc' => 'Pelatihan logika pemrograman dasar, eksperimen sains, dan robotika.']
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
    @endif

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
    <section class="teachers" id="pimpinan">
        <div class="container">
            <div class="section-header">
                <span>Our Leadership & Educators</span>
                <h2>Pimpinan & Tenaga Pendidik Lembaga</h2>
            </div>
            @php
                if (!isset($teachers) || (is_object($teachers) && method_exists($teachers, 'isEmpty') && $teachers->isEmpty())) {
                    $teachers = \App\Models\Teacher::where('is_active', true)->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
                }
            @endphp
            <div class="teacher-grid">
                @forelse($teachers as $t)
                    @php
                        $tName = is_object($t) ? $t->name : ($t['name'] ?? '');
                        $tRole = is_object($t) ? $t->role : ($t['role'] ?? '');
                        $tUnit = is_object($t) ? ($t->unit ?? 'LPP') : ($t['unit'] ?? 'LPP');
                        $tBio  = is_object($t) ? ($t->bio ?? null) : ($t['bio'] ?? null);
                        $tImage = is_object($t) ? $t->image_url : (isset($t['image']) && $t['image'] ? Storage::url($t['image']) : null);

                        // Extract initials cleanly
                        $cleanName = preg_replace('/^(Dr\.|Drs\.|H\.|Hj\.|Ustadz|Ustadzah|Prof\.)\s+/i', '', $tName);
                        $parts = array_filter(explode(' ', trim($cleanName)));
                        $initials = '';
                        $count = 0;
                        foreach ($parts as $p) {
                            if (!empty($p) && $count < 2) {
                                $initials .= strtoupper(substr($p, 0, 1));
                                $count++;
                            }
                        }
                        if (empty($initials)) {
                            $initials = 'LP';
                        }
                    @endphp
                    <div class="teacher-card">
                        <div class="teacher-img">
                            @if($tImage)
                                <img src="{{ $tImage }}" alt="{{ $tName }}" loading="lazy">
                            @else
                                <div class="teacher-avatar-fallback">
                                    <div class="teacher-fallback-circle">
                                        <span>{{ $initials }}</span>
                                    </div>
                                    <div class="teacher-fallback-pattern">
                                        <i data-feather="user" style="width: 18px; height: 18px;"></i>
                                    </div>
                                </div>
                            @endif
                            <span class="teacher-unit-pill">{{ $tUnit ?: 'LPP' }}</span>
                        </div>
                        <div class="teacher-info">
                            <h4>{{ $tName }}</h4>
                            <p class="teacher-role">{{ $tRole }}</p>
                            @if($tBio)
                                <p class="teacher-bio">{{ Str::limit($tBio, 85) }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px 20px; color: #64748b;">
                        <i data-feather="users" style="width: 44px; height: 44px; color: #cbd5e1; margin-bottom: 10px;"></i>
                        <p>Belum ada data pimpinan atau tenaga pendidik yang dipublikasikan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    <!-- 11. BANNER -->
    <div class="spmb-banner">
        <div class="container">
            <h2>{{ $settings['ppdb_title'] ?? 'Pendaftaran Santri Baru (SPMB) Telah Dibuka!' }}</h2>
            <p>{{ $settings['ppdb_desc'] ?? 'Raih kesempatan emas mendaftarkan putra-putri tercinta di unit pendidikan unggulan LPP Al Irsyad Karawang (Daycare sejak bayi lahir, Playgroup, TK Montessori, SDIT, SMPIT, SMAIT).' }}</p>
            <a href="{{ $settings['contact_ppdb_link'] ?? ($settings['hero_btn_link'] ?? '#') }}" class="btn btn-primary" style="padding: 15px 40px; font-size: 1.1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2);">
                {{ $settings['ppdb_btn_text'] ?? 'Daftar Sekarang' }} <i data-feather="arrow-right"></i>
            </a>
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
                        <img src="{{ $post->image_url ?? 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?auto=format&fit=crop&q=80&w=800' }}" alt="{{ $post->title }}">
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
    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="section-header">
                <span style="color: var(--secondary);">Testimonials</span>
                <h2 style="color: var(--white);">Apa Kata Mereka?</h2>
            </div>
            <div class="testi-carousel-container">
                <div class="testi-slider" id="testiSlider">
                    @forelse($testimonials as $testi)
                    <div class="testi-card">
                        <i data-feather="message-square" class="testi-quote"></i>
                        <div class="testi-img">
                            <img src="{{ $testi->image_url ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=200' }}" alt="{{ $testi->name }}" onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=200'">
                        </div>
                        <p>"{{ $testi->content }}"</p>
                        <div>
                            <h4>{{ $testi->name }}</h4>
                            @if(!empty($testi->occupation))
                                <div class="testi-occupation">
                                    <i data-feather="briefcase"></i>
                                    <span>{{ $testi->occupation }}</span>
                                </div>
                            @endif
                            <span class="testi-role">{{ $testi->role_label }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="testi-card" style="flex: 0 0 100%; text-align: center;">
                        <p>Belum ada testimoni.</p>
                    </div>
                    @endforelse
                </div>

                @if($testimonials->count() > 1)
                <div class="testi-nav-wrapper">
                    <button type="button" class="testi-nav-btn" id="testiPrevBtn" aria-label="Testimoni Sebelumnya">
                        <i data-feather="chevron-left"></i>
                    </button>
                    <div class="testi-indicators" id="testiDots"></div>
                    <button type="button" class="testi-nav-btn" id="testiNextBtn" aria-label="Testimoni Berikutnya">
                        <i data-feather="chevron-right"></i>
                    </button>
                </div>
                @endif

                <div style="text-align: center; margin-top: 35px;">
                    <a href="{{ route('testimonials.index') }}" class="btn btn-outline-white" style="border-radius: 50px; padding: 12px 32px; font-weight: 600; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px;">
                        <span>Lihat Semua Testimoni</span>
                        <i data-feather="arrow-right" style="width: 16px; height: 16px;"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- 14. FACILITIES & EKSTRAKURIKULER SHOWCASE -->
    @if(($settings['home_show_facilities'] ?? '1') == '1')
    <section class="facilities" id="programs">
        <div class="container">
            <!-- Part A: Fasilitas Sekolah -->
            <div class="section-header" style="max-width: 820px; margin: 0 auto 36px; text-align: center;">
                <span>Modern Campus Ecosystem</span>
                <h2>Fasilitas Lengkap & Lingkungan Terpadu</h2>
                <p style="color: #64748b; font-size: 1rem; margin-top: 8px;">Kampus terpadu LPP Al Irsyad Karawang dilengkapi 26+ sarana prasarana modern berstandar tinggi untuk menunjang kenyamanan, kesehatan, dan pembinaan karakter islami santri.</p>
            </div>

            <!-- 4 Featured Visual Cards -->
            <div class="facilities-highlight-grid">
                <div class="fac-mini-card">
                    <div class="fac-mini-media">
                        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=600" alt="Masjid Jami Al Irsyad" loading="lazy">
                        <span class="fac-mini-badge">Episentrum Ibadah</span>
                    </div>
                    <div class="fac-mini-body">
                        <h4>Masjid Jami Al Irsyad</h4>
                        <p>Pusat sholat fardhu & dhuha berjamaah, halaqah tahfidz bersanad, dan kajian adab nabawiyah santri.</p>
                    </div>
                </div>

                <div class="fac-mini-card">
                    <div class="fac-mini-media">
                        <img src="https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&q=80&w=600" alt="Lab Komputer iMac & Robotik" loading="lazy">
                        <span class="fac-mini-badge">iMac & STEM Lab</span>
                    </div>
                    <div class="fac-mini-body">
                        <h4>Lab Komputer & Robotik</h4>
                        <p>Workstation iMac mutakhir, lab sains terstandar, dan studio robotik untuk inovasi teknologi digital.</p>
                    </div>
                </div>

                <div class="fac-mini-card">
                    <div class="fac-mini-media">
                        <img src="https://images.unsplash.com/photo-1530549387789-4c1017266635?auto=format&fit=crop&q=80&w=600" alt="Irsyadin Water Pool & Sporthall" loading="lazy">
                        <span class="fac-mini-badge">Renang & Olahraga</span>
                    </div>
                    <div class="fac-mini-body">
                        <h4>Water Pool & Sporthall</h4>
                        <p>Kolam renang privat syar'i terpisah ikhwan/akhwat, arena futsal, basket, dan panahan sunnah.</p>
                    </div>
                </div>

                <div class="fac-mini-card">
                    <div class="fac-mini-media">
                        <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&q=80&w=600" alt="Kelas Smart AC & Montessori" loading="lazy">
                        <span class="fac-mini-badge">Smart AC & Daycare</span>
                    </div>
                    <div class="fac-mini-body">
                        <h4>Kelas Smart AC & Montessori</h4>
                        <p>Ruang kelas sejuk dengan Interactive TV serta sentra Montessori ramah anak sejak usia bayi/balita.</p>
                    </div>
                </div>
            </div>

            <!-- 4-Pill Overview Strip -->
            <div class="fac-categories-strip">
                <div class="fac-cat-box">
                    <div class="fac-cat-icon"><i data-feather="book-open"></i></div>
                    <div class="fac-cat-info">
                        <h5>Akademik & Riset</h5>
                        <span>Lab Komputer, Fisika, Bio-Kimia, Bahasa, & Perpustakaan Digital</span>
                    </div>
                </div>
                <div class="fac-cat-box">
                    <div class="fac-cat-icon"><i data-feather="sun"></i></div>
                    <div class="fac-cat-info">
                        <h5>Ibadah & Karakter</h5>
                        <span>Masjid Jami, Aula 1.000 Santri, & Ruang Halaqah Tahfidz</span>
                    </div>
                </div>
                <div class="fac-cat-box">
                    <div class="fac-cat-icon"><i data-feather="activity"></i></div>
                    <div class="fac-cat-info">
                        <h5>Olahraga & Bermain</h5>
                        <span>Irsyadin Water Pool, Sporthall, Lapangan Futsal, & Playground</span>
                    </div>
                </div>
                <div class="fac-cat-box">
                    <div class="fac-cat-icon"><i data-feather="shield"></i></div>
                    <div class="fac-cat-info">
                        <h5>Layanan & Keamanan</h5>
                        <span>CCTV 24 Jam, Smart Card Presensi, Armada Jemputan, & UKS</span>
                    </div>
                </div>
            </div>

            <!-- Action CTA Button for Facilities -->
            <div style="text-align: center; margin-bottom: 10px;">
                <a href="{{ route('fasilitas.index') }}" class="btn btn-outline" style="border-color: var(--primary); color: var(--primary); font-weight: 700;">
                    Jelajahi Seluruh 26+ Fasilitas Kampus & Galeri <i data-feather="arrow-right" style="width: 16px; height: 16px;"></i>
                </a>
            </div>

            <!-- Part B: Ekstrakurikuler Carousel (Touch & Auto-Slide) -->
            <div class="ekskul-section-wrapper">
                <div class="ekskul-header-flex">
                    <div>
                        <span style="color: var(--secondary); font-weight: 800; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; display: block; margin-bottom: 4px;">Talent & Character Building</span>
                        <h2 style="font-size: 1.95rem; font-weight: 800; color: #1e293b; margin: 0;">Ekstrakurikuler & Pembinaan Bakat</h2>
                    </div>
                    <div class="slider-nav-btns">
                        <button type="button" id="ekskulPrevBtn" class="slider-nav-btn" aria-label="Previous Ekskul">
                            <i data-feather="chevron-left" style="width: 18px; height: 18px;"></i>
                        </button>
                        <button type="button" id="ekskulNextBtn" class="slider-nav-btn" aria-label="Next Ekskul">
                            <i data-feather="chevron-right" style="width: 18px; height: 18px;"></i>
                        </button>
                    </div>
                </div>

                @php
                    $homeEkskuls = [
                        ['name' => 'Tahfidz Bersanad', 'cat' => 'Qur\'ani', 'icon' => 'book-open'],
                        ['name' => 'Robotik & IoT', 'cat' => 'Sains & IT', 'icon' => 'cpu'],
                        ['name' => 'Coding & Game', 'cat' => 'Sains & IT', 'icon' => 'code'],
                        ['name' => 'Panahan Sunnah', 'cat' => 'Olahraga', 'icon' => 'target'],
                        ['name' => 'Tapak Suci Silat', 'cat' => 'Beladiri', 'icon' => 'shield'],
                        ['name' => 'Renang Water Pool', 'cat' => 'Olahraga', 'icon' => 'droplet'],
                        ['name' => 'Taekwondo', 'cat' => 'Beladiri', 'icon' => 'zap'],
                        ['name' => 'Futsal & Soccer', 'cat' => 'Olahraga', 'icon' => 'circle'],
                        ['name' => 'Pramuka SIT', 'cat' => 'Kepanduan', 'icon' => 'compass'],
                        ['name' => 'English Club', 'cat' => 'Bahasa', 'icon' => 'globe'],
                        ['name' => 'Nadi Al-Lughah', 'cat' => 'Bahasa Arab', 'icon' => 'message-square'],
                        ['name' => 'Desain & Media', 'cat' => 'Kreatif', 'icon' => 'image']
                    ];
                @endphp

                <div class="ekskul-slider-container">
                    <div class="ekskul-slider-track" id="ekskulSliderTrack">
                        @foreach($homeEkskuls as $item)
                        <div class="ekskul-slider-item">
                            <a href="{{ route('ekskul.index') }}" class="ekskul-card-mini">
                                <div class="ekskul-icon-wrapper">
                                    <i data-feather="{{ $item['icon'] }}"></i>
                                </div>
                                <h4>{{ $item['name'] }}</h4>
                                <span class="ekskul-cat-tag">{{ $item['cat'] }}</span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div style="text-align: center; margin-top: 25px;">
                    <a href="{{ route('ekskul.index') }}" class="btn btn-primary" style="font-weight: 700;">
                        Lihat Seluruh Katalog 18+ Ekstrakurikuler & Prestasi <i data-feather="arrow-right" style="width: 16px; height: 16px;"></i>
                    </a>
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
                        <div class="logo-emblem" style="width: 38px; height: 38px;">
                            <span style="font-size: 0.78rem;">LPP</span>
                        </div>
                        LPP AL IRSYAD
                    </h3>
                    <p style="color: #94a3b8; font-size: 0.9rem;">{{ $settings['footer_desc'] ?? 'LPP (Lajnah Pendidikan dan Pengajaran) Al Irsyad Al Islamiyyah Karawang menaungi dan mengelola seluruh unit pendidikan Islam terpadu (Daycare, KB-TK Montessori, SDIT, SMPIT, SMAIT) yang berlandaskan Al-Qur\'an, As-Sunnah, dan keunggulan sains-teknologi global.' }}</p>
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
                        <li><a href="#welcome">Ketua LPP</a></li>
                        <li><a href="#unit-pendidikan">Unit Pendidikan</a></li>
                        <li><a href="{{ route('kurikulum.index') }}">Kurikulum Khas</a></li>
                        <li><a href="{{ route('fasilitas.index') }}">Fasilitas Kampus</a></li>
                        <li><a href="{{ route('ekskul.index') }}">Ekstrakurikuler</a></li>
                        <li><a href="{{ route('posts.index') }}">Berita & Artikel</a></li>
                        <li><a href="{{ $settings['contact_ppdb_link'] ?? '#' }}">SPMB Online</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Unit & Layanan</h4>
                    <ul class="footer-links">
                        <li><a href="#unit-pendidikan">Daycare, KB & TK Islam Al Irsyad</a></li>
                        <li><a href="#unit-pendidikan">SDIT Al Irsyad 01 & 02</a></li>
                        <li><a href="#unit-pendidikan">SMPIT Al Irsyad Karawang</a></li>
                        <li><a href="#unit-pendidikan">SMAIT Al Irsyad Karawang</a></li>
                        <li><a href="#">Sistem Informasi Lembaga</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Hubungi Kami</h4>
                    <ul class="contact-list">
                        <li><i data-feather="map-pin"></i> <span>{{ $settings['contact_address'] ?? 'Jl. Raya Telukjambe, Sukaluyu, Telukjambe Timur, Karawang' }}</span></li>
                        <li><i data-feather="phone"></i> <span>{{ $settings['contact_phone'] ?? '(0267) 1234-567' }}</span></li>
                        <li><i data-feather="mail"></i> <span>{{ $settings['contact_email'] ?? 'info@alirsyadkarawang.sch.id' }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} LPP Al Irsyad Al Islamiyyah Karawang. All rights reserved.</p>
                <span id="credit-link">Developed by <a href="https://www.murniabadi.co.id" target="_blank" style="color: var(--secondary); font-weight: 700;">MATEK</a></span>
            </div>
        </div>
    </footer>

    <!-- Mobile Floating WhatsApp Action Button -->
    @php
        $waNum = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? ($settings['ppdb_wa_number'] ?? ($settings['contact_phone'] ?? '6281234567890')));
        if (empty($waNum)) $waNum = '6281234567890';
    @endphp
    <a href="https://wa.me/{{ $waNum }}?text=Halo%20Admin%20Sekolah,%20saya%20ingin%20konsultasi%20pendaftaran%20SPMB." target="_blank" class="mobile-fab-whatsapp" aria-label="Konsultasi WhatsApp">
        <i data-feather="message-circle" style="width: 18px; height: 18px;"></i>
        <span>Chat SPMB</span>
    </a>

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

        // Mobile Menu auto-close & outside click
        document.addEventListener('DOMContentLoaded', function () {
            const navLinks = document.querySelectorAll('.nav-menu a');
            const menu = document.getElementById('navMenu');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (menu && menu.classList.contains('active')) {
                        menu.classList.remove('active');
                    }
                });
            });

            document.addEventListener('click', function (e) {
                const toggle = document.querySelector('.mobile-toggle');
                if (menu && menu.classList.contains('active') && !menu.contains(e.target) && !toggle.contains(e.target)) {
                    menu.classList.remove('active');
                }
            });

            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/sw.js').catch(() => {});
            }
        });

        // Hero Slider Logic
        (function initHeroSlider() {
            const slides = document.querySelectorAll('.hero-slide');
            const dots = document.querySelectorAll('.hero-dot');
            const prevBtn = document.getElementById('heroPrevBtn');
            const nextBtn = document.getElementById('heroNextBtn');
            const wrapper = document.getElementById('heroSliderWrapper');
            if (!slides.length) return;

            let currentSlide = 0;
            let slideInterval = null;
            const intervalTime = 6000;

            function showSlide(index) {
                if (index < 0) {
                    currentSlide = slides.length - 1;
                } else if (index >= slides.length) {
                    currentSlide = 0;
                } else {
                    currentSlide = index;
                }

                slides.forEach((slide, idx) => {
                    if (idx === currentSlide) {
                        slide.classList.add('active');
                    } else {
                        slide.classList.remove('active');
                    }
                });

                dots.forEach((dot, idx) => {
                    if (idx === currentSlide) {
                        dot.classList.add('active');
                    } else {
                        dot.classList.remove('active');
                    }
                });
            }

            function nextSlide() {
                showSlide(currentSlide + 1);
            }

            function prevSlide() {
                showSlide(currentSlide - 1);
            }

            function startAutoplay() {
                stopAutoplay();
                slideInterval = setInterval(nextSlide, intervalTime);
            }

            function stopAutoplay() {
                if (slideInterval) {
                    clearInterval(slideInterval);
                    slideInterval = null;
                }
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    nextSlide();
                    startAutoplay();
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    prevSlide();
                    startAutoplay();
                });
            }

            dots.forEach(dot => {
                dot.addEventListener('click', (e) => {
                    const targetIndex = parseInt(e.currentTarget.getAttribute('data-slide'), 10);
                    showSlide(targetIndex);
                    startAutoplay();
                });
            });

            if (wrapper) {
                wrapper.addEventListener('mouseenter', stopAutoplay);
                wrapper.addEventListener('mouseleave', startAutoplay);

                let touchStartX = 0;
                let touchEndX = 0;
                wrapper.addEventListener('touchstart', (e) => {
                    touchStartX = e.changedTouches[0].screenX;
                    stopAutoplay();
                }, { passive: true });

                wrapper.addEventListener('touchend', (e) => {
                    touchEndX = e.changedTouches[0].screenX;
                    if (touchStartX - touchEndX > 50) {
                        nextSlide();
                    } else if (touchEndX - touchStartX > 50) {
                        prevSlide();
                    }
                    startAutoplay();
                }, { passive: true });
            }

            startAutoplay();
        })();

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

        // Testimonials Carousel
        (function initTestimonialsCarousel() {
            const slider = document.getElementById('testiSlider');
            const prevBtn = document.getElementById('testiPrevBtn');
            const nextBtn = document.getElementById('testiNextBtn');
            const dotsContainer = document.getElementById('testiDots');
            if (!slider) return;

            const cards = slider.querySelectorAll('.testi-card');
            if (cards.length <= 1) return;

            // Generate dots
            if (dotsContainer) {
                dotsContainer.innerHTML = '';
                cards.forEach((_, idx) => {
                    const dot = document.createElement('button');
                    dot.className = 'testi-dot' + (idx === 0 ? ' active' : '');
                    dot.setAttribute('aria-label', 'Slide ' + (idx + 1));
                    dot.addEventListener('click', () => {
                        cards[idx].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
                    });
                    dotsContainer.appendChild(dot);
                });
            }

            function updateActiveDot() {
                if (!dotsContainer) return;
                const dots = dotsContainer.querySelectorAll('.testi-dot');
                const scrollLeft = slider.scrollLeft;
                const cardWidth = (cards[0] ? cards[0].offsetWidth : 320) + 24;
                const activeIndex = Math.round(scrollLeft / cardWidth);
                dots.forEach((dot, idx) => {
                    dot.classList.toggle('active', idx === Math.min(activeIndex, dots.length - 1));
                });
            }

            slider.addEventListener('scroll', updateActiveDot, { passive: true });

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    const cardWidth = (cards[0] ? cards[0].offsetWidth : 320) + 24;
                    slider.scrollBy({ left: -cardWidth, behavior: 'smooth' });
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    const cardWidth = (cards[0] ? cards[0].offsetWidth : 320) + 24;
                    if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 15) {
                        slider.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        slider.scrollBy({ left: cardWidth, behavior: 'smooth' });
                    }
                });
            }
        })();

        // Ekstrakurikuler Carousel Auto-Slide & Touch Navigation
        (function initEkskulSlider() {
            const track = document.getElementById('ekskulSliderTrack');
            const prevBtn = document.getElementById('ekskulPrevBtn');
            const nextBtn = document.getElementById('ekskulNextBtn');
            if (!track) return;

            function getStep() {
                const firstCard = track.querySelector('.ekskul-slider-item');
                return firstCard ? (firstCard.offsetWidth + 16) : 220;
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 15) {
                        track.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        track.scrollBy({ left: getStep(), behavior: 'smooth' });
                    }
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    if (track.scrollLeft <= 10) {
                        track.scrollTo({ left: track.scrollWidth, behavior: 'smooth' });
                    } else {
                        track.scrollBy({ left: -getStep(), behavior: 'smooth' });
                    }
                });
            }

            // Auto-slide every 3.5s unless hovered/focused
            let autoSlideTimer = setInterval(() => {
                if (track.matches(':hover')) return;
                if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 15) {
                    track.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    track.scrollBy({ left: getStep(), behavior: 'smooth' });
                }
            }, 3500);

            track.addEventListener('mouseenter', () => clearInterval(autoSlideTimer));
            track.addEventListener('mouseleave', () => {
                autoSlideTimer = setInterval(() => {
                    if (track.matches(':hover')) return;
                    if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 15) {
                        track.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        track.scrollBy({ left: getStep(), behavior: 'smooth' });
                    }
                }, 3500);
            });
        })();

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