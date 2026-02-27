<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - CMS Sekolah by MATEK</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/setup.css') }}">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        :root {
            --primary: #4f46e5;
            --accent: #7c3aed;
        }

        body {
            background: radial-gradient(circle at top right, #eef2ff 0%, #f8fafc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-logo img {
            height: 60px;
            margin-bottom: 15px;
        }

        .login-logo h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            letter-spacing: -0.02em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #64748b;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #94a3b8;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px 12px 48px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-family: inherit;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.4);
        }

        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-logo">
            <img src="{{ asset('images/matek-logo.png') }}"
                onerror="this.src='https://via.placeholder.com/100?text=MATEK'" alt="MATEK Logo">
            <h2>Portal Admin</h2>
        </div>

        @if ($errors->any())
            <div class="error-message">
                <i data-feather="alert-circle" style="width: 16px;"></i>
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

        <div style="margin-top: 30px; text-align: center;">
            <a href="{{ url('/') }}" style="color: #64748b; font-size: 0.875rem; text-decoration: none;">
                <i data-feather="home" style="width: 14px; vertical-align: middle; margin-right: 4px;"></i> Kembali ke
                Beranda
            </a>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</body>

</html>