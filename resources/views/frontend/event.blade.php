@extends('frontend.layouts.app')

@section('title', $event->title . ' - Agenda Kegiatan')
@section('meta_description', Str::limit(strip_tags($event->description), 150))

@push('styles')
    <style>
        .event-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .event-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .event-meta-banner {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            background: #eef2ff;
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            color: var(--primary-color);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .event-content {
            max-width: 800px;
            margin: 0 auto;
            background: var(--bg-surface);
            padding: 3rem;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
        }

        .prose {
            line-height: 1.8;
            color: var(--text-primary);
        }

        .prose p {
            /* No custom styles needed here, TailwindCSS handles styling */
    </style>
@endpush

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100">
            <!-- Featured Image -->
            @if($event->image)
                <div class="aspect-video w-full relative">
                    <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                    <div class="absolute top-6 left-6">
                        <span
                            class="px-4 py-2 rounded-full text-sm font-semibold {{ $event->type == 'online' ? 'bg-blue-600 text-white' : 'bg-emerald-600 text-white' }} shadow-lg">
                            <i data-feather="{{ $event->type == 'online' ? 'video' : 'map-pin' }}"
                                class="inline-block w-4 h-4 mr-1"></i>
                            {{ ucfirst($event->type) }}
                        </span>
                    </div>
                </div>
            @endif

            <div class="p-8 md:p-12">
                <div class="mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">{{ $event->title }}</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-emerald-50 rounded-2xl p-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100 flex-shrink-0">
                                <i data-feather="calendar" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs text-emerald-600 font-bold uppercase tracking-wider mb-1">Tanggal</p>
                                <p class="text-gray-800 font-medium">{{ $event->start_time->format('l, d F Y') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100 flex-shrink-0">
                                <i data-feather="clock" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs text-emerald-600 font-bold uppercase tracking-wider mb-1">Waktu</p>
                                <p class="text-gray-800 font-medium">
                                    {{ $event->start_time->format('H:i') }}
                                    @if($event->end_time)
                                        - {{ $event->end_time->format('H:i') }}
                                    @endif
                                    WIB
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100 flex-shrink-0">
                                <i data-feather="{{ $event->type == 'online' ? 'link' : 'map-pin' }}" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs text-emerald-600 font-bold uppercase tracking-wider mb-1">
                                    {{ $event->type == 'online' ? 'Link Meeting' : 'Lokasi' }}</p>
                                @if($event->type == 'online')
                                    @if($event->meeting_link)
                                        <a href="{{ $event->meeting_link }}" target="_blank"
                                            class="text-blue-600 font-medium flex items-center gap-1 hover:underline">
                                            Gabung Meeting <i data-feather="external-link" class="w-3 h-3"></i>
                                        </a>
                                    @else
                                        <p class="text-gray-500 italic">Link belum tersedia</p>
                                    @endif
                                @else
                                    <p class="text-gray-800 font-medium">{{ $event->location ?? 'Lokasi akan diumumkan' }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100 flex-shrink-0">
                                <i data-feather="user" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs text-emerald-600 font-bold uppercase tracking-wider mb-1">Penyelenggara
                                </p>
                                <p class="text-gray-800 font-medium">{{ $event->organizer_name ?? 'SDIT Al Irsyad' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed mb-12">
                    {!! $event->description !!}
                </div>

                @if($event->type == 'offline' && $event->map_link)
                    <div class="mb-12">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i data-feather="map" class="text-emerald-600"></i> Lokasi Acara
                        </h3>
                        <div class="rounded-2xl overflow-hidden border border-gray-200">
                            @if(Str::startsWith($event->map_link, '<iframe'))
                                {!! $event->map_link !!}
                            @else
                                <iframe width="100%" height="400" frameborder="0" style="border:0" src="{{ $event->map_link }}"
                                    allowfullscreen></iframe>
                            @endif
                        </div>
                    </div>
                @endif

                @if($event->sponsors && count($event->sponsors) > 0)
                    <div class="border-t border-gray-100 pt-12">
                        <h3 class="text-xl font-bold text-center text-gray-900 mb-8">Disponsori Oleh</h3>
                        <div class="flex flex-wrap justify-center items-center gap-8 md:gap-12">
                            @foreach($event->sponsors as $sponsor)
                                <div class="flex flex-col items-center gap-2 grayscale hover:grayscale-0 transition duration-300">
                                    @if(!empty($sponsor['logo']))
                                        <img src="{{ Storage::url($sponsor['logo']) }}" alt="{{ $sponsor['name'] }}"
                                            class="h-12 md:h-16 w-auto object-contain">
                                    @endif
                                    <span class="text-sm font-medium text-gray-500">{{ $sponsor['name'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="bg-gray-50 p-8 text-center border-t border-gray-100">
                <a href="{{ route('events.index') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-200 rounded-full text-gray-600 font-semibold hover:bg-gray-100 transition duration-200">
                    <i data-feather="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar Agenda
                </a>
            </div>
        </div>
    </div>
@endsection