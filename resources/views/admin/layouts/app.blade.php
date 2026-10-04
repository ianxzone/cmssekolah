<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ \App\Models\Setting::siteName() }}</title>

    <!-- Dynamic Favicon -->
    <link rel="icon" type="image/png" href="{{ \App\Models\Setting::faviconUrl() }}">
    <link rel="shortcut icon" href="{{ \App\Models\Setting::faviconUrl() }}">
    <link rel="apple-touch-icon" href="{{ \App\Models\Setting::faviconUrl() }}">

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
                <a href="{{ route('admin.dashboard') }}" class="brand" title="{{ \App\Models\Setting::siteName() }}">
                    @if(\App\Models\Setting::logoUrl())
                        <img src="{{ \App\Models\Setting::logoUrl() }}" alt="Logo" class="brand-logo">
                    @else
                        <i data-feather="hexagon" class="brand-icon"></i>
                    @endif
                    <div class="brand-text">
                        <span class="brand-title">{{ \App\Models\Setting::siteName() }}</span>
                        <span class="brand-subtitle">Admin Console</span>
                    </div>
                </a>
                <button class="menu-toggle" id="menu-toggle-btn" aria-label="Tutup Menu">
                    <i data-feather="x"></i>
                </button>
                <button class="collapse-toggle" id="sidebar-collapse-btn" title="Collapse Sidebar" aria-label="Collapse Sidebar">
                    <i data-feather="chevron-left"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard">
                    <i data-feather="grid"></i>
                    <span>Dashboard</span>
                </a>

                <div class="nav-section">CONTENT MANAGEMENT</div>

                @if(auth()->user()->isEditor())
                <a href="{{ route('admin.pages.index') }}"
                    class="nav-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" title="Pages">
                    <i data-feather="file-text"></i>
                    <span>Pages</span>
                </a>

                <a href="{{ route('admin.biolink.index') }}"
                    class="nav-item {{ request()->routeIs('admin.biolink.*') ? 'active' : '' }}" title="Biolink Manager">
                    <i data-feather="share-2"></i>
                    <span>Biolink Manager</span>
                </a>
                @endif

                <a href="{{ route('admin.posts.index') }}"
                    class="nav-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}" title="Posts">
                    <i data-feather="edit-3"></i>
                    <span>Posts</span>
                </a>

                @if(auth()->user()->isEditor())
                <a href="{{ route('admin.comments.index') }}"
                    class="nav-item {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}" title="Komentar">
                    <i data-feather="message-circle"></i>
                    <span>Komentar</span>
                    @php
                        $pendingCommentsCount = \App\Models\PostComment::where('status', 'pending')->count();
                    @endphp
                    @if($pendingCommentsCount > 0)
                        <span class="badge-count">
                            {{ $pendingCommentsCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" title="Categories">
                    <i data-feather="folder"></i>
                    <span>Categories</span>
                </a>
                @endif

                <a href="{{ route('admin.media.index') }}"
                    class="nav-item {{ request()->routeIs('admin.media.*') ? 'active' : '' }}" title="Media Manager">
                    <i data-feather="image"></i>
                    <span>Media Manager</span>
                </a>

                @if(auth()->user()->isEditor())
                <a href="{{ route('admin.events.index') }}"
                    class="nav-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" title="Events">
                    <i data-feather="calendar"></i>
                    <span>Events</span>
                </a>

                <a href="{{ route('admin.teachers.index') }}"
                    class="nav-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}" title="Data SDM & Pimpinan">
                    <i data-feather="users"></i>
                    <span>Data SDM & Pimpinan</span>
                </a>

                <a href="{{ route('admin.alumni.index') }}"
                    class="nav-item {{ request()->routeIs('admin.alumni.*') ? 'active' : '' }}" title="Alumni">
                    <i data-feather="award"></i>
                    <span>Alumni</span>
                </a>
                @endif

                @if(auth()->user()->isAdmin())
                <div class="nav-section">DATA COLLECTION</div>

                <a href="{{ route('admin.guestbook.index') }}"
                    class="nav-item {{ request()->routeIs('admin.guestbook.*') ? 'active' : '' }}" title="Buku Tamu">
                    <i data-feather="book-open"></i>
                    <span>Buku Tamu</span>
                </a>

                <a href="{{ route('admin.forms.index') }}"
                    class="nav-item {{ request()->routeIs('admin.forms.*') ? 'active' : '' }}" title="Forms">
                    <i data-feather="inbox"></i>
                    <span>Forms</span>
                </a>
                @endif

                @if(auth()->user()->isEditor())
                <a href="{{ route('admin.testimonials.index') }}"
                    class="nav-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}" title="Testimonials">
                    <i data-feather="message-square"></i>
                    <span>Testimonials</span>
                </a>
                @endif

                @if(auth()->user()->isAdmin())
                <div class="nav-section">SYSTEM</div>

                <a href="{{ route('admin.wordpress-import.index') }}"
                    class="nav-item {{ request()->routeIs('admin.wordpress-import.*') ? 'active' : '' }}" title="Import WordPress">
                    <i data-feather="download-cloud"></i>
                    <span>Import WordPress</span>
                </a>

                <a href="{{ route('admin.rankmath-import.index') }}"
                    class="nav-item {{ request()->routeIs('admin.rankmath-import.*') ? 'active' : '' }}" title="Import Rank Math">
                    <i data-feather="zap"></i>
                    <span>Import Rank Math</span>
                </a>

                <a href="{{ route('admin.redirects.index') }}"
                    class="nav-item {{ request()->routeIs('admin.redirects.*') ? 'active' : '' }}" title="Redirections (SEO)">
                    <i data-feather="corner-up-right"></i>
                    <span>Redirections (SEO)</span>
                </a>

                <a href="{{ route('admin.settings.index') }}"
                    class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" title="Settings">
                    <i data-feather="settings"></i>
                    <span>Settings</span>
                </a>

                <a href="{{ route('admin.security.index') }}"
                    class="nav-item {{ request()->routeIs('admin.security.*') ? 'active' : '' }}" title="Security Center">
                    <i data-feather="shield"></i>
                    <span>Security Center</span>
                </a>
                @endif
            </nav>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn" title="Logout">
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
                    <button type="button" class="topbar-menu-toggle" id="topbar-menu-toggle-btn" title="Buka Navigasi" aria-label="Buka Menu">
                        <i data-feather="menu"></i>
                    </button>
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

        if (toggleBtn) {
            toggleBtn.addEventListener('click', toggleSidebar);
        }
        const topbarToggleBtn = document.getElementById('topbar-menu-toggle-btn');
        if (topbarToggleBtn) {
            topbarToggleBtn.addEventListener('click', toggleSidebar);
        }
        if (overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }

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
    {{-- WordPress-Style Link Insert & Edit Modal for Trix Editors --}}
    @include('admin.partials.link-modal')

    @stack('scripts')
</body>

</html>