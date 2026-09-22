{{-- WordPress-Style SEO Media Modal --}}
<div id="wpMediaModal" class="wp-media-modal-backdrop" style="display: none;">
    <div class="wp-media-modal-container">
        <!-- Header -->
        <div class="wp-media-modal-header">
            <div class="wp-media-modal-tabs">
                <button type="button" class="wp-media-tab-btn" data-tab="upload" onclick="switchMediaTab('upload')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <span>Unggah Berkas</span>
                </button>
                <button type="button" class="wp-media-tab-btn active" data-tab="library" onclick="switchMediaTab('library')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Pustaka Media</span>
                </button>
            </div>
            <button type="button" class="wp-media-modal-close" onclick="closeWpMediaModal()" title="Tutup (Esc)">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Body -->
        <div class="wp-media-modal-body">
            <!-- TAB 1: Upload Files -->
            <div id="wpMediaTabUpload" class="wp-media-tab-pane" style="display: none;">
                <div class="wp-media-dropzone" id="wpMediaDropzone">
                    <div class="wp-media-dropzone-inner">
                        <div class="wp-media-upload-icon">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0 0 0.5rem 0;">Tarik berkas ke sini untuk mengunggah</h3>
                        <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1.25rem;">atau</p>
                        <label class="wp-media-upload-btn">
                            <span>Pilih Berkas</span>
                            <input type="file" id="wpMediaFileInput" multiple accept="image/*" style="display: none;" onchange="handleMediaFilesSelect(this.files)">
                        </label>
                        <p style="color: #9ca3af; font-size: 0.75rem; margin-top: 1.5rem;">Ukuran maksimal berkas unggahan: 2 MB (JPG, PNG, GIF, WebP - Otomatis Dioptimasi).</p>
                    </div>

                    <!-- Progress bar -->
                    <div id="wpMediaUploadProgressContainer" style="display: none; margin-top: 1.5rem; width: 80%; max-width: 400px;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: #4b5563; margin-bottom: 4px;">
                            <span id="wpMediaUploadStatusText">Mengunggah berkas...</span>
                            <span id="wpMediaUploadPercentText">0%</span>
                        </div>
                        <div style="width: 100%; height: 8px; background: #e5e7eb; border-radius: 9999px; overflow: hidden;">
                            <div id="wpMediaProgressBar" style="width: 0%; height: 100%; background: #4f46e5; transition: width 0.2s;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: Media Library -->
            <div id="wpMediaTabLibrary" class="wp-media-tab-pane active">
                <div class="wp-media-library-container">
                    <!-- Left: Grid View -->
                    <div class="wp-media-grid-column">
                        <!-- Toolbar -->
                        <div class="wp-media-library-toolbar">
                            <div class="wp-media-search-box">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <input type="text" id="wpMediaSearchInput" placeholder="Cari media (nama, alt text, judul)..." oninput="debounceMediaSearch()">
                            </div>
                            <button type="button" class="wp-media-refresh-btn" onclick="fetchMediaLibrary(1, true)" title="Muat ulang">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </button>
                        </div>

                        <!-- Grid -->
                        <div class="wp-media-grid-scroll">
                            <div id="wpMediaGrid" class="wp-media-grid">
                                <!-- Filled via JS -->
                            </div>
                            <div id="wpMediaLoading" class="wp-media-loading" style="display: none;">
                                <div class="wp-spinner"></div>
                                <span>Memuat media...</span>
                            </div>
                            <div id="wpMediaEmpty" class="wp-media-empty" style="display: none;">
                                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p>Tidak ada media ditemukan</p>
                            </div>

                            <!-- Load More Button -->
                            <div id="wpMediaLoadMoreContainer" style="display: none; text-align: center; padding: 1.5rem 0;">
                                <button type="button" class="wp-media-load-more-btn" onclick="loadMoreMedia()">Muat Berkas Lainnya</button>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Inspector Sidebar (Details & SEO) -->
                    <div class="wp-media-sidebar-column" id="wpMediaSidebar">
                        <div class="wp-media-sidebar-empty" id="wpMediaSidebarEmpty">
                            <p>Pilih gambar di sebelah kiri untuk melihat detail dan mengatur SEO.</p>
                        </div>

                        <div class="wp-media-sidebar-content" id="wpMediaSidebarContent" style="display: none;">
                            <div class="wp-sidebar-heading">RINCIAN LAMPIRAN</div>
                            
                            <!-- Thumbnail & Meta -->
                            <div class="wp-attachment-info">
                                <div class="wp-attachment-thumbnail">
                                    <img id="wpSidebarThumb" src="" alt="Thumbnail">
                                </div>
                                <div class="wp-attachment-details">
                                    <div class="wp-file-name" id="wpSidebarFileName">-</div>
                                    <div class="wp-file-date" id="wpSidebarFileDate">-</div>
                                    <div class="wp-file-size" id="wpSidebarFileSize">-</div>
                                    <button type="button" class="wp-file-delete-btn" onclick="deleteCurrentMediaItem()">Hapus Secara Permanen</button>
                                </div>
                            </div>

                            <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 1rem 0;">

                            <!-- SEO Fields Form -->
                            <div class="wp-seo-form">
                                <div class="wp-form-group">
                                    <label class="wp-form-label" for="wpMetaAltText">
                                        <span>Teks Alternatif (Alt Text)</span>
                                        <span class="wp-seo-badge">Penting untuk SEO</span>
                                    </label>
                                    <input type="text" id="wpMetaAltText" class="wp-form-input" placeholder="Jelaskan isi gambar untuk Google & pembaca layar...">
                                    <small class="wp-form-help">Membantu Google Image mengindeks postingan dan ramah aksesibilitas.</small>
                                </div>

                                <div class="wp-form-group">
                                    <label class="wp-form-label" for="wpMetaTitle">Judul Gambar</label>
                                    <input type="text" id="wpMetaTitle" class="wp-form-input" placeholder="Judul gambar...">
                                </div>

                                <div class="wp-form-group">
                                    <label class="wp-form-label" for="wpMetaCaption">
                                        <span>Keterangan (Caption)</span>
                                        <span class="wp-hint-badge">Tampil di Konten</span>
                                    </label>
                                    <textarea id="wpMetaCaption" class="wp-form-textarea" rows="2" placeholder="Keterangan teks yang tampil tepat di bawah gambar..."></textarea>
                                </div>

                                <div class="wp-form-group">
                                    <label class="wp-form-label" for="wpMetaDescription">Deskripsi</label>
                                    <textarea id="wpMetaDescription" class="wp-form-textarea" rows="2" placeholder="Catatan atau deskripsi lengkap berkas..."></textarea>
                                </div>

                                <div class="wp-seo-save-row">
                                    <button type="button" class="wp-btn-save-seo" id="wpBtnSaveSeo" onclick="saveCurrentMediaMetadata()">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span>Simpan Info SEO</span>
                                    </button>
                                    <span class="wp-save-status" id="wpSaveStatus"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="wp-media-modal-footer">
            <div class="wp-footer-selection-info" id="wpFooterSelectionInfo">
                <span>Belum ada berkas dipilih</span>
            </div>
            <div class="wp-footer-actions">
                <button type="button" class="wp-btn-secondary" onclick="closeWpMediaModal()">Batal</button>
                <button type="button" class="wp-btn-primary" id="wpBtnInsertMedia" disabled onclick="executeMediaSelection()">
                    <span id="wpBtnInsertText">Pilih Media</span>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern WordPress Media Modal Styles */
.wp-media-modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(4px);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    box-sizing: border-box;
}

.wp-media-modal-container {
    background: #ffffff;
    width: 95vw;
    max-width: 1160px;
    height: calc(100vh - 40px);
    max-height: 760px;
    border-radius: 16px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    font-family: inherit;
    border: 1px solid rgba(229, 231, 235, 0.8);
}

/* Header */
.wp-media-modal-header {
    height: 56px;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 1.25rem;
    flex-shrink: 0;
}

.wp-media-modal-tabs {
    display: flex;
    gap: 0.5rem;
}

.wp-media-tab-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 0.5rem 1rem;
    background: transparent;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    color: #4b5563;
    cursor: pointer;
    transition: all 0.15s ease;
}

.wp-media-tab-btn:hover {
    background: #f3f4f6;
    color: #111827;
}

.wp-media-tab-btn.active {
    background: #ffffff;
    color: #4f46e5;
    font-weight: 600;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.wp-media-modal-close {
    background: transparent;
    border: none;
    cursor: pointer;
    color: #6b7280;
    padding: 6px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s ease;
}

.wp-media-modal-close:hover {
    background: #e5e7eb;
    color: #111827;
}

/* Body */
.wp-media-modal-body {
    flex: 1;
    overflow: hidden;
    position: relative;
    background: #ffffff;
}

.wp-media-tab-pane {
    width: 100%;
    height: 100%;
}

/* Tab 1: Dropzone */
.wp-media-dropzone {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
    padding: 2rem;
}

.wp-media-dropzone-inner {
    width: 100%;
    max-width: 600px;
    border: 2px dashed #cbd5e1;
    border-radius: 16px;
    padding: 3rem 2rem;
    text-align: center;
    background: #f8fafc;
    transition: all 0.2s ease;
}

.wp-media-dropzone-inner.dragover {
    border-color: #4f46e5;
    background: #eef2ff;
}

.wp-media-upload-icon {
    color: #4f46e5;
    margin-bottom: 1rem;
    display: inline-flex;
}

.wp-media-upload-btn {
    display: inline-block;
    padding: 0.625rem 1.75rem;
    background: #4f46e5;
    color: #ffffff;
    font-weight: 600;
    font-size: 0.875rem;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
    transition: background 0.15s ease;
}

.wp-media-upload-btn:hover {
    background: #4338ca;
}

/* Tab 2: Library & Inspector Layout */
.wp-media-library-container {
    display: flex;
    height: 100%;
    overflow: hidden;
}

.wp-media-grid-column {
    flex: 1;
    display: flex;
    flex-direction: column;
    border-right: 1px solid #e5e7eb;
    height: 100%;
    overflow: hidden;
}

.wp-media-library-toolbar {
    padding: 0.875rem 1.25rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    gap: 1rem;
    background: #fafafa;
}

.wp-media-search-box {
    position: relative;
    flex: 1;
    max-width: 380px;
    display: flex;
    align-items: center;
}

.wp-media-search-box svg {
    position: absolute;
    left: 12px;
    width: 16px;
    height: 16px;
    color: #9ca3af;
    pointer-events: none;
}

.wp-media-search-box input {
    width: 100%;
    padding: 0.5rem 0.75rem 0.5rem 2.25rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.875rem;
    background: #ffffff;
    transition: border-color 0.15s ease;
}

.wp-media-search-box input:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.15);
}

.wp-media-refresh-btn {
    padding: 0.5rem;
    background: #ffffff;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    color: #6b7280;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s ease;
}

.wp-media-refresh-btn:hover {
    color: #111827;
    background: #f3f4f6;
}

.wp-media-grid-scroll {
    flex: 1;
    overflow-y: auto;
    padding: 1.25rem;
}

.wp-media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 12px;
}

.wp-media-card {
    position: relative;
    aspect-ratio: 1;
    background: #f1f5f9;
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.15s ease;
}

.wp-media-card:hover {
    border-color: #93c5fd;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.wp-media-card.selected {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.25);
}

.wp-media-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.wp-media-card .wp-card-check {
    display: none;
    position: absolute;
    top: 6px;
    right: 6px;
    width: 22px;
    height: 22px;
    background: #4f46e5;
    color: white;
    border-radius: 50%;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.wp-media-card.selected .wp-card-check {
    display: flex;
}

.wp-media-loading,
.wp-media-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem;
    color: #6b7280;
    gap: 12px;
}

.wp-spinner {
    width: 32px;
    height: 32px;
    border: 3px solid #e5e7eb;
    border-top-color: #4f46e5;
    border-radius: 50%;
    animation: wpSpin 0.7s linear infinite;
}

@keyframes wpSpin {
    to { transform: rotate(360deg); }
}

.wp-media-load-more-btn {
    padding: 0.5rem 1.5rem;
    background: #ffffff;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
    transition: all 0.15s ease;
}

.wp-media-load-more-btn:hover {
    background: #f9fafb;
    border-color: #9ca3af;
}

/* Right: Inspector Sidebar */
.wp-media-sidebar-column {
    width: 340px;
    height: 100%;
    overflow-y: auto;
    background: #f9fafb;
    flex-shrink: 0;
    padding: 1.25rem;
    box-sizing: border-box;
}

.wp-media-sidebar-empty {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    text-align: center;
    color: #9ca3af;
    font-size: 0.875rem;
    padding: 1rem;
}

.wp-sidebar-heading {
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    color: #6b7280;
    margin-bottom: 0.875rem;
}

.wp-attachment-info {
    display: flex;
    gap: 12px;
    align-items: flex-start;
}

.wp-attachment-thumbnail {
    width: 72px;
    height: 72px;
    border-radius: 8px;
    background: #e5e7eb;
    overflow: hidden;
    flex-shrink: 0;
    border: 1px solid #d1d5db;
}

.wp-attachment-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.wp-attachment-details {
    flex: 1;
    overflow: hidden;
    font-size: 0.75rem;
    color: #4b5563;
    line-height: 1.4;
}

.wp-file-name {
    font-weight: 600;
    color: #111827;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 2px;
}

.wp-file-delete-btn {
    color: #ef4444;
    background: none;
    border: none;
    padding: 0;
    font-size: 0.75rem;
    cursor: pointer;
    margin-top: 4px;
    text-decoration: underline;
}

.wp-file-delete-btn:hover {
    color: #dc2626;
}

/* SEO Form */
.wp-form-group {
    margin-bottom: 0.875rem;
}

.wp-form-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.8rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 4px;
}

.wp-seo-badge {
    font-size: 0.65rem;
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
    padding: 1px 6px;
    border-radius: 9999px;
    font-weight: 600;
}

.wp-hint-badge {
    font-size: 0.65rem;
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
    padding: 1px 6px;
    border-radius: 9999px;
    font-weight: 600;
}

.wp-form-input,
.wp-form-textarea {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.8125rem;
    background: #ffffff;
    box-sizing: border-box;
    font-family: inherit;
    transition: border-color 0.15s ease;
}

.wp-form-input:focus,
.wp-form-textarea:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.15);
}

.wp-form-help {
    display: block;
    font-size: 0.7rem;
    color: #6b7280;
    margin-top: 3px;
    line-height: 1.3;
}

.wp-seo-save-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 1rem;
}

.wp-btn-save-seo {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.4rem 0.875rem;
    background: #4f46e5;
    color: #ffffff;
    border: none;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.15s ease;
}

.wp-btn-save-seo:hover {
    background: #4338ca;
}

.wp-save-status {
    font-size: 0.75rem;
    color: #059669;
    font-weight: 500;
}

/* Footer */
.wp-media-modal-footer {
    height: 60px;
    background: #ffffff;
    border-top: 1px solid #e5e7eb;
    padding: 0 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}

.wp-footer-selection-info {
    font-size: 0.875rem;
    color: #4b5563;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 50%;
}

.wp-footer-actions {
    display: flex;
    gap: 10px;
}

.wp-btn-secondary {
    padding: 0.5rem 1rem;
    background: #ffffff;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
    transition: all 0.15s ease;
}

.wp-btn-secondary:hover {
    background: #f3f4f6;
}

.wp-btn-primary {
    padding: 0.5rem 1.25rem;
    background: #006837;
    border: 1px solid #004d28;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 700;
    color: #ffffff;
    cursor: pointer;
    transition: all 0.15s ease;
    box-shadow: 0 2px 4px rgba(0, 104, 55, 0.2);
}

.wp-btn-primary:hover:not(:disabled) {
    background: #024324;
}

.wp-btn-primary:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .wp-media-library-container {
        flex-direction: column;
    }
    .wp-media-sidebar-column {
        width: 100%;
        height: 260px;
        border-top: 1px solid #e5e7eb;
    }
    .wp-media-modal-backdrop {
        padding: 0.5rem;
    }
    .wp-media-modal-container {
        width: 100vw;
        height: 100vh;
        border-radius: 0;
    }
}
</style>

<script>
// WordPress-Style Media Modal Manager
(function() {
    let currentOptions = {
        mode: 'editor', // 'editor' or 'featured'
        title: 'Pustaka Media',
        onSelect: null,
        currentPath: null
    };

    let mediaItems = [];
    let selectedMedia = null;
    let currentPage = 1;
    let lastPage = 1;
    let searchDebounceTimer = null;
    let metaDebounceTimer = null;

    // Open Modal
    window.openWpMediaModal = function(options = {}) {
        currentOptions = Object.assign({
            mode: 'editor',
            title: options.mode === 'featured' ? 'Pilih Gambar Utama' : 'Sisipkan Gambar ke Konten',
            onSelect: null,
            currentPath: null
        }, options);

        const modal = document.getElementById('wpMediaModal');
        modal.style.display = 'flex';

        // Update button label according to mode
        const btnText = document.getElementById('wpBtnInsertText');
        if (currentOptions.mode === 'featured') {
            btnText.textContent = 'Gunakan Sebagai Gambar Utama';
        } else {
            btnText.textContent = 'Sisipkan ke dalam Konten';
        }

        switchMediaTab('library');
        fetchMediaLibrary(1, true);

        // Escape key listener
        document.addEventListener('keydown', handleEscKey);
    };

    // Close Modal
    window.closeWpMediaModal = function() {
        const modal = document.getElementById('wpMediaModal');
        modal.style.display = 'none';
        document.removeEventListener('keydown', handleEscKey);
    };

    function handleEscKey(e) {
        if (e.key === 'Escape') {
            closeWpMediaModal();
        }
    }

    // Switch Tabs
    window.switchMediaTab = function(tabName) {
        const tabs = document.querySelectorAll('.wp-media-tab-btn');
        tabs.forEach(t => {
            if (t.getAttribute('data-tab') === tabName) {
                t.classList.add('active');
            } else {
                t.classList.remove('active');
            }
        });

        if (tabName === 'upload') {
            document.getElementById('wpMediaTabUpload').style.display = 'block';
            document.getElementById('wpMediaTabLibrary').style.display = 'none';
        } else {
            document.getElementById('wpMediaTabUpload').style.display = 'none';
            document.getElementById('wpMediaTabLibrary').style.display = 'block';
        }
    };

    // Debounce search
    window.debounceMediaSearch = function() {
        clearTimeout(searchDebounceTimer);
        searchDebounceTimer = setTimeout(() => {
            fetchMediaLibrary(1, true);
        }, 350);
    };

    // Fetch Media Library
    window.fetchMediaLibrary = async function(page = 1, reset = false) {
        const grid = document.getElementById('wpMediaGrid');
        const loader = document.getElementById('wpMediaLoading');
        const emptyState = document.getElementById('wpMediaEmpty');
        const loadMoreContainer = document.getElementById('wpMediaLoadMoreContainer');
        const search = document.getElementById('wpMediaSearchInput').value.trim();

        if (reset) {
            currentPage = 1;
            grid.innerHTML = '';
            selectedMedia = null;
            updateInspectorUI();
        }

        loader.style.display = 'flex';
        emptyState.style.display = 'none';
        loadMoreContainer.style.display = 'none';

        try {
            const url = `{{ route('admin.media.list') }}?page=${page}&search=${encodeURIComponent(search)}`;
            const res = await fetch(url, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await res.json();

            loader.style.display = 'none';
            currentPage = result.current_page;
            lastPage = result.last_page;

            if (reset) {
                mediaItems = result.data || [];
            } else {
                mediaItems = mediaItems.concat(result.data || []);
            }

            if (mediaItems.length === 0) {
                emptyState.style.display = 'flex';
                return;
            }

            renderMediaCards(result.data || [], reset);

            if (currentPage < lastPage) {
                loadMoreContainer.style.display = 'block';
            }
        } catch (err) {
            console.error('Failed to load media:', err);
            loader.style.display = 'none';
            emptyState.style.display = 'flex';
            emptyState.querySelector('p').textContent = 'Gagal memuat media pustaka.';
        }
    };

    // Load more pagination
    window.loadMoreMedia = function() {
        if (currentPage < lastPage) {
            fetchMediaLibrary(currentPage + 1, false);
        }
    };

    // Render cards
    function renderMediaCards(items, reset) {
        const grid = document.getElementById('wpMediaGrid');
        
        items.forEach(item => {
            const card = document.createElement('div');
            card.className = 'wp-media-card';
            card.id = `media-card-${item.id}`;
            
            const isSelected = selectedMedia && selectedMedia.id === item.id;
            if (isSelected) {
                card.classList.add('selected');
            }

            const imgThumb = item.url ? item.url : `/storage/${item.path}`;

            card.innerHTML = `
                <img src="${imgThumb}" alt="${item.alt_text || item.title || item.name}" loading="lazy">
                <div class="wp-card-check">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </div>
            `;

            card.addEventListener('click', () => {
                selectMediaItem(item);
            });

            grid.appendChild(card);
        });
    }

    // Select Media Item
    function selectMediaItem(item) {
        selectedMedia = item;

        // Highlight selected card
        document.querySelectorAll('.wp-media-card').forEach(c => c.classList.remove('selected'));
        const activeCard = document.getElementById(`media-card-${item.id}`);
        if (activeCard) {
            activeCard.classList.add('selected');
        }

        updateInspectorUI();
    }

    // Update Inspector UI
    function updateInspectorUI() {
        const sidebarEmpty = document.getElementById('wpMediaSidebarEmpty');
        const sidebarContent = document.getElementById('wpMediaSidebarContent');
        const btnInsert = document.getElementById('wpBtnInsertMedia');
        const footerInfo = document.getElementById('wpFooterSelectionInfo');

        if (!selectedMedia) {
            sidebarEmpty.style.display = 'flex';
            sidebarContent.style.display = 'none';
            btnInsert.disabled = true;
            footerInfo.innerHTML = '<span>Belum ada berkas dipilih</span>';
            return;
        }

        sidebarEmpty.style.display = 'none';
        sidebarContent.style.display = 'block';
        btnInsert.disabled = false;

        // Populate details
        const imgThumb = selectedMedia.url ? selectedMedia.url : `/storage/${selectedMedia.path}`;
        document.getElementById('wpSidebarThumb').src = imgThumb;
        document.getElementById('wpSidebarFileName').textContent = selectedMedia.file_name || selectedMedia.name;
        document.getElementById('wpSidebarFileDate').textContent = selectedMedia.created_at ? new Date(selectedMedia.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' }) : '-';
        document.getElementById('wpSidebarFileSize').textContent = selectedMedia.human_size || (selectedMedia.size ? Math.round(selectedMedia.size / 1024) + ' KB' : '-');

        // Form fields
        document.getElementById('wpMetaAltText').value = selectedMedia.alt_text || '';
        document.getElementById('wpMetaTitle').value = selectedMedia.title || selectedMedia.name || '';
        document.getElementById('wpMetaCaption').value = selectedMedia.caption || '';
        document.getElementById('wpMetaDescription').value = selectedMedia.description || '';
        document.getElementById('wpSaveStatus').textContent = '';

        footerInfo.innerHTML = `<strong>1 berkas terpilih:</strong> <span style="color: #4f46e5; font-weight: 500;">${selectedMedia.name}</span>`;
    }

    // Save Metadata via AJAX
    window.saveCurrentMediaMetadata = async function() {
        if (!selectedMedia) return;

        const altText = document.getElementById('wpMetaAltText').value.trim();
        const title = document.getElementById('wpMetaTitle').value.trim();
        const caption = document.getElementById('wpMetaCaption').value.trim();
        const description = document.getElementById('wpMetaDescription').value.trim();
        const saveStatus = document.getElementById('wpSaveStatus');

        saveStatus.textContent = 'Menyimpan...';
        saveStatus.style.color = '#4f46e5';

        try {
            const url = `{{ url('admin/media') }}/${selectedMedia.id}`;
            const res = await fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    alt_text: altText,
                    title: title,
                    caption: caption,
                    description: description
                })
            });

            const result = await res.json();
            if (result.success) {
                selectedMedia.alt_text = altText;
                selectedMedia.title = title;
                selectedMedia.caption = caption;
                selectedMedia.description = description;

                saveStatus.textContent = 'Tersimpan ✔';
                saveStatus.style.color = '#059669';

                setTimeout(() => {
                    if (saveStatus.textContent === 'Tersimpan ✔') {
                        saveStatus.textContent = '';
                    }
                }, 3000);
            }
        } catch (err) {
            console.error('Error saving metadata:', err);
            saveStatus.textContent = 'Gagal menyimpan.';
            saveStatus.style.color = '#ef4444';
        }
    };

    // Delete Media
    window.deleteCurrentMediaItem = async function() {
        if (!selectedMedia) return;

        if (!confirm('Apakah Anda yakin ingin menghapus berkas ini secara permanen dari server?')) {
            return;
        }

        try {
            const url = `{{ url('admin/media') }}/${selectedMedia.id}`;
            const res = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const result = await res.json();
            if (result.success) {
                selectedMedia = null;
                fetchMediaLibrary(1, true);
            }
        } catch (err) {
            alert('Gagal menghapus berkas media.');
        }
    };

    // Execute Selection Action
    window.executeMediaSelection = function() {
        if (!selectedMedia) return;

        // Auto-save any unsaved edits in metadata fields before executing
        selectedMedia.alt_text = document.getElementById('wpMetaAltText').value.trim();
        selectedMedia.title = document.getElementById('wpMetaTitle').value.trim();
        selectedMedia.caption = document.getElementById('wpMetaCaption').value.trim();
        selectedMedia.description = document.getElementById('wpMetaDescription').value.trim();

        // Trigger background save
        saveCurrentMediaMetadata();

        if (typeof currentOptions.onSelect === 'function') {
            currentOptions.onSelect(selectedMedia, currentOptions.mode);
        }

        closeWpMediaModal();
    };

    // Drag and Drop & Upload Files Handling
    const dropzone = document.getElementById('wpMediaDropzone');
    const dropzoneInner = dropzone ? dropzone.querySelector('.wp-media-dropzone-inner') : null;

    if (dropzone) {
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                if (dropzoneInner) dropzoneInner.classList.add('dragover');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                if (dropzoneInner) dropzoneInner.classList.remove('dragover');
            }, false);
        });

        dropzone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleMediaFilesSelect(files);
        });
    }

    window.handleMediaFilesSelect = function(files) {
        if (!files || files.length === 0) return;
        uploadFilesSequentially(Array.from(files));
    };

    async function uploadFilesSequentially(fileList) {
        const progressContainer = document.getElementById('wpMediaUploadProgressContainer');
        const progressBar = document.getElementById('wpMediaProgressBar');
        const progressStatus = document.getElementById('wpMediaUploadStatusText');
        const progressPercent = document.getElementById('wpMediaUploadPercentText');

        progressContainer.style.display = 'block';
        let lastUploadedItem = null;

        for (let i = 0; i < fileList.length; i++) {
            const file = fileList[i];
            progressStatus.textContent = `Mengunggah (${i + 1}/${fileList.length}): ${file.name}`;
            
            await new Promise((resolve, reject) => {
                const formData = new FormData();
                formData.append('file', file);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.media.store') }}', true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.setRequestHeader('Accept', 'application/json');

                xhr.upload.onprogress = (e) => {
                    if (e.lengthComputable) {
                        const percent = Math.round((e.loaded / e.total) * 100);
                        progressBar.style.width = `${percent}%`;
                        progressPercent.textContent = `${percent}%`;
                    }
                };

                xhr.onload = () => {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.media) {
                            lastUploadedItem = response.media;
                        } else {
                            lastUploadedItem = response;
                        }
                        resolve(response);
                    } else {
                        reject(new Error('Upload failed'));
                    }
                };

                xhr.onerror = () => reject(new Error('Network error'));
                xhr.send(formData);
            }).catch(err => {
                console.error('File upload error:', err);
            });
        }

        // Reset progress and switch back to library
        setTimeout(() => {
            progressContainer.style.display = 'none';
            progressBar.style.width = '0%';
            progressPercent.textContent = '0%';

            switchMediaTab('library');
            fetchMediaLibrary(1, true).then(() => {
                if (lastUploadedItem) {
                    selectMediaItem(lastUploadedItem);
                }
            });
        }, 500);
    }
})();
</script>
