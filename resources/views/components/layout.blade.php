<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SDIT Al Irsyad Karawang' }}</title>
    <meta name="description"
        content="{{ $metaDescription ?? 'Sekolah Dasar Islam Terpadu Al Irsyad Al Islamiyah Karawang - Islamic Value x Technology' }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">

    <!-- Navbar -->
    <header class="bg-white/90 backdrop-blur-md fixed w-full z-50 transition-all duration-300 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <a href="/" class="flex items-center gap-2">
                        <!-- Placeholder Logo -->
                        <div
                            class="w-10 h-10 bg-primary-800 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                            AI
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-lg leading-tight text-primary-900">SDIT Al Irsyad</span>
                            <span class="text-xs text-secondary-600 font-medium tracking-wider">ISLAMIC & TECH</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex space-x-8">
                    <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                    <x-nav-link href="{{ route('posts.index') }}"
                        :active="request()->routeIs('posts.*')">Berita</x-nav-link>
                    <x-nav-link href="{{ route('events.index') }}"
                        :active="request()->routeIs('events.*')">Agenda</x-nav-link>
                    <div class="relative group">
                        <button
                            class="flex items-center gap-1 text-gray-600 hover:text-primary-600 font-medium transition py-2">
                            Profil
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <!-- Dropdown -->
                        <div
                            class="absolute left-0 mt-0 w-48 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-left z-50 border border-gray-100">
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 first:rounded-t-lg">Visi
                                & Misi</a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700">Sejarah</a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 last:rounded-b-lg">Struktur
                                Organisasi</a>
                        </div>
                    </div>
                    <a href="#"
                        class="px-5 py-2 bg-primary-800 text-white rounded-full font-medium hover:bg-primary-900 transition shadow-lg shadow-primary-800/20">PPDB
                        Online</a>
                </nav>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button class="text-gray-500 hover:text-gray-900 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow pt-16">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div
                            class="w-10 h-10 bg-primary-500 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                            AI
                        </div>
                        <span class="font-bold text-xl">SDIT Al Irsyad Karawang</span>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-sm">
                        Mewujudkan generasi Rabbani yang unggul dalam Imtaq dan Iptek. Sekolah penggerak bernafaskan
                        Islam dengan kurikulum teknologi terdepan.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition"><span
                                class="sr-only">Facebook</span>FB</a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><span
                                class="sr-only">Instagram</span>IG</a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><span
                                class="sr-only">Youtube</span>YT</a>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-4 text-primary-400">Tautan</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-primary-400 transition">Beranda</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition">Profil Sekolah</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition">Berita & Artikel</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition">Agenda Kegiatan</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition">PPDB</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-4 text-primary-400">Kontak</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-start gap-2">
                            <span class="mt-1 text-primary-500">📍</span>
                            <span>Jl. RH. Jaja Abdullah No.12, Karawang Kulon, Karawang Barat</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-primary-500">📞</span>
                            <span>(0267) 123456</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-primary-500">✉️</span>
                            <span>info@sdit.alirsyad.sch.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} SDIT Al Irsyad Al Islamiyah Karawang. All rights reserved.
            </div>
        </div>
    </footer>
</body>

</html>