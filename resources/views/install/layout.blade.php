<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup CMS Sekolah - by MATEK</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/setup.css') }}">
    <script src="https://unpkg.com/feather-icons"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="setup-container">
        <div class="setup-header">
            <img src="{{ asset('images/matek-logo.png') }}"
                onerror="this.src='https://via.placeholder.com/100?text=MATEK'" alt="MATEK Logo" class="setup-logo">
            <h1>CMS SEKOLAH</h1>
            <p>Panduan Instalasi by MATEK</p>
        </div>

        <div class="setup-body">
            @yield('content')
        </div>
    </div>

    <div class="footer-credit" style="position: absolute; bottom: 20px; width: 100%; left: 0;">
        Powered by <a href="https://www.murniabadi.co.id" target="_blank">MATEK</a>
    </div>

    <script>
        feather.replace();
    </script>
    @stack('scripts')
</body>

</html>