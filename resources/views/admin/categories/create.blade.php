@extends('admin.layouts.app')

@section('title', 'Create Category')

@push('styles')
    <style>
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.875rem;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .text-danger {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }
    </style>
@endpush

@section('content')
    <div class="panel" style="max-width: 600px; margin: 0 auto;">
        <div class="panel-header">
            <h2 class="panel-title">New Category</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Category Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required
                        autofocus onkeyup="generateSlug()">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="slug">URL Slug (Auto-generated)</label>
                    <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug') }}">
                    @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="save"></i> Save Category
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn"
                        style="background-color: var(--bg-body); border-color: var(--border-color);">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function generateSlug() {
            let title = document.getElementById('name').value;
            let slug = title.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // Remove invalid chars
                .replace(/\s+/g, '-')         // Replace spaces with -
                .replace(/-+/g, '-')         // Collapse multiple -
                .trim();
            document.getElementById('slug').value = slug;
        }
    </script>
@endpush