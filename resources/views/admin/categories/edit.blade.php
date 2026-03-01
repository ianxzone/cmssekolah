@extends('admin.layouts.app')

@section('title', 'Edit Category')

@push('styles')
@endpush

@section('content')
    <div class="panel" style="max-width: 600px; margin: 0 auto;">
        <div class="panel-header">
            <h2 class="panel-title">Edit Category: {{ $category->name }}</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="parent_id">Parent Category</label>
                    <select id="parent_id" name="parent_id" class="form-control">
                        <option value="">-- None (Top Level) --</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="name">Category Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}"
                        required autofocus onkeyup="generateSlug()">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea id="description" name="description" class="form-control"
                        rows="3">{{ old('description', $category->description) }}</textarea>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="slug">URL Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}"
                        required>
                    @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <h3
                    style="font-size: 1.125rem; font-weight: 600; margin: 2rem 0 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">
                    SEO Settings</h3>

                <div class="form-group">
                    <label class="form-label" for="seo_title">SEO Title</label>
                    <input type="text" id="seo_title" name="seo_title" class="form-control"
                        value="{{ old('seo_title', $category->seo_title) }}">
                    @error('seo_title') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="seo_description">SEO Description</label>
                    <textarea id="seo_description" name="seo_description" class="form-control"
                        rows="3">{{ old('seo_description', $category->seo_description) }}</textarea>
                    @error('seo_description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="save"></i> Update Category
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
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            document.getElementById('slug').value = slug;
        }
    </script>
@endpush