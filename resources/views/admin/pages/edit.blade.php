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

        /* Media Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            width: 80%;
            max-width: 900px;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            display: flex;
            flex-direction: column;
            max-height: 85vh;
        }

        .modal-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 1.5rem;
            overflow-y: auto;
            flex-grow: 1;
        }

        .media-picker-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 1rem;
        }

        .media-item {
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.2s;
        }

        .media-item:hover {
            border-color: var(--primary-color);
        }

        .media-item.selected {
            border-color: var(--primary-color);
            background: rgba(79, 70, 229, 0.05);
        }

        .media-item-preview {
            aspect-ratio: 1;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .media-item-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .media-item-name {
            font-size: 0.75rem;
            padding: 0.5rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: center;
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

    <!-- Media Library Modal -->
    <div id="mediaModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="font-weight: 600; margin: 0;">Media Library</h3>
                <button onclick="closeMediaModal()"
                    style="border: none; background: none; cursor: pointer; color: var(--text-secondary);">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div style="margin-bottom: 1.5rem; display: flex; gap: 1rem;">
                    <input type="text" id="mediaSearch" class="form-control" placeholder="Search media..."
                        onkeyup="fetchMediaItems()">
                    <button class="btn btn-primary" onclick="insertSelectedMedia()">Insert Selected</button>
                </div>
                <div id="mediaPickerGrid" class="media-picker-grid">
                    <!-- Loaded via JS -->
                </div>
                <div id="mediaLoading" style="text-align: center; padding: 2rem; display: none;">
                    <div style="color: var(--text-secondary);">Loading...</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Trix Attachment Handling
        document.addEventListener("trix-attachment-add", function (event) {
            if (event.attachment.file) {
                uploadFileAttachment(event.attachment);
            }
        });

        function uploadFileAttachment(attachment) {
            const file = attachment.file;
            const form = new FormData();
            form.append("file", file);

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "{{ route('admin.media.store') }}", true);
            xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
            xhr.setRequestHeader("Accept", "application/json");

            xhr.upload.onprogress = function (event) {
                const progress = event.loaded / event.total * 100;
                attachment.setUploadProgress(progress);
            };

            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    attachment.setAttributes({
                        url: response.url,
                        href: response.url
                    });
                }
            };

            xhr.send(form);
        }

        // Trix Toolbar Customization: Add Media Button
        document.addEventListener("trix-initialize", function (event) {
            const buttonGroup = event.target.toolbarElement.querySelector(".trix-button-group--block-tools");
            const btnHtml = `<button type="button" class="trix-button trix-button--icon" data-trix-action="add-media" title="Add Media" style="background-image: none !important; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="pointer-events: none;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </button>`;
            buttonGroup.insertAdjacentHTML("beforeend", btnHtml);

            event.target.toolbarElement.querySelector('[data-trix-action="add-media"]').addEventListener("click", () => {
                openMediaModal();
            });
        });

        let selectedMediaItem = null;

        function openMediaModal() {
            document.getElementById('mediaModal').style.display = 'block';
            fetchMediaItems();
        }

        function closeMediaModal() {
            document.getElementById('mediaModal').style.display = 'none';
        }

        async function fetchMediaItems() {
            const search = document.getElementById('mediaSearch').value;
            const grid = document.getElementById('mediaPickerGrid');
            const loader = document.getElementById('mediaLoading');

            grid.innerHTML = '';
            loader.style.display = 'block';

            try {
                const response = await fetch(`{{ route('admin.media.list') }}?search=${search}`);
                const result = await response.json();

                loader.style.display = 'none';

                if (result.data.length === 0) {
                    grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; color: var(--text-secondary);">No media found.</div>';
                    return;
                }

                result.data.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'media-item';
                    div.onclick = () => selectMediaItem(item, div);

                    const preview = item.mime_type.startsWith('image/')
                        ? `<img src="/storage/${item.path}" alt="${item.name}">`
                        : `<svg style="width: 48px; height: 48px; opacity: 0.3;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>`;

                    div.innerHTML = `
                                <div class="media-item-preview">${preview}</div>
                                <div class="media-item-name">${item.name}</div>
                            `;
                    grid.appendChild(div);
                });
                feather.replace();
            } catch (error) {
                console.error('Error fetching media:', error);
                loader.innerText = 'Failed to load media.';
            }
        }

        function selectMediaItem(item, element) {
            document.querySelectorAll('.media-item').forEach(el => el.classList.remove('selected'));
            element.classList.add('selected');
            selectedMediaItem = item;
        }

        function insertSelectedMedia() {
            if (!selectedMediaItem) {
                alert('Please select a media item first.');
                return;
            }

            const trix = document.querySelector("trix-editor");
            const attachment = new Trix.Attachment({
                url: `/storage/${selectedMediaItem.path}`,
                href: `/storage/${selectedMediaItem.path}`,
                filename: selectedMediaItem.name,
                contentType: selectedMediaItem.mime_type
            });

            trix.editor.insertAttachment(attachment);
            closeMediaModal();
        }
    </script>
@endpush