<div x-data="mediaPicker()" 
     @open-media-picker.window="openModal($event.detail)"
     class="media-picker-modal"
     x-show="isOpen"
     style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.5); align-items: center; justify-content: center;"
     x-transition.opacity>
    
    <div class="card" style="width: 90%; max-width: 1000px; height: 85vh; display: flex; flex-direction: column; background: var(--bg-body); border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.2);" @click.away="isOpen = false">
        
        <!-- Header -->
        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; background: var(--bg-card);">
            <h3 style="margin: 0; font-size: 1.125rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                <i data-feather="image"></i> Pilih Media
            </h3>
            <button @click="isOpen = false" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-muted);">&times;</button>
        </div>

        <!-- Toolbar -->
        <div style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--border-color); display: flex; gap: 1rem; background: var(--bg-card);">
            <input type="text" x-model="searchQuery" @input.debounce.500ms="fetchMedia(1)" class="form-control" placeholder="Cari media..." style="max-width: 300px;">
            <div style="margin-left: auto;">
                <span x-show="isLoading" style="color: var(--text-muted); font-size: 0.875rem;">Loading...</span>
            </div>
        </div>

        <!-- Grid -->
        <div style="flex: 1; overflow-y: auto; padding: 1.5rem; background: var(--bg-body);">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 1rem;">
                <template x-for="item in mediaItems" :key="item.id">
                    <div @click="selectItem(item)" 
                         class="media-item" 
                         :class="selectedItem?.id === item.id ? 'selected' : ''"
                         style="border: 2px solid transparent; border-radius: 8px; overflow: hidden; cursor: pointer; position: relative; aspect-ratio: 1; background: var(--bg-card);">
                        
                        <img :src="item.url" :alt="item.name" style="width: 100%; height: 100%; object-fit: cover;">
                        
                        <div x-show="selectedItem?.id === item.id" style="position: absolute; inset: 0; border: 3px solid var(--primary-color); border-radius: 8px; pointer-events: none;">
                            <div style="position: absolute; top: 0.5rem; right: 0.5rem; background: var(--primary-color); color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            
            <div x-show="mediaItems.length === 0 && !isLoading" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                Tidak ada media ditemukan.
            </div>

            <!-- Pagination -->
            <div x-show="totalPages > 1" style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 1.5rem;">
                <button @click="fetchMedia(currentPage - 1)" :disabled="currentPage === 1" class="btn" style="padding: 0.25rem 0.75rem; border: 1px solid var(--border-color);">&laquo;</button>
                <span style="align-self: center; font-size: 0.875rem;">Halaman <span x-text="currentPage"></span> dari <span x-text="totalPages"></span></span>
                <button @click="fetchMedia(currentPage + 1)" :disabled="currentPage === totalPages" class="btn" style="padding: 0.25rem 0.75rem; border: 1px solid var(--border-color);">&raquo;</button>
            </div>
        </div>

        <!-- Footer -->
        <div style="padding: 1.25rem 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 1rem; background: var(--bg-card);">
            <button @click="isOpen = false" class="btn" style="border: 1px solid var(--border-color); background: var(--bg-body);">Batal</button>
            <button @click="confirmSelection" class="btn btn-primary" :disabled="!selectedItem">Pilih Media</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
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
            this.targetCallback = detail.callback;
            this.selectedItem = null;
            this.isOpen = true;
            this.fetchMedia(1);
            setTimeout(() => { if (window.feather) feather.replace(); }, 50);
        },

        async fetchMedia(page = 1) {
            this.isLoading = true;
            try {
                const response = await fetch(/kalebet/media/list?page= + page + &search= + encodeURIComponent(this.searchQuery));
                const json = await response.json();
                this.mediaItems = json.data;
                this.currentPage = json.current_page;
                this.totalPages = json.last_page;
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
                // Call the callback function dynamically
                window[this.targetCallback](this.selectedItem);
            }
            this.isOpen = false;
        }
    }));
});
</script>
