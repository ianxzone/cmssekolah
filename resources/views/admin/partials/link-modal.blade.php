{{-- WordPress-Style Insert & Edit Link Modal --}}
<div id="wpLinkModal" class="wp-link-modal-backdrop" style="display: none;">
    <div class="wp-link-modal-container" role="dialog" aria-modal="true" aria-labelledby="wpLinkModalTitle">
        <!-- Header -->
        <div class="wp-link-modal-header">
            <h3 class="wp-link-modal-title" id="wpLinkModalTitle">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #006837;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
                <span id="wpLinkModalTitleText">Sisipkan / Edit Tautan</span>
            </h3>
            <button type="button" class="wp-link-modal-close" onclick="closeWpLinkModal()" title="Tutup (Esc)">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Body Form -->
        <div class="wp-link-modal-body">
            <!-- Anchor Text -->
            <div class="wp-link-field-group">
                <label class="wp-link-label" for="wpLinkText">Teks Tautan (Anchor Text)</label>
                <input type="text" id="wpLinkText" class="wp-link-input" placeholder="Teks yang akan diklik oleh pembaca...">
                <span class="wp-link-helper">Teks yang akan ditampilkan sebagai tautan pada artikel / halaman.</span>
            </div>

            <!-- URL Input -->
            <div class="wp-link-field-group">
                <label class="wp-link-label" for="wpLinkUrl">Alamat URL Tautan <span style="color: #ef4444;">*</span></label>
                <input type="text" id="wpLinkUrl" class="wp-link-input" placeholder="https://contoh.com atau /berita/judul atau #section" required>
                <span class="wp-link-helper">Dapat berupa link eksternal (https://...), halaman internal (/...), atau anchor (#...).</span>
            </div>

            <!-- Options Box -->
            <div class="wp-link-options-box">
                <!-- Target Blank -->
                <label class="wp-link-checkbox-label" for="wpLinkTargetBlank">
                    <input type="checkbox" id="wpLinkTargetBlank" class="wp-link-checkbox">
                    <span>Buka tautan di tab baru (<code>target="_blank"</code>)</span>
                </label>

                <!-- Rel Nofollow -->
                <label class="wp-link-checkbox-label" for="wpLinkNofollow">
                    <input type="checkbox" id="wpLinkNofollow" class="wp-link-checkbox">
                    <span>Tambahkan <code>rel="nofollow"</code> <span style="font-size: 0.72rem; color: #64748b; font-weight: normal;">(disarankan untuk tautan sponsor / eksternal)</span></span>
                </label>
            </div>

            <!-- Title Attribute (Tooltip) -->
            <div class="wp-link-field-group">
                <label class="wp-link-label" for="wpLinkTitle">Judul Tautan / Tooltip (Opsional)</label>
                <input type="text" id="wpLinkTitle" class="wp-link-input" placeholder="Teks tooltip yang muncul saat kursor diarahkan ke tautan">
            </div>
        </div>

        <!-- Footer -->
        <div class="wp-link-modal-footer">
            <div>
                <button type="button" id="btnWpLinkUnlink" class="btn-wp-link-unlink" onclick="unlinkWpCurrentSelection()" style="display: none;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Hapus Tautan</span>
                </button>
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="button" class="btn-wp-link-cancel" onclick="closeWpLinkModal()">Batal</button>
                <button type="button" class="btn-wp-link-save" onclick="applyWpLinkModal()">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span id="btnWpLinkSaveText">Terapkan Tautan</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    let currentTrixEditor = null;
    let savedRange = null;
    let isEditingExistingLink = false;
    let existingAnchorElement = null;

    // 1. Initialize Trix Link Attributes & View Overrides
    function initTrixLinkConfiguration() {
        if (typeof Trix === 'undefined') return;

        // Register custom textAttributes for target, rel, and title
        if (!Trix.config.textAttributes.target) {
            Trix.config.textAttributes.target = {
                inheritable: true,
                parser: function(element) {
                    const a = element.closest("a:not([data-trix-attachment])");
                    if (a && a.hasAttribute("target")) return a.getAttribute("target");
                }
            };
        }

        if (!Trix.config.textAttributes.rel) {
            Trix.config.textAttributes.rel = {
                inheritable: true,
                parser: function(element) {
                    const a = element.closest("a:not([data-trix-attachment])");
                    if (a && a.hasAttribute("rel")) return a.getAttribute("rel");
                }
            };
        }

        if (!Trix.config.textAttributes.linkTitle) {
            Trix.config.textAttributes.linkTitle = {
                inheritable: true,
                parser: function(element) {
                    const a = element.closest("a:not([data-trix-attachment])");
                    if (a && a.hasAttribute("title")) return a.getAttribute("title");
                }
            };
        }

        // Patch PieceView to copy target, rel, and title onto rendered <a> elements
        if (Trix.PieceView && !Trix.PieceView.prototype._wpLinkPatched) {
            const originalCreateContainerElement = Trix.PieceView.prototype.createContainerElement;
            Trix.PieceView.prototype.createContainerElement = function() {
                const el = originalCreateContainerElement.apply(this, arguments);
                if (el && el.tagName === 'A') {
                    if (this.attributes && this.attributes.target) {
                        el.setAttribute('target', this.attributes.target);
                    }
                    if (this.attributes && this.attributes.rel) {
                        el.setAttribute('rel', this.attributes.rel);
                    }
                    if (this.attributes && this.attributes.linkTitle) {
                        el.setAttribute('title', this.attributes.linkTitle);
                    }
                }
                return el;
            };
            Trix.PieceView.prototype._wpLinkPatched = true;
        }
    }

    // 2. Open Modal Function
    window.openWpLinkModal = function(trixElement) {
        initTrixLinkConfiguration();

        const editorElement = trixElement || document.querySelector('trix-editor:focus') || document.querySelector('trix-editor');
        if (!editorElement || !editorElement.editor) return;

        currentTrixEditor = editorElement;
        const editor = editorElement.editor;
        savedRange = editor.getSelectedRange();

        const modal = document.getElementById('wpLinkModal');
        const textInput = document.getElementById('wpLinkText');
        const urlInput = document.getElementById('wpLinkUrl');
        const targetBlankCheck = document.getElementById('wpLinkTargetBlank');
        const nofollowCheck = document.getElementById('wpLinkNofollow');
        const titleInput = document.getElementById('wpLinkTitle');
        const unlinkBtn = document.getElementById('btnWpLinkUnlink');
        const saveText = document.getElementById('btnWpLinkSaveText');
        const titleText = document.getElementById('wpLinkModalTitleText');

        // Check if cursor or selection is inside an <a> tag
        let selectedText = "";
        if (savedRange && savedRange[0] !== savedRange[1]) {
            selectedText = editor.getDocument().getStringAtPosition(savedRange[0], savedRange[1]) || "";
        }

        // Detect existing link from DOM
        existingAnchorElement = null;
        const sel = window.getSelection();
        if (sel && sel.anchorNode) {
            const node = sel.anchorNode.nodeType === 3 ? sel.anchorNode.parentElement : sel.anchorNode;
            if (node) {
                existingAnchorElement = node.closest('a:not([data-trix-attachment])');
            }
        }

        // Also check Trix attributes at cursor
        const currentAttributes = editor.getAttributesAtPosition ? (editor.getAttributesAtPosition(savedRange[0]) || {}) : {};

        if (existingAnchorElement || currentAttributes.href) {
            isEditingExistingLink = true;
            unlinkBtn.style.display = 'inline-flex';
            saveText.innerText = 'Perbarui Tautan';
            titleText.innerText = 'Edit Tautan';

            const href = existingAnchorElement ? existingAnchorElement.getAttribute('href') : (currentAttributes.href || '');
            const target = existingAnchorElement ? existingAnchorElement.getAttribute('target') : (currentAttributes.target || '');
            const rel = existingAnchorElement ? existingAnchorElement.getAttribute('rel') : (currentAttributes.rel || '');
            const title = existingAnchorElement ? existingAnchorElement.getAttribute('title') : (currentAttributes.linkTitle || '');
            const anchorContent = existingAnchorElement ? existingAnchorElement.textContent : selectedText;

            textInput.value = anchorContent || selectedText || '';
            urlInput.value = href || '';
            targetBlankCheck.checked = (target === '_blank');
            nofollowCheck.checked = !!(rel && rel.includes('nofollow'));
            titleInput.value = title || '';
        } else {
            isEditingExistingLink = false;
            unlinkBtn.style.display = 'none';
            saveText.innerText = 'Sisipkan Tautan';
            titleText.innerText = 'Sisipkan Tautan';

            textInput.value = selectedText || '';
            urlInput.value = '';
            targetBlankCheck.checked = false;
            nofollowCheck.checked = false;
            titleInput.value = '';
        }

        modal.style.display = 'flex';
        // Trigger smooth appearance
        requestAnimationFrame(() => {
            modal.classList.add('active');
            if (urlInput.value) {
                urlInput.focus();
                urlInput.select();
            } else if (textInput.value) {
                urlInput.focus();
            } else {
                textInput.focus();
            }
        });
    };

    // 3. Close Modal
    window.closeWpLinkModal = function() {
        const modal = document.getElementById('wpLinkModal');
        if (!modal) return;
        modal.classList.remove('active');
        setTimeout(() => {
            modal.style.display = 'none';
            if (currentTrixEditor) {
                currentTrixEditor.focus();
            }
        }, 200);
    };

    // 4. Remove / Unlink
    window.unlinkWpCurrentSelection = function() {
        if (!currentTrixEditor || !currentTrixEditor.editor) return;
        const editor = currentTrixEditor.editor;

        if (savedRange) {
            editor.setSelectedRange(savedRange);
        }

        editor.removeAttribute('href');
        editor.removeAttribute('target');
        editor.removeAttribute('rel');
        editor.removeAttribute('linkTitle');

        closeWpLinkModal();
    };

    // 5. Apply Link
    window.applyWpLinkModal = function() {
        if (!currentTrixEditor || !currentTrixEditor.editor) return;
        const editor = currentTrixEditor.editor;

        let url = document.getElementById('wpLinkUrl').value.trim();
        const anchorText = document.getElementById('wpLinkText').value.trim();
        const isTargetBlank = document.getElementById('wpLinkTargetBlank').checked;
        const isNofollow = document.getElementById('wpLinkNofollow').checked;
        const linkTitle = document.getElementById('wpLinkTitle').value.trim();

        if (!url) {
            alert('Silakan masukkan alamat URL tautan terlebih dahulu.');
            document.getElementById('wpLinkUrl').focus();
            return;
        }

        // Format URL: if not starting with protocol, slash, hash, tel, or mailto
        if (!url.match(/^[a-zA-Z]+:\/\//) && !url.startsWith('/') && !url.startsWith('#') && !url.startsWith('mailto:') && !url.startsWith('tel:')) {
            url = 'https://' + url;
        }

        // Calculate rel attribute
        let relArray = [];
        if (isTargetBlank) {
            relArray.push('noopener', 'noreferrer');
        }
        if (isNofollow) {
            relArray.push('nofollow');
        }
        const relValue = relArray.length > 0 ? relArray.join(' ') : null;

        if (savedRange) {
            editor.setSelectedRange(savedRange);
        }

        const hasSelectedText = savedRange && (savedRange[0] !== savedRange[1]);

        if (hasSelectedText) {
            // Apply attributes directly to selection
            editor.activateAttribute('href', url);
            if (isTargetBlank) {
                editor.activateAttribute('target', '_blank');
            } else {
                editor.removeAttribute('target');
            }

            if (relValue) {
                editor.activateAttribute('rel', relValue);
            } else {
                editor.removeAttribute('rel');
            }

            if (linkTitle) {
                editor.activateAttribute('linkTitle', linkTitle);
            } else {
                editor.removeAttribute('linkTitle');
            }
        } else {
            // No selection: insert the anchor text and link it
            const textToInsert = anchorText || url;
            const startPos = savedRange ? savedRange[0] : editor.getPosition();

            editor.insertString(textToInsert);
            editor.setSelectedRange([startPos, startPos + textToInsert.length]);

            editor.activateAttribute('href', url);
            if (isTargetBlank) {
                editor.activateAttribute('target', '_blank');
            }
            if (relValue) {
                editor.activateAttribute('rel', relValue);
            }
            if (linkTitle) {
                editor.activateAttribute('linkTitle', linkTitle);
            }

            // Move cursor to after inserted text
            editor.setSelectedRange(startPos + textToInsert.length);
        }

        closeWpLinkModal();
    };

    // 6. Hook Trix Initialization with Robust Multi-stage Setup
    function setupTrixLinkButton(trixEl) {
        if (!trixEl) return;
        initTrixLinkConfiguration();
        const toolbar = trixEl.toolbarElement;
        if (!toolbar) return;
        if (toolbar.dataset.wpLinkEnhanced === "true") return;
        toolbar.dataset.wpLinkEnhanced = "true";

        // Hide default Trix link dialog
        const defaultDialog = toolbar.querySelector('[data-trix-dialog="href"]');
        if (defaultDialog) {
            defaultDialog.style.display = 'none';
        }

        // Find default Link button in toolbar
        const linkBtn = toolbar.querySelector('[data-trix-attribute="href"]');
        if (linkBtn) {
            linkBtn.removeAttribute('data-trix-attribute');
            linkBtn.setAttribute('data-trix-action', 'open-wp-link-modal');
            linkBtn.setAttribute('title', 'Sisipkan / Edit Tautan (Ctrl+K)');

            linkBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                window.openWpLinkModal(trixEl);
            });
        }
    }

    document.addEventListener('trix-initialize', function(event) {
        setupTrixLinkButton(event.target);
    });

    function setupAllTrixLinks() {
        document.querySelectorAll('trix-editor').forEach(el => {
            if (el.toolbarElement) {
                setupTrixLinkButton(el);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupAllTrixLinks);
    } else {
        setupAllTrixLinks();
    }
    setTimeout(setupAllTrixLinks, 150);
    setTimeout(setupAllTrixLinks, 600);

    // 7. Global Keyboard Shortcut Handler: Ctrl+K / Cmd+K inside Trix
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
            const activeEditor = document.activeElement && document.activeElement.tagName === 'TRIX-EDITOR'
                ? document.activeElement
                : document.querySelector('trix-editor:focus');

            if (activeEditor) {
                e.preventDefault();
                e.stopPropagation();
                window.openWpLinkModal(activeEditor);
            }
        }

        // Close on Esc
        if (e.key === 'Escape') {
            const modal = document.getElementById('wpLinkModal');
            if (modal && modal.classList.contains('active')) {
                closeWpLinkModal();
            }
        }
    });

    // Close on backdrop click
    document.addEventListener('DOMContentLoaded', function() {
        initTrixLinkConfiguration();

        const modal = document.getElementById('wpLinkModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeWpLinkModal();
                }
            });
        }

        // Allow Enter key in URL input to submit
        const urlInput = document.getElementById('wpLinkUrl');
        if (urlInput) {
            urlInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    applyWpLinkModal();
                }
            });
        }
    });

})();
</script>
