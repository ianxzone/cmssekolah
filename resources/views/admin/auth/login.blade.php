<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator | {{ \App\Models\Setting::siteName() }}</title>
    <!-- Dynamic Favicon -->
    <link rel="icon" type="image/png" href="{{ \App\Models\Setting::faviconUrl() }}">
    <link rel="shortcut icon" href="{{ \App\Models\Setting::faviconUrl() }}">
    <link rel="apple-touch-icon" href="{{ \App\Models\Setting::faviconUrl() }}">

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    @if(($captchaProvider ?? '') === 'turnstile' && !empty($turnstileSiteKey))
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endif
    @if(($captchaProvider ?? '') === 'recaptcha' && !empty($recaptchaSiteKey))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    <style>
        :root {
            --primary: #065f46;
            --primary-dark: #064e3b;
            --primary-light: #10b981;
            --secondary: #fbbf24;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --bg-light: #f8fafc;
            --white: #ffffff;
            --border: #e2e8f0;
            --danger: #ef4444;
            --radius-md: 12px;
            --radius-lg: 20px;
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #064e3b 0%, #022c22 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle Islamic Arabesque overlay pattern */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0.04;
            background-image: url("https://www.transparenttextures.com/patterns/arabesque-thin.png");
            pointer-events: none;
        }

        .login-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 440px;
            padding: 40px 32px;
            box-shadow: var(--shadow-lg);
            position: relative;
            z-index: 10;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .brand-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-logo-emblem {
            width: 58px;
            height: 58px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--secondary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            box-shadow: 0 10px 20px rgba(6, 95, 70, 0.25);
            border: 2px solid var(--secondary);
        }

        .brand-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-dark);
            letter-spacing: -0.5px;
        }

        .brand-header p {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: var(--radius-md);
            font-size: 0.85rem;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            line-height: 1.4;
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            pointer-events: none;
            width: 18px;
            height: 18px;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            font-size: 0.92rem;
            font-family: inherit;
            color: var(--text-main);
            background: #f8fafc;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(6, 95, 70, 0.15);
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            color: #94a3b8;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .toggle-password:hover {
            color: var(--primary);
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            font-size: 0.85rem;
        }

        .remember-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--text-muted);
        }

        .remember-wrap input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        /* CAPTCHA Box */
        .captcha-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: var(--radius-md);
            padding: 14px;
            margin-bottom: 20px;
        }

        .captcha-math-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .captcha-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .captcha-math-question {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary-dark);
            letter-spacing: 1px;
            background: #ffffff;
            padding: 6px 14px;
            border-radius: 8px;
            border: 1px dashed #86efac;
            display: inline-block;
        }

        .btn-submit {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border: none;
            border-radius: var(--radius-md);
            font-size: 0.95rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(6, 95, 70, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(6, 95, 70, 0.4);
            background: linear-gradient(135deg, #047857 0%, var(--primary-dark) 100%);
        }

        .footer-note {
            text-align: center;
            margin-top: 24px;
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        /* Invisible Honeypot */
        .hp-field {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            height: 0;
            width: 0;
            z-index: -1;
            pointer-events: none;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand-header">
            @if(\App\Models\Setting::logoUrl())
                <div style="margin-bottom: 14px;">
                    <img src="{{ \App\Models\Setting::logoUrl() }}" alt="{{ \App\Models\Setting::siteName() }}" style="max-height: 64px; max-width: 180px; object-fit: contain; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));">
                </div>
            @else
                <div class="brand-logo-emblem">
                    <i data-feather="shield" style="width: 28px; height: 28px;"></i>
                </div>
            @endif
            <h1>Portal Administrator</h1>
            <p>{{ \App\Models\Setting::siteName() }} &bull; {{ \App\Models\Setting::siteTagline() }}</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i data-feather="check-circle" style="width: 18px; height: 18px; flex-shrink: 0;"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i data-feather="alert-triangle" style="width: 18px; height: 18px; flex-shrink: 0;"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <!-- Invisible Honeypot & Timestamp Trap -->
            <input type="text" name="_hp_name" class="hp-field" tabindex="-1" autocomplete="off">
            <input type="hidden" name="_hp_time" value="{{ time() }}">

            <div class="form-group">
                <label class="form-label" for="email">Alamat Email</label>
                <div class="input-group">
                    <i data-feather="mail" class="input-icon"></i>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="admin@sekolah.com">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-group">
                    <i data-feather="lock" class="input-icon"></i>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Masukkan password">
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility()" aria-label="Lihat Password">
                        <i data-feather="eye" id="passwordEyeIcon" style="width: 18px; height: 18px;"></i>
                    </button>
                </div>
            </div>

            <!-- CAPTCHA Section -->
            @if($captchaEnabled)
                @if($captchaProvider === 'builtin' && $mathCaptcha)
                    <div class="captcha-box">
                        <div class="captcha-math-header">
                            <span class="captcha-badge"><i data-feather="shield-check" style="width:14px; height:14px;"></i> Verifikasi Keamanan</span>
                            <span class="captcha-math-question">{{ $mathCaptcha['question'] }}</span>
                        </div>
                        <div class="input-group" style="margin-top: 8px;">
                            <i data-feather="check" class="input-icon"></i>
                            <input type="number" name="captcha_answer" class="form-control" required placeholder="Ketik hasil perhitungan di atas" style="background:#ffffff;">
                        </div>
                    </div>
                @elseif($captchaProvider === 'turnstile' && !empty($turnstileSiteKey))
                    <div style="margin-bottom: 20px; display: flex; justify-content: center;">
                        <div class="cf-turnstile" data-sitekey="{{ $turnstileSiteKey }}"></div>
                    </div>
                @elseif($captchaProvider === 'recaptcha' && !empty($recaptchaSiteKey))
                    <div style="margin-bottom: 20px; display: flex; justify-content: center;">
                        <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
                    </div>
                @endif
            @endif

            <div class="form-options">
                <label class="remember-wrap">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Ingat Saya</span>
                </label>
                <span style="color: #94a3b8; font-size: 0.8rem;">AES-256 Protected</span>
            </div>

            <button type="submit" class="btn-submit">
                <i data-feather="log-in" style="width: 18px; height: 18px;"></i> Masuk ke Dashboard
            </button>
        </form>

        <div class="footer-note">
            Dilindungi oleh OWASP Security Firewall &bull; &copy; {{ date('Y') }} {{ config('app.name', 'CMS Sekolah') }}
        </div>
    </div>

    <script>
        feather.replace();

        function togglePasswordVisibility() {
            const passInput = document.getElementById('password');
            const eyeIcon = document.getElementById('passwordEyeIcon');
            if (passInput.type === 'password') {
                passInput.type = 'text';
                eyeIcon.setAttribute('data-feather', 'eye-off');
            } else {
                passInput.type = 'password';
                eyeIcon.setAttribute('data-feather', 'eye');
            }
            feather.replace();
        }
    </script>
</body>
</html>
