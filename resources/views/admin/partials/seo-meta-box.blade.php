@php
    $seoTitle = old('seo_title', isset($model) ? $model->seo_title : '');
    $seoDesc = old('seo_description', isset($model) ? $model->seo_description : '');
@endphp
<div class="seo-meta-box" style="margin-top: 2rem; border: 1px solid var(--border-color); border-radius: 8px; padding: 1.5rem; background: #fff;">
    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
        <i data-feather="search"></i> Pengaturan SEO (Snippet Preview)
    </h3>
    
    <!-- Google Snippet Preview -->
    <div class="google-snippet-preview" style="margin-bottom: 1.5rem; padding: 1.25rem; background: #ffffff; border: 1px solid #dfe1e5; border-radius: 8px; font-family: arial, sans-serif; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div style="font-size: 14px; color: #202124; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
            <div style="width: 28px; height: 28px; background: #f1f3f4; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <svg focusable="false" viewBox="0 0 24 24" style="width: 16px; height: 16px; color: #70757a;"><path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.51c-.8-1.84-2.73-3.07-4.9-3.32V13c0-.55-.45-1-1-1H7v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"></path></svg>
            </div>
            <div>
                <span style="display: block; font-size: 14px; color: #202124; line-height: 1.3;">{{ config('app.name', 'Website Anda') }}</span>
                <span style="display: block; font-size: 12px; color: #4d5156; line-height: 1.3;">{{ config('app.url') }} <span style="color: #5f6368;">&rsaquo; post</span></span>
            </div>
        </div>
        <div id="snippet-title" style="color: #1a0dab; font-size: 20px; cursor: pointer; text-decoration: none; margin-bottom: 4px; line-height: 1.3; font-weight: 400; padding-top: 4px;">{{ $seoTitle ?: 'Judul Artikel Anda Akan Tampil Di Sini' }}</div>
        <div id="snippet-desc" style="color: #4d5156; font-size: 14px; line-height: 1.58;">{{ $seoDesc ?: 'Berikan deskripsi singkat dan menarik di sini agar orang-orang yang menemukan website Anda di Google ingin mengklik dan membaca selengkapnya.' }}</div>
    </div>

    <div class="row" style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
        <!-- SEO Title Input -->
        <div class="form-group" style="margin-bottom: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <label class="form-label" for="seo_title" style="margin-bottom: 0;">SEO Title</label>
                <span id="seo-title-counter" style="font-size: 0.75rem; font-weight: 600;">0 / 60</span>
            </div>
            <input type="text" id="seo_title" name="seo_title" class="form-control" value="{{ $seoTitle }}" placeholder="Opsional. Jika kosong akan menggunakan judul utama.">
            <div style="height: 4px; border-radius: 2px; background-color: #e2e8f0; margin-top: 6px;">
                <div id="seo-title-progress" style="height: 100%; width: 0%; border-radius: 2px; transition: width 0.3s, background-color 0.3s;"></div>
            </div>
            @error('seo_title') <span class="text-danger mt-1 d-block" style="font-size: 0.875rem;">{{ $message }}</span> @enderror
        </div>

        <!-- SEO Description Input -->
        <div class="form-group" style="margin-bottom: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <label class="form-label" for="seo_description" style="margin-bottom: 0;">SEO Description</label>
                <span id="seo-desc-counter" style="font-size: 0.75rem; font-weight: 600;">0 / 160</span>
            </div>
            <textarea id="seo_description" name="seo_description" class="form-control" rows="3" placeholder="Opsional. Deskripsi ringkas halaman untuk mesin pencari Google.">{{ $seoDesc }}</textarea>
            <div style="height: 4px; border-radius: 2px; background-color: #e2e8f0; margin-top: 6px;">
                <div id="seo-desc-progress" style="height: 100%; width: 0%; border-radius: 2px; transition: width 0.3s, background-color 0.3s;"></div>
            </div>
            @error('seo_description') <span class="text-danger mt-1 d-block" style="font-size: 0.875rem;">{{ $message }}</span> @enderror
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('seo_title');
        const descInput = document.getElementById('seo_description');
        const mainTitleInput = document.getElementById('title'); // falls back to main title
        
        const titleCounter = document.getElementById('seo-title-counter');
        const descCounter = document.getElementById('seo-desc-counter');
        
        const titleProgress = document.getElementById('seo-title-progress');
        const descProgress = document.getElementById('seo-desc-progress');
        
        const snippetTitle = document.getElementById('snippet-title');
        const snippetDesc = document.getElementById('snippet-desc');

        function updateTitleSEO() {
            if(!titleInput) return;
            
            let val = titleInput.value.trim();
            if(!val && mainTitleInput) val = mainTitleInput.value.trim();
            
            const len = val.length;
            titleCounter.textContent = `${len} / 60`;
            
            let percent = (len / 60) * 100;
            if(percent > 100) percent = 100;
            titleProgress.style.width = `${percent}%`;
            
            if (len === 0) {
                titleProgress.style.backgroundColor = '#e2e8f0';
                titleCounter.style.color = 'var(--text-secondary)';
                snippetTitle.textContent = 'Judul Artikel Anda Akan Tampil Di Sini';
            } else if (len < 30) {
                titleProgress.style.backgroundColor = '#f59e0b'; // warning (orange)
                titleCounter.style.color = '#f59e0b';
                snippetTitle.textContent = val;
            } else if (len <= 60) {
                titleProgress.style.backgroundColor = '#10b981'; // good (green)
                titleCounter.style.color = '#10b981';
                snippetTitle.textContent = val;
            } else {
                titleProgress.style.backgroundColor = '#ef4444'; // danger (red)
                titleCounter.style.color = '#ef4444';
                snippetTitle.textContent = val.substring(0, 60) + '...';
            }
        }

        function updateDescSEO() {
            if(!descInput) return;
            
            let val = descInput.value.trim();
            const len = val.length;
            descCounter.textContent = `${len} / 160`;
            
            let percent = (len / 160) * 100;
            if(percent > 100) percent = 100;
            descProgress.style.width = `${percent}%`;
            
            if (len === 0) {
                descProgress.style.backgroundColor = '#e2e8f0';
                descCounter.style.color = 'var(--text-secondary)';
                snippetDesc.textContent = 'Berikan deskripsi singkat dan menarik di sini agar orang-orang yang menemukan website Anda di Google ingin mengklik dan membaca selengkapnya.';
            } else if (len < 50) {
                descProgress.style.backgroundColor = '#f59e0b'; // warning
                descCounter.style.color = '#f59e0b';
                snippetDesc.textContent = val;
            } else if (len <= 160) {
                descProgress.style.backgroundColor = '#10b981'; // good
                descCounter.style.color = '#10b981';
                snippetDesc.textContent = val;
            } else {
                descProgress.style.backgroundColor = '#ef4444'; // danger
                descCounter.style.color = '#ef4444';
                snippetDesc.textContent = val.substring(0, 160) + '...';
            }
        }

        if(titleInput) titleInput.addEventListener('input', updateTitleSEO);
        if(descInput) descInput.addEventListener('input', updateDescSEO);
        if(mainTitleInput) mainTitleInput.addEventListener('input', updateTitleSEO);

        // Initial call
        if(titleInput) updateTitleSEO();
        if(descInput) updateDescSEO();
    });
</script>
