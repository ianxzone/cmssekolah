<style>
    .media-picker-modal {
        position: fixed;
        inset: 0;
        z-index: 100001;
        background: rgba(0, 0, 0, 0.65);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .media-picker-modal[style*="display: none"] {
        display: none !important;
    }
    [x-cloak] {
        display: none !important;
    }
</style>

<div x-data="mediaPicker()" 
     @open-media-picker.window="openModal($event.detail)"
     class="media-picker-modal"
     x-show="isOpen"
     x-cloak
     x-transition.opacity>
    
    <div class="card" style="width: 90%; max-width: 1000px; height: 85vh; display: flex; flex-direction: column; background: var(--bg-body, #ffffff); border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.2);" @click.away="isOpen = false">
        
        <!-- Header -->
        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color, #e2e8f0); display: flex; justify-content: space-between; align-items: center; background: var(--bg-card, #ffffff);">
            <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                <i data-feather="image"></i> Pilih Media
            </h3>
            <button type="button" @click="isOpen = false" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-muted, #64748b); line-height: 1;">&times;</button>
        </div>

        <!-- Toolbar -->
        <div style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--border-color, #e2e8f0); display: flex; gap: 1rem; background: var(--bg-card, #ffffff);">
            <input type="text" x-model="searchQuery" @input.debounce.500ms="fetchMedia(1)" class="form-control" placeholder="Cari media..." style="max-width: 300px;">
            <div style="margin-left: auto;">
                <span x-show="isLoading" style="color: var(--text-muted, #64748b); font-size: 0.875rem;">Loading...</span>
            </div>
        </div>

        <!-- Grid -->
        <div style="flex: 1; overflow-y: auto; padding: 1.5rem; background: var(--bg-body, #f8fafc);">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 1rem;">
                <template x-for="item in mediaItems" :key="item.id">
                    <div @click="selectItem(item)" 
                         class="media-item" 
                         :class="selectedItem?.id === item.id ? 'selected' : ''"
                         style="border: 2px solid transparent; border-radius: 8px; overflow: hidden; cursor: pointer; position: relative; aspect-ratio: 1; background: var(--bg-card, #ffffff);">
                        
                        <img :src="item.url" :alt="item.name" style="width: 100%; height: 100%; object-fit: cover;">
                        
                        <div x-show="selectedItem?.id === item.id" style="position: absolute; inset: 0; border: 3px solid var(--primary-color, #006837); border-radius: 8px; pointer-events: none;">
                            <div style="position: absolute; top: 0.5rem; right: 0.5rem; background: var(--primary-color, #006837); color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            
            <div x-show="mediaItems.length === 0 && !isLoading" style="text-align: center; padding: 3rem; color: var(--text-muted, #64748b);">
                Tidak ada media ditemukan.
            </div>

            <!-- Pagination -->
            <div x-show="totalPages > 1" style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 1.5rem;">
                <button type="button" @click="fetchMedia(currentPage - 1)" :disabled="currentPage === 1" class="btn" style="padding: 0.25rem 0.75rem; border: 1px solid var(--border-color, #e2e8f0);">&laquo;</button>
                <span style="align-self: center; font-size: 0.875rem;">Halaman <span x-text="currentPage"></span> dari <span x-text="totalPages"></span></span>
                <button type="button" @click="fetchMedia(currentPage + 1)" :disabled="currentPage === totalPages" class="btn" style="padding: 0.25rem 0.75rem; border: 1px solid var(--border-color, #e2e8f0);">&raquo;</button>
            </div>
        </div>

        <!-- Footer -->
        <div style="padding: 1.25rem 1.5rem; border-top: 1px solid var(--border-color, #e2e8f0); display: flex; justify-content: flex-end; gap: 1rem; background: var(--bg-card, #ffffff);">
            <button type="button" @click="isOpen = false" class="btn" style="border: 1px solid var(--border-color, #e2e8f0); background: var(--bg-body, #ffffff);">Batal</button>
            <button type="button" @click="confirmSelection" class="btn btn-primary" :disabled="!selectedItem">Pilih Media</button>
        </div>
    </div>
</div>

<script>
(function() {
    function registerMediaPicker() {
        if (typeof Alpine !== 'undefined') {
            Alpine.data('mediaPicker', () => ({
                isOpen: false,
                isLoading: false,
                mediaItems: [],
                currentPage: 1,
                totalPages: 1,
                searchQuery: '',
                selectedItem: null,
                targetCallback: null,

                openModal(detail) {
                    this.targetCallback = detail ? detail.callback : null;
                    this.selectedItem = null;
                    this.isOpen = true;
                    this.fetchMedia(1);
                    setTimeout(() => { if (window.feather) feather.replace(); }, 50);
                },

                async fetchMedia(page = 1) {
                    this.isLoading = true;
                    try {
                        const url = "{{ route('admin.media.list') }}?page=" + page + "&search=" + encodeURIComponent(this.searchQuery);
                        const response = await fetch(url);
                        const json = await response.json();
                        this.mediaItems = json.data || [];
                        this.currentPage = json.current_page || 1;
                        this.totalPages = json.last_page || 1;
                    } catch (error) {
                        console.error('Failed to fetch media:', error);
                    }
                    this.isLoading = false;
                },

                selectItem(item) {
                    this.selectedItem = item;
                },

                confirmSelection() {
                    if (this.selectedItem && this.targetCallback) {
                        if (typeof this.targetCallback === 'function') {
                            this.targetCallback(this.selectedItem);
                        } else if (typeof window[this.targetCallback] === 'function') {
                            window[this.targetCallback](this.selectedItem);
                        }
                    }
                    this.isOpen = false;
                }
            }));
        }
    }

    if (window.Alpine) {
        registerMediaPicker();
    } else {
        document.addEventListener('alpine:init', registerMediaPicker);
    }
})();
</script>
