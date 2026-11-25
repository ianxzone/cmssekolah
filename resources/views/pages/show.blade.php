@php
    $hasFlipbook = str_contains($page->content ?? '', 'pdf-flipbook-wrapper') 
                || str_contains($page->content ?? '', 'dflip') 
                || str_contains($page->content ?? '', '_df_book')
                || str_contains($page->content ?? '', '[pdf');
    $badgeText = $hasFlipbook ? 'Publikasi & Booklet Digital' : 'Informasi Resmi';
    $waNumber = \App\Models\Setting::get('contact_whatsapp', '62895708351313');
    $waClean = preg_replace('/[^0-9]/', '', $waNumber);
@endphp

<x-layout :title="$page->seo_title ?: $page->title" :metaDescription="$page->seo_description ?: \Illuminate\Support\Str::limit(strip_tags($page->content ?? ''), 160)" :metaImage="$page->image ? \Illuminate\Support\Facades\Storage::url($page->image) : null" metaType="article">
    <!-- Elegant Bespoke Page Hero -->
    <div class="relative bg-gradient-to-b from-emerald-950 via-primary-900 to-emerald-900 py-12 md:py-16 overflow-hidden text-white border-b border-emerald-800/40">
        <!-- Ambient lighting glow -->
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <!-- Breadcrumbs -->
            <nav class="inline-flex items-center gap-2 text-emerald-200/80 text-xs sm:text-sm mb-4 px-3.5 py-1 rounded-full bg-white/5 backdrop-blur-md border border-white/10">
                <a href="/" class="hover:text-white transition flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Beranda</span>
                </a>
                <span class="text-emerald-400/60">&rsaquo;</span>
                <span class="text-emerald-200 font-semibold">{{ $badgeText }}</span>
            </nav>

            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-white mb-3 tracking-tight leading-tight max-w-4xl mx-auto drop-shadow-sm">
                {{ $page->title }}
            </h1>

            <p class="text-xs sm:text-sm text-emerald-200/90 font-medium tracking-wide flex items-center justify-center gap-2">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                <span>Lajnah Pendidikan & Pengajaran Al Irsyad Al Islamiyyah Karawang</span>
            </p>
        </div>
    </div>

    @if(!empty($isPreview))
        <div style="background: linear-gradient(90deg, #d97706, #b45309); color: white; padding: 12px 20px; text-align: center; font-size: 0.9rem; font-weight: 600; box-shadow: 0 2px 8px rgba(0,0,0,0.15); display: flex; align-items: center; justify-content: center; gap: 10px; flex-wrap: wrap;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            <span>MODE PRATINJAU: Halaman ini berstatus <u>{{ $page->status_label }}</u> dan belum dapat diakses pengunjung umum.</span>
            <a href="{{ route('admin.pages.edit', $page) }}" style="background: white; color: #b45309; padding: 4px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 700; text-decoration: none; margin-left: 8px;">Edit Halaman</a>
        </div>
    @endif

    <!-- Page Content Container (Dynamic width for rich interactive flipbooks) -->
    <div class="bg-slate-100/70 min-h-screen py-8 sm:py-12 md:py-16">
        <div class="{{ $hasFlipbook ? 'max-w-6xl xl:max-w-7xl' : 'max-w-4xl' }} mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl sm:rounded-3xl {{ $hasFlipbook ? 'p-4 sm:p-7 md:p-9' : 'p-6 sm:p-10 md:p-12' }} shadow-xl border border-slate-200/80">
                @if($page->image_url && !$hasFlipbook)
                    <div class="w-full h-64 md:h-96 relative mb-8 rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                        <img src="{{ $page->image_url }}" alt="{{ $page->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="page-content prose prose-lg prose-primary max-w-none text-gray-700">
                    {!! $page->content !!}
                </div>

                @if($hasFlipbook)
                    <!-- Institutional Call-To-Action Showcase -->
                    <div class="mt-10 sm:mt-12 p-6 sm:p-8 rounded-2xl bg-gradient-to-br from-emerald-900 via-primary-900 to-emerald-950 text-white shadow-xl relative overflow-hidden">
                        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-2xl"></div>
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
                            <div>
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold uppercase tracking-wider mb-2.5 border border-emerald-500/30">
                                    <span>Pendaftaran Santri Baru (SPMB)</span>
                                </div>
                                <h3 class="text-xl sm:text-2xl font-black text-white mb-1.5 leading-snug">Tertarik Mendaftarkan Putra-Putri Anda?</h3>
                                <p class="text-sm text-emerald-100/90 max-w-xl mb-0">
                                    Dapatkan pendidikan terpadu berkualitas, berakhlak mulia, tahfidz Al-Qur'an, dan berwawasan global di Sekolah IT Al Irsyad Karawang.
                                </p>
                            </div>
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 shrink-0">
                                <a href="/smart#daftar" target="_blank" rel="noopener" class="btn-cta-flipbook inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold rounded-xl text-sm transition-all duration-200 shadow-lg hover:shadow-xl no-underline">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    <span>Daftar SPMB Online</span>
                                </a>
                                <a href="https://wa.me/{{ $waClean }}?text={{ urlencode('Bismillah, Assalamu\'alaikum Panitia PPDB Al Irsyad, saya ingin konsultasi pendaftaran setelah membaca booklet: ' . $page->title) }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl text-sm border border-white/20 transition-all duration-200 no-underline">
                                    <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.173.086.275.071.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.086s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/></svg>
                                    <span>Konsultasi Panitia</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        /* Scoped Typography & Embed Styles for CMS Pages */
        .page-content {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #374151;
        }
        .page-content p {
            margin-bottom: 1.25rem;
            line-height: 1.8;
        }
        .page-content h1, .page-content h2, .page-content h3, .page-content h4 {
            color: #064e3b;
            font-weight: 700;
            line-height: 1.35;
        }
        .page-content h2 {
            font-size: 1.5rem;
            margin-top: 2.25rem;
            margin-bottom: 1rem;
            border-left: 4px solid #10b981;
            padding-left: 0.75rem;
            letter-spacing: -0.01em;
        }
        @media (min-width: 640px) {
            .page-content h2 {
                font-size: 1.75rem;
            }
        }
        .page-content h3 {
            font-size: 1.25rem;
            margin-top: 1.75rem;
            margin-bottom: 0.75rem;
        }
        .page-content ol {
            list-style-type: decimal;
            margin-left: 1.5rem;
            margin-bottom: 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }
        .page-content ul {
            list-style-type: disc;
            margin-left: 1.5rem;
            margin-bottom: 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }
        .page-content li {
            padding-left: 0.35rem;
            line-height: 1.75;
        }
        .page-content strong {
            font-weight: 700;
            color: #111827;
        }
        .page-content a:not(.btn-cta):not(.btn-pdf):not(.widget-button) {
            color: #059669;
            text-decoration: underline;
            font-weight: 600;
            transition: color 0.2s;
        }
        .page-content a:not(.btn-cta):not(.btn-pdf):not(.widget-button):hover {
            color: #047857;
        }

        /* YouTube & Responsive Video Embeds */
        .page-content .video-container,
        .page-content iframe[src*="youtube.com"],
        .page-content iframe[src*="youtu.be"] {
            width: 100% !important;
            aspect-ratio: 16 / 9;
            border-radius: 1rem;
            overflow: hidden;
            border: 0;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
            margin: 2rem 0;
            display: block;
        }
        .page-content .video-container iframe {
            width: 100% !important;
            height: 100% !important;
            border: 0;
        }

        /* DAFTAR PPDB & CTA Buttons */
        .page-content .widget-button,
        .page-content a[href*="ppdbdaftar"],
        .page-content .btn-cta {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.75rem !important;
            padding: 1rem 2.5rem !important;
            background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
            color: #ffffff !important;
            font-weight: 800 !important;
            font-size: 1.15rem !important;
            border-radius: 1rem !important;
            text-decoration: none !important;
            box-shadow: 0 10px 20px -5px rgba(5, 150, 105, 0.4) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            margin: 2rem auto !important;
            text-align: center !important;
            letter-spacing: 0.5px !important;
            border: none !important;
        }
        .page-content .widget-button:hover,
        .page-content a[href*="ppdbdaftar"]:hover,
        .page-content .btn-cta:hover {
            background: linear-gradient(135deg, #047857 0%, #064e3b 100%) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 15px 30px -5px rgba(5, 150, 105, 0.5) !important;
            color: #ffffff !important;
        }
        .page-content .widget-button svg,
        .page-content a[href*="ppdbdaftar"] svg,
        .page-content .btn-cta svg {
            width: 22px !important;
            height: 22px !important;
            max-width: 22px !important;
            max-height: 22px !important;
            fill: currentColor !important;
            margin: 0 !important;
            display: inline-block !important;
        }

        /* Card Container Alignment for Button */
        .page-content .elementor-widget-container {
            text-align: center;
        }

        /* Flipbook Reader reset in prose */
        .page-content .pdf-flipbook-wrapper {
            margin-top: 1.5rem !important;
            margin-bottom: 2rem !important;
        }
        .page-content .pdf-flipbook-wrapper a {
            text-decoration: none !important;
        }
    </style>
    @endpush
</x-layout>