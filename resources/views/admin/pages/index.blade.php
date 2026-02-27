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
            @if($pages->count() > 0)
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color);">
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Title</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Slug</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Type</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500; text-align: right;">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pages as $page)
                                <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.15s ease;"
                                    onmouseover="this.style.backgroundColor='#f9fafb'"
                                    onmouseout="this.style.backgroundColor='transparent'">
                                    <td style="padding: 1rem; font-weight: 500;">{{ $page->title }}</td>
                                    <td style="padding: 1rem; color: var(--text-secondary);">/{{ $page->slug }}</td>
                                    <td style="padding: 1rem;">
                                        <span
                                            style="background-color: #e0e7ff; color: #4338ca; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                            {{ $page->type ?? 'Default' }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem; text-align: right;">
                                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                            <a href="/{{ $page->slug }}" target="_blank"
                                                style="padding: 0.5rem; color: var(--text-secondary); border-radius: 6px;"
                                                title="View">
                                                <i data-feather="external-link" style="width: 18px; height: 18px;"></i>
                                            </a>
                                            <a href="{{ route('admin.pages.edit', $page) }}"
                                                style="padding: 0.5rem; color: var(--primary-color); background-color: rgba(79, 70, 229, 0.1); border-radius: 6px;"
                                                title="Edit">
                                                <i data-feather="edit-2" style="width: 18px; height: 18px;"></i>
                                            </a>
                                            <form action="{{ route('admin.pages.destroy', $page) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this page?');"
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
                    {{ $pages->links() }}
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