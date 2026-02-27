<x-layout :title="$event->title">
    <div class="bg-gray-50 min-h-screen py-8 md:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex mb-6 text-sm text-gray-500">
                <a href="/" class="hover:text-primary-600">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('events.index') }}" class="hover:text-primary-600">Agenda</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ $event->title }}</span>
            </nav>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Main Content -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        @if($event->image)
                        <div class="w-full h-64 md:h-80 relative">
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                        </div>
                        @endif
                        
                        <div class="p-8">
                            <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $event->title }}</h1>
                            
                            <div class="prose prose-primary max-w-none text-gray-700">
                                {!! $event->description !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Info & Booking -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">Detail Kegiatan</h3>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex gap-4">
                                <div class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center text-primary-600 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tanggal</p>
                                    <p class="font-semibold text-gray-900">{{ $event->start_time->format('l, d F Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex gap-4">
                                <div class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center text-primary-600 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Waktu</p>
                                    <p class="font-semibold text-gray-900">
                                        {{ $event->start_time->format('H:i') }} - {{ $event->end_time ? $event->end_time->format('H:i') : 'Selesai' }} WIB
                                    </p>
                                </div>
                            </div>

                            @if($event->location)
                            <div class="flex gap-4">
                                <div class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center text-primary-600 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Lokasi</p>
                                    <p class="font-semibold text-gray-900">{{ $event->location }}</p>
                                </div>
                            </div>
                            @endif
                            
                             @if($event->capacity)
                            <div class="flex gap-4">
                                <div class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center text-primary-600 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Kuota</p>
                                    <p class="font-semibold text-gray-900">{{ $event->capacity }} Orang</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <button class="w-full py-3 bg-secondary-600 hover:bg-secondary-700 text-white font-bold rounded-xl shadow-lg shadow-secondary-600/20 transition transform active:scale-95">
                            Daftar Sekarang
                        </button>
                        <p class="text-center text-xs text-gray-400 mt-3">Segera daftar sebelum kuota habis!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
