@extends('admin.layouts.app')

@section('title', 'Edit Page')

@push('styles')
    <!-- Trix CDN -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <style>
        /* Trix Customization */
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }

        trix-editor {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: var(--bg-surface);
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            min-height: 300px;
        }

        trix-editor:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

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

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="panel">
        <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="panel-title">Edit Page: {{ $page->title }}</h2>
            <a href="/{{ $page->slug }}" target="_blank" class="btn"
                style="background-color: #f3f4f6; color: var(--text-primary);">
                <i data-feather="external-link"></i> View Live
            </a>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.pages.update', $page) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="title">Page Title <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control"
                            value="{{ old('title', $page->title) }}" required>
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="slug">URL Slug</label>
                        <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', $page->slug) }}"
                            required>
                        @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="content">Page Content <span class="text-danger">*</span></label>
                    <input id="content" type="hidden" name="content" value="{{ old('content', $page->content) }}">
                    <trix-editor input="content"></trix-editor>
                    @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <h3
                    style="font-size: 1.125rem; font-weight: 600; margin: 2rem 0 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">
                    SEO & Advanced Settings</h3>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="seo_title">SEO Title</label>
                        <input type="text" id="seo_title" name="seo_title" class="form-control"
                            value="{{ old('seo_title', $page->seo_title) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="type">Page Type</label>
                        <input type="text" id="type" name="type" class="form-control" value="{{ old('type', $page->type) }}"
                            placeholder="e.g. standard, landing">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="seo_description">SEO Description</label>
                    <textarea id="seo_description" name="seo_description" class="form-control"
                        rows="3">{{ old('seo_description', $page->seo_description) }}</textarea>
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="save"></i> Update Page
                    </button>
                    <a href="{{ route('admin.pages.index') }}" class="btn"
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
        // Disable file uploads completely just to be safe.
        document.addEventListener("trix-file-accept", function (event) {
            event.preventDefault();
        });
    </script>
@endpush