<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Dynamic SEO Meta Tags -->
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <meta name="description"
        content="@yield('meta_description', 'Welcome to our platform. Read the latest updates and submit your forms securely.')">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --bg-body: #f9fafb;
            --bg-surface: #ffffff;
            --border-color: #e5e7eb;
            --container-width: 1100px;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Navbar */
        .navbar {
            background-color: var(--bg-surface);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .container {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 4rem;
        }

        .brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-secondary);
            transition: color 0.15s ease;
        }

        .nav-link:hover {
            color: var(--primary-color);
        }

        /* Main Area */
        main {
            flex-grow: 1;
            padding: 3rem 0;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Footer */
        footer {
            background-color: var(--bg-surface);
            border-top: 1px solid var(--border-color);
            padding: 2rem 0;
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        /* UI Utilities */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: var(--radius-md);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-outline {
            background-color: transparent;
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .btn-outline:hover {
            background-color: var(--bg-body);
        }

        /* Alert Notifications */
        .alert {
            padding: 1rem;
            border-radius: var(--radius-md);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-content {
                flex-direction: column;
                height: auto;
                padding: 1rem 0;
                gap: 1rem;
            }

            main {
                padding: 2rem 0;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <nav class="navbar">
        <div class="container nav-content">
            <a href="{{ route('home') }}" class="brand">
                <i data-feather="hexagon"></i>
                {{ config('app.name', 'My Website') }}
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link">Home / Blog</a>
                <a href="{{ url('/admin') }}" class="nav-link">Admin Login</a>
            </div>
        </div>
    </nav>

    <main class="container">
        @if (session('success'))
            <div class="alert alert-success" id="flash-message">
                <i data-feather="check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <div class="container">
            &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
        </div>
    </footer>

    <script>
        feather.replace();

        // Auto dismiss alert
        setTimeout(() => {
            const alert = document.getElementById('flash-message');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 500);
            }
        }, 4000);
    </script>
    @stack('scripts')
</body>

</html>