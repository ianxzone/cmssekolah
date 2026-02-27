@extends('admin.layouts.app')

@section('title', 'Manage Testimonials')

@section('content')
    <div class="panel">
        <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="panel-title">Testimonials</h2>
            <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
                <i data-feather="plus"></i> New Testimonial
            </a>
        </div>
        <div class="panel-body">
            @if($testimonials->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color);">
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Name</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Role</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Status</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500; text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testimonials as $testimonial)
                                <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.15s ease;"
                                    onmouseover="this.style.backgroundColor='#f9fafb'"
                                    onmouseout="this.style.backgroundColor='transparent'">
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            @if($testimonial->image)
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($testimonial->image) }}" alt="Image"
                                                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1px solid var(--border-color);">
                                            @else
                                                <div style="width: 40px; height: 40px; border-radius: 50%; background-color: var(--bg-body); display: flex; align-items: center; justify-content: center; color: var(--text-secondary);">
                                                    <i data-feather="user"></i>
                                                </div>
                                            @endif
                                            <span style="font-weight: 500;">{{ $testimonial->name }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem; text-transform: capitalize;">{{ $testimonial->role }}</td>
                                    <td style="padding: 1rem;">
                                        @if($testimonial->is_active)
                                            <span style="display: inline-flex; align-items: center; px-2.5; py-0.5; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: rgba(16, 185, 129, 0.1); color: #065f46; padding: 0.25rem 0.75rem;">Active</span>
                                        @else
                                            <span style="display: inline-flex; align-items: center; px-2.5; py-0.5; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: rgba(107, 114, 128, 0.1); color: #4b5563; padding: 0.25rem 0.75rem;">Inactive</span>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem; text-align: right;">
                                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}"
                                                style="padding: 0.5rem; color: var(--primary-color); background-color: rgba(79, 70, 229, 0.1); border-radius: 6px;"
                                                title="Edit">
                                                <i data-feather="edit-2" style="width: 18px; height: 18px;"></i>
                                            </a>
                                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this testimonial?');"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="padding: 0.5rem; color: var(--danger-color); background-color: rgba(239, 68, 68, 0.1); border: none; border-radius: 6px; cursor: pointer;"
                                                    title="Delete">
                                                    <i data-feather="trash-2" style="width: 18px; height: 18px;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 2rem;">
                    {{ $testimonials->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem 1rem;">
                    <div style="color: var(--text-secondary); margin-bottom: 1rem;">
                        <i data-feather="message-square" style="width: 48px; height: 48px; opacity: 0.5;"></i>
                    </div>
                    <h3 style="font-size: 1.125rem; font-weight: 500; color: var(--text-primary); margin-bottom: 0.5rem;">No testimonials found</h3>
                    <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Start adding testimonials from parents or students.</p>
                    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
                        <i data-feather="plus"></i> Add Testimonial
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
