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
        <a href="/" class="logo">
            <div class="logo-emblem">
                <span>LPP</span>
            </div>
            <div class="logo-text">
                <h1>LPP AL IRSYAD</h1>
                <p>LAJNAH PENDIDIKAN & PENGAJARAN</p>
            </div>
        </a>
        <ul class="nav-menu" id="navMenu">
            @php
                $navLinks = json_decode($settings['navbar_links'] ?? '[]', true);
                if (empty($navLinks)) {
                    $navLinks = [
                        ['label' => 'Beranda', 'url' => '/'],
                        ['label' => 'Ketua LPP', 'url' => '/#welcome'],
                        ['label' => 'Unit Pendidikan', 'url' => '/#unit-pendidikan'],
                        ['label' => 'Kurikulum Khas', 'url' => '/#kurikulum-khas'],
                        ['label' => 'Fasilitas', 'url' => '/#programs'],
                        ['label' => 'Berita', 'url' => route('posts.index')]
                    ];
                }
            @endphp
            @foreach($navLinks as $link)
                <li><a href="{{ $link['url'] }}" class="nav-link">{{ $link['label'] }}</a></li>
            @endforeach
            <li><a href="{{ $settings['contact_ppdb_link'] ?? '#' }}" class="nav-spmb">SPMB Online</a></li>
        </ul>
        <div class="mobile-toggle" onclick="toggleMenu()">
            <i data-feather="menu"></i>
        </div>
    </div>
</nav>
