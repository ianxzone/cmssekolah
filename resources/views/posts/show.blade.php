<x-layout :title="$post->seo_title ?? $post->title" :metaDescription="$post->seo_description ?? Str::limit(strip_tags($post->content), 160)">
    <div class="bg-gray-50 min-h-screen py-8 md:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="flex mb-6 text-sm text-gray-500">
                <a href="/" class="hover:text-primary-600">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('posts.index') }}" class="hover:text-primary-600">Berita</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900 truncate max-w-[200px]">{{ $post->title }}</span>
            </nav>

            <article class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                <!-- Header Image -->
                @if($post->image)
                    <div class="w-full h-64 md:h-96 relative">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image) }}" alt="{{ $post->title }}"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    </div>
                @endif

                <div class="p-8 md:p-12">
                    <!-- Meta Header -->
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-6">
                        @if($post->category)
                            <span
                                class="bg-primary-50 text-primary-700 font-bold px-3 py-1 rounded-full border border-primary-100">
                                {{ $post->category->name }}
                            </span>
                        @endif
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{ $post->published_at ? $post->published_at->format('l, d F Y') : $post->created_at->format('l, d F Y') }}
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-8 leading-tight">
                        {{ $post->title }}
                    </h1>

                    <!-- Content -->
                    <div class="prose prose-lg prose-primary max-w-none text-gray-700 mb-12">
                        {!! $post->content !!}
                    </div>

                    <!-- Tags -->
                    @if($post->tags->count() > 0)
                        <div class="flex flex-wrap gap-2 mb-8 pt-6 border-t border-gray-100">
                            <span class="text-sm font-medium text-gray-500 mr-2">Topik:</span>
                            @foreach($post->tags as $tag)
                                <span
                                    class="text-sm bg-gray-100 text-gray-600 px-3 py-1 rounded-lg hover:bg-gray-200 transition cursor-pointer">#{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif

                    <!-- Social Share -->
                    <div class="bg-gray-50 rounded-xl p-6 flex flex-col md:flex-row items-center justify-between gap-4">
                        <span class="font-bold text-gray-700">Bagikan artikel ini:</span>
                        <div class="flex gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                target="_blank"
                                class="w-10 h-10 rounded-full bg-[#1877F2] text-white flex items-center justify-center hover:opacity-90 transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.791-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}"
                                target="_blank"
                                class="w-10 h-10 rounded-full bg-[#1DA1F2] text-white flex items-center justify-center hover:opacity-90 transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . request()->url()) }}"
                                target="_blank"
                                class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:opacity-90 transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.008-.57-.008-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.304-5.235c0-5.443 4.429-9.876 9.88-9.876 2.639 0 5.122 1.026 6.988 2.894a9.825 9.825 0 012.893 6.991c-.001 5.443-4.43 9.879-9.878 9.858m0-19.876C5.975 1.909 0 7.86 0 15.149c0 2.333.607 4.546 1.76 6.471L.484 26.545l4.897-1.284c1.83 1.013 3.903 1.558 5.966 1.558 9.179 0 15.15-5.952 15.149-15.151 0-4.045-1.574-7.85-4.434-10.71A15.109 15.109 0 0012.051 1.909z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            </article>

            <!-- Navigation to Next/Prev would go here if implemented -->

        </div>
    </div>
</x-layout>