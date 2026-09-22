<x-layout :title="$page->seo_title ?: $page->title" :metaDescription="$page->seo_description ?: Str::limit(strip_tags($page->content), 160)" :metaImage="$page->image ? Storage::url($page->image) : null" metaType="article">
    <!-- Page Header -->
    <div class="bg-primary-900 py-16 md:py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/arabesque.png')] opacity-10">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-primary-900 to-primary-800 opacity-90"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">{{ $page->title }}</h1>
            <nav class="flex justify-center text-primary-100 text-sm">
                <a href="/" class="hover:text-white transition">Beranda</a>
                <span class="mx-2">/</span>
                <span class="text-white font-medium">{{ $page->title }}</span>
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

    <!-- Page Content -->
    <div class="bg-white min-h-screen py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($page->image_url)
                <div class="w-full h-64 md:h-96 relative mb-8 rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                    <img src="{{ $page->image_url }}" alt="{{ $page->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <div class="prose prose-lg prose-primary max-w-none text-gray-700">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</x-layout>