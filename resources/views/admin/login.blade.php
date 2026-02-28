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
    <title>Login Admin - {{ $adminBrandName }}</title>
    <link rel="icon"
        href="{{ $adminFavicon ? \Illuminate\Support\Facades\Storage::url($adminFavicon) : asset('favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/setup.css') }}">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        :root {
            --primary: #064e3b;
            --primary-light: #065f46;
            --secondary: #fbbf24;
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --radius-xl: 24px;
            --radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 50%, #fefce8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
        }

        /* Ambient backgrounds */
        .ambient-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.5;
        }

        .blob-1 {
            width: 400px;
            height: 400px;
            background: rgba(6, 78, 59, 0.1);
            top: -200px;
            right: -100px;
        }

        .blob-2 {
            width: 300px;
            height: 300px;
            background: rgba(251, 191, 36, 0.1);
            bottom: -150px;
            left: -50px;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: var(--radius-xl);
            padding: 50px 40px;
            box-shadow: 0 25px 50px -12px rgba(6, 78, 59, 0.08);
            position: relative;
            animation: cardEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes cardEntrance {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .login-logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-logo img {
            height: 70px;
            width: auto;
            margin-bottom: 15px;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.05));
        }

        .login-logo h2 {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--gray-900);
            letter-spacing: -0.03em;
            margin: 0;
        }

        .login-logo p {
            color: var(--gray-500);
            font-size: 0.95rem;
            margin-top: 5px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 8px;
            transition: var(--transition);
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper svg {
            position: absolute;
            left: 18px;
            width: 20px;
            height: 20px;
            color: var(--gray-400);
            transition: var(--transition);
        }

        .form-control {
            width: 100%;
            padding: 14px 18px 14px 50px;
            background: var(--gray-100);
            border: 2px solid transparent;
            border-radius: var(--radius-lg);
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            color: var(--gray-900);
            transition: var(--transition);
        }

        .form-control::placeholder {
            color: var(--gray-400);
        }

        .form-control:focus {
            outline: none;
            background: var(--white);
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(6, 78, 59, 0.05);
        }

        .form-group:focus-within .form-label {
            color: var(--primary);
        }

        .form-group:focus-within .input-wrapper svg {
            color: var(--primary);
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--radius-lg);
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 10px;
            box-shadow: 0 10px 20px -5px rgba(6, 78, 59, 0.2);
        }

        .btn-login:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -5px rgba(6, 78, 59, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login svg {
            width: 20px;
            height: 20px;
        }

        .error-message {
            background: #fef2f2;
            color: #b91c1c;
            padding: 14px 18px;
            border-radius: var(--radius-lg);
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #fee2e2;
            animation: shake 0.5s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
        }

        @keyframes shake {

            10%,
            90% {
                transform: translate3d(-1px, 0, 0);
            }

            20%,
            80% {
                transform: translate3d(2px, 0, 0);
            }

            30%,
            50%,
            70% {
                transform: translate3d(-4px, 0, 0);
            }

            40%,
            60% {
                transform: translate3d(4px, 0, 0);
            }
        }

        .links-area {
            margin-top: 35px;
            text-align: center;
            padding-top: 25px;
            border-top: 1px solid var(--gray-200);
        }

        .back-link {
            color: var(--gray-500);
            font-size: 0.9rem;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .back-link:hover {
            color: var(--primary);
        }

        .back-link svg {
            width: 16px;
            height: 16px;
        }
    </style>
</head>

<body>
    <div class="ambient-blob blob-1"></div>
    <div class="ambient-blob blob-2"></div>

    <div class="login-card">
        <div class="login-logo">
            @if($adminLogo)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($adminLogo) }}" alt="{{ $adminBrandName }} Logo">
            @else
                <img src="{{ asset('images/matek-logo.png') }}"
                    onerror="this.src='https://placehold.co/100?text={{ urlencode(explode(' ', $adminBrandName)[0]) }}'"
                    alt="Logo">
            @endif
            <h2>Portal Admin</h2>
            <p>{{ $adminBrandName }}</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                <i data-feather="alert-circle"></i>
                <span>Email atau password salah.</span>
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Email</label>
                <div class="input-wrapper">
                    <i data-feather="mail"></i>
                    <input type="email" name="email" class="form-control" placeholder="admin@sekolah.sch.id" required
                        autofocus>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrapper">
                    <i data-feather="lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-login">
                Masuk ke Dashboard <i data-feather="arrow-right"></i>
            </button>
        </form>

        <div class="links-area">
            <a href="{{ url('/') }}" class="back-link">
                <i data-feather="home"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</body>

</html>