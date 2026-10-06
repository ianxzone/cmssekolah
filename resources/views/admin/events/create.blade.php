@extends('admin.layouts.app')

@section('title', 'Create Event')

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
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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

        .trix-button--icon-color::before {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M4 20h16'/%3E%3Cmpath d='m6 16 6-12 6 12'/%3E%3Cpath d='M8 12h8'/%3E%3C/svg%3E") !important;
        }

        .trix-button--icon-align-center::before {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cline x1='18' y1='10' x2='6' y2='10'/%3E%3Cline x1='21' y1='6' x2='3' y2='6'/%3E%3Cline x1='21' y1='14' x2='3' y2='14'/%3E%3Cline x1='18' y1='18' x2='6' y2='18'/%3E%3C/svg%3E") !important;
        }

        .trix-button--icon-align-right::before {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cline x1='21' y1='10' x2='10' y2='10'/%3E%3Cline x1='21' y1='6' x2='3' y2='6'/%3E%3Cline x1='21' y1='14' x2='3' y2='14'/%3E%3Cline x1='21' y1='18' x2='10' y2='18'/%3E%3C/svg%3E") !important;
        }

        .trix-button--icon-table::before {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M3 3h18v18H3zM3 9h18M3 15h18M9 3v18M15 3v18'/%3E%3C/svg%3E") !important;
        }

        .trix-button--icon-fullscreen::before {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3'/%3E%3C/svg%3E") !important;
        }

        .color-picker-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 5px;
            padding: 10px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .color-circle {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            cursor: pointer;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Create New Event</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid-layout">
                    <!-- Main Content Area -->
                    <div>
                        <div class="form-group">
                            <label class="form-label" for="title">Event Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}"
                                required autofocus style="font-size: 1.25rem; font-weight: 500; padding: 1rem;">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <label class="form-label" for="description" style="margin-bottom: 0;">Event
                                    Description</label>
                            </div>
                            <div class="trix-editor-container" id="editor-container">
                                <input id="description" type="hidden" name="description" value="{{ old('description') }}">
                                <trix-editor input="description"></trix-editor>
                            </div>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>

                    <!-- Sidebar Area -->
                    <div class="sidebar-panel">
                        <div class="form-group">
                            <label class="form-label">Event Type <span class="text-danger">*</span></label>
                            <div style="display: flex; gap: 1.5rem; margin-top: 0.5rem;">
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                    <input type="radio" name="type" value="offline" {{ old('type', 'offline') == 'offline' ? 'checked' : '' }} onchange="toggleEventType()">
                                    <span>Offline</span>
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                    <input type="radio" name="type" value="online" {{ old('type') == 'online' ? 'checked' : '' }} onchange="toggleEventType()">
                                    <span>Online</span>
                                </label>
                            </div>
                            @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group" id="meeting-link-group" style="display: none;">
                            <label class="form-label" for="meeting_link">Meeting Link (Zoom/GMeet)</label>
                            <input type="url" id="meeting_link" name="meeting_link" class="form-control"
                                value="{{ old('meeting_link') }}" placeholder="https://zoom.us/j/...">
                            @error('meeting_link') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="start_time">Start Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" id="start_time" name="start_time" class="form-control"
                                value="{{ old('start_time') }}" required>
                            @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="end_time">End Time</label>
                            <input type="datetime-local" id="end_time" name="end_time" class="form-control"
                                value="{{ old('end_time') }}">
                            @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="location">Location</label>
                            <input type="text" id="location" name="location" class="form-control"
                                value="{{ old('location') }}" placeholder="e.g. Main Hall">
                            @error('location') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group" id="map-link-group">
                            <label class="form-label" for="map_link">Map Link (Google Maps Embed URL)</label>
                            <textarea id="map_link" name="map_link" class="form-control" rows="3"
                                placeholder="Paste iframe or URL here">{{ old('map_link') }}</textarea>
                            <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.25rem;">Insert direct
                                link or iframe code.</p>
                            @error('map_link') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="organizer_name">Organizer</label>
                            <input type="text" id="organizer_name" name="organizer_name" class="form-control"
                                value="{{ old('organizer_name') }}" placeholder="e.g. OSIS SDIT Al Irsyad">
                            @error('organizer_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="capacity">Capacity</label>
                            <input type="number" id="capacity" name="capacity" class="form-control"
                                value="{{ old('capacity') }}" min="1" placeholder="e.g. 100">
                            @error('capacity') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Sponsors</label>
                            <div id="sponsors-container">
                                <!-- Sponsors will be added here -->
                            </div>
                            <button type="button" class="btn btn-sm btn-outline"
                                style="margin-top: 0.5rem; width: 100%; border: 1px dashed var(--border-color); color: var(--text-secondary);"
                                onclick="addSponsorRow()">
                                <i data-feather="plus"></i> Add Sponsor
                            </button>
                        </div>

                                                <div class="form-group" style="margin-top: 1.5rem;" x-data="{ imageUrl: '' }">
                            <label class="form-label" for="image">Event Featured Image (URL)</label>
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <input type="text" id="image" name="image" class="form-control" x-model="imageUrl" placeholder="Pilih dari Media Manager..." readonly style="background-color: var(--bg-body); cursor: pointer;" @click="$dispatch('open-media-picker', { callback: 'setFeaturedImage' })">
                                <button type="button" class="btn btn-primary" @click="$dispatch('open-media-picker', { callback: 'setFeaturedImage' })" style="white-space: nowrap;">
                                    <i data-feather="image"></i> Browse
                                </button>
                            </div>
                            <div x-show="imageUrl" style="margin-top: 1rem; width: 100%; aspect-ratio: 16/9; background-color: var(--border-color); border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; position: relative;">
                                <img :src="imageUrl" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                <button type="button" @click="imageUrl = ''" style="position: absolute; top: 0.5rem; right: 0.5rem; background: var(--danger-color); color: white; border: none; border-radius: 50%; width: 28px; height: 28px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="x" style="width: 14px; height: 14px;"></i>
                                </button>
                            </div>
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>


                        <div style="margin-top: 2.5rem; display: flex; flex-direction: column; gap: 1rem;">
                            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                                <i data-feather="save"></i> Save Event
                            </button>
                            <a href="{{ route('admin.events.index') }}" class="btn"
                                style="width: 100%; justify-content: center; background-color: white; border-color: var(--border-color);">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Trix Global Configuration Enhancements
        Trix.config.textAttributes.color = {
            style: { color: "value" },
            parser: function (element) {
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

                window.setFeaturedImage = function(media) {
            const input = document.getElementById('image');
            // Trigger alpine model update
            input.value = '/storage/' + media.path;
            input.dispatchEvent(new Event('input'));
        };

        window.insertTrixMedia = function(media) {
            const trix = document.querySelector("trix-editor");
            if(trix && trix.editor) {
                const attachment = new Trix.Attachment({
                    url: '/storage/' + media.path,
                    href: '/storage/' + media.path,
                    filename: media.name,
                    contentType: media.mime_type
                });
                trix.editor.insertAttachment(attachment);
            }
        };

        // Fix Trix Toolbar (ensure it runs even if loaded late)
        function initTrixCustomization(event) {
            const toolbar = event ? event.target.toolbarElement : (document.querySelector("trix-toolbar") || document.querySelector("trix-editor").toolbarElement);
            if (!toolbar) return;
            
            // Check if already initialized
            if (toolbar.hasAttribute("data-customized")) return;
            toolbar.setAttribute("data-customized", "true");

            const blockGroup = toolbar.querySelector(".trix-button-group--block-tools");
            const textGroup = toolbar.querySelector(".trix-button-group--text-tools");
            const historyGroup = toolbar.querySelector(".trix-button-group--history-tools");

            if (blockGroup) {
                const alignCenterHtml = `<button type="button" class="trix-button trix-button--icon trix-button--icon-align-center" data-trix-attribute="alignCenter" title="Align Center"></button>`;
                const alignRightHtml = `<button type="button" class="trix-button trix-button--icon trix-button--icon-align-right" data-trix-attribute="alignRight" title="Align Right"></button>`;
                const tableHtml = `<button type="button" class="trix-button trix-button--icon trix-button--icon-table" data-trix-action="insert-table" title="Insert Table"></button>`;
                const btnHtml = `<button type="button" class="trix-button trix-button--icon" data-trix-action="add-media" title="Add Media from Library" style="background-image: none !important; display: flex; align-items: center; justify-content: center;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="pointer-events: none;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></button>`;
                
                blockGroup.insertAdjacentHTML("beforeend", alignCenterHtml + alignRightHtml + tableHtml + btnHtml);

                toolbar.querySelector('[data-trix-action="add-media"]').addEventListener("click", () => {
                    window.dispatchEvent(new CustomEvent("open-media-picker", { detail: { callback: "insertTrixMedia" }}));
                });

                toolbar.querySelector('[data-trix-action="insert-table"]').addEventListener("click", (e) => {
                    const table = `<table border="1" style="width:100%; border-collapse: collapse; margin: 10px 0;"><tr><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr></table><p>&nbsp;</p>`;
                    document.querySelector("trix-editor").editor.insertHTML(table);
                });
            }

            if (historyGroup) {
                const fsHtml = `<button type="button" class="trix-button trix-button--icon trix-button--icon-fullscreen" data-trix-action="toggle-fullscreen" title="Full Screen" style="margin-left: auto; border-left: 1px solid #eee;"></button>`;
                historyGroup.insertAdjacentHTML("beforeend", fsHtml);
                toolbar.querySelector('[data-trix-action="toggle-fullscreen"]').addEventListener("click", () => {
                    document.getElementById("editor-container").classList.toggle("full-screen");
                });
            }
        }
        
        document.addEventListener("trix-initialize", initTrixCustomization);
        // Fallback if trix is already initialized before script runs
        setTimeout(() => {
            const trix = document.querySelector("trix-editor");
            if(trix && trix.editor) initTrixCustomization();
        }, 500);

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

        // New Logic for Event Type and Sponsors
        function toggleEventType() {
            const type = document.querySelector('input[name="type"]:checked').value;
            const meetingGroup = document.getElementById('meeting-link-group');
            const mapGroup = document.getElementById('map-link-group');

            if (type === 'online') {
                meetingGroup.style.display = 'block';
                mapGroup.style.display = 'none';
            } else {
                meetingGroup.style.display = 'none';
                mapGroup.style.display = 'block';
            }
        }

        let sponsorIndex = 0;
        function addSponsorRow(name = '', logo = '') {
            const container = document.getElementById('sponsors-container');
            const div = document.createElement('div');
            div.className = 'sponsor-row';
            div.style.marginBottom = '1rem';
            div.style.padding = '0.75rem';
            div.style.backgroundColor = 'white';
            div.style.border = '1px solid var(--border-color)';
            div.style.borderRadius = '8px';
            div.style.position = 'relative';

            div.innerHTML = `
                    <button type="button" onclick="this.parentElement.remove()" style="position: absolute; top: -10px; right: -10px; width: 20px; height: 20px; border-radius: 50%; background: var(--danger-color); color: white; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 12px; z-index: 10;">
                        <i data-feather="x" style="width: 12px; height: 12px;"></i>
                    </button>
                    <div class="form-group" style="margin-bottom: 0.5rem;">
                        <input type="text" name="sponsor_names[]" class="form-control" value="${name}" placeholder="Sponsor Name" style="padding: 0.5rem;">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <input type="file" name="sponsor_logos[]" class="form-control" accept="image/*" style="padding: 0.25rem; font-size: 0.75rem;">
                    </div>
                `;
            container.appendChild(div);
            feather.replace();
            sponsorIndex++;
        }

        // Initialize display
        window.onload = function () {
            toggleEventType();
        };
    </script>
@endpush

