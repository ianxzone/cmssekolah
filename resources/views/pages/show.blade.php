<x-layout :title="$page->seo_title ?: $page->title" :metaDescription="$page->seo_description ?: \Illuminate\Support\Str::limit(strip_tags($page->content ?? ''), 160)" :metaImage="$page->image ? \Illuminate\Support\Facades\Storage::url($page->image) : null" metaType="article">
    <!-- Page Header -->
    <div class="bg-primary-900 py-14 md:py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')] opacity-10"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-primary-900 via-primary-800 to-emerald-950 opacity-95"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 text-emerald-200 text-xs font-semibold uppercase tracking-wider mb-3 backdrop-blur-sm border border-white/10">
                <span>Informasi Resmi</span>
            </div>
            <h1 class="text-2xl sm:text-3xl md:text-5xl font-extrabold text-white mb-4 tracking-tight leading-tight max-w-4xl mx-auto">{{ $page->title }}</h1>
            <nav class="flex justify-center items-center text-primary-200 text-sm">
                <a href="/" class="hover:text-white transition">Beranda</a>
                <span class="mx-2 text-primary-300">/</span>
                <span class="text-white font-medium truncate max-w-xs sm:max-w-md">{{ $page->title }}</span>
            </nav>
        </div>
    </div>

    @if(!empty($isPreview))
        <div style="background: linear-gradient(90deg, #d97706, #b45309); color: white; padding: 12px 20px; text-align: center; font-size: 0.9rem; font-weight: 600; box-shadow: 0 2px 8px rgba(0,0,0,0.15); display: flex; align-items: center; justify-content: center; gap: 10px; flex-wrap: wrap;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            <span>MODE PRATINJAU: Halaman ini berstatus <u>{{ $page->status_label }}</u> dan belum dapat diakses pengunjung umum.</span>
            <a href="{{ route('admin.pages.edit', $page) }}" style="background: white; color: #b45309; padding: 4px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 700; text-decoration: none; margin-left: 8px;">Edit Halaman</a>
        </div>
    @endif

    <!-- Page Content Container -->
    <div class="bg-slate-50 min-h-screen py-8 sm:py-12 md:py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-6 sm:p-10 md:p-12 shadow-sm border border-slate-100/80">
                @if($page->image_url)
                    <div class="w-full h-64 md:h-96 relative mb-8 rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                        <img src="{{ $page->image_url }}" alt="{{ $page->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="page-content prose prose-lg prose-primary max-w-none text-gray-700">
                    {!! $page->content !!}
                </div>
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
    </style>
    @endpush
</x-layout>