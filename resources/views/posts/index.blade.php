<x-layout title="Berita Sekolah | SDIT Al Irsyad Karawang">
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Berita & Informasi Sekolah</h1>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Dapatkan informasi terbaru mengenai kegiatan, prestasi,
                    dan pengumuman sekolah.</p>
            </div>

            <!-- Search/Filter (Placeholder) -->
            <div class="mb-8 flex justify-center">
                <div class="relative w-full max-w-md">
                    <input type="text" placeholder="Cari berita..."
                        class="w-full pl-10 pr-4 py-3 rounded-full border border-gray-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-3.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            @if($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                        <article
                            class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition duration-300 overflow-hidden flex flex-col h-full border border-gray-100">
                            <a href="{{ route('posts.show', $post->slug) }}" class="block relative h-48 overflow-hidden">
                                @if($post->image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image) }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4">
                                    @if($post->category)
                                        <span
                                            class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-primary-700 shadow-sm">
                                            {{ $post->category->name }}
                                        </span>
                                    @endif
                                </div>
                            </a>
                            <div class="p-6 flex-grow flex flex-col">
                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-primary-600 transition line-clamp-2">
                                    <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                                </h3>
                                <div class="text-gray-600 text-sm line-clamp-3 mb-4 flex-grow">
                                    {{ Str::limit(strip_tags($post->content), 120) }}
                                </div>
                                <a href="{{ route('posts.show', $post->slug) }}"
                                    class="inline-flex items-center text-primary-600 font-medium hover:underline text-sm mt-auto">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-2xl shadow-sm">
                    <div class="inline-block p-4 rounded-full bg-gray-100 mb-4 text-gray-400">
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900">Belum ada berita</h3>
                    <p class="text-gray-500 mt-2">Silakan kembali lagi nanti untuk update terbaru.</p>
                </div>
            @endif
        </div>
    </div>
</x-layout>