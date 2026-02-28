@extends('admin.layouts.app')

@section('title', 'Media Manager')

@push('styles')
    <style>
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1.25rem;
            margin-top: 1.5rem;
        }

        .media-card {
            background: var(--bg-surface);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            cursor: pointer;
            display: flex;
            flex-direction: column;
        }

        .media-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-color);
        }

        .media-preview {
            aspect-ratio: 1;
            background-color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }

        .media-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .media-card:hover .media-preview img {
            transform: scale(1.05);
        }

        .media-preview .file-icon {
            font-size: 3rem;
            color: var(--text-secondary);
            opacity: 0.3;
        }

        .media-info {
            padding: 0.85rem;
            flex-grow: 1;
        }

        .media-name {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 0.25rem;
        }

        .media-meta {
            font-size: 0.75rem;
            color: var(--text-secondary);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .file-badge {
            padding: 2px 5px;
            background: #f1f5f9;
            border-radius: 4px;
            font-weight: 700;
            font-size: 0.6rem;
            text-transform: uppercase;
            color: var(--text-secondary);
        }

        .media-actions {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            display: flex;
            gap: 0.35rem;
            opacity: 0;
            transform: translateY(-5px);
            transition: all 0.2s ease;
            z-index: 10;
        }

        .media-card:hover .media-actions {
            opacity: 1;
            transform: translateY(0);
        }

        .action-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            cursor: pointer;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s;
        }

        .action-btn:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .action-btn.delete:hover {
            background: var(--danger-color);
            color: white;
            border-color: var(--danger-color);
        }

        .upload-zone {
            border: 2px dashed var(--border-color);
            border-radius: 16px;
            padding: 3rem 2rem;
            text-align: center;
            background: var(--bg-surface);
            transition: all 0.3s ease;
            cursor: pointer;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .upload-zone:hover {
            border-color: var(--primary-color);
            background: #fafbff;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background-color: var(--bg-surface);
            border-radius: 20px;
            width: 100%;
            max-width: 850px;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            display: flex;
            animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalFadeIn {
            from { transform: translateY(20px) scale(0.95); opacity: 0; }
            to { transform: translateY(0) scale(1); opacity: 1; }
        }

        .modal-body {
            display: flex;
            width: 100%;
        }

        .modal-preview {
            flex: 1.2;
            background: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            min-height: 400px;
        }

        .modal-preview img {
            max-width: 100%;
            max-height: 400px;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
            object-fit: contain;
        }

        .modal-form {
            flex: 1;
            padding: 2.25rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            background: var(--bg-surface);
            overflow-y: auto;
        }

        /* Fixed form styles for User Complaint */
        .modal-form .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .modal-form .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: var(--bg-body);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            font-size: 0.875rem;
            color: var(--text-primary);
            transition: all 0.2s;
        }

        .modal-form .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            background-color: white;
        }

        .dark .modal-form .form-control:focus {
            background-color: rgba(255, 255, 255, 0.05);
        }

        @media (max-width: 800px) {
            .modal-content {
                flex-direction: column;
                max-height: 95vh;
            }
            .modal-body {
                flex-direction: column;
            }
            .modal-preview {
                flex: none;
                height: 250px;
                min-height: auto;
            }
        }

        /* Toast styles */
        #toast {
            display: none;
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: #0f172a;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);
            z-index: 3000;
            align-items: center;
            gap: 0.75rem;
            animation: toastIn 0.3s ease-out;
        }

        @keyframes toastIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
@endpush

@section('content')
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Media Manager</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                @csrf
                <div class="upload-zone" onclick="document.getElementById('file-input').click()">
                    <div style="color: var(--primary-color); margin-bottom: 1rem;">
                        <i data-feather="upload-cloud" style="width: 48px; height: 48px;"></i>
                    </div>
                    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">Click to upload or drag and
                        drop</h3>
                    <p style="color: var(--text-secondary); font-size: 0.875rem;">PNG, JPG, GIF, PDF up to 10MB</p>
                    <input type="file" id="file-input" name="file" style="display: none;" onchange="this.form.submit()">
                </div>
            </form>

            @if ($media->count() > 0)
                <div class="media-grid">
                    @foreach ($media as $item)
                        <div class="media-card" onclick="editMedia({{ $item->id }})">
                            <div class="media-actions">
                                <button class="action-btn" onclick="event.stopPropagation(); copyUrl('{{ $item->url }}')"
                                    title="Copy URL">
                                    <i data-feather="link" style="width: 14px; height: 14px;"></i>
                                </button>
                                <form action="{{ route('admin.media.destroy', $item) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')" style="display:inline;"
                                    onclick="event.stopPropagation()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" title="Delete">
                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="media-preview">
                                @if ($item->is_image)
                                    <img src="{{ $item->url }}" alt="{{ $item->alt_text ?? $item->name }}">
                                @else
                                    <div class="file-icon">
                                        <i data-feather="file-text"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="media-info">
                                <div class="media-name" title="{{ $item->name }}">{{ $item->name }}</div>
                                <div class="media-meta">
                                    <span class="file-badge">{{ strtoupper(explode('/', $item->mime_type)[1] ?? 'FILE') }}</span>
                                    <span>{{ number_format($item->size / 1024, 1) }} KB</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top: 2rem;">
                    {{ $media->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 4rem 1rem;">
                    <div style="color: var(--text-secondary); margin-bottom: 1rem; opacity: 0.3;">
                        <i data-feather="image" style="width: 64px; height: 64px;"></i>
                    </div>
                    <h3 style="font-size: 1.125rem; font-weight: 500;">No files uploaded yet</h3>
                    <p style="color: var(--text-secondary);">Upload your first multimedia file above.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Edit Media Modal -->
    <div id="editMediaModal" class="modal" onclick="if(event.target == this) closeEditModal()">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-preview">
                    <div id="modal-preview-container" style="text-align: center;">
                        <!-- Preview injected here -->
                    </div>
                </div>
                <div class="modal-form">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 700;">Edit Media Details</h3>
                        <button onclick="closeEditModal()"
                            style="background: none; border: none; cursor: pointer; color: var(--text-secondary);">
                            <i data-feather="x"></i>
                        </button>
                    </div>

                    <div id="media-file-info"
                        style="font-size: 0.8125rem; color: var(--text-secondary); padding: 0.75rem; background: var(--bg-body); border-radius: 8px;">
                        <!-- Name, Size, Date injected here -->
                    </div>

                    <form id="edit-media-form" onsubmit="saveMedia(event)">
                        <input type="hidden" id="edit-media-id">

                        <div class="form-group">
                            <label class="form-label" for="edit-alt-text">Alt Text (Alternative Description)</label>
                            <input type="text" id="edit-alt-text" class="form-control"
                                placeholder="Describe the image for SEO...">
                            <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.35rem;">Bagus untuk SEO
                                dan aksesibilitas.</p>
                        </div>

                        <div class="form-group" style="margin-top: 1rem;">
                            <label class="form-label" for="edit-caption">Caption</label>
                            <textarea id="edit-caption" class="form-control" rows="3" placeholder="Tambahkan caption..."></textarea>
                        </div>

                        <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                            <button type="submit" class="btn btn-primary" style="flex: 1; padding: 0.75rem;">
                                <i data-feather="save"></i> Simpan Perubahan
                            </button>
                            <button type="button" class="btn" onclick="closeEditModal()"
                                style="background: var(--bg-body); border: 1px solid var(--border-color); padding: 0.75rem;">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast">
        <i data-feather="check-circle" style="color: #10b981; width: 20px; height: 20px;"></i>
        <span id="toast-message">Berhasil disimpan!</span>
    </div>
@endsection

@push('scripts')
    <script>
        function copyUrl(url) {
            navigator.clipboard.writeText(url).then(() => {
                showToast('URL berhasil disalin!');
            });
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toast-message');
            toastMsg.innerText = message;
            toast.style.display = 'flex';

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(10px)';
                toast.style.transition = 'all 0.5s ease';
                setTimeout(() => {
                    toast.style.display = 'none';
                    toast.style.opacity = '1';
                    toast.style.transform = 'translateY(0)';
                }, 500);
            }, 3000);
        }

        async function editMedia(id) {
            const modal = document.getElementById('editMediaModal');
            const previewContainer = document.getElementById('modal-preview-container');
            const infoContainer = document.getElementById('media-file-info');

            try {
                const response = await fetch(`/admin/media/${id}`);
                const data = await response.json();

                if (data.mime_type.startsWith('image/')) {
                    previewContainer.innerHTML = `<img src="${data.url}" alt="${data.name}">`;
                } else {
                    previewContainer.innerHTML =
                        `<div style="font-size: 5rem; color: var(--text-secondary); opacity: 0.3;"><i data-feather="file-text" style="width: 80px; height: 80px;"></i></div><p style="margin-top: 1rem; font-weight: 500;">${data.name}</p>`;
                    feather.replace();
                }

                infoContainer.innerHTML = `
                    <div style="margin-bottom: 2px;"><strong>Nama File:</strong> ${data.name}</div>
                    <div style="margin-bottom: 2px;"><strong>Tipe:</strong> ${data.mime_type}</div>
                    <div style="margin-bottom: 2px;"><strong>Ukuran:</strong> ${data.size}</div>
                    <div><strong>Upload:</strong> ${data.created_at}</div>
                `;

                document.getElementById('edit-media-id').value = data.id;
                document.getElementById('edit-alt-text').value = data.alt_text || '';
                document.getElementById('edit-caption').value = data.caption || '';

                modal.classList.add('show');
                feather.replace();
            } catch (error) {
                console.error('Error:', error);
                showToast('Gagal memuat detail media.');
            }
        }

        function closeEditModal() {
            document.getElementById('editMediaModal').classList.remove('show');
        }

        async function saveMedia(e) {
            e.preventDefault();
            const id = document.getElementById('edit-media-id').value;
            const alt_text = document.getElementById('edit-alt-text').value;
            const caption = document.getElementById('edit-caption').value;
            const submitBtn = e.target.querySelector('button[type="submit"]');

            submitBtn.disabled = true;
            const originalHtml = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i data-feather="loader" class="animate-spin"></i> Menyimpan...';
            feather.replace();

            try {
                const response = await fetch(`/admin/media/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ alt_text, caption })
                });

                const result = await response.json();

                if (result.success) {
                    closeEditModal();
                    showToast('Detail media berhasil diperbarui!');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Gagal menyimpan perubahan.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
                feather.replace();
            }
        }
    </script>
@endpush