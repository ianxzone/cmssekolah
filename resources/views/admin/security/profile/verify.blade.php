<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi 2FA | {{ \App\Models\Setting::siteName() }}</title>
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        :root {
            --primary: #059669;
            --primary-dark: #047857;
            --secondary: #0f172a;
            --bg-color: #f1f5f9;
            --white: #ffffff;
            --text-main: #334155;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --radius-md: 10px;
            --radius-lg: 16px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: var(--text-main);
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .login-card {
            background: var(--white);
            width: 100%;
            max-width: 420px;
            padding: 40px;
            border-radius: var(--radius-lg);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            border: 1px solid rgba(255, 255, 255, 0.8);
            position: relative;
            z-index: 10;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-logo-emblem {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 4px 10px rgba(5, 150, 105, 0.2);
        }

        .brand-header h1 {
            font-size: 1.4rem;
            color: var(--secondary);
            margin: 0 0 6px 0;
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        .brand-header p {
            color: var(--text-muted);
            margin: 0;
            font-size: 0.85rem;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 0.85rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            line-height: 1.5;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--secondary);
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            font-size: 1.1rem;
            font-family: inherit;
            color: var(--secondary);
            background: #f8fafc;
            transition: all 0.2s ease;
            box-sizing: border-box;
            text-align: center;
            letter-spacing: 2px;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
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
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand-header">
            <div class="brand-logo-emblem" style="background: #0f172a; box-shadow: 0 4px 10px rgba(15,23,42,0.2);">
                <i data-feather="lock" style="width: 28px; height: 28px;"></i>
            </div>
            <h1>Autentikasi 2 Langkah</h1>
            <p>Masukkan kode OTP dari aplikasi Authenticator Anda</p>
        </div>

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

        <form action="{{ route('admin.2fa.verify.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="otp">Kode 6 Digit</label>
                <input type="text" id="otp" name="otp" class="form-control" required autofocus autocomplete="off" placeholder="123456" maxlength="6">
            </div>

            <button type="submit" class="btn-submit" style="margin-bottom: 1rem;">
                Verifikasi
            </button>
        </form>

        <form action="{{ route('admin.logout') }}" method="POST" style="text-align: center;">
            @csrf
            <button type="submit" style="background: none; border: none; color: #64748b; text-decoration: underline; cursor: pointer; font-size: 0.85rem;">
                Batalkan & Logout
            </button>
        </form>
    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>
