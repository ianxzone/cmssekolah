<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Dibatasi | Security Firewall</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: rgba(30, 41, 59, 0.9);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 20px;
            max-width: 520px;
            width: 100%;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
        }
        .icon {
            width: 72px;
            height: 72px;
            background: rgba(239, 68, 68, 0.15);
            border: 2px solid #ef4444;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: #ef4444;
        }
        h1 { font-size: 1.75rem; font-weight: 800; margin-bottom: 12px; color: #ffffff; }
        p { font-size: 0.95rem; color: #94a3b8; line-height: 1.6; margin-bottom: 24px; }
        .meta-box {
            background: rgba(15, 23, 42, 0.6);
            border: 1px dashed rgba(148, 163, 184, 0.2);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.85rem;
            color: #cbd5e1;
            margin-bottom: 28px;
            word-break: break-all;
        }
        .btn {
            display: inline-block;
            background: #065f46;
            color: #ffffff;
            font-weight: 700;
            padding: 12px 28px;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: #047857;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">
            <svg width="36" height="36" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h1>403 - Akses Dibatasi</h1>
        <p>{{ $reason ?? 'Permintaan Anda diblokir oleh Sistem Keamanan Sekolah demi melindungi integritas website.' }}</p>
        <div class="meta-box">
            <div><strong>Alamat IP Anda:</strong> {{ $ip ?? request()->ip() }}</div>
            <div style="margin-top: 4px; font-size: 0.75rem; color: #64748b;">Ref: {{ date('Ymd-His') }} &bull; Security Firewall v1.0</div>
        </div>
        <a href="{{ url('/') }}" class="btn">&larr; Kembali ke Beranda</a>
    </div>
</body>
</html>
