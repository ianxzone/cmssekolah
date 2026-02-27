<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $adminBrandName = \App\Models\Setting::where('key', 'school_name')->value('value') ?? config('app.name', 'CMS');
        $adminLogo = \App\Models\Setting::where('key', 'school_logo')->value('value');
        $adminFavicon = \App\Models\Setting::where('key', 'school_favicon')->value('value');
    @endphp
    <title>Wizard Setup Data Sekolah - {{ $adminBrandName }}</title>
    <link rel="icon"
        href="{{ $adminFavicon ? \Illuminate\Support\Facades\Storage::url($adminFavicon) : asset('favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/setup.css') }}">
    <script src="https://unpkg.com/feather-icons"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary: #4f46e5;
            --accent: #7c3aed;
        }

        .onboarding-skip {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.2s;
        }

        .onboarding-skip:hover {
            color: var(--primary);
        }
    </style>
</head>

<body>
    <div class="setup-container">
        <div class="setup-header">
            @if($adminLogo)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($adminLogo) }}" alt="{{ $adminBrandName }} Logo"
                    class="setup-logo" style="height: 60px; object-fit: contain;">
            @else
                <img src="{{ asset('images/matek-logo.png') }}"
                    onerror="this.src='https://placehold.co/100?text={{ urlencode(explode(' ', $adminBrandName)[0]) }}'"
                    alt="Logo" class="setup-logo">
            @endif
            <h1>SETUP DATA SEKOLAH</h1>
            <p>Mari lengkapi profil sekolah Anda</p>
        </div>

        <div class="setup-body">
            @yield('content')
        </div>
    </div>

    <div class="footer-credit" style="padding: 20px 0; width: 100%; text-align: center;">
        Powered by <a href="https://www.murniabadi.co.id" target="_blank"
            style="color: var(--primary); font-weight: 600; text-decoration: none;">MATEK</a>
    </div>

    <script>
        feather.replace();
    </script>
    @stack('scripts')
</body>

</html>