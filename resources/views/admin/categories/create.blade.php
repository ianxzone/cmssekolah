@extends('admin.layouts.app')

@section('title', 'Create Category')

@section('content')

    <div class="panel" style="max-width: 600px; margin: 0 auto;">
        <div class="panel-header">
            <h2 class="panel-title">New Category</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="parent_id">Parent Category</label>
                    <select id="parent_id" name="parent_id" class="form-control">
                        <option value="">-- None (Top Level) --</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="name">Category Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required
                        autofocus onkeyup="generateSlug()">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea id="description" name="description" class="form-control"
                        rows="3">{{ old('description') }}</textarea>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="slug">URL Slug (Auto-generated)</label>
                    <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug') }}">
                    @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <h3
                    style="font-size: 1.125rem; font-weight: 600; margin: 2rem 0 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">
                    SEO Settings</h3>

                <div class="form-group">
                    <label class="form-label" for="seo_title">SEO Title</label>
                    <input type="text" id="seo_title" name="seo_title" class="form-control" value="{{ old('seo_title') }}">
                    @error('seo_title') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="seo_description">SEO Description</label>
                    <textarea id="seo_description" name="seo_description" class="form-control"
                        rows="3">{{ old('seo_description') }}</textarea>
                    @error('seo_description') <span class="text-danger">{{ $message }}</span> @enderror
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