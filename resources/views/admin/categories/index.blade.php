@extends('admin.layouts.app')

@section('title', 'Manage Categories')

@section('content')
    <div class="panel">
        <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="panel-title">Categories</h2>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i data-feather="plus"></i> New Category
            </a>
        </div>
        <div class="panel-body">
            @if($categories->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color);">
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Category Name</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Parent</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Slug</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Total Posts</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500; text-align: right;">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.15s ease;"
                                    onmouseover="this.style.backgroundColor='#f9fafb'"
                                    onmouseout="this.style.backgroundColor='transparent'">
                                    <td style="padding: 1rem; font-weight: 500;">
                                        @if($category->parent)
                                            <span style="color: var(--text-secondary); font-weight: normal;">— </span>
                                        @endif
                                        {{ $category->name }}
                                    </td>
                                    <td style="padding: 1rem; color: var(--text-secondary);">
                                        {{ $category->parent ? $category->parent->name : '-' }}
                                    </td>
                                    <td style="padding: 1rem; color: var(--text-secondary);">{{ $category->slug }}</td>
                                    <td style="padding: 1rem;">
                                        <span
                                            style="font-weight: 600; color: var(--primary-color);">{{ $category->posts_count }}</span>
                                    </td>
                                    <td style="padding: 1rem; text-align: right;">
                                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                            <a href="{{ route('admin.categories.edit', $category) }}"
                                                style="padding: 0.5rem; color: var(--primary-color); background-color: rgba(79, 70, 229, 0.1); border-radius: 6px;"
                                                title="Edit">
                                                <i data-feather="edit-2" style="width: 18px; height: 18px;"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this category? Associated posts might be affected.');"
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
                    {{ $categories->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem 1rem;">
                    <div style="color: var(--text-secondary); margin-bottom: 1rem;">
                        <i data-feather="folder" style="width: 48px; height: 48px; opacity: 0.5;"></i>
                    </div>
                    <h3 style="font-size: 1.125rem; font-weight: 500; color: var(--text-primary); margin-bottom: 0.5rem;">No
                        categories found</h3>
                    <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Get started by creating your first category.
                    </p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i data-feather="plus"></i> Create Category
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection