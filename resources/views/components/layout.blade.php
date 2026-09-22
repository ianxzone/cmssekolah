<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Dynamic SEO Meta Tags -->
    @php
        $siteName = config('app.name', 'LPP Al Irsyad Karawang');
        $defaultTitleFormat = \App\Models\Setting::get('seo_default_title_format', '%title% - ' . $siteName);
        $defaultDescription = \App\Models\Setting::get('seo_default_description', 'LPP Al Irsyad Al Islamiyyah Karawang - Lajnah Pendidikan & Pengajaran');
        $defaultKeywords = \App\Models\Setting::get('seo_default_keywords', 'sekolah, islam, karawang, sdit');
        $defaultImage = \App\Models\Setting::get('seo_default_image', '');
        
        $pageTitle = $title ?? $siteName;
        // Jika sedang di beranda (tidak ada section title spesifik), gunakan title utuh
        $finalTitle = (!empty($title) && $pageTitle !== $siteName) ? str_replace('%title%', $pageTitle, $defaultTitleFormat) : $pageTitle;
        
        $finalDescription = $metaDescription ?? $defaultDescription;
        $metaImage = $metaImage ?? ($defaultImage ? Storage::url($defaultImage) : asset('assets/images/default-og.png'));
        $metaUrl = url()->current();
    @endphp

    <title>{{ $finalTitle }}</title>
    <meta name="description" content="{{ $finalDescription }}">
    <meta name="keywords" content="{{ $metaKeywords ?? $defaultKeywords }}">
    
    <link rel="canonical" href="{{ $metaUrl }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ $metaType ?? 'website' }}">
    <meta property="og:url" content="{{ $metaUrl }}">
    <meta property="og:title" content="{{ $finalTitle }}">
    <meta property="og:description" content="{{ $finalDescription }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:site_name" content="{{ $siteName }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $metaUrl }}">
    <meta name="twitter:title" content="{{ $finalTitle }}">
    <meta name="twitter:description" content="{{ $finalDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">

    <!-- Webmaster Tools & Analytics -->
    @if(\App\Models\Setting::get('seo_google_site_verification'))
    <meta name="google-site-verification" content="{{ \App\Models\Setting::get('seo_google_site_verification') }}" />
    @endif

    @include('partials.analytics')

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --radius-md: 12px;
            --radius-lg: 24px;
            --container-max: 1200px;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Outfit', sans-serif;
        }

        /* 1. TOPBAR */
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
            max-width: var(--container-max);
            margin: 0 auto;
            padding: 0 20px;
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

        /* 2. NAVBAR */
        .navbar {
            background: var(--white);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .navbar.sticky-active {
            padding: 10px 0;
            box-shadow: var(--shadow-md);
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: var(--container-max);
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo img {
            height: 50px;
        }

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

        .logo-text h1 {
            font-size: 1.25rem;
            color: var(--primary-dark);
            font-weight: 800;
            line-height: 1;
            margin: 0;
        }

        .logo-text p {
            font-size: 0.75rem;
            color: var(--primary-light);
            font-weight: 600;
            letter-spacing: 1px;
            margin: 0;
        }

        .nav-menu {
            display: flex;
            gap: 30px;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-link {
            font-weight: 600;
            color: var(--text-main);
            font-size: 0.95rem;
            text-decoration: none;
            transition: var(--transition);
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .nav-spmb {
            background: var(--primary);
            color: var(--white) !important;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .nav-spmb:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
        }

        .mobile-toggle {
            display: none;
            cursor: pointer;
            color: var(--primary-dark);
        }

        /* FOOTER */
        footer {
            background: #0f172a;
            color: #cbd5e1;
            padding: 80px 0 20px;
            margin-top: auto;
        }

        footer .container {
            max-width: var(--container-max);
            margin: 0 auto;
            padding: 0 20px;
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
            line-height: 1.6;
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
            color: var(--white);
            transition: var(--transition);
            text-decoration: none;
        }

        .social-links a:hover {
            background: var(--secondary);
            color: var(--primary-dark);
        }

        .footer-col h4 {
            color: var(--white);
            font-size: 1.2rem;
            margin-bottom: 25px;
            font-weight: 700;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            text-decoration: none;
            color: #cbd5e1;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--secondary);
            padding-left: 5px;
        }

        .contact-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .contact-list li {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            align-items: flex-start;
            line-height: 1.5;
        }

        .contact-list i {
            color: var(--secondary);
            margin-top: 5px;
            width: 18px;
            flex-shrink: 0;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        /* Floating WhatsApp Button */
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

        /* Responsive */
        @media (max-width: 1024px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .topbar {
                display: none;
            }

            .mobile-toggle {
                display: block;
            }

            .nav-menu {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: var(--white);
                flex-direction: column;
                padding: 16px 20px 24px;
                display: none;
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
                border-top: 1px solid #f1f5f9;
            }

            .nav-menu.active {
                display: flex;
                animation: navSlideDown 0.25s ease-out;
            }

            @keyframes navSlideDown {
                from {
                    opacity: 0;
                    transform: translateY(-8px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .nav-menu li {
                width: 100%;
                border-bottom: 1px solid #f8fafc;
                padding: 10px 0;
            }

            .nav-menu li:last-child {
                border-bottom: none;
                padding-top: 15px;
            }

            .nav-spmb {
                display: block;
                text-align: center;
                width: 100%;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }

        @media (max-width: 480px) {
            .mobile-fab-whatsapp {
                bottom: 16px;
                right: 16px;
                padding: 10px 16px;
                font-size: 0.84rem;
            }
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">

    @include('frontend.layouts.navbar')

    <!-- Main Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    @include('frontend.layouts.footer')

</body>

</html>