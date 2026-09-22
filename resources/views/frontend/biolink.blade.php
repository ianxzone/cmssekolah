<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Optimization -->
    <title>{{ $profile->meta_title ?: ($profile->title . ' | PPDB & Informasi Resmi') }}</title>
    <meta name="description" content="{{ $profile->meta_description ?: $profile->bio }}">
    <meta name="keywords" content="{{ $profile->meta_keywords ?: 'Al Irsyad Karawang, PPDB Online, Link Bio Sekolah' }}">
    <meta name="author" content="{{ $profile->title }}">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $profile->meta_title ?: $profile->title }}">
    <meta property="og:description" content="{{ $profile->meta_description ?: $profile->bio }}">
    @if($profile->og_image)
        <meta property="og:image" content="{{ $profile->og_image }}">
    @endif

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $profile->avatar_url }}">

    @include('partials.analytics')
    
    <!-- Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        'brand-green': '{{ $profile->theme_primary_color ?: "#006837" }}',
                        'brand-light': '#E8F5E9',
                        'brand-accent': '{{ $profile->theme_accent_color ?: "#FBB03B" }}',
                    },
                    animation: {
                        'bounce-slow': 'bounce 2s infinite',
                        'pulse-glow': 'pulseGlow 3s infinite',
                        'fade-in': 'fadeIn 0.5s ease-out forwards',
                    },
                    keyframes: {
                        pulseGlow: {
                            '0%, 100%': { boxShadow: '0 0 15px rgba(0, 255, 136, 0.2)' },
                            '50%': { boxShadow: '0 0 25px rgba(0, 255, 136, 0.5)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        html {
            overflow-y: auto !important;
            overflow-x: hidden !important;
            scroll-behavior: smooth;
            height: 100%;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.35) transparent;
        }

        /* Ultra-sleek iOS-style translucent floating pill scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.35);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.65);
        }

        body {
            /* Base Color: Deep Islamic Green */
            background-color: {{ $profile->theme_bg_color ?: '#022c19' }};
            overflow-x: hidden;
            overflow-y: visible;
            touch-action: pan-y;
            -webkit-overflow-scrolling: touch;
            
            @if($profile->show_pattern)
            /* Islamic Tech Background Layers */
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(0, 146, 69, 0.4) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(0, 255, 170, 0.1) 0%, transparent 40%),
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0l25.98 15v30L30 60 4.02 45V15z' fill='none' stroke='%2300ff88' stroke-opacity='0.05' stroke-width='1'/%3E%3C/svg%3E");
            
            background-size: 100% 100%, 100% 100%, 40px 40px, 40px 40px, 60px 60px;
            background-attachment: fixed;
            @endif
            min-height: 100vh;
            display: flex;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 40px -10px rgba(0, 255, 136, 0.15);
        }

        .btn-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 104, 55, 0.25);
            border-color: {{ $profile->theme_primary_color ?: '#006837' }};
        }

        .btn-highlight {
            background: linear-gradient(135deg, {{ $profile->theme_primary_color ?: '#006837' }} 0%, #004d25 100%);
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .scanline {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to bottom, transparent 50%, rgba(0, 255, 136, 0.02) 51%);
            background-size: 100% 4px;
            pointer-events: none;
            z-index: 0;
        }
    </style>
</head>
<body>

    @if($profile->show_scanline)
    <!-- Efek Scanline Halus -->
    <div class="scanline fixed inset-0"></div>
    @endif

    <main class="w-full max-w-[420px] glass-panel rounded-3xl overflow-hidden relative pb-8 z-10 animate-fade-in" style="height: fit-content;">
        
        <!-- Header Section -->
        <div class="bg-brand-green h-40 relative">
            <!-- Background Header Image -->
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $profile->banner_url }}');"></div>
            <!-- Overlay gelap -->
            <div class="absolute inset-0 bg-black/25"></div>
            
            <!-- Tech Accent Line -->
            <div class="absolute bottom-0 w-full h-1 bg-gradient-to-r from-transparent via-brand-accent to-transparent opacity-60"></div>

            <div class="absolute -bottom-12 left-0 right-0 flex justify-center z-10">
                <div class="relative group">
                    <!-- Foto Profil -->
                    <div class="w-28 h-28 bg-white rounded-2xl p-2 shadow-2xl flex items-center justify-center transition-transform duration-500 group-hover:scale-105 group-hover:shadow-[0_0_30px_rgba(0,104,55,0.3)]">
                        <img 
                            src="{{ $profile->avatar_url }}" 
                            alt="{{ $profile->title }}" 
                            class="w-full h-full object-contain"
                        >
                    </div>
                    @if($profile->show_verified_badge)
                    <!-- Verified Badge -->
                    <div class="absolute -bottom-1 -right-1 bg-blue-500 text-white w-7 h-7 flex items-center justify-center rounded-full border-2 border-white text-xs shadow-md animate-bounce-slow" title="Terverifikasi">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Profile Info -->
        <div class="mt-14 text-center px-6">
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">{{ $profile->title }}</h1>
            @if($profile->subtitle)
                <h2 class="text-sm font-semibold text-brand-green uppercase tracking-widest text-[10px] mt-1">{{ $profile->subtitle }}</h2>
            @endif
            
            @if($profile->badge_text)
            <div class="mt-3 mb-3 inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-50 border border-green-100 shadow-sm">
                @if($profile->badge_icon)
                    <i class="{{ $profile->badge_icon }} text-brand-green text-xs"></i>
                @endif
                <span class="text-xs font-bold text-brand-green">{{ $profile->badge_text }}</span>
            </div>
            @endif

            @if($profile->bio)
            <p class="text-gray-500 text-sm leading-relaxed mx-auto max-w-[300px]">
                {{ $profile->bio }}
            </p>
            @endif
        </div>

        <!-- Social Media Row -->
        @if(!empty($profile->social_links) && is_array($profile->social_links))
        <div class="flex justify-center flex-wrap gap-3 mt-5 mb-8 px-4">
            @foreach($profile->social_links as $social)
                @if(!empty($social['is_active']) && !empty($social['url']))
                <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" title="{{ $social['platform'] ?? 'Social' }}" class="w-10 h-10 rounded-xl bg-gradient-to-br from-white to-gray-50 flex items-center justify-center text-gray-600 {{ $social['color_hover'] ?? 'hover:text-brand-green' }} transition shadow-sm border border-gray-200 hover:-translate-y-1 hover:shadow-lg">
                    <i class="{{ $social['icon'] ?? 'fa-solid fa-link' }} text-xl"></i>
                </a>
                @endif
            @endforeach
        </div>
        @endif

        <!-- LINKS CONTAINER -->
        <div class="px-5 space-y-4">

            <!-- Video Highlight -->
            @if($profile->show_youtube && !empty($profile->youtube_url))
            @php
                $embedUrl = $profile->youtube_url;
                // Normalize youtube link if standard watch or short link
                if (str_contains($embedUrl, 'watch?v=')) {
                    $embedUrl = str_replace('watch?v=', 'embed/', $embedUrl);
                } elseif (str_contains($embedUrl, 'youtu.be/')) {
                    $embedUrl = str_replace('youtu.be/', 'www.youtube.com/embed/', $embedUrl);
                }
                // Append params if needed
                if (!str_contains($embedUrl, '?')) {
                    $embedUrl .= '?autoplay=1&mute=1&controls=1&loop=1&rel=0';
                }
            @endphp
            <div class="mb-5 rounded-2xl overflow-hidden shadow-lg border border-gray-200 relative group bg-black">
                <iframe 
                    class="w-full aspect-video" 
                    src="{{ $embedUrl }}" 
                    title="Video Profil {{ $profile->title }}" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
                <div class="absolute inset-0 pointer-events-none border border-white/10 rounded-2xl"></div>
            </div>
            @endif

            <!-- SECTIONS & LINKS DYNAMIC RENDER -->
            @foreach($profile->sections as $section)
                @if($section->activeLinks->isNotEmpty())
                    <div class="pt-2">
                        <!-- Section Header -->
                        <div class="flex items-center gap-2 ml-1 mb-2">
                            @if($section->icon)
                                <i class="{{ $section->icon }} text-gray-400 text-xs"></i>
                            @endif
                            <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $section->title }}</div>
                        </div>

                        <!-- Section Items -->
                        @if($section->layout_type === 'grid_2')
                            <!-- 2-Column Grid Layout (Cocok untuk Unit Sekolah) -->
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($section->activeLinks as $link)
                                    <a href="{{ route('biolink.click', $link->id) }}" 
                                       target="{{ $link->open_new_tab ? '_blank' : '_self' }}" 
                                       rel="noopener noreferrer"
                                       class="btn-link bg-white p-3.5 rounded-xl border border-gray-200 hover:border-brand-green flex flex-col items-center text-center gap-2 group shadow-sm hover:shadow-md">
                                        <div class="w-9 h-9 {{ $link->icon_bg_color ?: 'bg-green-50' }} {{ $link->icon_color ?: 'text-brand-green' }} rounded-lg flex items-center justify-center transition-transform group-hover:scale-110">
                                            <i class="{{ $link->icon ?: 'fa-solid fa-link' }} text-base"></i>
                                        </div>
                                        <span class="text-xs font-bold text-gray-700 leading-tight">{{ $link->title }}</span>
                                        @if($link->subtitle)
                                            <span class="text-[10px] text-gray-400">{{ $link->subtitle }}</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <!-- List Layout (Full Width Cards) -->
                            <div class="space-y-3">
                                @foreach($section->activeLinks as $link)
                                    @if($link->style_type === 'highlighted')
                                        <!-- Highlighted / Priority Button (e.g., PPDB Online) -->
                                        <a href="{{ route('biolink.click', $link->id) }}" 
                                           target="{{ $link->open_new_tab ? '_blank' : '_self' }}" 
                                           rel="noopener noreferrer"
                                           class="btn-link btn-highlight relative w-full p-4 rounded-xl flex items-center gap-4 text-white overflow-hidden group shadow-[0_0_20px_rgba(0,104,55,0.4)]">
                                            <!-- Circuit tech pattern overlay -->
                                            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/circuit-board.png')] mix-blend-overlay"></div>
                                            <!-- Glow hover orb -->
                                            <div class="absolute right-0 top-0 w-32 h-32 bg-white opacity-5 rounded-full blur-2xl transform translate-x-10 -translate-y-10 group-hover:scale-150 transition-transform duration-700"></div>
                                            
                                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/30 shadow-inner group-hover:rotate-12 transition-transform flex-shrink-0">
                                                <i class="{{ $link->icon ?: 'fa-solid fa-rocket' }} text-xl text-white drop-shadow-md"></i>
                                            </div>
                                            <div class="flex-1 z-10 min-w-0">
                                                <h3 class="font-bold text-base md:text-lg text-white drop-shadow truncate">{{ $link->title }}</h3>
                                                @if($link->subtitle)
                                                    <p class="text-xs text-green-100 truncate">{{ $link->subtitle }}</p>
                                                @endif
                                            </div>
                                            @if($link->badge_text)
                                                <div class="z-10 bg-brand-accent text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm flex items-center gap-1 animate-pulse flex-shrink-0">
                                                    <i class="fa-solid fa-circle text-[6px]"></i> {{ $link->badge_text }}
                                                </div>
                                            @endif
                                        </a>
                                    @else
                                        <!-- Standard Card Link -->
                                        <a href="{{ route('biolink.click', $link->id) }}" 
                                           target="{{ $link->open_new_tab ? '_blank' : '_self' }}" 
                                           rel="noopener noreferrer"
                                           class="btn-link bg-white w-full p-3.5 rounded-xl flex items-center gap-3.5 border border-gray-200 hover:border-brand-green group shadow-sm hover:shadow-md">
                                            <div class="w-10 h-10 {{ $link->icon_bg_color ?: 'bg-gray-100' }} {{ $link->icon_color ?: 'text-gray-700' }} rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                                <i class="{{ $link->icon ?: 'fa-solid fa-link' }} text-lg"></i>
                                            </div>
                                            <div class="flex-1 min-w-0 text-left">
                                                <span class="font-semibold text-sm text-gray-800 block truncate">{{ $link->title }}</span>
                                                @if($link->subtitle)
                                                    <span class="text-[11px] text-gray-400 block truncate">{{ $link->subtitle }}</span>
                                                @endif
                                            </div>
                                            @if($link->badge_text)
                                                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-amber-100 text-amber-800 flex-shrink-0">{{ $link->badge_text }}</span>
                                            @else
                                                <i class="fa-solid fa-chevron-right text-gray-300 text-xs transition-transform group-hover:translate-x-1 flex-shrink-0"></i>
                                            @endif
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            @endforeach

        </div>

        <!-- Footer -->
        <div class="mt-8 text-center px-6">
            @if($profile->footer_text)
                <p class="text-xs text-gray-500 font-medium">{{ $profile->footer_text }}</p>
            @endif
            @if($profile->footer_subtext)
                <p class="text-[10px] text-gray-400 mt-1">{{ $profile->footer_subtext }}</p>
            @endif
        </div>

    </main>

    <!-- Touch & Mouse Drag/Swipe Simulation for Mobile Preview -->
    <script>
        (function() {
            let isDragging = false;
            let startY = 0;
            let startScrollTop = 0;
            let moved = false;

            window.addEventListener('mousedown', function(e) {
                // Ignore if clicked on form fields or inputs
                if (['INPUT', 'TEXTAREA', 'SELECT', 'BUTTON'].includes(e.target.tagName)) return;
                
                isDragging = true;
                moved = false;
                startY = e.clientY;
                startScrollTop = window.scrollY || document.documentElement.scrollTop;
                document.body.style.userSelect = 'none';
            });

            window.addEventListener('mousemove', function(e) {
                if (!isDragging) return;
                const deltaY = e.clientY - startY;
                if (Math.abs(deltaY) > 5) {
                    moved = true;
                    document.body.style.cursor = 'grab';
                    window.scrollTo({
                        top: startScrollTop - deltaY,
                        behavior: 'auto'
                    });
                }
            });

            function endDrag() {
                if (!isDragging) return;
                isDragging = false;
                document.body.style.userSelect = '';
                document.body.style.cursor = '';
            }

            window.addEventListener('mouseup', endDrag);
            window.addEventListener('mouseleave', endDrag);

            // Intercept accidental link clicks if user was swiping/dragging
            document.addEventListener('click', function(e) {
                if (moved) {
                    e.preventDefault();
                    e.stopPropagation();
                    moved = false;
                }
            }, true);
        })();
    </script>
</body>
</html>
