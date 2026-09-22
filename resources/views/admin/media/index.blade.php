@extends('admin.layouts.app')

@section('title', 'Media Manager')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .media-manager-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .media-stats-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            background: #ecfdf5;
            color: #065f46;
            font-size: 0.8rem;
            font-weight: 700;
            border: 1px solid #a7f3d0;
        }

        /* Upload Zone */
        .upload-zone {
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 2.25rem 1.5rem;
            text-align: center;
            background: #f8fafc;
            transition: all 0.2s ease;
            cursor: pointer;
            margin-bottom: 2rem;
            position: relative;
        }

        .upload-zone:hover, .upload-zone.dragover {
            border-color: #006837;
            background: #f0fdf4;
            transform: translateY(-1px);
        }

        .upload-icon-circle {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: #ecfdf5;
            color: #006837;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem auto;
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 104, 55, 0.15);
        }

        /* Media Grid */
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1.25rem;
        }

        .media-card {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            transition: all 0.2s ease;
            position: relative;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
        }

        .media-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.1);
            border-color: #006837;
        }

        .media-card-preview {
            aspect-ratio: 1;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            border-bottom: 1px solid #f1f5f9;
        }

        .media-card-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.25s ease;
        }

        .media-card:hover .media-card-preview img {
            transform: scale(1.05);
        }

        .media-card-info {
            padding: 0.85rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .media-card-title {
            font-size: 0.825rem;
            font-weight: 700;
            color: #0f172a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 0.35rem;
        }

        .media-card-meta {
            font-size: 0.72rem;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .media-card-badge {
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 0.68rem;
            color: #475569;
            text-transform: uppercase;
        }

        .media-card-actions {
            position: absolute;
            top: 8px;
            right: 8px;
            display: flex;
            gap: 5px;
            opacity: 0;
            transition: opacity 0.2s ease;
            z-index: 5;
        }

        .media-card:hover .media-card-actions {
            opacity: 1;
        }

        .quick-action-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(226, 232, 240, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #334155;
            font-size: 0.75rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.15s;
        }

        .quick-action-btn:hover {
            background: #ffffff;
            color: #006837;
            transform: scale(1.08);
        }

        .quick-action-btn.btn-delete:hover {
            color: #dc2626;
            background: #fee2e2;
        }

        /* ==========================================================================
           Attachment Details Modal (WordPress-Style Inspector)
           ========================================================================== */
        .attachment-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(5px);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
        }

        .attachment-modal-backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        .attachment-modal-container {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.35);
            width: 100%;
            max-width: 980px;
            max-height: calc(100vh - 48px);
            height: auto;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            transform: scale(0.95);
            transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .attachment-modal-backdrop.active .attachment-modal-container {
            transform: scale(1);
        }

        .attachment-modal-header {
            padding: 1rem 1.5rem;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .attachment-modal-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }

        .attachment-nav-controls {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .attachment-nav-btn {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 0.78rem;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.15s;
        }

        .attachment-nav-btn:hover:not(:disabled) {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #94a3b8;
        }

        .attachment-nav-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .attachment-modal-close {
            background: transparent;
            border: none;
            color: #64748b;
            cursor: pointer;
            border-radius: 8px;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 8px;
            transition: all 0.15s;
        }

        .attachment-modal-close:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .attachment-modal-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow-y: auto;
            flex: 1;
            background: #ffffff;
        }

        @media (max-width: 860px) {
            .attachment-modal-body {
                grid-template-columns: 1fr;
            }
        }

        /* Left Column: Preview & Info */
        .attachment-preview-col {
            padding: 1.5rem;
            border-right: 1px solid #e2e8f0;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .attachment-img-frame {
            border-radius: 14px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 240px;
            max-height: 340px;
            position: relative;
        }

        .attachment-img-frame img {
            max-width: 100%;
            max-height: 340px;
            object-fit: contain;
            display: block;
        }

        .attachment-meta-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            font-size: 0.8rem;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .meta-row .label {
            color: #64748b;
            font-weight: 500;
        }

        .meta-row .value {
            color: #0f172a;
            font-weight: 700;
            text-align: right;
            max-width: 60%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .attachment-url-box {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 0.25rem;
        }

        .attachment-url-input {
            flex: 1;
            padding: 6px 10px;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 0.75rem;
            color: #334155;
            font-family: monospace;
            outline: none;
        }

        .btn-copy-url {
            padding: 6px 12px;
            background: #006837;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.15s;
        }

        .btn-copy-url:hover {
            background: #024324;
        }

        /* Right Column: Metadata Form */
        .attachment-form-col {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 1.25rem;
        }

        .seo-form-group {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            margin-bottom: 1rem;
        }

        .seo-label-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .seo-label {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #334155;
        }

        .badge-seo-tip {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 12px;
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .badge-content-tip {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 12px;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .seo-input, .seo-textarea {
            width: 100%;
            padding: 0.65rem 0.85rem;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 0.85rem;
            color: #0f172a;
            transition: all 0.15s;
            outline: none;
            background: #f8fafc;
        }

        .seo-input:focus, .seo-textarea:focus {
            background: #ffffff;
            border-color: #006837;
            box-shadow: 0 0 0 3px rgba(0, 104, 55, 0.12);
        }

        .seo-help-text {
            font-size: 0.72rem;
            color: #64748b;
            line-height: 1.4;
        }

        .attachment-actions-footer {
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .btn-delete-permanent {
            background: transparent;
            color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.15s;
        }

        .btn-delete-permanent:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn-save-seo {
            background: #006837;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 0.65rem 1.4rem;
            font-size: 0.825rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 6px -1px rgba(0, 104, 55, 0.2);
            transition: all 0.15s;
        }

        .btn-save-seo:hover {
            background: #024324;
            transform: translateY(-1px);
        }

        .save-indicator {
            font-size: 0.75rem;
            font-weight: 600;
            color: #059669;
            display: none;
            align-items: center;
            gap: 4px;
        }
    </style>
@endpush

@section('content')
<div class="panel">
    <div class="panel-header">
        <div class="media-manager-header">
            <div>
                <h2 class="panel-title" style="margin-bottom: 0.25rem;">Media Manager</h2>
                <p style="font-size: 0.825rem; color: #64748b; margin: 0;">Pustaka media terpusat dengan optimasi SEO gambar (Alt Text, Title, Caption)</p>
            </div>
            <div>
                <span class="media-stats-badge">
                    <i class="fas fa-images"></i> Total: {{ $media->total() }} Berkas
                </span>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <!-- Direct Upload Zone -->
        <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
            @csrf
            <div class="upload-zone" id="uploadDropzone" onclick="document.getElementById('file-input').click()">
                <div class="upload-icon-circle">
                    <i class="fas fa-cloud-arrow-up"></i>
                </div>
                <h3 style="font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 0.35rem;">
                    Tarik berkas ke sini atau klik untuk mengunggah
                </h3>
                <p style="color: #64748b; font-size: 0.825rem; margin: 0;">
                    Mendukung JPG, PNG, GIF, WebP, PDF hingga 2MB (Otomatis Dioptimasi)
                </p>
                <input type="file" id="file-input" name="file" style="display: none;" onchange="this.form.submit()">
            </div>
        </form>

        <!-- Media Grid -->
        @if($media->count() > 0)
            <div class="media-grid" id="mediaLibraryGrid">
                @foreach($media as $index => $item)
                    <div class="media-card" onclick="openAttachmentInspector({{ $index }})" data-id="{{ $item->id }}">
                        <div class="media-card-actions" onclick="event.stopPropagation()">
                            <button type="button" class="quick-action-btn" onclick="openAttachmentInspector({{ $index }})" title="Rincian & SEO">
                                <i class="fas fa-pencil"></i>
                            </button>
                            <button type="button" class="quick-action-btn" onclick="copyDirectUrl('{{ $item->url }}')" title="Salin URL">
                                <i class="fas fa-link"></i>
                            </button>
                            <form action="{{ route('admin.media.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus berkas ini secara permanen?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="quick-action-btn btn-delete" title="Hapus">
                                    <i class="fas fa-trash-can"></i>
                                </button>
                            </form>
                        </div>

                        <div class="media-card-preview">
                            @if($item->is_image)
                                <img src="{{ $item->url }}" alt="{{ $item->alt_text ?? $item->name }}" loading="lazy">
                            @else
                                <div style="font-size: 2.5rem; color: #94a3b8;">
                                    <i class="fas fa-file-lines"></i>
                                </div>
                            @endif
                        </div>

                        <div class="media-card-info">
                            <div class="media-card-title" title="{{ $item->title ?: $item->name }}">
                                {{ $item->title ?: $item->name }}
                            </div>
                            <div class="media-card-meta">
                                <span class="media-card-badge">{{ strtoupper(explode('/', $item->mime_type)[1] ?? 'FILE') }}</span>
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
                <div style="color: #cbd5e1; font-size: 3.5rem; margin-bottom: 1rem;">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3 style="font-size: 1.15rem; font-weight: 700; color: #1e293b;">Belum ada berkas media</h3>
                <p style="color: #64748b; font-size: 0.875rem;">Unggah berkas pertama Anda melalui area di atas.</p>
            </div>
        @endif
    </div>
</div>

<!-- ==========================================================================
     WordPress-Style Attachment Details Modal (Inspector)
     ========================================================================== -->
<div id="attachmentDetailsModal" class="attachment-modal-backdrop" onclick="handleBackdropClick(event)">
    <div class="attachment-modal-container" role="dialog" aria-modal="true" aria-labelledby="modalAttachmentTitle">
        <!-- Header -->
        <div class="attachment-modal-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <h3 class="attachment-modal-title" id="modalAttachmentTitle">
                    <i class="fas fa-photo-film text-emerald-700"></i>
                    <span>Rincian Lampiran</span>
                </h3>
            </div>

            <!-- Navigation between items (< >) -->
            <div class="attachment-nav-controls">
                <button type="button" id="btnPrevMedia" class="attachment-nav-btn" onclick="navigateMedia(-1)" title="Berkas Sebelumnya (Panah Kiri)">
                    <i class="fas fa-chevron-left"></i> <span>Sebelumnya</span>
                </button>
                <button type="button" id="btnNextMedia" class="attachment-nav-btn" onclick="navigateMedia(1)" title="Berkas Selanjutnya (Panah Kanan)">
                    <span>Selanjutnya</span> <i class="fas fa-chevron-right"></i>
                </button>
                <button type="button" class="attachment-modal-close" onclick="closeAttachmentInspector()" title="Tutup (Esc)">
                    <i class="fas fa-times text-base"></i>
                </button>
            </div>
        </div>

        <!-- Body -->
        <div class="attachment-modal-body">
            <!-- Left Column: Visual Preview & Technical Meta -->
            <div class="attachment-preview-col">
                <div class="attachment-img-frame" id="inspectorImgFrame">
                    <img id="inspectorImg" src="" alt="Pratinjau">
                </div>

                <div class="attachment-meta-card">
                    <div class="meta-row">
                        <span class="label">Nama Berkas:</span>
                        <span class="value" id="inspectorFileName" title="">-</span>
                    </div>
                    <div class="meta-row">
                        <span class="label">Tipe Berkas:</span>
                        <span class="value" id="inspectorFileType">-</span>
                    </div>
                    <div class="meta-row">
                        <span class="label">Ukuran Berkas:</span>
                        <span class="value" id="inspectorFileSize">-</span>
                    </div>
                    <div class="meta-row">
                        <span class="label">Tanggal Unggah:</span>
                        <span class="value" id="inspectorFileDate">-</span>
                    </div>

                    <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 4px 0;">

                    <div>
                        <span class="label" style="font-size: 0.72rem; display: block; margin-bottom: 4px;">URL Berkas:</span>
                        <div class="attachment-url-box">
                            <input type="text" id="inspectorUrlInput" class="attachment-url-input" readonly>
                            <button type="button" class="btn-copy-url" id="btnCopyInspectorUrl" onclick="copyInspectorUrl()">
                                <i class="fas fa-copy"></i> <span id="copyBtnText">Salin</span>
                            </button>
                            <a id="inspectorOpenLink" href="#" target="_blank" class="quick-action-btn" title="Buka di tab baru">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: SEO Metadata Editor -->
            <div class="attachment-form-col">
                <form id="attachmentSeoForm" onsubmit="saveAttachmentSeo(event)">
                    <!-- Alt Text -->
                    <div class="seo-form-group">
                        <div class="seo-label-row">
                            <label class="seo-label" for="metaAltText">Teks Alternatif (Alt Text)</label>
                            <span class="badge-seo-tip">Penting untuk SEO</span>
                        </div>
                        <input type="text" id="metaAltText" class="seo-input" placeholder="Jelaskan isi gambar untuk Google & pembaca layar...">
                        <span class="seo-help-text">Membantu Google Image mengindeks postingan dan ramah bagi tunanetra (aksesibilitas).</span>
                    </div>

                    <!-- Title -->
                    <div class="seo-form-group">
                        <label class="seo-label" for="metaTitle">Judul Gambar (Title)</label>
                        <input type="text" id="metaTitle" class="seo-input" placeholder="Judul gambar...">
                        <span class="seo-help-text">Judul yang muncul di pustaka media dan atribut title gambar.</span>
                    </div>

                    <!-- Caption -->
                    <div class="seo-form-group">
                        <div class="seo-label-row">
                            <label class="seo-label" for="metaCaption">Keterangan (Caption)</label>
                            <span class="badge-content-tip">Tampil di Konten</span>
                        </div>
                        <textarea id="metaCaption" class="seo-textarea" rows="2" placeholder="Teks keterangan yang tampil tepat di bawah gambar di artikel..."></textarea>
                        <span class="seo-help-text">Akan dibungkus dalam tag <code>&lt;figcaption&gt;</code> di bawah gambar.</span>
                    </div>

                    <!-- Description -->
                    <div class="seo-form-group">
                        <label class="seo-label" for="metaDescription">Deskripsi Lengkap</label>
                        <textarea id="metaDescription" class="seo-textarea" rows="2" placeholder="Catatan internal atau keterangan lengkap mengenai berkas ini..."></textarea>
                    </div>

                    <!-- Actions Footer -->
                    <div class="attachment-actions-footer">
                        <button type="button" class="btn-delete-permanent" onclick="deleteCurrentAttachment()">
                            <i class="fas fa-trash-can"></i> Hapus Permanen
                        </button>

                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span class="save-indicator" id="saveIndicator">
                                <i class="fas fa-check-circle"></i> Tersimpan!
                            </span>
                            <button type="submit" class="btn-save-seo" id="btnSaveSeo">
                                <i class="fas fa-floppy-disk"></i> Simpan Info SEO
                            </button>
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
    // All media items passed from controller
    const allMediaItems = @json($media->items());
    let currentMediaIndex = -1;

    function openAttachmentInspector(index) {
        if (index < 0 || index >= allMediaItems.length) return;
        currentMediaIndex = index;
        const item = allMediaItems[index];

        // Populate Left Column
        const img = document.getElementById('inspectorImg');
        if (item.mime_type && item.mime_type.startsWith('image/')) {
            img.src = item.url;
            img.style.display = 'block';
        } else {
            img.src = '';
            img.style.display = 'none';
        }

        document.getElementById('inspectorFileName').innerText = item.file_name || item.name;
        document.getElementById('inspectorFileName').title = item.file_name || item.name;
        document.getElementById('inspectorFileType').innerText = (item.mime_type || 'Unknown').toUpperCase();
        document.getElementById('inspectorFileSize').innerText = (item.size ? (item.size / 1024).toFixed(1) : 0) + ' KB';
        
        let dateStr = '-';
        if (item.created_at) {
            const d = new Date(item.created_at);
            dateStr = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
        }
        document.getElementById('inspectorFileDate').innerText = dateStr;

        const urlInput = document.getElementById('inspectorUrlInput');
        urlInput.value = item.url || '';
        document.getElementById('inspectorOpenLink').href = item.url || '#';

        // Populate Right Column
        document.getElementById('metaAltText').value = item.alt_text || '';
        document.getElementById('metaTitle').value = item.title || '';
        document.getElementById('metaCaption').value = item.caption || '';
        document.getElementById('metaDescription').value = item.description || '';

        // Update Prev/Next buttons
        document.getElementById('btnPrevMedia').disabled = (currentMediaIndex === 0);
        document.getElementById('btnNextMedia').disabled = (currentMediaIndex === allMediaItems.length - 1);

        // Reset indicators
        document.getElementById('saveIndicator').style.display = 'none';
        document.getElementById('copyBtnText').innerText = 'Salin';

        // Show Modal
        const modal = document.getElementById('attachmentDetailsModal');
        modal.style.display = 'flex';
        requestAnimationFrame(() => {
            modal.classList.add('active');
        });
    }

    function closeAttachmentInspector() {
        const modal = document.getElementById('attachmentDetailsModal');
        modal.classList.remove('active');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 200);
    }

    function navigateMedia(direction) {
        const newIndex = currentMediaIndex + direction;
        if (newIndex >= 0 && newIndex < allMediaItems.length) {
            openAttachmentInspector(newIndex);
        }
    }

    function copyInspectorUrl() {
        const url = document.getElementById('inspectorUrlInput').value;
        navigator.clipboard.writeText(url).then(() => {
            const btnText = document.getElementById('copyBtnText');
            btnText.innerText = 'Tersalin!';
            setTimeout(() => {
                btnText.innerText = 'Salin';
            }, 2000);
        });
    }

    function copyDirectUrl(url) {
        navigator.clipboard.writeText(url).then(() => {
            alert('URL berkas berhasil disalin!');
        });
    }

    function saveAttachmentSeo(e) {
        e.preventDefault();
        if (currentMediaIndex === -1) return;
        const item = allMediaItems[currentMediaIndex];

        const btn = document.getElementById('btnSaveSeo');
        const originalContent = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

        const payload = {
            alt_text: document.getElementById('metaAltText').value,
            title: document.getElementById('metaTitle').value,
            caption: document.getElementById('metaCaption').value,
            description: document.getElementById('metaDescription').value,
        };

        fetch(`/admin/media/${item.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = originalContent;

            if (data.success) {
                // Update local memory
                allMediaItems[currentMediaIndex].alt_text = payload.alt_text;
                allMediaItems[currentMediaIndex].title = payload.title;
                allMediaItems[currentMediaIndex].caption = payload.caption;
                allMediaItems[currentMediaIndex].description = payload.description;

                // Update UI card title
                const card = document.querySelector(`.media-card[data-id="${item.id}"] .media-card-title`);
                if (card) {
                    card.innerText = payload.title || item.name;
                }

                // Show success indicator
                const indicator = document.getElementById('saveIndicator');
                indicator.style.display = 'inline-flex';
                setTimeout(() => {
                    indicator.style.display = 'none';
                }, 3000);
            } else {
                alert('Gagal menyimpan perubahan.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = originalContent;
            alert('Terjadi kesalahan jaringan saat menyimpan.');
        });
    }

    function deleteCurrentAttachment() {
        if (currentMediaIndex === -1) return;
        const item = allMediaItems[currentMediaIndex];

        if (!confirm(`Hapus berkas "${item.title || item.name}" secara permanen? Tindakan ini tidak dapat dibatalkan.`)) {
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/media/${item.id}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }

    function handleBackdropClick(e) {
        const container = document.querySelector('.attachment-modal-container');
        if (container && !container.contains(e.target)) {
            closeAttachmentInspector();
        }
    }

    // Keyboard Shortcuts
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('attachmentDetailsModal');
        if (modal && modal.classList.contains('active')) {
            if (e.key === 'Escape') {
                closeAttachmentInspector();
            } else if (e.key === 'ArrowLeft') {
                // Don't trigger if typing in an input
                if (document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
                    navigateMedia(-1);
                }
            } else if (e.key === 'ArrowRight') {
                if (document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
                    navigateMedia(1);
                }
            }
        }
    });

    // Drag & Drop visual feedback on main dropzone
    const dropzone = document.getElementById('uploadDropzone');
    if (dropzone) {
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropzone.classList.add('dragover');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropzone.classList.remove('dragover');
            }, false);
        });

        dropzone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('file-input').files = files;
                document.getElementById('upload-form').submit();
            }
        });
    }
</script>
@endpush