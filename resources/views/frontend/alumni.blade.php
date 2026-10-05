<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $siteName = config('app.name', 'Lajnah Pendidikan dan Pengajaran Al Irsyad Al Islamiyyah Karawang');
        $pageTitle = ($settings['alumni_hero_title'] ?? 'Jejak Prestasi Alumni') . ' - ' . $siteName;
        $metaDesc = $settings['alumni_hero_description'] ?? 'Melihat keberhasilan lulusan Lajnah Pendidikan Al Irsyad Karawang di berbagai PTN, PTLN, dan PTS favorit dari tahun ke tahun.';
    @endphp
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ strip_tags($metaDesc) }}">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ strip_tags($metaDesc) }}">
    <meta property="og:image" content="https://www.alirsyad.sch.id/wp-content/uploads/2026/02/og-image-alumni.jpg">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ \App\Models\Setting::faviconUrl() }}">
    <link rel="shortcut icon" href="{{ \App\Models\Setting::faviconUrl() }}">
    <link rel="apple-touch-icon" href="{{ \App\Models\Setting::faviconUrl() }}">

    @include('partials.analytics')

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-green: #1b4d3e;
            --secondary-gold: #c5a059;
            --accent-yellow: #fcc419;
            --whatsapp-green: #25D366;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }

        .font-amiri {
            font-family: 'Amiri', serif;
        }

        .islamic-pattern {
            background-image: url("https://www.transparenttextures.com/patterns/arabesque-thin.png");
        }

        .card-shadow {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .gradient-green {
            background: linear-gradient(135deg, #1b4d3e 0%, #2d7a63 100%);
        }

        .tab-btn.active {
            background-color: var(--primary-green);
            color: white;
            border-color: var(--primary-green);
            box-shadow: 0 4px 12px rgba(27, 77, 62, 0.2);
        }

        .float-wa {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: var(--whatsapp-green);
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .float-wa:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 2px 6px 16px rgba(37, 211, 102, 0.4);
        }

        #mobile-menu {
            transition: all 0.3s ease-in-out;
            max-height: 0;
            overflow: hidden;
        }

        #mobile-menu.open {
            max-height: 500px;
            padding: 1rem 0;
        }

        /* Modal Styles */
        #imageModal {
            transition: opacity 0.3s ease;
            opacity: 0;
        }

        #imageModal.show {
            opacity: 1;
        }

        .modal-content-wrapper {
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        #imageModal.show .modal-content-wrapper {
            transform: scale(1);
        }
    </style>
</head>

<body class="text-gray-800">

    @php
        $waNumber = preg_replace('/[^0-9]/', '', $settings['contact_whatsapp'] ?? '62895708351313');
        if (str_starts_with($waNumber, '0')) {
            $waNumber = '62' . substr($waNumber, 1);
        }

        $alumniNavLinks = json_decode($settings['alumni_navbar_links'] ?? '[]', true);
        if (empty($alumniNavLinks)) {
            $alumniNavLinks = [
                ['label' => 'Beranda', 'url' => url('/')],
                ['label' => 'Profil', 'url' => url('/#welcome')],
                ['label' => 'Berita', 'url' => route('posts.index')],
                ['label' => 'Alumni', 'url' => route('alumni.index'), 'active' => true],
            ];
        }
        $alumniNavLinks = array_filter($alumniNavLinks, fn($l) => !str_contains(strtolower($l['label'] ?? ''), 'ketua lpp'));

        $ctaText = $settings['alumni_cta_text'] ?? 'PPDB Online';
        $ctaUrl = $settings['alumni_cta_url'] ?? ($settings['contact_ppdb_link'] ?? 'https://smart.alirsyad.sch.id/pendaftaran');
    @endphp

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/{{ $waNumber }}" class="float-wa" target="_blank" title="Hubungi Kami via WhatsApp">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
        </svg>
    </a>

    <!-- Header / Navbar -->
    <nav class="bg-white border-b sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ url('/') }}" class="flex items-center space-x-3 md:space-x-4">
                    <img src="{{ \App\Models\Setting::logoUrl() }}" alt="{{ \App\Models\Setting::siteName() }}" class="h-10 md:h-14 w-auto drop-shadow-sm">
                    <div class="border-l-2 border-emerald-100 pl-3 md:pl-4">
                        <span class="block text-sm md:text-lg font-bold text-emerald-900 leading-tight">{{ $settings['alumni_brand_title'] ?? \App\Models\Setting::siteName() }}</span>
                        <span class="block text-[8px] md:text-[10px] text-emerald-600 font-bold uppercase tracking-wider md:tracking-[0.15em] mt-0.5">{{ $settings['alumni_brand_subtitle'] ?? \App\Models\Setting::siteTagline() }}</span>
                    </div>
                </a>

                <!-- Burger Button (Mobile Only) -->
                <div class="md:hidden">
                    <button id="menu-toggle" class="text-emerald-900 focus:outline-none p-2" aria-label="Buka Menu">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8 font-semibold">
                    @foreach($alumniNavLinks as $link)
                        @php
                            $isActive = !empty($link['active']) || strtolower(trim($link['label'] ?? '')) === 'alumni';
                        @endphp
                        @if($isActive)
                            <a href="{{ $link['url'] }}" class="text-emerald-700 border-b-2 border-emerald-700 pb-1">{{ $link['label'] }}</a>
                        @else
                            <a href="{{ $link['url'] }}" class="text-gray-600 hover:text-emerald-700 transition">{{ $link['label'] }}</a>
                        @endif
                    @endforeach
                    @if($ctaText)
                        <a href="{{ $ctaUrl }}" class="bg-emerald-700 text-white px-6 py-2.5 rounded-full hover:bg-emerald-800 transition shadow-md">{{ $ctaText }}</a>
                    @endif
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div id="mobile-menu" class="md:hidden bg-white border-t border-gray-100 flex flex-col space-y-4 px-2">
                @foreach($alumniNavLinks as $link)
                    @php
                        $isActive = !empty($link['active']) || strtolower(trim($link['label'] ?? '')) === 'alumni';
                    @endphp
                    @if($isActive)
                        <a href="{{ $link['url'] }}" class="text-emerald-700 font-bold px-4 py-2 bg-emerald-50 rounded-lg">{{ $link['label'] }}</a>
                    @else
                        <a href="{{ $link['url'] }}" class="text-gray-700 font-semibold px-4 py-2 hover:bg-emerald-50 rounded-lg transition">{{ $link['label'] }}</a>
                    @endif
                @endforeach
                @if($ctaText)
                    <a href="{{ $ctaUrl }}" class="bg-emerald-700 text-white px-4 py-3 rounded-xl font-bold text-center shadow-lg mx-4 mb-4">{{ $ctaText }}</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section (Full Width) -->
    <header class="w-full gradient-green text-white py-24 relative overflow-hidden islamic-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-yellow-400 font-amiri text-2xl md:text-3xl mb-3 italic">
                {{ $settings['alumni_hero_subtitle'] ?? 'Barakallah, Selamat & Sukses' }}
            </h2>
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6 tracking-tight">
                {{ $settings['alumni_hero_title'] ?? 'Jejak Prestasi Alumni' }}
            </h1>
            @php
                $heroDesc = $settings['alumni_hero_description'] ?? '';
                $defaultDesc = 'Keberhasilan lulusan yang tersebar di Perguruan Tinggi unggulan dalam dan luar negeri.';
            @endphp
            @if(empty($heroDesc) || $heroDesc === $defaultDesc)
                <p class="text-emerald-50 text-lg md:text-xl max-w-3xl mx-auto opacity-90 leading-relaxed">
                    Keberhasilan lulusan SMA Islam Teladan Al Irsyad Al Islamiyyah Karawang yang
                    <span class="font-semibold text-white underline decoration-yellow-500 underline-offset-4">tersebar di Perguruan Tinggi unggulan dalam dan luar negeri.</span>
                </p>
            @else
                <p class="text-emerald-50 text-lg md:text-xl max-w-3xl mx-auto opacity-90 leading-relaxed">
                    {!! nl2br(e($heroDesc)) !!}
                </p>
            @endif
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-gray-50 to-transparent"></div>
    </header>

    <!-- Talkshow Section -->
    @if(isset($videos) && $videos->count() > 0)
        @php $mainVideo = $videos->first(); @endphp
        <section class="max-w-5xl mx-auto px-4 -mt-16 relative z-20 mb-20">
            <div class="bg-white rounded-3xl shadow-2xl p-4 md:p-10 border border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                    <div class="border-l-4 border-emerald-600 pl-4">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $mainVideo->judul }}</h3>
                        @if($mainVideo->deskripsi)
                            <p class="text-gray-500 text-sm">{{ $mainVideo->deskripsi }}</p>
                        @endif
                    </div>
                    <a href="{{ $mainVideo->youtube_url }}" target="_blank"
                        class="inline-flex items-center text-red-600 font-bold hover:underline">
                        Lihat di YouTube
                    </a>
                </div>
                <div class="aspect-video rounded-2xl overflow-hidden bg-black shadow-inner">
                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $mainVideo->youtube_embed_id }}"
                        title="{{ $mainVideo->judul }}" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>

                @if($videos->count() > 1)
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <h4 class="text-sm font-bold text-emerald-900 uppercase tracking-wider mb-4">Video Lainnya</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($videos->skip(1) as $video)
                                <a href="{{ $video->youtube_url }}" target="_blank" class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/40 transition">
                                    <div class="w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm">{{ $video->judul }}</div>
                                        @if($video->deskripsi)
                                            <div class="text-xs text-gray-500 line-clamp-1">{{ $video->deskripsi }}</div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Statistics Section -->
    @if(isset($angkatanList) && $angkatanList->count() > 0)
        @php
            // Sort chronologically (oldest to newest left-to-right, matching reference)
            $statsAngkatan = $angkatanList->sortBy('tahun_lulus')->values();
            // Sort newest to oldest for flyer archive tabs
            $flyerAngkatan = $angkatanList->sortByDesc('tahun_lulus')->values();
        @endphp
        <section class="max-w-7xl mx-auto px-4 py-8 mb-10">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-emerald-900 mb-4">{{ $settings['alumni_stats_title'] ?? 'Statistik Keberhasilan' }}</h2>
                <div class="w-20 h-1.5 bg-yellow-500 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($statsAngkatan as $angkatan)
                    @php
                        $ptnVal = rtrim(rtrim(number_format((float)$angkatan->persen_ptn, 2, '.', ''), '0'), '.');
                        $ptsVal = rtrim(rtrim(number_format((float)$angkatan->persen_pts, 2, '.', ''), '0'), '.');
                        $ptlnVal = rtrim(rtrim(number_format((float)$angkatan->persen_ptln, 2, '.', ''), '0'), '.');
                        $kedinasanVal = rtrim(rtrim(number_format((float)$angkatan->persen_kedinasan, 2, '.', ''), '0'), '.');
                    @endphp

                    @if($angkatan->is_highlighted)
                        <!-- Highlighted Card (Latest Cohort) -->
                        <div class="bg-emerald-900 p-6 rounded-3xl border border-emerald-800 shadow-xl text-white transform md:scale-105 z-10 text-center">
                            <h4 class="text-yellow-400 font-bold text-base mb-4 flex items-center justify-center">
                                <span class="bg-yellow-500 text-emerald-900 px-2 py-1 rounded-md mr-2 text-sm">{{ $angkatan->tahun_lulus }}</span>
                                {{ $angkatan->nama_angkatan }}
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-end">
                                    <span class="text-emerald-100 text-[10px] leading-tight text-left">PTN +<br>PTLN</span>
                                    <span class="text-3xl font-bold text-yellow-400">{{ $ptnVal }}%</span>
                                </div>
                                <div class="w-full bg-emerald-800 h-1.5 rounded-full">
                                    <div class="bg-yellow-500 h-full rounded-full" style="width: {{ min(100, (float)$angkatan->persen_ptn) }}%"></div>
                                </div>
                                <div class="flex flex-wrap justify-center gap-x-2 gap-y-1 text-[10px] text-emerald-200 uppercase tracking-widest font-bold pt-1">
                                    @if($angkatan->persen_ptln > 0)
                                        <span>PTLN: {{ $ptlnVal }}%</span>
                                    @endif
                                    @if($angkatan->persen_pts > 0)
                                        <span>PTS: {{ $ptsVal }}%</span>
                                    @endif
                                    @if($angkatan->persen_kedinasan > 0)
                                        <span>Kedinasan: {{ $kedinasanVal }}%</span>
                                    @endif
                                    @if($angkatan->persen_ptln == 0 && $angkatan->persen_pts == 0 && $angkatan->persen_kedinasan == 0)
                                        <span>{{ $angkatan->catatan ?: 'Terbaru' }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Regular Card -->
                        <div class="bg-white p-6 rounded-3xl border border-gray-100 card-shadow text-center">
                            <h4 class="text-emerald-800 font-bold text-base mb-4 flex items-center justify-center">
                                <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-md mr-2 text-sm">{{ $angkatan->tahun_lulus }}</span>
                                {{ $angkatan->nama_angkatan }}
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-end">
                                    <span class="text-gray-500 text-xs">Lolos PTN</span>
                                    <span class="text-xl font-bold text-emerald-700">{{ $ptnVal }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 h-1.5 rounded-full">
                                    <div class="bg-emerald-500 h-full rounded-full" style="width: {{ min(100, (float)$angkatan->persen_ptn) }}%"></div>
                                </div>
                                <div class="flex flex-wrap justify-center gap-x-3 gap-y-1 text-[10px] text-gray-500 font-bold pt-1">
                                    @if($angkatan->persen_ptln > 0)
                                        <span>PTLN: {{ $ptlnVal }}%</span>
                                    @endif
                                    @if($angkatan->persen_pts > 0)
                                        <span>PTS: {{ $ptsVal }}%</span>
                                    @endif
                                    @if($angkatan->persen_kedinasan > 0)
                                        <span>Kedinasan: {{ $kedinasanVal }}%</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>

        <!-- Flyer Section -->
        <section class="max-w-6xl mx-auto px-4 py-16 mb-20">
            <div class="bg-emerald-50 rounded-[3rem] p-8 md:p-16 border border-emerald-100">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-emerald-900 mb-2">{{ $settings['alumni_flyer_title'] ?? 'Flyer Arsip Kelulusan' }}</h3>
                    <p class="text-gray-600">Klik angkatan untuk melihat flyer. <span class="text-emerald-700 font-bold">Klik gambar untuk memperbesar.</span></p>
                </div>

                <div class="flex flex-wrap justify-center gap-3 mb-10">
                    @foreach($flyerAngkatan as $index => $angkatan)
                        <button onclick="showFlyer('{{ $angkatan->tahun_lulus }}')"
                            id="btn-{{ $angkatan->tahun_lulus }}"
                            class="tab-btn {{ $index === 0 ? 'active' : '' }} px-6 py-2 md:px-8 md:py-3 rounded-full border-2 border-emerald-200 font-bold transition-all text-sm md:text-base">
                            Tahun {{ $angkatan->tahun_lulus }}
                        </button>
                    @endforeach
                </div>

                <div class="bg-white rounded-2xl p-4 shadow-lg overflow-hidden">
                    @foreach($flyerAngkatan as $index => $angkatan)
                        @php
                            $flyerSrc = $angkatan->flyer_url;
                            if (!$flyerSrc && file_exists(public_path('images/alumni/flyer-' . $angkatan->tahun_lulus . '.png'))) {
                                $flyerSrc = asset('images/alumni/flyer-' . $angkatan->tahun_lulus . '.png');
                            }
                        @endphp
                        <div id="flyer-{{ $angkatan->tahun_lulus }}" class="flyer-container {{ $index === 0 ? '' : 'hidden' }} group">
                            <img src="{{ $flyerSrc }}"
                                alt="Flyer {{ $angkatan->nama_angkatan }} {{ $angkatan->tahun_lulus }}"
                                onclick="openModal(this.src)"
                                class="w-full h-auto rounded-xl max-w-4xl mx-auto cursor-zoom-in hover:opacity-95 transition duration-300 shadow-sm">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Modal for Image Preview -->
    <div id="imageModal" class="fixed inset-0 z-[100] hidden bg-black/90 backdrop-blur-sm p-4 md:p-10" onclick="closeModal()">
        <button onclick="closeModal()" class="absolute top-6 right-6 text-white hover:text-yellow-400 transition z-50 bg-black/50 p-2 rounded-full" title="Tutup">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <!-- Image Wrapper -->
        <div class="modal-content-wrapper relative max-w-5xl w-full h-full flex items-center justify-center pointer-events-none mx-auto">
            <img id="modalImg" src="" alt="Flyer Besar" onclick="event.stopPropagation()"
                class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl border-4 border-white/10 pointer-events-auto">
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-emerald-950 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 border-b border-emerald-800 pb-16 text-center md:text-left">
                <div class="md:col-span-2">
                    <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-4 mb-6">
                        <img src="{{ \App\Models\Setting::logoUrl() }}" alt="{{ \App\Models\Setting::siteName() }}" class="h-16 w-auto">
                        <div class="md:border-l-2 border-emerald-700 md:pl-4">
                            <span class="block text-xl font-bold uppercase tracking-tight">{{ \App\Models\Setting::siteName() }}</span>
                            <span class="block text-xs text-emerald-400 uppercase tracking-[0.2em] mt-1 font-semibold">{{ \App\Models\Setting::siteTagline() }}</span>
                        </div>
                    </div>
                    <p class="text-emerald-200 text-sm leading-relaxed max-w-xl mx-auto md:mx-0">
                        {{ $settings['footer_about'] ?? 'Menjadi Lembaga Dakwah Pendidikan Terdepan dalam Akhlak & Prestasi serta Menjadi Teladan bagi Lembaga Lain' }}
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-6 text-yellow-500 uppercase tracking-widest">Tautan Cepat</h4>
                    <ul class="text-emerald-200 text-sm space-y-3">
                        <li><a href="{{ $ctaUrl }}" class="hover:text-white transition">{{ $ctaText ?: 'PPDB Online' }}</a></li>
                        <li><a href="{{ url('/') }}" class="hover:text-white transition">Beranda Utama</a></li>
                        <li><a href="{{ url('/#welcome') }}" class="hover:text-white transition">Profil Lembaga</a></li>
                        <li><a href="{{ route('posts.index') }}" class="hover:text-white transition">Berita & Artikel</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-emerald-500 text-[10px] uppercase tracking-widest font-bold">
                <div class="text-center md:text-left">
                    &copy; {{ date('Y') }} Lajnah Pendidikan dan Pengajaran Al Irsyad Al Islamiyyah Karawang.
                </div>
                <div class="text-center md:text-right">
                    Crafted by <a href="https://www.murniabadi.co.id/" class="text-emerald-400 hover:text-white underline decoration-yellow-500 underline-offset-4 transition duration-300" target="_blank">MATEK</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Toggle Mobile Menu
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('open');
            });
        }

        // Tab Flyer
        function showFlyer(year) {
            document.querySelectorAll('.flyer-container').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            const flyerEl = document.getElementById('flyer-' + year);
            const btnEl = document.getElementById('btn-' + year);
            if (flyerEl) flyerEl.classList.remove('hidden');
            if (btnEl) btnEl.classList.add('active');
        }

        // Modal Functions
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImg');

        function openModal(src) {
            modalImg.src = src;
            modal.classList.remove('hidden');
            void modal.offsetWidth;
            modal.classList.add('flex');
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.remove('show');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }

        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape") closeModal();
        });
    </script>
</body>

</html>
