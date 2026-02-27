<x-layout title="Agenda & Kegiatan | SDIT Al Irsyad Karawang">
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Agenda & Kegiatan</h1>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Informasi jadwal kegiatan sekolah, event, seminar, dan
                    acara penting lainnya.</p>
            </div>

            @if($events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($events as $event)
                        <div
                            class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition duration-300 overflow-hidden border border-gray-100 flex flex-col md:flex-row">
                            <div class="md:w-1/3 h-48 md:h-auto relative bg-gray-200">
                                @if($event->image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($event->image) }}"
                                        alt="{{ $event->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                                <!-- Date Badge -->
                                <div class="absolute top-4 left-4 bg-white rounded-lg shadow-md p-2 text-center min-w-[60px]">
                                    <span
                                        class="block text-xl font-bold text-gray-900">{{ $event->start_time->format('d') }}</span>
                                    <span
                                        class="block text-xs font-semibold text-primary-600 uppercase">{{ $event->start_time->format('M') }}</span>
                                </div>
                            </div>
                            <div class="p-6 md:w-2/3 flex flex-col">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-primary-600 transition">
                                    <a href="{{ route('events.show', $event->id) }}">{{ $event->title }}</a>
                                </h3>
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $event->start_time->format('H:i') }} -
                                            {{ $event->end_time ? $event->end_time->format('H:i') : 'Selesai' }} WIB</span>
                                    </div>
                                    @if($event->location)
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span>{{ $event->location }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-center">
                                    <span
                                        class="text-sm font-medium {{ $event->capacity && $event->capacity > 0 ? 'text-green-600' : 'text-gray-500' }}">
                                        {{ $event->capacity ? 'Kuota: ' . $event->capacity . ' Orang' : 'Terbuka untuk umum' }}
                                    </span>
                                    <a href="{{ route('events.show', $event->id) }}"
                                        class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold rounded-lg transition shadow-sm">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $events->links() }}
                </div>
            @else
                <p class="text-center text-gray-500 py-12">Belum ada agenda kegiatan yang dijadwalkan.</p>
            @endif
        </div>
    </div>
</x-layout>