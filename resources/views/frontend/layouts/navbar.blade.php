<!-- 1. TOPBAR -->
<div class="topbar">
    <div class="container">
        <div class="topbar-info">
            <div><i data-feather="phone" style="width: 14px;"></i> {{ $settings['contact_phone'] ?? '(0267) 1234-567' }}</div>
            <div><i data-feather="mail" style="width: 14px;"></i> {{ $settings['contact_email'] ?? 'info@alirsyadkarawang.sch.id' }}</div>
        </div>
        <div>Jam Operasional: {{ $settings['contact_hours'] ?? 'Senin - Jumat (07:00 - 15:30)' }}</div>
    </div>
</div>

<!-- 2. NAVBAR -->
<nav class="navbar" id="mainNavbar">
    <div class="container">
        @php
            $siteLogo = \App\Models\Setting::logoUrl();
            $siteName = \App\Models\Setting::siteName();
            $siteTagline = \App\Models\Setting::siteTagline();
            $siteIconText = \App\Models\Setting::siteIconText();
        @endphp
        <a href="{{ url('/') }}" class="logo">
            @if(!empty($siteLogo))
                <img src="{{ $siteLogo }}" alt="{{ $siteName }}" style="max-height: 48px; width: auto; object-fit: contain;">
            @else
                <div class="logo-emblem">
                    <span>{{ $siteIconText }}</span>
                </div>
            @endif
            <div class="logo-text">
                <h1>{{ $siteName }}</h1>
                <p>{{ $siteTagline }}</p>
            </div>
        </a>
        <ul class="nav-menu" id="navMenu">
            @php
                $isHome = request()->routeIs('home') || request()->is('/');

                $navLinks = json_decode($settings['navbar_links'] ?? '[]', true);
                if (empty($navLinks)) {
                    $navLinks = [
                        ['label' => 'Beranda', 'url' => '/'],
                        ['label' => 'Unit Pendidikan', 'url' => '#unit-pendidikan'],
                        ['label' => 'Kurikulum Khas', 'url' => '#kurikulum-khas'],
                        ['label' => 'Fasilitas', 'url' => '#programs'],
                        ['label' => 'Blog', 'url' => route('posts.index')]
                    ];
                }

                // Filter out any lingering 'Ketua LPP' items or obsolete welcome anchors
                $navLinks = array_filter($navLinks, function($l) {
                    $lbl = strtolower($l['label'] ?? '');
                    return !str_contains($lbl, 'ketua') && ($l['url'] ?? '') !== '/#welcome' && ($l['url'] ?? '') !== '#welcome';
                });

                // Contextual URL resolution: on Homepage use anchors (#), on other pages direct to dedicated routes
                $resolveItem = function($item) use ($isHome) {
                    $rawUrl = trim($item['url'] ?? '');
                    $label = strtolower(trim($item['label'] ?? ''));

                    $isBeranda = $label === 'beranda' || $rawUrl === '/' || $rawUrl === url('/');
                    $isUnit = str_contains($label, 'unit') || str_contains($rawUrl, 'unit-pendidikan');
                    $isKurikulum = str_contains($label, 'kurikulum') || str_contains($rawUrl, 'kurikulum');
                    $isFasilitas = str_contains($label, 'fasilitas') || str_contains($rawUrl, 'programs') || str_contains($rawUrl, 'fasilitas');
                    $isBlog = str_contains($label, 'blog') || str_contains($label, 'berita') || str_contains($rawUrl, 'blog') || str_contains($rawUrl, 'berita');
                    $isAlumni = str_contains($label, 'alumni') || str_contains($rawUrl, 'alumni');
                    $isEkskul = str_contains($label, 'ekstrakurikuler') || str_contains($label, 'ekskul') || str_contains($rawUrl, 'ekskul') || str_contains($rawUrl, 'ekstrakurikuler');
                    $isPartnership = str_contains($label, 'partnership') || str_contains($label, 'kerjasama') || str_contains($rawUrl, 'partnership');

                    if ($isHome) {
                        // DI BERANDA: Gunakan tanda pagar (#) agar smooth scroll ke header section yang sesuai
                        if ($isBeranda) return ['url' => url('/'), 'active' => true];
                        if ($isUnit) return ['url' => '#unit-pendidikan', 'active' => false];
                        if ($isKurikulum) return ['url' => '#kurikulum-khas', 'active' => false];
                        if ($isFasilitas) return ['url' => '#programs', 'active' => false];
                        if ($isBlog) return ['url' => route('posts.index'), 'active' => false];
                        if ($isAlumni) return ['url' => route('alumni.index'), 'active' => false];
                        if ($isEkskul) return ['url' => '#programs', 'active' => false];
                        if ($isPartnership) return ['url' => '#partnership', 'active' => false];

                        if (str_starts_with($rawUrl, '/#')) {
                            return ['url' => substr($rawUrl, 1), 'active' => false];
                        }
                        return ['url' => $rawUrl, 'active' => false];
                    } else {
                        // DI HALAMAN LAIN: Langsung ke link halaman terkait tanpa tanda pagar (#)
                        if ($isBeranda) return ['url' => url('/'), 'active' => false];
                        if ($isUnit) return ['url' => url('/#unit-pendidikan'), 'active' => false];
                        if ($isKurikulum) return ['url' => route('kurikulum.index'), 'active' => request()->routeIs('kurikulum.*') || request()->is('kurikulum*')];
                        if ($isFasilitas) return ['url' => route('fasilitas.index'), 'active' => request()->routeIs('fasilitas.*') || request()->is('fasilitas*')];
                        if ($isBlog) return ['url' => route('posts.index'), 'active' => request()->routeIs('posts.*') || request()->is('blog*') || request()->is('post/*') || request()->is('category/*')];
                        if ($isAlumni) return ['url' => route('alumni.index'), 'active' => request()->routeIs('alumni.*') || request()->is('alumni*')];
                        if ($isEkskul) return ['url' => route('ekskul.index'), 'active' => request()->routeIs('ekskul.*') || request()->is('ekstrakurikuler*')];
                        if ($isPartnership) return ['url' => url('/#partnership'), 'active' => false];

                        if (str_starts_with($rawUrl, '#')) {
                            return ['url' => url('/' . $rawUrl), 'active' => false];
                        }
                        $isActive = request()->url() === $rawUrl || request()->is(trim($rawUrl, '/'));
                        return ['url' => $rawUrl, 'active' => $isActive];
                    }
                };

                $hasAlumniInLinks = false;
                foreach ($navLinks as $l) {
                    if (str_contains(strtolower($l['label'] ?? ''), 'alumni')) {
                        $hasAlumniInLinks = true;
                        break;
                    }
                }
            @endphp

            @foreach($navLinks as $link)
                @php
                    $resolved = $resolveItem($link);
                @endphp
                <li>
                    <a href="{{ $resolved['url'] }}" class="nav-link {{ $resolved['active'] ? 'active' : '' }}">
                        {{ $link['label'] }}
                    </a>
                </li>
            @endforeach

            @if(!$hasAlumniInLinks)
                @php
                    $isAlumniActive = request()->routeIs('alumni.*') || request()->is('alumni*');
                @endphp
                <li>
                    <a href="{{ route('alumni.index') }}" class="nav-link {{ $isAlumniActive ? 'active' : '' }}">Alumni</a>
                </li>
            @endif

            <li><a href="{{ $settings['contact_ppdb_link'] ?? '#' }}" class="nav-spmb">SPMB Online</a></li>
        </ul>
        <div class="mobile-toggle" onclick="toggleMenu()">
            <i data-feather="menu"></i>
        </div>
    </div>
</nav>
