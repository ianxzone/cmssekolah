<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wizard Setup Data Sekolah - by MATEK</title>
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
            <img src="{{ asset('images/matek-logo.png') }}"
                onerror="this.src='https://via.placeholder.com/100?text=MATEK'" alt="MATEK Logo" class="setup-logo">
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