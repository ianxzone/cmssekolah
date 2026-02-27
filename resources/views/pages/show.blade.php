<x-layout :title="$page->seo_title ?? $page->title" :metaDescription="$page->seo_description ?? Str::limit(strip_tags($page->content), 160)">
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

    <!-- Page Content -->
    <div class="bg-white min-h-screen py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="prose prose-lg prose-primary max-w-none text-gray-700">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</x-layout>