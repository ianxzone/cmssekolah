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
        <a href="/" class="logo">
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
                $navLinks = json_decode($settings['navbar_links'] ?? '[]', true);
                if (empty($navLinks)) {
                    $navLinks = [
                        ['label' => 'Beranda', 'url' => '/'],
                        ['label' => 'Unit Pendidikan', 'url' => '/#unit-pendidikan'],
                        ['label' => 'Kurikulum Khas', 'url' => '/#kurikulum-khas'],
                        ['label' => 'Fasilitas', 'url' => '/#programs'],
                        ['label' => 'Blog', 'url' => route('posts.index')]
                    ];
                }
                // Filter out any lingering 'Ketua LPP' items
                $navLinks = array_filter($navLinks, function($l) {
                    $lbl = strtolower($l['label'] ?? '');
                    return !str_contains($lbl, 'ketua') && ($l['url'] ?? '') !== '/#welcome' && ($l['url'] ?? '') !== '#welcome';
                });
            @endphp
            @foreach($navLinks as $link)
                <li><a href="{{ $link['url'] }}" class="nav-link">{{ $link['label'] }}</a></li>
            @endforeach
            <li><a href="{{ route('alumni.index') }}" class="nav-link">Alumni</a></li>
            <li><a href="{{ $settings['contact_ppdb_link'] ?? '#' }}" class="nav-spmb">SPMB Online</a></li>
        </ul>
        <div class="mobile-toggle" onclick="toggleMenu()">
            <i data-feather="menu"></i>
        </div>
    </div>
</nav>
