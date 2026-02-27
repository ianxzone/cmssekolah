@extends('admin.layouts.app')

@section('title', 'Events')

@section('content')
    <div class="panel">
        <div class="panel-header d-flex justify-content-between align-items-center">
            <h2 class="panel-title">All Events</h2>
            <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                <i data-feather="plus"></i> Create Event
            </a>
        </div>
        <div class="panel-body">
            @if($events->count() > 0)
                <div class="table-responsive">
                    <table class="table w-100" style="text-align: left; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color);">
                                <th style="padding: 1rem;">Image</th>
                                <th style="padding: 1rem;">Event Title</th>
                                <th style="padding: 1rem;">Date & Time</th>
                                <th style="padding: 1rem;">Location</th>
                                <th style="padding: 1rem;">Capacity</th>
                                <th style="padding: 1rem; text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="padding: 1rem;">
                                        @if($event->image)
                                            <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        @else
                                            <div style="width: 60px; height: 60px; background-color: var(--border-color); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                <i data-feather="image" style="color: var(--text-secondary);"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem; font-weight: 500;">
                                        {{ $event->title }}
                                    </td>
                                    <td style="padding: 1rem; color: var(--text-secondary);">
                                        <div>{{ $event->start_time->format('M d, Y') }}</div>
                                        <div style="font-size: 0.8rem;">{{ $event->start_time->format('H:i') }} - {{ $event->end_time ? $event->end_time->format('H:i') : 'TBD' }}</div>
                                    </td>
                                    <td style="padding: 1rem; color: var(--text-secondary);">
                                        {{ $event->location ?? 'Not specified' }}
                                    </td>
                                     <td style="padding: 1rem; color: var(--text-secondary);">
                                        {{ $event->capacity ? $event->capacity . ' people' : 'Unlimited' }}
                                    </td>
                                    <td style="padding: 1rem; text-align: right;">
                                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                            <a href="{{ route('admin.events.edit', $event) }}" class="btn" style="padding: 0.5rem; background-color: rgba(79, 70, 229, 0.1); color: var(--primary-color);" title="Edit">
                                                <i data-feather="edit-2"></i>
                                            </a>
                                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn" style="padding: 0.5rem; background-color: rgba(239, 68, 68, 0.1); color: var(--danger-color);" title="Delete">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div style="margin-top: 1.5rem;">
                    {{ $events->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem 1rem;">
                    <i data-feather="calendar" style="width: 48px; height: 48px; color: var(--text-secondary); margin-bottom: 1rem;"></i>
                    <h3 style="color: var(--text-primary); margin-bottom: 0.5rem;">No Events Found</h3>
                    <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Get started by creating your first event.</p>
                    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                        <i data-feather="plus"></i> Create Event
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
