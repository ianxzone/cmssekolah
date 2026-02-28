@php
    if (!isset($settings)) {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
    }
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sedang Dalam Pemeliharaan - {{ $settings['school_name'] ?? config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        :root {
            --primary: #065f46;
            --primary-dark: #064e3b;
            --secondary: #fbbf24;
            --slate-900: #0f172a;
            --slate-800: #1e293b;
            --slate-100: #f1f5f9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top right, #065f46, #0f172a);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            overflow: hidden;
            padding: 20px;
        }

        .maint-container {
            max-width: 650px;
            width: 100%;
            position: relative;
            z-index: 10;
            text-align: center;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 40px;
            padding: 60px 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: cardAppear 1s ease-out;
        }

        @keyframes cardAppear {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .logo-box {
            margin-bottom: 30px;
        }

        .logo {
            height: 80px;
            width: auto;
            filter: drop-shadow(0 0 20px rgba(251, 191, 36, 0.3));
        }

        .brand-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--secondary);
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 15px;
            opacity: 0.9;
        }

        .main-heading {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
            background: linear-gradient(to bottom, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sub-text {
            font-size: 1.15rem;
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .animated-icon {
            margin: 0 auto 30px;
            width: 100px;
            height: 100px;
            background: rgba(251, 191, 36, 0.1);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary);
            position: relative;
        }

        .animated-icon i {
            width: 48px;
            height: 48px;
            animation: pulse-icon 2s infinite;
        }

        @keyframes pulse-icon {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animated-icon::before {
            content: '';
            position: absolute;
            width: 130%;
            height: 130%;
            border: 2px dashed rgba(251, 191, 36, 0.2);
            border-radius: 40px;
            animation: rotate-border 10s linear infinite;
        }

        @keyframes rotate-border {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 40px;
        }

        .info-item {
            text-align: left;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .info-item i {
            color: var(--secondary);
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .info-item h4 {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #fff;
            margin-bottom: 4px;
        }

        .info-item p {
            color: #94a3b8;
            font-size: 0.95rem;
        }

        .footer-tag {
            margin-top: 40px;
            font-size: 0.85rem;
            color: rgba(148, 163, 184, 0.5);
        }

        /* Responsive */
        @media (max-width: 640px) {
            .main-heading {
                font-size: 2.2rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .glass-card {
                padding: 40px 25px;
            }
        }

        /* Abstract shapes in background */
        .shape {
            position: absolute;
            z-index: 1;
            filter: blur(80px);
            opacity: 0.4;
        }

        .shape-1 {
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: var(--primary);
        }

        .shape-2 {
            bottom: -10%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: var(--secondary);
            opacity: 0.2;
        }
    </style>
</head>

<body>
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <div class="maint-container">
        <div class="glass-card">
            <div class="logo-box">
                @if(isset($settings['school_logo']))
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($settings['school_logo']) }}" alt="Logo"
                        class="logo">
                @else
                    <div class="brand-name">{{ $settings['school_name'] ?? 'SEKOLAH ISLAM TELADAN' }}</div>
                @endif
            </div>

            <div class="animated-icon">
                <i data-feather="settings"></i>
            </div>

            <h1 class="main-heading">Under Maintenance</h1>
            <p class="sub-text">
                Kami sedang melakukan pembaharuan sistem untuk memberikan layanan yang lebih baik. Mohon menunggu
                sebentar, website akan segera kembali online.
            </p>

            <div class="info-grid">
                <div class="info-item">
                    <i data-feather="phone"></i>
                    <div>
                        <h4>Butuh Bantuan?</h4>
                        <p>{{ $settings['contact_phone'] ?? '(021) 1234-5678' }}</p>
                    </div>
                </div>
                <div class="info-item">
                    <i data-feather="mail"></i>
                    <div>
                        <h4>Email Hubungi</h4>
                        <p>{{ $settings['contact_email'] ?? 'info@sekolah.sch.id' }}</p>
                    </div>
                </div>
            </div>

            <p class="footer-tag">© {{ date('Y') }} {{ $settings['school_name'] ?? config('app.name') }}. Built with ❤️
                for Education.</p>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</body>

</html>