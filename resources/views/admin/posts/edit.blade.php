@extends('admin.layouts.app')

@section('title', 'Edit Post')

@push('styles')
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    
    <style>
        /* Summernote Custom Styling */
        .note-editor {
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            overflow: hidden !important;
        }
        
        .note-editor.note-frame {
            border-color: #e5e7eb !important;
        }
        
        .note-editor.note-frame:focus-within {
            border-color: #4f46e5 !important;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
        }
        
        .note-toolbar {
            background: #f9fafb !important;
            border-bottom: 1px solid #e5e7eb !important;
            padding: 8px !important;
        }
        
        .note-btn {
            background: #ffffff !important;
            border: 1px solid #d1d5db !important;
            color: #374151 !important;
            border-radius: 4px !important;
            padding: 6px 12px !important;
            font-size: 14px !important;
            transition: all 0.2s ease !important;
        }
        
        .note-btn:hover,
        .note-btn:active,
        .note-btn.active {
            background: #4f46e5 !important;
            border-color: #4f46e5 !important;
            color: #ffffff !important;
        }
        
        .note-btn:disabled {
            opacity: 0.4 !important;
            cursor: not-allowed !important;
        }
        
        .note-editable {
            min-height: 400px !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 14px !important;
            line-height: 1.6 !important;
            color: #111827 !important;
            padding: 16px !important;
        }
        
        .note-editable:focus {
            outline: none !important;
        }
        
        .note-statusbar {
            background: #f9fafb !important;
            border-top: 1px solid #e5e7eb !important;
        }
        
        .note-resizebar {
            display: none !important;
        }
        
        .note-placeholder {
            color: #9ca3af !important;
        }
        
        /* Dropdown Styling */
        .note-dropdown-menu {
            border-radius: 8px !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
            border: 1px solid #e5e7eb !important;
        }
        
        .note-dropdown-item:hover {
            background: #4f46e5 !important;
            color: #ffffff !important;
        }
        
        /* Modal Styling */
        .note-modal {
            border-radius: 12px !important;
        }
        
        .note-modal .note-btn {
            background: #4f46e5 !important;
            color: #ffffff !important;
        }
        
        /* Hide file image buttons if needed */
        .note-btn[data-event="imageShape"],
        .note-btn[data-event="colorTable"] {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <div class="panel">
        <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="panel-title">Edit Post: {{ $post->title }}</h2>
            <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="btn"
                style="background-color: #f3f4f6; color: var(--text-primary);">
                <i data-feather="external-link"></i> View Live
            </a>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid-layout">
                    <!-- Main Content Area -->
                    <div>
                        <div class="form-group">
                            <label class="form-label" for="title">Post Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control"
                                value="{{ old('title', $post->title) }}" required
                                style="font-size: 1.25rem; font-weight: 500; padding: 1rem;">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="subtitle">Sub Title</label>
                            <input type="text" id="subtitle" name="subtitle" class="form-control"
                                value="{{ old('subtitle', $post->subtitle) }}" placeholder="Enter a catchy sub title...">
                            @error('subtitle') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <label class="form-label" for="content" style="margin-bottom: 0;">Content <span
                                        class="text-danger">*</span></label>
                                <span id="content-word-count" style="font-size: 0.75rem; color: var(--text-secondary);">0
                                    words</span>
                            </div>
                            <textarea id="content" name="content" class="form-control" rows="10">{{ old('content', $post->content) }}</textarea>
                            @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <label class="form-label" for="description" style="margin-bottom: 0;">Short Description /
                                    Excerpt</label>
                                <span id="description-word-count"
                                    style="font-size: 0.75rem; color: var(--text-secondary);">0 words</span>
                            </div>
                            <textarea id="description" name="description" class="form-control" rows="3"
                                placeholder="Brief summary of the post...">{{ old('description', $post->description) }}</textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <h3
                            style="font-size: 1.125rem; font-weight: 600; margin: 2rem 0 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">
                            SEO Settings</h3>

                        <div class="form-group">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <label class="form-label" for="seo_title" style="margin-bottom: 0;">SEO Title</label>
                                <span id="seo_title-word-count" style="font-size: 0.75rem; color: var(--text-secondary);">0
                                    words</span>
                            </div>
                            <input type="text" id="seo_title" name="seo_title" class="form-control"
                                value="{{ old('seo_title', $post->seo_title) }}">
                            @error('seo_title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <label class="form-label" for="seo_description" style="margin-bottom: 0;">SEO
                                    Description</label>
                                <span id="seo_description-word-count"
                                    style="font-size: 0.75rem; color: var(--text-secondary);">0 words</span>
                            </div>
                            <textarea id="seo_description" name="seo_description" class="form-control"
                                rows="3">{{ old('seo_description', $post->seo_description) }}</textarea>
                            @error('seo_description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Sidebar Area -->
                    <div class="sidebar-panel">
                        <div class="form-group">
                            <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-control" required style="font-weight: 500;"
                                onchange="toggleSchedule()">
                                @php
                                    $isPublished = $post->published_at && $post->published_at <= now();
                                    $isScheduled = $post->published_at && $post->published_at > now();
                                    $defaultStatus = $isPublished ? 'published' : ($isScheduled ? 'scheduled' : 'draft');
                                    $currentStatus = old('status', $defaultStatus);
                                @endphp
                                <option value="draft" {{ $currentStatus === 'draft' ? 'selected' : '' }}>Save as Draft
                                </option>
                                <option value="published" {{ $currentStatus === 'published' ? 'selected' : '' }}>Published
                                </option>
                                <option value="scheduled" {{ $currentStatus === 'scheduled' ? 'selected' : '' }}>Schedule
                                </option>
                            </select>
                            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div id="schedule-group" class="form-group"
                            style="display: {{ $currentStatus === 'scheduled' ? 'block' : 'none' }};">
                            <label class="form-label" for="published_at">Schedule Date & Time <span
                                    class="text-danger">*</span></label>
                            <input type="datetime-local" id="published_at" name="published_at" class="form-control"
                                value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                            @error('published_at') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="category_id">Category <span class="text-danger">*</span></label>
                            <select id="category_id" name="category_id" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group" style="margin-top: 1.5rem;">
                            <label class="form-label" for="image">Featured Image</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*"
                                onchange="previewImage(event)">

                            <div id="image-preview"
                                style="margin-top: 1rem; width: 100%; aspect-ratio: 16/9; background-color: var(--border-color); border-radius: 8px; overflow: hidden; display: {{ $post->image ? 'flex' : 'none' }}; align-items: center; justify-content: center;">
                                <img id="preview-img" src="{{ $post->image ? Storage::url($post->image) : '#' }}"
                                    alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="slug">URL Slug</label>
                            <input type="text" id="slug" name="slug" class="form-control"
                                value="{{ old('slug', $post->slug) }}" required>
                            @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div style="margin-top: 2.5rem; display: flex; flex-direction: column; gap: 1rem;">
                            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                                <i data-feather="save"></i> Update Post
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

        function updateWordCount(inputId, displayId) {
            const display = document.getElementById(displayId);
            const text = document.getElementById(inputId).value;
            const count = countWords(text);
            display.innerText = `${count} word${count !== 1 ? 's' : ''}`;
        }
                        </div>`;
            textGroup.insertAdjacentHTML("beforeend", colorHtml);

            // 5. Add Full Screen Button
            const fsHtml = `<button type="button" class="trix-button trix-button--icon trix-button--icon-fullscreen" data-trix-action="toggle-fullscreen" title="Full Screen" style="margin-left: auto; border-left: 1px solid %23eee;"></button>`;
            historyGroup.insertAdjacentHTML("beforeend", fsHtml);

            // Add Media Button (Existing)
            const btnHtml = `<button type="button" class="trix-button trix-button--icon" data-trix-action="add-media" title="Add Media" style="background-image: none !important; display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="pointer-events: none;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </button>`;
            blockGroup.insertAdjacentHTML("beforeend", btnHtml);

            // Event Listeners for new actions
            toolbar.querySelector('[data-trix-action="add-media"]').addEventListener("click", () => openMediaModal());

            toolbar.querySelector('[data-trix-action="toggle-fullscreen"]').addEventListener("click", () => {
                document.getElementById('editor-container').classList.toggle('full-screen');
            });

            toolbar.querySelector('[data-trix-action="insert-table"]').addEventListener("click", () => {
                const table = `<table border="1" style="width:100%; border-collapse: collapse; margin: 10px 0;">
                            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                        </table><p>&nbsp;</p>`;
                event.target.editor.insertHTML(table);
            });

            toolbar.querySelector('[data-trix-action="show-color-picker"]').addEventListener("click", () => {
                const dialog = toolbar.querySelector('[data-trix-dialog="color-picker"]');
                if (dialog.hasAttribute("data-trix-active")) {
                    dialog.removeAttribute("data-trix-active");
                } else {
                    dialog.setAttribute("data-trix-active", "");
                }
            });

            toolbar.querySelectorAll(".color-circle").forEach(circle => {
                circle.addEventListener("click", (e) => {
                    const color = e.target.getAttribute("data-color");
                    if (color) {
                        event.target.editor.activateAttribute("color", color);
                    } else {
                        event.target.editor.removeAttribute("color");
                    }
                    toolbar.querySelector('[data-trix-dialog="color-picker"]').removeAttribute("data-trix-active");
                });
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

        document.getElementById('description').addEventListener('input', () => {
            updateWordCount('description', 'description-word-count');
        });

        document.getElementById('seo_title').addEventListener('input', () => {
            updateWordCount('seo_title', 'seo_title-word-count');
        });

        document.getElementById('seo_description').addEventListener('input', () => {
            updateWordCount('seo_description', 'seo_description-word-count');
        });

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

        // Summernote Initialization
        $(document).ready(function() {
            $('#content').summernote({
                placeholder: 'Write your content here...',
                tabsize: 2,
                height: 400,
                toolbar: [
                    ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        uploadImage(files[0], this);
                    }
                }
            });
        });

        function uploadImage(file, editor) {
            const formData = new FormData();
            formData.append('file', file);

            $.ajax({
                url: "{{ route('admin.media.store') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $(editor).summernote('insertImage', response.url);
                },
                error: function(xhr) {
                    alert('Failed to upload image');
                }
            });
        }

        // Word count update for Summernote
        $('#content').on('summernote.change', function() {
            updateWordCount('content', 'content-word-count');
        });

        // Initialize counts
        window.onload = function () {
            updateWordCount('description', 'description-word-count');
            updateWordCount('seo_title', 'seo_title-word-count');
            updateWordCount('seo_description', 'seo_description-word-count');
            updateWordCount('content', 'content-word-count');
        };
    </script>

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
@endpush