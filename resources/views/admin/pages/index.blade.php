@extends('admin.layouts.app')

@section('title', 'Manage Pages')

@section('content')
    <div class="panel">
        <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="panel-title">All Pages</h2>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                <i data-feather="plus"></i> Create New Page
            </a>
        </div>
        <div class="panel-body">
            <form method="GET" action="{{ route('admin.pages.index') }}" style="display: flex; gap: 1rem; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap;">
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <input type="text" name="search" style="padding: 0.625rem 1rem; border: 1px solid var(--border-color); border-radius: 8px; width: 280px; max-width: 100%;" placeholder="Cari judul atau slug..." value="{{ request('search') }}">
                    <select name="status" style="padding: 0.625rem 1rem; border: 1px solid var(--border-color); border-radius: 8px; background-color: white;" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published (Terbit)</option>
                        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled (Terjadwal)</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending Review</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                    </select>
                </div>
                @if(request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('admin.pages.index') }}" style="color: var(--text-secondary); font-size: 0.875rem; text-decoration: underline;">Reset Filter</a>
                @endif
            </form>

            @if($pages->count() > 0)
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color);">
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Title</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Slug</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Status</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Type</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Date</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500; text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pages as $page)
                                <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.15s ease;"
                                    onmouseover="this.style.backgroundColor='#f9fafb'"
                                    onmouseout="this.style.backgroundColor='transparent'">
                                    <td style="padding: 1rem; font-weight: 600; color: var(--text-primary);">{{ $page->title }}</td>
                                    <td style="padding: 1rem; color: var(--text-secondary); font-size: 0.875rem;"><code>/{{ $page->slug }}</code></td>
                                    <td style="padding: 1rem;">
                                        @if($page->status === 'published')
                                            @if($page->published_at && $page->published_at->isFuture())
                                                <span style="display: inline-flex; align-items: center; gap: 5px; background-color: rgba(59, 130, 246, 0.1); color: #2563eb; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                                    <i data-feather="clock" style="width: 12px; height: 12px;"></i> Scheduled
                                                </span>
                                            @else
                                                <span style="display: inline-flex; align-items: center; gap: 5px; background-color: rgba(16, 185, 129, 0.1); color: #059669; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                                    <i data-feather="check-circle" style="width: 12px; height: 12px;"></i> Published
                                                </span>
                                            @endif
                                        @elseif($page->status === 'scheduled')
                                            <span style="display: inline-flex; align-items: center; gap: 5px; background-color: rgba(59, 130, 246, 0.1); color: #2563eb; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                                <i data-feather="calendar" style="width: 12px; height: 12px;"></i> Scheduled
                                            </span>
                                        @elseif($page->status === 'pending')
                                            <span style="display: inline-flex; align-items: center; gap: 5px; background-color: rgba(245, 158, 11, 0.12); color: #d97706; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                                <i data-feather="alert-circle" style="width: 12px; height: 12px;"></i> Pending Review
                                            </span>
                                        @else
                                            <span style="display: inline-flex; align-items: center; gap: 5px; background-color: rgba(107, 114, 128, 0.12); color: #4b5563; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                                <i data-feather="file-text" style="width: 12px; height: 12px;"></i> Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem;">
                                        <span
                                            style="background-color: #e0e7ff; color: #4338ca; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                            {{ $page->type ?? 'Default' }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; font-size: 0.825rem; color: var(--text-secondary);">
                                        @if(($page->status === 'scheduled' || ($page->published_at && $page->published_at->isFuture())) && $page->published_at)
                                            <div><strong style="color: #2563eb;">Jadwal:</strong><br>{{ $page->published_at->format('d M Y, H:i') }}</div>
                                        @elseif($page->published_at)
                                            <div>{{ $page->published_at->format('d M Y, H:i') }}</div>
                                        @else
                                            <div>Diedit:<br>{{ $page->updated_at->format('d M Y') }}</div>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem; text-align: right;">
                                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                            <a href="/{{ $page->slug }}" target="_blank"
                                                style="padding: 0.5rem; color: var(--text-secondary); border-radius: 6px;"
                                                title="Lihat / Pratinjau">
                                                <i data-feather="external-link" style="width: 18px; height: 18px;"></i>
                                            </a>
                                            <a href="{{ route('admin.pages.edit', $page) }}"
                                                style="padding: 0.5rem; color: var(--primary-color); background-color: rgba(79, 70, 229, 0.1); border-radius: 6px;"
                                                title="Edit">
                                                <i data-feather="edit-2" style="width: 18px; height: 18px;"></i>
                                            </a>
                                            <form action="{{ route('admin.pages.destroy', $page) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus halaman ini?');"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="padding: 0.5rem; color: var(--danger-color); background-color: rgba(239, 68, 68, 0.1); border: none; border-radius: 6px; cursor: pointer;"
                                                    title="Hapus">
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
                    {{ $pages->appends(request()->query())->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem 1rem;">
                    <div style="color: var(--text-secondary); margin-bottom: 1rem;">
                        <i data-feather="file" style="width: 48px; height: 48px; opacity: 0.5;"></i>
                    </div>
                    <h3 style="font-size: 1.125rem; font-weight: 500; color: var(--text-primary); margin-bottom: 0.5rem;">No
                        pages found</h3>
                    <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Get started by creating your first page.</p>
                    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                        <i data-feather="plus"></i> Create New Page
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection