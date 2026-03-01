@extends('theme::layouts.app')

@section('title', 'Agenda Kegiatan - ' . config('app.name'))
@section('meta_description', 'Jadwal dan agenda kegiatan mendatang di sekolah kami.')

@push('styles')
    <style>
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: var(--text-secondary);
            font-size: 1.125rem;
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }

        .event-card {
            background: var(--bg-surface);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
        }

        .event-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .event-date-box {
            background-color: #eef2ff;
            color: var(--primary-color);
            border-radius: var(--radius-md);
            padding: 0.75rem 1rem;
            text-align: center;
            min-width: 80px;
        }

        .event-date-box .day {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
            display: block;
        }

        .event-date-box .month {
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .event-details flex-grow: 1;
        }

        .event-title {
            margin-bottom: 0.5rem;
            font-size: 1.125rem;
        }

        .event-title a {
            color: var(--text-primary);
            font-weight: 700;
        }

        .event-title a:hover {
            color: var(--primary-color);
        }

        .event-meta {
            font-size: 0.875rem;
            color: var(--text-secondary);
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            margin-bottom: 1rem;
        }

        .event-meta span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
            color: var(--text-secondary);
            background: var(--bg-surface);
            border-radius: var(--radius-lg);
            border: 1px dashed var(--border-color);
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1>Agenda Kegiatan</h1>
        <p>Jadwal acara dan kegiatan mendatang di sekolah kami.</p>
    </div>

    @if($events->count() > 0)
        <div class="events-grid">
            @foreach($events as $event)
                <div class="event-card">
                    <div class="event-date-box">
                        <span class="day">{{ $event->start_time->format('d') }}</span>
                        <span class="month">{{ $event->start_time->format('M') }}</span>
                    </div>
                    <div class="event-details">
                        <h2 class="event-title">
                            <a href="{{ route('events.show', $event->id) }}">{{ $event->title }}</a>
                        </h2>
                        <div class="event-meta">
                            <span><i data-feather="clock" style="width: 14px; height: 14px;"></i>
                                {{ $event->start_time->format('H:i') }}</span>
                            @if($event->location)
                                <span><i data-feather="map-pin" style="width: 14px; height: 14px;"></i> {{ $event->location }}</span>
                            @endif
                        </div>
                        <a href="{{ route('events.show', $event->id) }}"
                            class="text-sm font-medium text-primary-600 hover:text-primary-700">Detail Kegiatan &rarr;</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 3rem; display: flex; justify-content: center;">
            {{ $events->links() }}
        </div>
    @else
        <div class="empty-state">
            <i data-feather="calendar" style="width: 48px; height: 48px; opacity: 0.5; margin-bottom: 1rem;"></i>
            <h3>Belum ada agenda</h3>
            <p>Saat ini tidak ada kegiatan yang dijadwalkan.</p>
        </div>
    @endif
@endsection