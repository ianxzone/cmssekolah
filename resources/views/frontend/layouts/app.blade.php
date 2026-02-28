<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Dynamic SEO Meta Tags -->
    <title>@yield('title', ($settings['school_name'] ?? config('app.name', 'Laravel'))) @if(Request::is('/')) -
    {{ $settings['school_tagline'] ?? '' }} @endif
    </title>
    <meta name="description"
        content="@yield('meta_description', $settings['school_tagline'] ?? 'Welcome to our platform.')">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="icon"
        href="{{ isset($settings['school_favicon']) && $settings['school_favicon'] ? \Illuminate\Support\Facades\Storage::url($settings['school_favicon']) : asset('favicon.ico') }}">
    <script src="https://unpkg.com/feather-icons"></script>

    <script>
        // Inline script to prevent FOUC
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        :root {
            --primary: #065f46;
            --primary-dark: #064e3b;
            --primary-light: #10b981;
            --secondary: #fbbf24;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --bg-light: #f9fafb;
            --white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --radius-md: 12px;
            --radius-lg: 24px;
            --container-max: 1200px;
            --transition: all 0.3s ease;

            /* Compatibility for sub-views using old variables */
            --primary-color: var(--primary);
            --primary-hover: var(--primary-dark);
            --text-primary: var(--text-main);
            --text-secondary: var(--text-muted);
            --bg-body: var(--bg-light);
            --bg-surface: var(--white);
            --border-color: #e5e7eb;
        }

        .dark {
            --primary-dark: #10b981;
            --primary-light: #34d399;
            --text-main: #ffffff;
            --text-muted: #cbd5e1;
            --text-heading: #f8fafc;
            --bg-light: #0f172a;
            --white: #1e293b;
            --bg-elevated: #334155;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.5);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.7);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.9);
            --border-color: #334155;

            /* Compatibility for sub-views */
            --text-primary: var(--text-heading);
            --text-secondary: var(--text-muted);
            --bg-body: var(--bg-light);
            --bg-surface: var(--white);
            --primary-color: var(--primary-light);
            --primary-hover: var(--primary-dark);
        }

        .dark h1,
        .dark h2,
        .dark h3,
        .dark h4,
        .dark h5,
        .dark h6 {
            color: var(--text-heading);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--text-main);
            background-color: var(--bg-light);
            line-height: 1.6;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: var(--transition);
        }

        ul {
            list-style: none;
        }

        .container {
            max-width: var(--container-max);
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Topbar */
        .topbar {
            background: var(--primary-dark);
            color: var(--white);
            padding: 10px 0;
            font-size: 0.85rem;
        }

        .topbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-info {
            display: flex;
            gap: 20px;
        }

        .topbar-info div {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Navbar */
        .navbar {
            background: var(--white);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border-bottom: 1px solid var(--border-color);
        }

        .dark .navbar {
            background: #0f172a !important;
            border-bottom-color: #1e293b;
        }

        .logo-text h1 {
            color: var(--primary-dark);
            font-weight: 800;
            margin: 0;
        }

        .dark .logo-text h1 {
            color: var(--text-heading);
        }

        .logo-text p {
            color: var(--text-muted);
            margin: 0;
            line-height: 1;
            font-size: 0.8rem;
        }

        .dark .logo-text p {
            color: var(--text-muted);
            opacity: 0.9;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .nav-link {
            font-weight: 600;
            color: var(--text-main);
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .nav-link:hover {
            color: var(--primary);
            background: rgba(6, 95, 70, 0.05);
        }

        .dark .nav-link:hover {
            color: var(--primary-light);
            background: rgba(16, 185, 129, 0.1);
        }

        .nav-spmb {
            background: var(--secondary);
            color: var(--primary-dark);
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(251, 191, 36, 0.3);
        }

        .nav-spmb:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(251, 191, 36, 0.4);
        }

        .theme-toggle {
            background: none;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .theme-toggle:hover {
            background: rgba(0, 0, 0, 0.05);
            color: var(--primary);
        }

        .dark .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--primary-light);
        }

        .theme-toggle .sun-icon,
        .dark .theme-toggle .moon-icon {
            display: none;
        }

        .dark .theme-toggle .sun-icon {
            display: block;
        }

        .mobile-toggle {
            display: none;
            cursor: pointer;
            font-size: 1.5rem;
        }

        /* Main Area */
        main {
            flex-grow: 1;
            padding: 3rem 0;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Footer */
        footer {
            background: var(--primary-dark);
            color: var(--white);
            padding: 80px 0 20px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 40px;
            margin-bottom: 50px;
        }

        .footer-logo h3 {
            color: var(--white);
            font-size: 1.5rem;
            margin-bottom: 15px;
            font-weight: 800;
        }

        .footer-logo p {
            margin-bottom: 20px;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .social-links {
            display: flex;
            gap: 10px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .social-links a:hover {
            background: var(--secondary);
            color: var(--primary-dark);
            transform: translateY(-3px);
        }

        .footer-col h4 {
            color: var(--white);
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-col h4::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 30px;
            height: 2px;
            background: var(--secondary);
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            display: block;
        }

        .footer-links a:hover {
            color: var(--secondary);
            padding-left: 5px;
        }

        .contact-list li {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
        }

        .contact-list i {
            color: var(--secondary);
            flex-shrink: 0;
            margin-top: 4px;
        }

        .footer-bottom {
            padding-top: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Buttons compatibility */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            gap: 8px;
        }

        .btn-primary {
            background-color: var(--secondary);
            color: var(--primary-dark);
            box-shadow: 0 4px 14px rgba(251, 191, 36, 0.4);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: var(--white);
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: var(--radius-md);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        /* Subpage Hero Styling */
        .subpage-hero {
            position: relative;
            background: var(--primary-dark);
            background-size: cover;
            background-position: center;
            padding: 60px 0;
            color: var(--white);
            margin-bottom: 0;
            overflow: hidden;
        }

        .subpage-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(6, 78, 59, 0.95), rgba(6, 78, 59, 0.6));
            z-index: 0;
        }

        .subpage-hero .container {
            position: relative;
            z-index: 1;
        }

        .subpage-hero h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 10px;
            color: var(--white);
        }

        .subpage-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .subpage-breadcrumb a {
            color: var(--white);
            opacity: 0.8;
        }

        .subpage-breadcrumb a:hover {
            opacity: 1;
            text-decoration: underline;
        }

        /* Pagination Custom Styling */
        .pagination-wrapper {
            margin-top: 60px;
            display: flex;
            justify-content: center;
        }

        .custom-pagination {
            display: block;
        }

        .pagination-list {
            display: flex;
            gap: 10px;
            margin: 0;
            padding: 0;
            list-style: none;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .pagination-list .page-item .page-link {
            border: 1px solid var(--border-color);
            min-width: 46px;
            height: 46px;
            padding: 5px;
            border-radius: 14px;
            color: var(--text-main);
            background: var(--white);
            font-weight: 700;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .pagination-list .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: var(--white);
            box-shadow: 0 6px 15px rgba(6, 95, 70, 0.25);
        }

        .pagination-list .page-item:not(.active) .page-link:hover {
            background: rgba(6, 95, 70, 0.05);
            color: var(--primary);
            border-color: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .pagination-list .page-item.disabled .page-link {
            opacity: 0.4;
            cursor: not-allowed;
            background: var(--bg-light);
            color: var(--text-muted);
        }

        @media (max-width: 1024px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .subpage-hero {
                padding: 40px 0;
            }

            .subpage-hero h1 {
                font-size: 1.8rem;
            }

            .topbar {
                display: none !important;
            }

            .mobile-toggle {
                display: block;
            }

            .logo-text h1 {
                font-size: 1.1rem !important;
            }

            .logo-text p {
                font-size: 0.65rem !important;
            }

            .nav-menu {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: var(--white);
                flex-direction: column;
                padding: 20px;
                display: none;
                box-shadow: var(--shadow-md);
                z-index: 1000;
            }

            .dark .nav-menu {
                background: #0f172a;
            }

            .nav-menu.active {
                display: flex;
            }

            .nav-menu li {
                width: 100%;
            }

            .nav-link {
                width: 100%;
                padding: 12px;
            }

            .nav-spmb {
                display: block;
                text-align: center;
                margin-top: 10px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }
    </style>
    @stack('styles')
    {!! $settings['custom_header_scripts'] ?? '' !!}
</head>

<body>
    @php
        $resolveAsset = function ($path, $default = '') {
            if (empty($path))
                return $default;
            if (Str::startsWith($path, ['http://', 'https://', 'data:']))
                return $path;
            return Storage::url($path);
        };
        $fallbackLogo = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='50' viewBox='0 0 150 50'%3E%3Crect width='150' height='50' fill='%23065f46'/%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' fill='white' font-family='sans-serif' font-size='14'%3ELOGO%3C/text%3E%3C/svg%3E";
    @endphp

    <!-- 1. TOPBAR -->
    <div class="topbar">
        <div class="container">
            <div class="topbar-info">
                <div><i data-feather="phone" style="width: 14px;"></i>
                    {{ $settings['contact_phone'] ?? '(0267) 1234-567' }}</div>
                <div><i data-feather="mail" style="width: 14px;"></i> {{ $settings['contact_email'] ??
                    'info@alirsyadkarawang.sch.id' }}</div>
            </div>
            <div>Jam Operasional: {{ $settings['contact_hours'] ?? 'Senin - Jumat (07:00 - 15:30)' }}</div>
        </div>
    </div>

    <!-- 2. NAVBAR -->
    <nav class="navbar" id="mainNavbar">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <a href="/" class="logo" style="display: flex; align-items: center; gap: 10px;">
                <img src="{{ $resolveAsset($settings['school_logo'] ?? '', asset('images/logo.png')) }}"
                    onerror="this.src='{{ $fallbackLogo }}'" alt="Logo" style="height: 40px; border-radius: 4px;">
                <div class="logo-text">
                    <h1 style="font-size: 1.25rem;">{{ $settings['school_name'] ?? 'SDIT Al Irsyad' }}</h1>
                    <p style="font-size: 0.75rem;">{{ $settings['school_tagline'] ?? 'Sekolah Islam Teladan' }}</p>
                </div>
            </a>
            <div style="display: flex; align-items: center; gap: 10px; margin-left: auto;">
                <ul class="nav-menu" id="navMenu">
                    @php
                        $navLinks = json_decode($settings['navbar_links'] ?? '[]', true);
                        if (empty($navLinks)) {
                            $navLinks = [['label' => 'Beranda', 'url' => '/']];
                            $pages = \App\Models\Page::where('type', 'default')->get();
                            foreach ($pages as $page) {
                                $navLinks[] = ['label' => $page->title, 'url' => url('/page/' . $page->slug)];
                            }
                            $navLinks[] = ['label' => 'Berita', 'url' => route('posts.index')];
                        }
                    @endphp
                    @foreach($navLinks as $link)
                        <li><a href="{{ $link['url'] }}" class="nav-link">{{ $link['label'] }}</a></li>
                    @endforeach
                    <li><a href="{{ $settings['contact_ppdb_link'] ?? '#' }}" class="nav-spmb">SPMB Online</a></li>
                </ul>
                <button id="theme-toggle" class="theme-toggle" title="Toggle Theme">
                    <i data-feather="moon" class="moon-icon"></i>
                    <i data-feather="sun" class="sun-icon"></i>
                </button>
            </div>
            <div class="mobile-toggle" onclick="toggleMenu()" style="margin-left: 10px;">
                <i data-feather="menu"></i>
            </div>
        </div>
    </nav>

    @yield('hero')

    <main class="container">
        @if (session('success'))
            <div class="alert alert-success" id="flash-message">
                <i data-feather="check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- 3. FOOTER -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-logo">
                    <h3 style="display: flex; align-items: center; gap: 10px;">
                        <img src="{{ $resolveAsset($settings['school_logo'] ?? '', asset('images/logo.png')) }}"
                            onerror="this.src='{{ $fallbackLogo }}'" alt="Logo"
                            style="height: 40px; border-radius: 4px;">
                        {{ $settings['school_name'] ?? 'SDIT Al Irsyad' }}
                    </h3>
                    <p>{{ $settings['school_tagline'] ?? 'Sekolah Islam Teladan' }}</p>
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
                        <li><a href="{{ route('posts.index') }}">Berita & Artikel</a></li>
                        <li><a href="{{ route('teachers.index') }}">Data Guru</a></li>
                        <li><a href="{{ $settings['contact_ppdb_link'] ?? '#' }}">SPMB Online</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Layanan</h4>
                    <ul class="footer-links">
                        <li><a href="#">SIAKAD Sekolah</a></li>
                        <li><a href="#">E-Learning</a></li>
                        <li><a href="#">Perpustakaan Digital</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Hubungi Kami</h4>
                    <ul class="contact-list">
                        <li><i data-feather="map-pin"></i>
                            <span>{{ $settings['contact_address'] ?? 'Jl. Raya Telukjambe, Karawang' }}</span>
                        </li>
                        <li><i data-feather="phone"></i>
                            <span>{{ $settings['contact_phone'] ?? '(0267) 1234-567' }}</span>
                        </li>
                        <li><i data-feather="mail"></i> <span>{{ $settings['contact_email'] ??
                                'info@alirsyadkarawang.sch.id' }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ $settings['school_name'] ?? 'SMA Islam Teladan' }}. All rights reserved.
                </p>
                <div id="credit-link">Developed by <a href="https://www.murniabadi.co.id" target="_blank"
                        style="color: var(--secondary); font-weight: 700;">MATEK</a></div>
            </div>
        </div>
    </footer>

    <script>
        feather.replace();

        // Theme Toggle
        const themeToggleBtn = document.getElementById('theme-toggle');
        themeToggleBtn.addEventListener('click', () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        });

        // Mobile Menu
        function toggleMenu() {
            document.getElementById('navMenu').classList.toggle('active');
        }

        // Sticky Navbar
        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 50) navbar.style.padding = '10px 0';
            else navbar.style.padding = '15px 0';
        });

        // Auto dismiss alert
        setTimeout(() => {
            const alert = document.getElementById('flash-message');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 4000);

        // Credit check
        (function () {
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
    @stack('scripts')
    {!! $settings['custom_footer_scripts'] ?? '' !!}
</body>

</html>