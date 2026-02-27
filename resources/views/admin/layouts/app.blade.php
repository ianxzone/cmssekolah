<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Feather Icons for styling minimalist icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Admin CSS Styles -->
    <link href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <div class="overlay" id="mobile-overlay"></div>
    <div class="admin-layout">

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="brand">
                    <i data-feather="hexagon" class="brand-icon"></i>
                    <span class="brand-text">Admin Panel</span>
                </div>
                <button class="menu-toggle" id="menu-toggle-btn">
                    <i data-feather="menu"></i>
                </button>
                <button class="collapse-toggle" id="sidebar-collapse-btn" title="Collapse Sidebar">
                    <i data-feather="chevron-left"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-feather="grid"></i>
                    <span>Dashboard</span>
                </a>

                <div class="nav-section">CONTENT MANAGEMENT</div>

                <a href="{{ route('admin.pages.index') }}"
                    class="nav-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                    <i data-feather="file-text"></i>
                    <span>Pages</span>
                </a>

                <a href="{{ route('admin.posts.index') }}"
                    class="nav-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                    <i data-feather="edit-3"></i>
                    <span>Posts</span>
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i data-feather="folder"></i>
                    <span>Categories</span>
                </a>

                <a href="{{ route('admin.media.index') }}"
                    class="nav-item {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                    <i data-feather="image"></i>
                    <span>Media Manager</span>
                </a>

                <a href="{{ route('admin.events.index') }}"
                    class="nav-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                    <i data-feather="calendar"></i>
                    <span>Events</span>
                </a>

                <div class="nav-section">DATA COLLECTION</div>

                <a href="{{ route('admin.forms.index') }}"
                    class="nav-item {{ request()->routeIs('admin.forms.*') ? 'active' : '' }}">
                    <i data-feather="inbox"></i>
                    <span>Forms</span>
                </a>

                <a href="{{ route('admin.testimonials.index') }}"
                    class="nav-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                    <i data-feather="message-square"></i>
                    <span>Testimonials</span>
                </a>

                <div class="nav-section">SYSTEM</div>

                <a href="{{ route('admin.settings.index') }}"
                    class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i data-feather="settings"></i>
                    <span>Settings</span>
                </a>

                <a href="{{ route('admin.about') }}"
                    class="nav-item {{ request()->routeIs('admin.about') ? 'active' : '' }}">
                    <i data-feather="info"></i>
                    <span>Tentang CMS</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <form method="POST" action="{{ url('/logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i data-feather="log-out"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Topbar Custom -->
            <header class="topbar">
                <div class="topbar-left">
                    <h1 class="page-title">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="topbar-right">
                    <div class="user-profile">
                        <div class="avatar">
                            {{ substr(Auth::user()->name ?? 'Admin', 0, 1) }}
                        </div>
                        <span class="user-name">{{ Auth::user()->name ?? 'Administrator' }}</span>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content Area -->
            <div class="content-area">
                @if (session('success'))
                    <div class="alert alert-success">
                        <i data-feather="check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        <i data-feather="alert-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Initialize Icons -->
    <script>
        feather.replace();

        // Responsive Mobile Sidebar Logic
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');
        const toggleBtn = document.getElementById('menu-toggle-btn');
        const body = document.body;

        function toggleSidebar() {
            sidebar.classList.toggle('open');
            if (sidebar.classList.contains('open')) {
                overlay.classList.add('active');
                body.style.overflow = 'hidden'; // Prevent background scrolling
            } else {
                overlay.classList.remove('active');
                body.style.overflow = '';
            }
        }

        // Desktop Sidebar Collapse Logic
        const collapseBtn = document.getElementById('sidebar-collapse-btn');
        const sidebarBrand = document.querySelector('.sidebar .brand');

        // Load sidebar state from localStorage
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            body.classList.add('sidebar-collapsed');
            updateCollapseIcon();
        }

        function toggleSidebarCollapse() {
            body.classList.toggle('sidebar-collapsed');
            const isCollapsed = body.classList.contains('sidebar-collapsed');
            localStorage.setItem('sidebar-collapsed', isCollapsed);
            updateCollapseIcon();
        }

        function updateCollapseIcon() {
            const isCollapsed = body.classList.contains('sidebar-collapsed');
            collapseBtn.innerHTML = isCollapsed ?
                '<i data-feather="chevron-right"></i>' :
                '<i data-feather="chevron-left"></i>';
            feather.replace();
        }

        collapseBtn.addEventListener('click', toggleSidebarCollapse);

        // Also allow clicking the brand icon to expand when collapsed
        sidebarBrand.addEventListener('click', () => {
            if (body.classList.contains('sidebar-collapsed')) {
                toggleSidebarCollapse();
            }
        });

        toggleBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Auto-close Alerts after 3 seconds for Joyful UI
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 400);
                });
            }, 3000);
        });
    </script>
    @stack('scripts')
</body>

</html>