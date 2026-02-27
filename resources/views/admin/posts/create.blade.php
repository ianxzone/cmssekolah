@extends('admin.layouts.app')

@section('title', 'Create Post')

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

        .grid-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            align-items: start;
        }

        @media (max-width: 900px) {
            .grid-layout {
                grid-template-columns: 1fr;
            }
        }

        .sidebar-panel {
            background-color: #f9fafb;
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }
    </style>
@endpush

@section('content')
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Write New Post</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid-layout">
                    <!-- Main Content Area -->
                    <div>
                        <div class="form-group">
                            <label class="form-label" for="title">Post Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}"
                                required autofocus onkeyup="generateSlug()"
                                style="font-size: 1.25rem; font-weight: 500; padding: 1rem;">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="subtitle">Sub Title</label>
                            <input type="text" id="subtitle" name="subtitle" class="form-control" value="{{ old('subtitle') }}"
                                placeholder="Enter a catchy sub title...">
                            @error('subtitle') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <label class="form-label" for="content" style="margin-bottom: 0;">Content <span class="text-danger">*</span></label>
                                <span id="content-word-count" style="font-size: 0.75rem; color: var(--text-secondary);">0 words</span>
                            </div>
                            <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                            <trix-editor input="content"></trix-editor>
                            @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <label class="form-label" for="description" style="margin-bottom: 0;">Short Description / Excerpt</label>
                                <span id="description-word-count" style="font-size: 0.75rem; color: var(--text-secondary);">0 words</span>
                            </div>
                            <textarea id="description" name="description" class="form-control"
                                rows="3" placeholder="Brief summary of the post...">{{ old('description') }}</textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <h3
                            style="font-size: 1.125rem; font-weight: 600; margin: 2rem 0 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">
                            SEO Settings</h3>

                        <div class="form-group">
                            <label class="form-label" for="seo_title">SEO Title</label>
                            <input type="text" id="seo_title" name="seo_title" class="form-control"
                                value="{{ old('seo_title') }}">
                            @error('seo_title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="seo_description">SEO Description</label>
                            <textarea id="seo_description" name="seo_description" class="form-control"
                                rows="3">{{ old('seo_description') }}</textarea>
                            @error('seo_description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Sidebar Area -->
                    <div class="sidebar-panel">
                        <div class="form-group">
                            <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-control" required style="font-weight: 500;" onchange="toggleSchedule()">
                                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Save as Draft</option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publish Immediately</option>
                                <option value="scheduled" {{ old('status') === 'scheduled' ? 'selected' : '' }}>Schedule</option>
                            </select>
                            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div id="schedule-group" class="form-group" style="display: {{ old('status') === 'scheduled' ? 'block' : 'none' }};">
                            <label class="form-label" for="published_at">Schedule Date & Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" id="published_at" name="published_at" class="form-control" value="{{ old('published_at') }}">
                            @error('published_at') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="category_id">Category <span class="text-danger">*</span></label>
                            <select id="category_id" name="category_id" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group" style="margin-top: 1.5rem;">
                            <label class="form-label" for="image">Featured Image</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*"
                                onchange="previewImage(event)">
                            <div id="image-preview"
                                style="margin-top: 1rem; width: 100%; aspect-ratio: 16/9; background-color: var(--border-color); border-radius: 8px; overflow: hidden; display: none; align-items: center; justify-content: center;">
                                <img id="preview-img" src="#" alt="Preview"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="slug">URL Slug (Auto-generated)</label>
                            <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug') }}">
                            <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.25rem;">Leave blank to
                                auto-generate based on title.</p>
                            @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div style="margin-top: 2.5rem; display: flex; flex-direction: column; gap: 1rem;">
                            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                                <i data-feather="save"></i> Save Post
                            </button>
                            <a href="{{ route('admin.posts.index') }}" class="btn"
                                style="width: 100%; justify-content: center; background-color: white; border-color: var(--border-color);">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleSchedule() {
            const status = document.getElementById('status').value;
            const scheduleGroup = document.getElementById('schedule-group');
            if (status === 'scheduled') {
                scheduleGroup.style.display = 'block';
                document.getElementById('published_at').required = true;
            } else {
                scheduleGroup.style.display = 'none';
                document.getElementById('published_at').required = false;
            }
        }

        function countWords(str) {
            str = str.replace(/(^\s*)|(\s*$)/gi, "");
            str = str.replace(/[ ]{2,}/gi, " ");
            str = str.replace(/\n /, "\n");
            if (str === "") return 0;
            return str.split(' ').length;
        }

        function updateWordCount(inputId, displayId, isTrix = false) {
            const display = document.getElementById(displayId);
            let text = "";
            if (isTrix) {
                const editor = document.querySelector("trix-editor");
                text = editor.editor.getDocument().toString();
            } else {
                text = document.getElementById(inputId).value;
            }
            const count = countWords(text);
            display.innerText = `${count} word${count !== 1 ? 's' : ''}`;
        }

        document.addEventListener('trix-change', () => {
            updateWordCount('content', 'content-word-count', true);
        });

        document.getElementById('description').addEventListener('input', () => {
            updateWordCount('description', 'description-word-count');
        });

        function generateSlug() {
            let title = document.getElementById('title').value;
            let slug = title.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            document.getElementById('slug').value = slug;
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const preview = document.getElementById('image-preview');
                const img = document.getElementById('preview-img');
                img.src = reader.result;
                preview.style.display = 'flex';
            }
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        // Disable Trix file upload
        document.addEventListener("trix-file-accept", function (event) {
            event.preventDefault();
        });

        // Initialize counts
        window.onload = function() {
            updateWordCount('description', 'description-word-count');
            // Trix takes a moment to initialize
            setTimeout(() => updateWordCount('content', 'content-word-count', true), 500);
        };
    </script>
@endpush