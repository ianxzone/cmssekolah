<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ $settings['school_name'] ?? config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        :root {
            --primary:
                {{ $settings['theme_color_primary'] ?? '#4f46e5' }}
            ;
            --primary-dark: color-mix(in srgb, var(--primary) 80%, black);
            --bg-light: #f8fafc;
            --text-main: #1f2937;
            --text-muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
            padding: 20px;
        }

        .error-container {
            max-width: 500px;
            width: 100%;
        }

        .error-code {
            font-size: 8rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 10px;
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            opacity: 0.15;
            position: absolute;
            left: 50%;
            top: 45%;
            transform: translate(-50%, -50%);
            z-index: -1;
        }

        .error-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 30px;
            background: white;
            color: var(--primary);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 15px;
            color: var(--text-main);
        }

        p {
            font-size: 1.1rem;
            color: var(--text-muted);
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--primary);
            color: white;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.4);
            background: var(--primary-dark);
        }

        .logo {
            margin-bottom: 50px;
        }

        .logo img {
            height: 45px;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-code">@yield('code')</div>

        <div class="logo">
            @if(isset($settings['school_logo']) && $settings['school_logo'])
                <img src="{{ \Illuminate\Support\Facades\Storage::url($settings['school_logo']) }}" alt="Logo">
            @else
                <h1 style="font-weight: 800; color: var(--primary);">{{ $settings['school_name'] ?? config('app.name') }}
                </h1>
            @endif
        </div>

        <div class="error-icon">
            <i data-feather="@yield('icon', 'alert-circle')" style="width: 40px; height: 40px;"></i>
        </div>

        <h2>@yield('heading')</h2>
        <p>@yield('message')</p>

        <a href="{{ url('/') }}" class="btn">
            <i data-feather="home" style="width: 18px;"></i>
            Kembali ke Beranda
        </a>
    </div>

    <script>
        feather.replace();
    </script>
</body>

</html>