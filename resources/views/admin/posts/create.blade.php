@extends('admin.layouts.app')

@section('title', 'Create Post')

@push('styles')
    <!-- Trix CDN -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <style>
        /* Trix Customization handled in admin.css */
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
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



        /* Trix Enhancements */
        .trix-editor-container {
            position: relative;
            background: white;
            transition: all 0.3s ease;
        }

        .trix-editor-container.full-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 9999;
            padding: 2rem;
            background: white;
        }

        .trix-editor-container.full-screen trix-editor {
            height: calc(100vh - 150px) !important;
        }

        .trix-button--icon-color::before { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M4 20h16'/%3E%3Cmpath d='m6 16 6-12 6 12'/%3E%3Cpath d='M8 12h8'/%3E%3C/svg%3E") !important; }
        .trix-button--icon-align-center::before { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cline x1='18' y1='10' x2='6' y2='10'/%3E%3Cline x1='21' y1='6' x2='3' y2='6'/%3E%3Cline x1='21' y1='14' x2='3' y2='14'/%3E%3Cline x1='18' y1='18' x2='6' y2='18'/%3E%3C/svg%3E") !important; }
        .trix-button--icon-align-right::before { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cline x1='21' y1='10' x2='10' y2='10'/%3E%3Cline x1='21' y1='6' x2='3' y2='6'/%3E%3Cline x1='21' y1='14' x2='3' y2='14'/%3E%3Cline x1='21' y1='18' x2='10' y2='18'/%3E%3C/svg%3E") !important; }
        .trix-button--icon-table::before { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M3 3h18v18H3zM3 9h18M3 15h18M9 3v18M15 3v18'/%3E%3C/svg%3E") !important; }
        .trix-button--icon-fullscreen::before { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3'/%3E%3C/svg%3E") !important; }

        .color-picker-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 5px;
            padding: 10px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: var(--shadow-md);
        }
        .color-circle {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            cursor: pointer;
            border: 1px solid rgba(0,0,0,0.1);
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
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.65rem; flex-wrap: wrap; gap: 8px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <label class="form-label" for="content" style="margin-bottom: 0; font-weight: 600;">Content <span
                                            class="text-danger">*</span></label>
                                    <button type="button" class="btn-wp-add-media" onclick="openMediaModalForEditor()" title="Tambahkan gambar atau berkas media dari komputer atau pustaka media">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                            <circle cx="8.5" cy="8.5" r="1.5"/>
                                            <polyline points="21 15 16 10 5 21"/>
                                        </svg>
                                        <span>Tambah Media</span>
                                    </button>
                                </div>
                                <span id="content-word-count" style="font-size: 0.75rem; color: var(--text-secondary); font-weight: 500;">0
                                    words</span>
                            </div>
                            <div class="trix-editor-container" id="editor-container">
                                <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                                <trix-editor input="content"></trix-editor>
                            </div>
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

                        <!-- SEO Meta Box Component -->
                        @include('admin.partials.seo-meta-box')
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

                        <!-- Author Selection Field -->
                        @php
                            $currentUser = auth()->user() ?? \App\Models\User::find(1);
                            $canChangeAuthor = $currentUser ? $currentUser->canChangeAuthor() : true;
                            $selectedAuthorId = old('user_id', $currentUser ? $currentUser->id : 1);
                        @endphp
                        <div class="form-group">
                            <label class="form-label" for="user_id">
                                <i data-feather="user" style="width: 14px; height: 14px; vertical-align: middle; margin-right: 4px;"></i>
                                Penulis (Author) <span class="text-danger">*</span>
                            </label>
                            @if($canChangeAuthor)
                                <select id="user_id" name="user_id" class="form-control" required style="font-weight: 500;">
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id }}" {{ (string)$selectedAuthorId === (string)$author->id ? 'selected' : '' }}>
                                            {{ $author->name }} ({{ $author->role_label }})
                                        </option>
                                    @endforeach
                                </select>
                                <span style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.35rem; display: block;">
                                    Sebagai <strong>{{ $currentUser->role_label ?? 'Admin' }}</strong>, Anda dapat memilih author untuk artikel ini.
                                </span>
                            @else
                                <div style="padding: 0.65rem 0.85rem; background: #ffffff; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.875rem; color: var(--text-primary); display: flex; align-items: center; justify-content: space-between;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="width: 26px; height: 26px; border-radius: 50%; background: #065f46; color: white; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700;">
                                            {{ substr($currentUser->name ?? 'A', 0, 1) }}
                                        </div>
                                        <span><strong>{{ $currentUser->name ?? 'Anda' }}</strong></span>
                                    </div>
                                    <span style="font-size: 0.72rem; background: #ecfdf5; color: #065f46; padding: 2px 8px; border-radius: 4px; font-weight: 600;">{{ $currentUser->role_label ?? 'Penulis' }}</span>
                                </div>
                                <input type="hidden" name="user_id" value="{{ $currentUser->id ?? 1 }}">
                            @endif
                            @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group" style="margin-top: 1.5rem;">
                            <label class="form-label" style="display: flex; justify-content: space-between; align-items: center;">
                                <span>Gambar Utama (Featured Image)</span>
                                <span style="font-size: 0.75rem; color: var(--text-secondary);">16:9 disarankan</span>
                            </label>

                            <!-- Hidden inputs for media library path & remove image flag -->
                            <input type="hidden" id="featured_image_path" name="featured_image_path" value="{{ old('featured_image_path') }}">
                            <input type="hidden" id="remove_image" name="remove_image" value="0">

                            <!-- Card Preview Container -->
                            <div id="featured-image-box" style="border: 2px dashed #cbd5e1; border-radius: 12px; padding: 1rem; background: #ffffff; text-align: center; transition: all 0.2s;">
                                <!-- Image Preview Area -->
                                <div id="image-preview-wrapper" style="position: relative; width: 100%; aspect-ratio: 16/9; background: #f3f4f6; border-radius: 8px; overflow: hidden; display: none; margin-bottom: 0.75rem;">
                                    <img id="preview-img" src="#" alt="Featured Image Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                    <button type="button" onclick="removeFeaturedImage()" style="position: absolute; top: 8px; right: 8px; background: rgba(239, 68, 68, 0.9); color: white; border: none; border-radius: 6px; padding: 4px 8px; font-size: 0.75rem; cursor: pointer; display: flex; align-items: center; gap: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i> Hapus
                                    </button>
                                </div>

                                <!-- Placeholder when no image is selected -->
                                <div id="image-placeholder" style="padding: 1.25rem 1rem;">
                                    <svg style="width: 40px; height: 40px; color: #9ca3af; margin: 0 auto 0.5rem auto;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p style="font-size: 0.8125rem; color: #6b7280; margin: 0 0 0.75rem 0;">Belum ada gambar utama dipilih</p>
                                </div>

                                <!-- Action Buttons -->
                                <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
                                    <button type="button" class="btn btn-primary" onclick="openFeaturedImageMediaPicker()" style="font-size: 0.8125rem; padding: 0.4rem 0.875rem;">
                                        <i data-feather="image" style="width: 15px; height: 15px; margin-right: 4px;"></i> Pilih dari Media
                                    </button>
                                    <label class="btn" style="font-size: 0.8125rem; padding: 0.4rem 0.875rem; background: #f3f4f6; border: 1px solid #d1d5db; color: #374151; cursor: pointer; margin-bottom: 0;">
                                        <i data-feather="upload" style="width: 15px; height: 15px; margin-right: 4px;"></i> Upload File
                                        <input type="file" id="image" name="image" accept="image/*" style="display: none;" onchange="handleDirectFileSelect(event)">
                                    </label>
                                </div>
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

    {{-- WordPress-Style Media Library Modal --}}
    @include('admin.partials.media-modal')
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

        // Trix Global Configuration Enhancements
        Trix.config.textAttributes.color = {
            style: { color: "value" },
            parser: function(element) {
                return element.style.color;
            },
            inheritable: true
        };

        Trix.config.blockAttributes.alignCenter = {
            tagName: "div",
            terminal: true,
            breakOnReturn: true,
            group: false,
            style: { textAlign: "center" }
        };

        Trix.config.blockAttributes.alignRight = {
            tagName: "div",
            terminal: true,
            breakOnReturn: true,
            group: false,
            style: { textAlign: "right" }
        };

        // Trix Toolbar Customization & Enhancements
        function initTrixToolbarEnhancements(editorEl) {
            if (!editorEl) return;
            const toolbar = editorEl.toolbarElement;
            if (!toolbar) return;
            if (toolbar.dataset.enhanced === "true") return;
            toolbar.dataset.enhanced = "true";

            const blockGroup = toolbar.querySelector(".trix-button-group--block-tools");
            const textGroup = toolbar.querySelector(".trix-button-group--text-tools");
            const historyGroup = toolbar.querySelector(".trix-button-group--history-tools");

            if (!blockGroup || !textGroup || !historyGroup) return;

            // 1. Add Center Align Button
            if (!toolbar.querySelector('.trix-button--icon-align-center')) {
                const alignCenterHtml = `<button type="button" class="trix-button trix-button--icon trix-button--icon-align-center" data-trix-attribute="alignCenter" title="Rata Tengah (Align Center)"></button>`;
                blockGroup.insertAdjacentHTML("beforeend", alignCenterHtml);
            }

            // 2. Add Right Align Button
            if (!toolbar.querySelector('.trix-button--icon-align-right')) {
                const alignRightHtml = `<button type="button" class="trix-button trix-button--icon trix-button--icon-align-right" data-trix-attribute="alignRight" title="Rata Kanan (Align Right)"></button>`;
                blockGroup.insertAdjacentHTML("beforeend", alignRightHtml);
            }

            // 3. Add Table Button
            if (!toolbar.querySelector('[data-trix-action="insert-table"]')) {
                const tableHtml = `<button type="button" class="trix-button trix-button--icon trix-button--icon-table" data-trix-action="insert-table" title="Sisipkan Tabel"></button>`;
                blockGroup.insertAdjacentHTML("beforeend", tableHtml);
            }

            // 4. Add Color Button & Dialog
            if (!toolbar.querySelector('[data-trix-action="show-color-picker"]')) {
                const colorHtml = `
                    <button type="button" class="trix-button trix-button--icon trix-button--icon-color" data-trix-action="show-color-picker" title="Warna Teks"></button>
                    <div class="trix-dialog trix-dialog--color" data-trix-dialog="color-picker" data-trix-dialog-attribute="color">
                        <div class="color-picker-grid">
                            <div class="color-circle" style="background: #000000" data-color="#000000" title="Hitam"></div>
                            <div class="color-circle" style="background: #ef4444" data-color="#ef4444" title="Merah"></div>
                            <div class="color-circle" style="background: #3b82f6" data-color="#3b82f6" title="Biru"></div>
                            <div class="color-circle" style="background: #006837" data-color="#006837" title="Hijau SDIT"></div>
                            <div class="color-circle" style="background: #f59e0b" data-color="#f59e0b" title="Oranye"></div>
                            <div class="color-circle" style="background: #6366f1" data-color="#6366f1" title="Indigo"></div>
                            <div class="color-circle" style="background: #ec4899" data-color="#ec4899" title="Pink"></div>
                            <div class="color-circle" style="background: #8b5cf6" data-color="#8b5cf6" title="Ungu"></div>
                            <div class="color-circle" style="background: #6b7280" data-color="#6b7280" title="Abu-abu"></div>
                            <div class="color-circle" style="background: transparent; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; font-size: 10px;" data-color="" title="Reset Warna">✕</div>
                        </div>
                    </div>`;
                textGroup.insertAdjacentHTML("beforeend", colorHtml);
            }

            // 5. Add Media Button (Pustaka Media & Unggah)
            if (!toolbar.querySelector('[data-trix-action="add-media"]')) {
                const btnHtml = `<button type="button" class="trix-button trix-button--icon" data-trix-action="add-media" title="Tambah Media (Pustaka Media & Unggah Gambar)" style="background-image: none !important; display: inline-flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="pointer-events: none; color: #006837;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </button>`;
                blockGroup.insertAdjacentHTML("beforeend", btnHtml);
            }

            // 6. Add Full Screen Button
            if (!toolbar.querySelector('[data-trix-action="toggle-fullscreen"]')) {
                const fsHtml = `<button type="button" class="trix-button trix-button--icon trix-button--icon-fullscreen" data-trix-action="toggle-fullscreen" title="Layar Penuh (Full Screen)" style="margin-left: auto; border-left: 1px solid #eee;"></button>`;
                historyGroup.insertAdjacentHTML("beforeend", fsHtml);
            }

            // Event Listeners for actions
            toolbar.querySelector('[data-trix-action="add-media"]')?.addEventListener("click", (e) => {
                e.preventDefault();
                openMediaModalForEditor(editorEl.editor);
            });

            toolbar.querySelector('[data-trix-action="toggle-fullscreen"]')?.addEventListener("click", (e) => {
                e.preventDefault();
                document.getElementById('editor-container')?.classList.toggle('full-screen');
            });

            toolbar.querySelector('[data-trix-action="insert-table"]')?.addEventListener("click", (e) => {
                e.preventDefault();
                const table = `<table border="1" style="width:100%; border-collapse: collapse; margin: 15px 0;">
                    <thead><tr style="background:#f8fafc;"><th style="padding:8px; border:1px solid #cbd5e1;">Kolom 1</th><th style="padding:8px; border:1px solid #cbd5e1;">Kolom 2</th></tr></thead>
                    <tbody><tr><td style="padding:8px; border:1px solid #cbd5e1;">&nbsp;</td><td style="padding:8px; border:1px solid #cbd5e1;">&nbsp;</td></tr></tbody>
                </table><p><br></p>`;
                editorEl.editor.insertHTML(table);
            });

            toolbar.querySelector('[data-trix-action="show-color-picker"]')?.addEventListener("click", (e) => {
                e.preventDefault();
                const dialog = toolbar.querySelector('[data-trix-dialog="color-picker"]');
                if (dialog) {
                    if (dialog.hasAttribute("data-trix-active")) {
                        dialog.removeAttribute("data-trix-active");
                    } else {
                        dialog.setAttribute("data-trix-active", "");
                    }
                }
            });

            toolbar.querySelectorAll(".color-circle").forEach(circle => {
                circle.addEventListener("click", (e) => {
                    e.preventDefault();
                    const color = e.target.getAttribute("data-color");
                    if (color) {
                        editorEl.editor.activateAttribute("color", color);
                    } else {
                        editorEl.editor.removeAttribute("color");
                    }
                    toolbar.querySelector('[data-trix-dialog="color-picker"]')?.removeAttribute("data-trix-active");
                });
            });
        }

        // Initialize immediately or on event
        document.addEventListener("trix-initialize", function (event) {
            initTrixToolbarEnhancements(event.target);
        });

        function setupAllTrixEditors() {
            document.querySelectorAll("trix-editor").forEach(el => {
                if (el.toolbarElement) {
                    initTrixToolbarEnhancements(el);
                }
            });
        }

        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", setupAllTrixEditors);
        } else {
            setupAllTrixEditors();
        }
        setTimeout(setupAllTrixEditors, 150);
        setTimeout(setupAllTrixEditors, 600);

        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function openMediaModalForEditor(editorInstance) {
            window.openWpMediaModal({
                mode: 'editor',
                onSelect: function(item) {
                    const editorEl = document.querySelector("trix-editor");
                    const editor = editorInstance || editorEl?.editor;
                    if (!editor) return;

                    const imgUrl = item.url ? item.url : `/storage/${item.path}`;
                    const altAttr = item.alt_text ? escapeHtml(item.alt_text) : escapeHtml(item.title || item.name || '');
                    const titleAttr = item.title ? escapeHtml(item.title) : '';
                    const captionText = item.caption ? escapeHtml(item.caption.trim()) : '';

                    const attachmentData = {
                        url: imgUrl,
                        contentType: item.mime_type || 'image/jpeg',
                        filename: item.name || '',
                        filesize: item.size || 0
                    };

                    let figureHtml = `<figure data-trix-attachment='${JSON.stringify(attachmentData)}'`;
                    if (captionText) {
                        figureHtml += ` data-trix-attributes='${JSON.stringify({caption: captionText})}'`;
                    }
                    figureHtml += ` class="attachment attachment--preview">`;
                    figureHtml += `<img src="${imgUrl}" alt="${altAttr}" ${titleAttr ? `title="${titleAttr}"` : ''} style="max-width: 100%; height: auto; border-radius: 8px;" />`;
                    if (captionText) {
                        figureHtml += `<figcaption class="attachment__caption">${captionText}</figcaption>`;
                    }
                    figureHtml += `</figure><p><br></p>`;

                    try {
                        editor.insertHTML(figureHtml);
                    } catch (err) {
                        console.warn('insertHTML fallback to Trix.Attachment:', err);
                        const attachment = new Trix.Attachment({
                            url: imgUrl,
                            caption: captionText,
                            contentType: item.mime_type || 'image/jpeg',
                            filename: item.name || ''
                        });
                        editor.insertAttachment(attachment);
                    }
                }
            });
        }

        // Backward compatibility
        function insertMediaFromLibrary(editorInstance) {
            openMediaModalForEditor(editorInstance);
        }

        function openFeaturedImageMediaPicker() {
            window.openWpMediaModal({
                mode: 'featured',
                onSelect: function(item) {
                    document.getElementById('featured_image_path').value = item.path;
                    document.getElementById('remove_image').value = '0';
                    
                    const previewImg = document.getElementById('preview-img');
                    const previewWrapper = document.getElementById('image-preview-wrapper');
                    const placeholder = document.getElementById('image-placeholder');
                    
                    previewImg.src = item.url ? item.url : `/storage/${item.path}`;
                    previewWrapper.style.display = 'block';
                    placeholder.style.display = 'none';

                    if (window.feather) feather.replace();
                }
            });
        }

        function handleDirectFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview-wrapper').style.display = 'block';
                    document.getElementById('image-placeholder').style.display = 'none';
                    document.getElementById('remove_image').value = '0';
                    document.getElementById('featured_image_path').value = '';
                    if (window.feather) feather.replace();
                };
                reader.readAsDataURL(file);
            }
        }

        function removeFeaturedImage() {
            document.getElementById('featured_image_path').value = '';
            document.getElementById('remove_image').value = '1';
            document.getElementById('preview-img').src = '#';
            document.getElementById('image-preview-wrapper').style.display = 'none';
            document.getElementById('image-placeholder').style.display = 'block';
            const fileInput = document.getElementById('image');
            if (fileInput) fileInput.value = '';
        }

        // Trix Attachment Handling
        document.addEventListener("trix-attachment-add", function(event) {
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

            xhr.upload.onprogress = function(event) {
                const progress = event.loaded / event.total * 100;
                attachment.setUploadProgress(progress);
            };

            xhr.onload = function() {
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

        // Initialize counts
        window.onload = function() {
            updateWordCount('description', 'description-word-count');
            updateWordCount('seo_title', 'seo_title-word-count');
            updateWordCount('seo_description', 'seo_description-word-count');
            // Trix takes a moment to initialize
            setTimeout(() => updateWordCount('content', 'content-word-count', true), 500);
        };
    </script>
@endpush