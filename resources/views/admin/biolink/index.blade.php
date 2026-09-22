@extends('admin.layouts.app')

@section('title', 'Biolink Studio - Al Irsyad')

@push('styles')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Biolink Studio Theme Variables & Reset */
        :root {
            --studio-primary: #006837;
            --studio-primary-dark: #022c19;
            --studio-accent: #FBB03B;
            --studio-bg: #f8fafc;
            --studio-card: #ffffff;
            --studio-border: #e2e8f0;
            --studio-text: #0f172a;
            --studio-muted: #64748b;
        }

        /* Studio Top Action Bar */
        .studio-topbar {
            background: linear-gradient(135deg, #022c19 0%, #004d28 100%);
            border-radius: 16px;
            padding: 1.5rem 1.75rem;
            color: #ffffff;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px -5px rgba(2, 44, 25, 0.25);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.25rem;
        }

        .studio-title-area h2 {
            font-size: 1.45rem;
            font-weight: 800;
            margin: 0 0 0.35rem 0;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.02em;
        }

        .studio-badge {
            background: rgba(251, 176, 59, 0.2);
            color: #FBB03B;
            border: 1px solid rgba(251, 176, 59, 0.4);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .studio-url-box {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 6px 6px 6px 14px;
            gap: 10px;
        }

        .studio-url-text {
            font-family: monospace;
            font-size: 0.85rem;
            color: #e2e8f0;
            font-weight: 600;
        }

        .btn-copy-link {
            background: #FBB03B;
            color: #022c19;
            border: none;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }
        .btn-copy-link:hover {
            background: #f59e0b;
            transform: translateY(-1px);
        }

        .btn-qr {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 7px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }
        .btn-qr:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* 2-Column Split Workspace */
        .studio-workspace {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 2rem;
            align-items: start;
            padding-right: 0.5rem;
        }

        @media (max-width: 1200px) {
            .studio-workspace {
                grid-template-columns: 1fr 320px;
                gap: 1.5rem;
                padding-right: 0.25rem;
            }
        }

        @media (max-width: 992px) {
            .studio-workspace {
                grid-template-columns: 1fr;
                padding-right: 0;
            }
            .studio-preview-col {
                display: none;
            }
            .studio-preview-col.mobile-visible {
                display: block;
            }
        }

        /* Navigation Tabs */
        .studio-tabs {
            display: flex;
            background: #ffffff;
            padding: 6px;
            border-radius: 12px;
            border: 1px solid var(--studio-border);
            margin-bottom: 1.5rem;
            gap: 6px;
            overflow-x: auto;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .studio-tab-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 8px;
            border: none;
            background: transparent;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--studio-muted);
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .studio-tab-btn:hover {
            color: var(--studio-primary);
            background: #f1f5f9;
        }

        .studio-tab-btn.active {
            background: #022c19;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(2, 44, 25, 0.2);
        }

        .studio-tab-badge {
            background: rgba(255, 255, 255, 0.2);
            color: currentColor;
            font-size: 0.72rem;
            padding: 2px 7px;
            border-radius: 10px;
            font-weight: 700;
        }
        .studio-tab-btn:not(.active) .studio-tab-badge {
            background: #e2e8f0;
            color: var(--studio-muted);
        }

        /* Studio Card Container */
        .studio-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid var(--studio-border);
            padding: 1.75rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .studio-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            padding-bottom: 0.85rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .studio-card-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--studio-text);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Link & Section Cards */
        .section-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .section-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--studio-text);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .link-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1.15rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            transition: all 0.2s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .link-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transform: translateY(-1px);
        }

        .link-card.highlighted {
            border-left: 4px solid var(--studio-accent);
            background: #fffdfa;
        }

        .link-card.inactive {
            opacity: 0.55;
            background: #f1f5f9;
        }

        .link-info {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-grow: 1;
            min-width: 0;
        }

        .link-icon-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #ecfdf5;
            color: #006837;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
            border: 1px solid #d1fae5;
        }

        .link-text {
            min-width: 0;
        }

        .link-title {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--studio-text);
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .link-url {
            font-size: 0.75rem;
            color: var(--studio-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
        }

        .link-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .click-badge {
            background: #f1f5f9;
            color: #475569;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* Custom Switch */
        .studio-switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 22px;
            flex-shrink: 0;
        }
        .studio-switch input { opacity: 0; width: 0; height: 0; }
        .studio-slider {
            position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0;
            background-color: #cbd5e1;
            transition: .25s;
            border-radius: 22px;
        }
        .studio-slider:before {
            position: absolute; content: ""; height: 16px; width: 16px; left: 3px; bottom: 3px;
            background-color: white;
            transition: .25s;
            border-radius: 50%;
            box-shadow: 0 1px 3px rgba(0,0,0,0.15);
        }
        input:checked + .studio-slider { background-color: #10b981; }
        input:checked + .studio-slider:before { transform: translateX(18px); }

        /* Theme Cards */
        .theme-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .theme-card {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px;
            cursor: pointer;
            transition: all 0.2s;
            background: #ffffff;
            text-align: left;
        }
        .theme-card:hover {
            border-color: #006837;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.06);
        }
        .theme-card.active {
            border-color: #006837;
            background: #f0fdf4;
            box-shadow: 0 0 0 3px rgba(0, 104, 55, 0.15);
        }

        .theme-preview-box {
            height: 65px;
            border-radius: 8px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .theme-button-sample {
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }

        /* Form Controls */
        .studio-form-group {
            margin-bottom: 1.25rem;
        }
        .studio-form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--studio-text);
            margin-bottom: 0.4rem;
        }
        .studio-form-control {
            width: 100%;
            padding: 0.7rem 0.9rem;
            border: 1px solid var(--studio-border);
            border-radius: 10px;
            font-size: 0.875rem;
            box-sizing: border-box;
            background: #ffffff;
            transition: all 0.2s;
        }
        .studio-form-control:focus {
            outline: none;
            border-color: #006837;
            box-shadow: 0 0 0 3px rgba(0, 104, 55, 0.1);
        }
        .studio-form-hint {
            font-size: 0.75rem;
            color: var(--studio-muted);
            margin-top: 0.3rem;
            display: block;
        }

        /* Smartphone Mockup Frame (Right Column) */
        .phone-wrapper {
            position: sticky;
            top: 85px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-right: 0.75rem;
        }

        .phone-frame {
            width: 305px;
            height: 610px;
            max-height: calc(100vh - 145px);
            min-height: 500px;
            background: #0f172a;
            border-radius: 44px;
            padding: 10px;
            box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.35), 0 0 0 3px #334155;
            position: relative;
            box-sizing: border-box;
            transition: all 0.2s ease;
        }

        .phone-screen {
            width: 100%;
            height: 100%;
            background: #022c19;
            border-radius: 34px;
            overflow: hidden;
            position: relative;
        }

        .phone-notch {
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 20px;
            background: #0f172a;
            border-radius: 12px;
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            pointer-events: none;
        }
        .notch-camera {
            width: 8px;
            height: 8px;
            background: #1e293b;
            border-radius: 50%;
        }
        .notch-speaker {
            width: 34px;
            height: 3.5px;
            background: #1e293b;
            border-radius: 4px;
        }

        .phone-iframe {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }

        .phone-controls {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 1rem;
        }

        .btn-phone-action {
            background: #ffffff;
            color: #475569;
            border: 1px solid var(--studio-border);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-phone-action:hover {
            color: var(--studio-primary);
            border-color: var(--studio-primary);
        }

        /* Modals */
        .studio-modal-backdrop {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(5px);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            overflow-y: auto;
        }

        .studio-modal-box {
            background: #ffffff;
            border-radius: 20px;
            width: 100%;
            max-width: 540px;
            max-height: calc(100vh - 2.5rem);
            display: flex;
            flex-direction: column;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            overflow: hidden;
            margin: auto;
            position: relative;
            animation: modalFadeIn 0.2s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.96) translateY(8px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .studio-modal-header {
            padding: 1.15rem 1.5rem;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .studio-modal-title {
            font-weight: 800;
            font-size: 1.1rem;
            color: var(--studio-text);
            margin: 0;
        }

        .studio-modal-body {
            padding: 1.5rem;
            overflow-y: auto;
            flex: 1;
        }

        /* Toast Feedback */
        .studio-toast {
            position: fixed;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            background: #065f46;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            box-shadow: 0 10px 25px rgba(6, 95, 70, 0.3);
            z-index: 10000;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: toastPop 0.3s ease-out;
        }
        @keyframes toastPop {
            from { opacity: 0; transform: translate(-50%, 20px); }
            to { opacity: 1; transform: translate(-50%, 0); }
        }
    </style>
@endpush

@section('content')
<div x-data="{
    activeTab: '{{ request('tab', 'links') }}',
    showLinkModal: false,
    linkModalMode: 'create',
    linkForm: { id: '', section_id: '{{ $sections->first()->id ?? '' }}', title: '', subtitle: '', url: '', icon: 'fa-solid fa-link', badge_text: '', badge_color: 'bg-emerald-500 text-white', is_highlight: false, open_new_tab: true, sort_order: 0, is_active: true },
    showSectionModal: false,
    sectionModalMode: 'create',
    sectionForm: { id: '', title: '', subtitle: '', badge_text: '', icon: 'fa-solid fa-layer-group', sort_order: 0, is_active: true },
    showQrModal: false,
    toastMsg: '',
    showToast(msg) {
        this.toastMsg = msg;
        setTimeout(() => { this.toastMsg = ''; }, 3000);
    },
    copyBiolinkUrl() {
        const url = '{{ route('biolink.show') }}';
        navigator.clipboard.writeText(url).then(() => {
            this.showToast('Tautan Biolink berhasil disalin ke clipboard!');
        });
    },
    refreshPreview() {
        const iframe = document.getElementById('biolinkIframe');
        if (iframe) {
            iframe.contentWindow.location.reload();
            this.showToast('Pratinjau diperbarui!');
        }
    },
    scrollPreview(amount) {
        const iframe = document.getElementById('biolinkIframe');
        if (iframe && iframe.contentWindow) {
            iframe.contentWindow.scrollBy({ top: amount, behavior: 'smooth' });
        }
    },
    setThemePreset(theme) {
        if (theme === 'emerald') {
            document.getElementById('theme_bg_color').value = '#022c19';
            document.getElementById('theme_primary_color').value = '#006837';
            document.getElementById('theme_accent_color').value = '#FBB03B';
        } else if (theme === 'royal') {
            document.getElementById('theme_bg_color').value = '#0f172a';
            document.getElementById('theme_primary_color').value = '#006837';
            document.getElementById('theme_accent_color').value = '#fbbf24';
        } else if (theme === 'cyber') {
            document.getElementById('theme_bg_color').value = '#090d16';
            document.getElementById('theme_primary_color').value = '#059669';
            document.getElementById('theme_accent_color').value = '#10b981';
        } else if (theme === 'minimal') {
            document.getElementById('theme_bg_color').value = '#f8fafc';
            document.getElementById('theme_primary_color').value = '#006837';
            document.getElementById('theme_accent_color').value = '#d97706';
        }
        this.showToast('Preset tema dipilih! Klik Simpan Tema.');
    },
    openCreateLink(sectionId) {
        this.linkModalMode = 'create';
        this.linkForm = {
            id: '',
            section_id: sectionId || '{{ $sections->first()->id ?? '' }}',
            title: '',
            subtitle: '',
            url: '',
            icon: 'fa-solid fa-link',
            badge_text: '',
            badge_color: 'bg-emerald-500 text-white',
            is_highlight: false,
            open_new_tab: true,
            sort_order: 0,
            is_active: true
        };
        this.showLinkModal = true;
    },
    openEditLink(link) {
        this.linkModalMode = 'edit';
        this.linkForm = {
            id: link.id,
            section_id: link.section_id,
            title: link.title,
            subtitle: link.subtitle || '',
            url: link.url,
            icon: link.icon || 'fa-solid fa-link',
            badge_text: link.badge_text || '',
            badge_color: link.badge_color || 'bg-emerald-500 text-white',
            is_highlight: Boolean(link.is_highlight),
            open_new_tab: Boolean(link.open_new_tab),
            sort_order: link.sort_order || 0,
            is_active: Boolean(link.is_active)
        };
        this.showLinkModal = true;
    },
    openCreateSection() {
        this.sectionModalMode = 'create';
        this.sectionForm = { id: '', title: '', subtitle: '', badge_text: '', icon: 'fa-solid fa-layer-group', sort_order: {{ $sections->count() }}, is_active: true };
        this.showSectionModal = true;
    },
    openEditSection(sec) {
        this.sectionModalMode = 'edit';
        this.sectionForm = {
            id: sec.id,
            title: sec.title,
            subtitle: sec.subtitle || '',
            badge_text: sec.badge_text || '',
            icon: sec.icon || 'fa-solid fa-layer-group',
            sort_order: sec.sort_order || 0,
            is_active: Boolean(sec.is_active)
        };
        this.showSectionModal = true;
    }
}">

    <!-- TOP ACTION BAR -->
    <div class="studio-topbar">
        <div class="studio-title-area">
            <h2>
                <i data-feather="share-2" style="width: 24px; height: 24px; color: #FBB03B;"></i>
                Biolink Studio
                <span class="studio-badge">Link in Bio</span>
            </h2>
            <div style="font-size: 0.85rem; opacity: 0.85;">
                Kelola profil publik, tautan penting, media sosial, dan branding resmi sekolah secara mandiri.
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <div class="studio-url-box">
                <i data-feather="link" style="width: 14px; height: 14px; color: #FBB03B;"></i>
                <span class="studio-url-text">{{ url('/links') }}</span>
                <button type="button" class="btn-copy-link" @click="copyBiolinkUrl()" title="Salin ke Clipboard">
                    <i data-feather="copy" style="width: 13px; height: 13px;"></i> Salin Link
                </button>
            </div>

            <button type="button" class="btn-qr" @click="showQrModal = true" title="Tampilkan QR Code">
                <i data-feather="grid" style="width: 14px; height: 14px;"></i> QR Code
            </button>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; color: #065f46; padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 10px; border-left: 4px solid #10b981; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
            <i data-feather="check-circle" style="width: 20px; height: 20px; color: #10b981;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- 2-COLUMN SPLIT WORKSPACE -->
    <div class="studio-workspace">

        <!-- LEFT COLUMN: STUDIO CONTROLS (60%) -->
        <div class="studio-controls-col">

            <!-- STUDIO NAVIGATION TABS (LINK-FIRST!) -->
            <div class="studio-tabs">
                <button type="button" class="studio-tab-btn" :class="{ 'active': activeTab === 'links' }" @click="activeTab = 'links'">
                    <i data-feather="link-2" style="width: 16px; height: 16px;"></i>
                    <span>Tautan & Seksi</span>
                    <span class="studio-tab-badge">{{ $totalLinks }}</span>
                </button>
                <button type="button" class="studio-tab-btn" :class="{ 'active': activeTab === 'theme' }" @click="activeTab = 'theme'">
                    <i data-feather="droplet" style="width: 16px; height: 16px;"></i>
                    <span>Desain & Tema</span>
                </button>
                <button type="button" class="studio-tab-btn" :class="{ 'active': activeTab === 'profile' }" @click="activeTab = 'profile'">
                    <i data-feather="user" style="width: 16px; height: 16px;"></i>
                    <span>Profil & Sosmed</span>
                </button>
                <button type="button" class="studio-tab-btn" :class="{ 'active': activeTab === 'seo' }" @click="activeTab = 'seo'">
                    <i data-feather="bar-chart-2" style="width: 16px; height: 16px;"></i>
                    <span>Analitik & SEO</span>
                    <span class="studio-tab-badge">{{ number_format($totalClicks) }} klik</span>
                </button>
            </div>

            <!-- ============================================== -->
            <!-- TAB 1: TAUTAN & SEKSI (LINKS & SECTIONS) -->
            <!-- ============================================== -->
            <div x-show="activeTab === 'links'" x-transition>
                <div class="studio-card">
                    <div class="studio-card-header">
                        <div>
                            <h3 class="studio-card-title">
                                <i data-feather="list" style="width: 18px; height: 18px; color: var(--studio-primary);"></i>
                                Daftar Tautan & Kategori
                            </h3>
                            <span style="font-size: 0.8rem; color: var(--studio-muted);">Kelola tombol tautan yang tampil di halaman Biolink sekolah.</span>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <button type="button" class="btn btn-outline" style="font-size: 0.8rem; padding: 7px 12px; border-radius: 8px;" @click="openCreateSection()">
                                <i data-feather="folder-plus" style="width: 14px; height: 14px;"></i> Buat Seksi
                            </button>
                            <button type="button" class="btn btn-primary" style="font-size: 0.8rem; padding: 7px 14px; border-radius: 8px; background: #006837;" @click="openCreateLink()">
                                <i data-feather="plus" style="width: 14px; height: 14px;"></i> Tambah Tautan
                            </button>
                        </div>
                    </div>

                    @forelse($sections as $section)
                        <div class="section-box">
                            <div class="section-header">
                                <div class="section-title">
                                    <i class="{{ $section->icon ?: 'fa-solid fa-layer-group' }}" style="color: var(--studio-primary);"></i>
                                    <span>{{ $section->title }}</span>
                                    <span style="font-size: 0.72rem; font-weight: 700; background: #e2e8f0; color: #475569; padding: 2px 8px; border-radius: 12px;">
                                        {{ $section->links->count() }} Tautan
                                    </span>
                                    @if(!$section->is_active)
                                        <span style="font-size: 0.7rem; background: #fee2e2; color: #991b1b; padding: 2px 6px; border-radius: 4px;">Nonaktif</span>
                                    @endif
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <button type="button" style="background: none; border: none; cursor: pointer; color: var(--studio-primary); font-size: 0.8rem; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;" @click="openCreateLink({{ $section->id }})">
                                        <i data-feather="plus-circle" style="width: 14px; height: 14px;"></i> Tambah Link
                                    </button>
                                    <span style="color: #cbd5e1;">|</span>
                                    <button type="button" style="background: none; border: none; cursor: pointer; color: #64748b;" @click="openEditSection({{ json_encode($section) }})" title="Edit Seksi">
                                        <i data-feather="edit-2" style="width: 15px; height: 15px;"></i>
                                    </button>
                                    <form action="{{ route('admin.biolink.sections.destroy', $section->id) }}" method="POST" onsubmit="return confirm('Hapus seksi ini beserta semua tautan di dalamnya?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; cursor: pointer; color: #ef4444;" title="Hapus Seksi">
                                            <i data-feather="trash-2" style="width: 15px; height: 15px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Link Cards Inside Section -->
                            <div class="link-list">
                                @forelse($section->links as $link)
                                    <div class="link-card {{ $link->is_highlight ? 'highlighted' : '' }} {{ !$link->is_active ? 'inactive' : '' }}">
                                        <div class="link-info">
                                            <div class="link-icon-avatar">
                                                <i class="{{ $link->icon ?: 'fa-solid fa-link' }}"></i>
                                            </div>
                                            <div class="link-text">
                                                <div class="link-title">
                                                    {{ $link->title }}
                                                    @if($link->badge_text)
                                                        <span style="font-size: 0.68rem; padding: 2px 6px; border-radius: 6px; font-weight: 700; margin-left: 4px; background: #e0e7ff; color: #3730a3;">
                                                            {{ $link->badge_text }}
                                                        </span>
                                                    @endif
                                                    @if($link->is_highlight)
                                                        <span style="font-size: 0.68rem; padding: 2px 6px; border-radius: 6px; font-weight: 700; margin-left: 4px; background: #fef3c7; color: #92400e;">
                                                            Highlight ⭐
                                                        </span>
                                                    @endif
                                                </div>
                                                <span class="link-url">{{ $link->url }}</span>
                                            </div>
                                        </div>

                                        <div class="link-meta">
                                            <span class="click-badge" title="Total Klik">
                                                <i data-feather="mouse-pointer" style="width: 11px; height: 11px;"></i>
                                                {{ $link->clicks_count }}
                                            </span>

                                            <button type="button" class="btn-phone-action" style="padding: 5px 10px;" @click="openEditLink({{ json_encode($link) }})" title="Edit Tautan">
                                                <i data-feather="edit-2" style="width: 13px; height: 13px;"></i>
                                            </button>

                                            <form action="{{ route('admin.biolink.links.destroy', $link->id) }}" method="POST" onsubmit="return confirm('Hapus tautan ini?')" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-phone-action" style="padding: 5px 10px; color: #ef4444;" title="Hapus Tautan">
                                                    <i data-feather="trash-2" style="width: 13px; height: 13px;"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div style="text-align: center; padding: 1.5rem 1rem; color: var(--studio-muted); font-size: 0.85rem; border: 1px dashed #cbd5e1; border-radius: 10px; background: #ffffff;">
                                        Belum ada tautan di seksi ini.
                                        <a href="javascript:void(0)" style="color: var(--studio-primary); font-weight: 700; text-decoration: underline; margin-left: 4px;" @click="openCreateLink({{ $section->id }})">
                                            + Tambah Tautan Pertama
                                        </a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 3rem 1.5rem; color: var(--studio-muted);">
                            <i data-feather="link-2" style="width: 48px; height: 48px; opacity: 0.4; margin-bottom: 1rem;"></i>
                            <h4 style="font-weight: 700; margin-bottom: 0.5rem; color: var(--studio-text);">Belum Ada Seksi Tautan</h4>
                            <p style="font-size: 0.875rem; margin-bottom: 1.25rem;">Mulai dengan membuat seksi kategori (misal: "Pendaftaran & Informasi", "Unit Sekolah", dll).</p>
                            <button type="button" class="btn btn-primary" style="background: #006837;" @click="openCreateSection()">
                                <i data-feather="plus"></i> Buat Seksi Pertama
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ============================================== -->
            <!-- TAB 2: TAMPILAN & TEMA (APPEARANCE & THEME) -->
            <!-- ============================================== -->
            <div x-show="activeTab === 'theme'" x-transition style="display: none;">
                <form action="{{ route('admin.biolink.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_tab" value="theme">
                    <!-- Preserve required identity fields -->
                    <input type="hidden" name="title" value="{{ $profile->title }}">
                    <input type="hidden" name="subtitle" value="{{ $profile->subtitle }}">

                    <div class="studio-card">
                        <div class="studio-card-header">
                            <div>
                                <h3 class="studio-card-title">
                                    <i data-feather="layout" style="width: 18px; height: 18px; color: var(--studio-primary);"></i>
                                    Preset Tema Visual
                                </h3>
                                <span style="font-size: 0.8rem; color: var(--studio-muted);">Pilih salah satu tema siap pakai atau sesuaikan palet warna di bawah.</span>
                            </div>
                        </div>

                        <div class="theme-grid">
                            <!-- Preset 1: Islamic Emerald -->
                            <div class="theme-card {{ $profile->theme_bg_color === '#022c19' ? 'active' : '' }}" @click="setThemePreset('emerald')">
                                <div class="theme-preview-box" style="background: #022c19;">
                                    <span class="theme-button-sample" style="background: #ffffff; color: #006837; border: 1px solid #006837;">Link Sample</span>
                                </div>
                                <div style="font-weight: 700; font-size: 0.85rem; color: #0f172a;">Islamic Emerald</div>
                                <div style="font-size: 0.72rem; color: #64748b;">Tema Resmi Al Irsyad</div>
                            </div>

                            <!-- Preset 2: Royal Slate -->
                            <div class="theme-card {{ $profile->theme_bg_color === '#0f172a' ? 'active' : '' }}" @click="setThemePreset('royal')">
                                <div class="theme-preview-box" style="background: #0f172a;">
                                    <span class="theme-button-sample" style="background: #ffffff; color: #0f172a; border: 1px solid #fbbf24;">Link Sample</span>
                                </div>
                                <div style="font-weight: 700; font-size: 0.85rem; color: #0f172a;">Royal Gold</div>
                                <div style="font-size: 0.72rem; color: #64748b;">Elegance & Wibawa</div>
                            </div>

                            <!-- Preset 3: Midnight Cyber -->
                            <div class="theme-card {{ $profile->theme_bg_color === '#090d16' ? 'active' : '' }}" @click="setThemePreset('cyber')">
                                <div class="theme-preview-box" style="background: #090d16;">
                                    <span class="theme-button-sample" style="background: #1e293b; color: #10b981; border: 1px solid #10b981;">Link Sample</span>
                                </div>
                                <div style="font-weight: 700; font-size: 0.85rem; color: #0f172a;">Midnight Tech</div>
                                <div style="font-size: 0.72rem; color: #64748b;">Dark Mode Modern</div>
                            </div>

                            <!-- Preset 4: Clean Minimal -->
                            <div class="theme-card {{ $profile->theme_bg_color === '#f8fafc' ? 'active' : '' }}" @click="setThemePreset('minimal')">
                                <div class="theme-preview-box" style="background: #f1f5f9;">
                                    <span class="theme-button-sample" style="background: #ffffff; color: #006837; border: 1px solid #e2e8f0;">Link Sample</span>
                                </div>
                                <div style="font-weight: 700; font-size: 0.85rem; color: #0f172a;">Clean Soft</div>
                                <div style="font-size: 0.72rem; color: #64748b;">Terang & Minimalis</div>
                            </div>
                        </div>

                        <!-- Custom Colors -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.25rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9;">
                            <div class="studio-form-group">
                                <label class="studio-form-label">Warna Latar (Background)</label>
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    <input type="color" id="theme_bg_color" name="theme_bg_color" value="{{ old('theme_bg_color', $profile->theme_bg_color ?: '#022c19') }}" style="width: 44px; height: 38px; border: none; border-radius: 8px; cursor: pointer;">
                                    <input type="text" class="studio-form-control" value="{{ old('theme_bg_color', $profile->theme_bg_color ?: '#022c19') }}" oninput="document.getElementById('theme_bg_color').value = this.value">
                                </div>
                            </div>

                            <div class="studio-form-group">
                                <label class="studio-form-label">Warna Tombol Tautan</label>
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    <input type="color" id="theme_primary_color" name="theme_primary_color" value="{{ old('theme_primary_color', $profile->theme_primary_color ?: '#006837') }}" style="width: 44px; height: 38px; border: none; border-radius: 8px; cursor: pointer;">
                                    <input type="text" class="studio-form-control" value="{{ old('theme_primary_color', $profile->theme_primary_color ?: '#006837') }}" oninput="document.getElementById('theme_primary_color').value = this.value">
                                </div>
                            </div>

                            <div class="studio-form-group">
                                <label class="studio-form-label">Warna Aksen & Badge</label>
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    <input type="color" id="theme_accent_color" name="theme_accent_color" value="{{ old('theme_accent_color', $profile->theme_accent_color ?: '#FBB03B') }}" style="width: 44px; height: 38px; border: none; border-radius: 8px; cursor: pointer;">
                                    <input type="text" class="studio-form-control" value="{{ old('theme_accent_color', $profile->theme_accent_color ?: '#FBB03B') }}" oninput="document.getElementById('theme_accent_color').value = this.value">
                                </div>
                            </div>
                        </div>

                        <!-- Visual Effects -->
                        <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid #f1f5f9;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                                <div>
                                    <div style="font-weight: 700; font-size: 0.88rem; color: var(--studio-text);">Pola Geometris Islami (Pattern)</div>
                                    <div style="font-size: 0.75rem; color: var(--studio-muted);">Menampilkan watermark pola arabesque halus di latar belakang.</div>
                                </div>
                                <label class="studio-switch">
                                    <input type="checkbox" name="show_pattern" value="1" {{ $profile->show_pattern ? 'checked' : '' }}>
                                    <span class="studio-slider"></span>
                                </label>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <div style="font-weight: 700; font-size: 0.88rem; color: var(--studio-text);">Efek Cahaya Scanline Cyber</div>
                                    <div style="font-size: 0.75rem; color: var(--studio-muted);">Animasi garis pendar halus di atas header biolink.</div>
                                </div>
                                <label class="studio-switch">
                                    <input type="checkbox" name="show_scanline" value="1" {{ $profile->show_scanline ? 'checked' : '' }}>
                                    <span class="studio-slider"></span>
                                </label>
                            </div>
                        </div>

                        <div style="margin-top: 2rem;">
                            <button type="submit" class="btn btn-primary" style="background: #006837; padding: 10px 24px;">
                                <i data-feather="save"></i> Simpan Pengaturan Tema
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ============================================== -->
            <!-- TAB 3: PROFIL & SOSMED (PROFILE & SOCIALS) -->
            <!-- ============================================== -->
            <div x-show="activeTab === 'profile'" x-transition style="display: none;">
                <form action="{{ route('admin.biolink.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_tab" value="profile">

                    <div class="studio-card">
                        <div class="studio-card-header">
                            <h3 class="studio-card-title">
                                <i data-feather="user-check" style="width: 18px; height: 18px; color: var(--studio-primary);"></i>
                                Identitas & Branding Sekolah
                            </h3>
                        </div>

                        <!-- Avatar & Banner Upload -->
                        <div style="display: grid; grid-template-columns: 140px 1fr; gap: 1.5rem; align-items: start; margin-bottom: 1.5rem;">
                            <div>
                                <label class="studio-form-label">Foto Avatar</label>
                                <div style="width: 110px; height: 110px; border-radius: 50%; overflow: hidden; border: 3px solid #006837; margin-bottom: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                    <img src="{{ $profile->avatar_url }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <input type="file" name="avatar" accept="image/*" style="font-size: 0.75rem; width: 110px;">
                            </div>

                            <div>
                                <div class="studio-form-group">
                                    <label class="studio-form-label">Nama Lembaga / Judul Utama <span style="color: red;">*</span></label>
                                    <input type="text" name="title" class="studio-form-control" value="{{ old('title', $profile->title) }}" required placeholder="Al Irsyad Al Islamiyyah">
                                </div>

                                <div class="studio-form-group">
                                    <label class="studio-form-label">Subjudul Cabang / Kategori</label>
                                    <input type="text" name="subtitle" class="studio-form-control" value="{{ old('subtitle', $profile->subtitle) }}" placeholder="Karawang Branch">
                                </div>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="studio-form-group">
                                <label class="studio-form-label">Teks Pill Badge</label>
                                <input type="text" name="badge_text" class="studio-form-control" value="{{ old('badge_text', $profile->badge_text) }}" placeholder="Contoh: Islamic Tech Generation">
                            </div>
                            <div class="studio-form-group">
                                <label class="studio-form-label">Ikon Pill Badge (FontAwesome)</label>
                                <input type="text" name="badge_icon" class="studio-form-control" value="{{ old('badge_icon', $profile->badge_icon) }}" placeholder="fa-solid fa-microchip">
                            </div>
                        </div>

                        <div class="studio-form-group">
                            <label class="studio-form-label">Bio / Slogan Singkat</label>
                            <textarea name="bio" class="studio-form-control" rows="3" placeholder="Deskripsi ringkas 2-3 kalimat">{{ old('bio', $profile->bio) }}</textarea>
                        </div>

                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; background: #f8fafc; border-radius: 10px; margin-bottom: 1rem;">
                            <div>
                                <div style="font-weight: 700; font-size: 0.88rem; color: var(--studio-text);">Centang Biru Resmi (Verified Badge)</div>
                                <div style="font-size: 0.75rem; color: var(--studio-muted);">Menampilkan icon verified di samping foto profil.</div>
                            </div>
                            <label class="studio-switch">
                                <input type="checkbox" name="show_verified_badge" value="1" {{ $profile->show_verified_badge ? 'checked' : '' }}>
                                <span class="studio-slider"></span>
                            </label>
                        </div>

                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; background: #f8fafc; border-radius: 10px; margin-bottom: 1.5rem;">
                            <div>
                                <div style="font-weight: 700; font-size: 0.88rem; color: var(--studio-text);">Status Publikasi Biolink</div>
                                <div style="font-size: 0.75rem; color: var(--studio-muted);">Aktifkan agar halaman publik dapat diakses pengunjung.</div>
                            </div>
                            <label class="studio-switch">
                                <input type="checkbox" name="is_active" value="1" {{ $profile->is_active ? 'checked' : '' }}>
                                <span class="studio-slider"></span>
                            </label>
                        </div>

                        <!-- Video YouTube Embed -->
                        <div style="border-top: 1px solid #f1f5f9; padding-top: 1.25rem;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                                <div class="studio-form-label" style="margin: 0;">Embed Video YouTube Profil</div>
                                <label class="studio-switch">
                                    <input type="checkbox" name="show_youtube" value="1" {{ $profile->show_youtube ? 'checked' : '' }}>
                                    <span class="studio-slider"></span>
                                </label>
                            </div>
                            <input type="text" name="youtube_url" class="studio-form-control" value="{{ old('youtube_url', $profile->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=xxxxx">
                            <span class="studio-form-hint">Video profil akan disematkan rapi di halaman biolink.</span>
                        </div>

                        <div style="margin-top: 2rem;">
                            <button type="submit" class="btn btn-primary" style="background: #006837; padding: 10px 24px;">
                                <i data-feather="save"></i> Simpan Profil
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ============================================== -->
            <!-- TAB 4: ANALITIK & SEO (ANALYTICS & SEO) -->
            <!-- ============================================== -->
            <div x-show="activeTab === 'seo'" x-transition style="display: none;">
                <!-- Clicks Overview Card -->
                <div class="studio-card">
                    <div class="studio-card-header">
                        <h3 class="studio-card-title">
                            <i data-feather="trending-up" style="width: 18px; height: 18px; color: var(--studio-primary);"></i>
                            Top Tautan Paling Sering Diklik
                        </h3>
                    </div>

                    @if($topLinks->count() > 0)
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            @foreach($topLinks as $idx => $link)
                                <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <span style="width: 24px; height: 24px; border-radius: 50%; background: #006837; color: white; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700;">
                                            {{ $idx + 1 }}
                                        </span>
                                        <div>
                                            <div style="font-weight: 700; font-size: 0.88rem; color: #0f172a;">{{ $link->title }}</div>
                                            <span style="font-size: 0.75rem; color: #64748b;">{{ Str::limit($link->url, 45) }}</span>
                                        </div>
                                    </div>
                                    <span style="background: #ecfdf5; color: #065f46; font-weight: 800; font-size: 0.85rem; padding: 4px 12px; border-radius: 20px;">
                                        {{ $link->clicks_count }} klik
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 2rem 1rem; color: var(--studio-muted); font-size: 0.85rem;">
                            Belum ada statistik klik yang tercatat.
                        </div>
                    @endif
                </div>

                <!-- SEO Settings Form -->
                <form action="{{ route('admin.biolink.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_tab" value="seo">
                    <input type="hidden" name="title" value="{{ $profile->title }}">
                    <input type="hidden" name="subtitle" value="{{ $profile->subtitle }}">

                    <div class="studio-card">
                        <div class="studio-card-header">
                            <h3 class="studio-card-title">
                                <i data-feather="search" style="width: 18px; height: 18px; color: var(--studio-primary);"></i>
                                Pengaturan SEO & Pratinjau Share WhatsApp
                            </h3>
                        </div>

                        <div class="studio-form-group">
                            <label class="studio-form-label">Meta Title (Judul Tab Browser & Share)</label>
                            <input type="text" name="meta_title" class="studio-form-control" value="{{ old('meta_title', $profile->meta_title) }}" placeholder="Al Irsyad Al Islamiyyah | PPDB & Informasi Resmi">
                        </div>

                        <div class="studio-form-group">
                            <label class="studio-form-label">Meta Description</label>
                            <textarea name="meta_description" class="studio-form-control" rows="3" placeholder="Deskripsi ringkas yang tampil saat link dibagikan ke WhatsApp / Telegram">{{ old('meta_description', $profile->meta_description) }}</textarea>
                        </div>

                        <div class="studio-form-group">
                            <label class="studio-form-label">Gambar Thumbnail Share (OG Image)</label>
                            @if($profile->og_image)
                                <div style="margin-bottom: 8px; max-width: 200px; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
                                    <img src="{{ $profile->og_image }}" alt="OG Preview" style="width: 100%; height: auto; display: block;">
                                </div>
                            @endif
                            <input type="file" name="og_image_file" accept="image/*" class="studio-form-control">
                            <span class="studio-form-hint">Rekomendasi rasio 1.91:1 (contoh: 1200x630 pixel).</span>
                        </div>

                        <div style="margin-top: 2rem;">
                            <button type="submit" class="btn btn-primary" style="background: #006837; padding: 10px 24px;">
                                <i data-feather="save"></i> Simpan Pengaturan SEO
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        <!-- RIGHT COLUMN: STICKY SMARTPHONE MOCKUP (40%) -->
        <div class="studio-preview-col">
            <div class="phone-wrapper">
                <div class="phone-frame">
                    <div class="phone-screen">
                        <div class="phone-notch">
                            <div class="notch-speaker"></div>
                            <div class="notch-camera"></div>
                        </div>

                        <!-- Live Iframe -->
                        <iframe id="biolinkIframe" src="{{ route('biolink.show') }}" class="phone-iframe"></iframe>
                    </div>
                </div>

                <div class="phone-controls">
                    <button type="button" class="btn-phone-action" @click="scrollPreview(-220)" title="Gulir ke Atas">
                        <i data-feather="chevron-up" style="width: 13px; height: 13px;"></i>
                    </button>
                    <button type="button" class="btn-phone-action" @click="scrollPreview(220)" title="Gulir ke Bawah">
                        <i data-feather="chevron-down" style="width: 13px; height: 13px;"></i>
                    </button>
                    <button type="button" class="btn-phone-action" @click="refreshPreview()" title="Muat Ulang Tampilan HP">
                        <i data-feather="refresh-cw" style="width: 12px; height: 12px;"></i> Refresh
                    </button>
                    <a href="{{ route('biolink.show') }}" target="_blank" class="btn-phone-action" title="Buka di Tab Baru">
                        <i data-feather="external-link" style="width: 12px; height: 12px;"></i> Buka Penuh
                    </a>
                </div>

                <div style="margin-top: 8px; font-size: 0.75rem; color: #64748b; display: flex; align-items: center; gap: 5px;">
                    <span style="width: 7px; height: 7px; background: #10b981; border-radius: 50%; display: inline-block;"></span>
                    Pratinjau Layar HP Interaktif
                </div>
            </div>
        </div>

    </div>

    <!-- ============================================== -->
    <!-- MODAL: ADD / EDIT LINK -->
    <!-- ============================================== -->
    <template x-teleport="body">
        <div x-show="showLinkModal" class="studio-modal-backdrop" x-cloak style="display: none;">
            <div class="studio-modal-box" @click.away="showLinkModal = false">
                <div class="studio-modal-header">
                    <h4 class="studio-modal-title" x-text="linkModalMode === 'create' ? 'Tambah Tautan Baru' : 'Edit Tautan'"></h4>
                    <button type="button" style="background: none; border: none; font-size: 1.4rem; cursor: pointer; color: #64748b; line-height: 1;" @click="showLinkModal = false">&times;</button>
                </div>

                <form :action="linkModalMode === 'create' ? '{{ route('admin.biolink.links.store') }}' : '{{ url('admin/biolink/links') }}/' + linkForm.id" method="POST" class="studio-modal-body">
                    @csrf
                    <template x-if="linkModalMode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="studio-form-group">
                        <label class="studio-form-label">Pilih Seksi Kategori <span style="color: red;">*</span></label>
                        <select name="section_id" class="studio-form-control" x-model="linkForm.section_id" required>
                            @foreach($sections as $sec)
                                <option value="{{ $sec->id }}">{{ $sec->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="studio-form-group">
                        <label class="studio-form-label">Judul Tautan / Tombol <span style="color: red;">*</span></label>
                        <input type="text" name="title" class="studio-form-control" x-model="linkForm.title" required placeholder="Contoh: PPDB Online SDIT Al Irsyad">
                    </div>

                    <div class="studio-form-group">
                        <label class="studio-form-label">Target URL / Link Lengkap <span style="color: red;">*</span></label>
                        <input type="text" name="url" class="studio-form-control" x-model="linkForm.url" required placeholder="https://... atau /form/ppdb">
                    </div>

                    <div class="studio-form-group">
                        <label class="studio-form-label">Subjudul / Keterangan Kecil</label>
                        <input type="text" name="subtitle" class="studio-form-control" x-model="linkForm.subtitle" placeholder="Contoh: Pendaftaran Gelombang 1 Dibuka">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="studio-form-group">
                            <label class="studio-form-label">Ikon FontAwesome</label>
                            <input type="text" name="icon" class="studio-form-control" x-model="linkForm.icon" placeholder="fa-brands fa-whatsapp">
                        </div>
                        <div class="studio-form-group">
                            <label class="studio-form-label">Badge Teks (Opsional)</label>
                            <input type="text" name="badge_text" class="studio-form-control" x-model="linkForm.badge_text" placeholder="HOT / BARU">
                        </div>
                    </div>

                    <!-- Quick Icon Helpers -->
                    <div style="margin-bottom: 1.25rem;">
                        <span style="font-size: 0.72rem; font-weight: 700; color: #64748b; margin-bottom: 4px; display: block;">Pilih Ikon Cepat:</span>
                        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                            <button type="button" class="btn-phone-action" style="padding: 3px 8px; font-size: 0.72rem;" @click="linkForm.icon = 'fa-brands fa-whatsapp'"><i class="fa-brands fa-whatsapp" style="color: #25D366;"></i> WhatsApp</button>
                            <button type="button" class="btn-phone-action" style="padding: 3px 8px; font-size: 0.72rem;" @click="linkForm.icon = 'fa-solid fa-file-signature'"><i class="fa-solid fa-file-signature"></i> Formulir</button>
                            <button type="button" class="btn-phone-action" style="padding: 3px 8px; font-size: 0.72rem;" @click="linkForm.icon = 'fa-solid fa-map-location-dot'"><i class="fa-solid fa-map-location-dot"></i> Maps</button>
                            <button type="button" class="btn-phone-action" style="padding: 3px 8px; font-size: 0.72rem;" @click="linkForm.icon = 'fa-brands fa-instagram'"><i class="fa-brands fa-instagram" style="color: #E1306C;"></i> Instagram</button>
                            <button type="button" class="btn-phone-action" style="padding: 3px 8px; font-size: 0.72rem;" @click="linkForm.icon = 'fa-brands fa-youtube'"><i class="fa-brands fa-youtube" style="color: #FF0000;"></i> YouTube</button>
                            <button type="button" class="btn-phone-action" style="padding: 3px 8px; font-size: 0.72rem;" @click="linkForm.icon = 'fa-solid fa-globe'"><i class="fa-solid fa-globe"></i> Website</button>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                            <input type="checkbox" name="is_highlight" value="1" x-model="linkForm.is_highlight">
                            <span>Sorot Tautan (Highlight ⭐)</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                            <input type="checkbox" name="is_active" value="1" x-model="linkForm.is_active">
                            <span>Tautan Aktif</span>
                        </label>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 10px; padding-top: 0.5rem; border-top: 1px solid #f1f5f9;">
                        <button type="button" class="btn" style="background: #f1f5f9; color: #475569;" @click="showLinkModal = false">Batal</button>
                        <button type="submit" class="btn btn-primary" style="background: #006837;">Simpan Tautan</button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <!-- ============================================== -->
    <!-- MODAL: ADD / EDIT SECTION -->
    <!-- ============================================== -->
    <template x-teleport="body">
        <div x-show="showSectionModal" class="studio-modal-backdrop" x-cloak style="display: none;">
            <div class="studio-modal-box" @click.away="showSectionModal = false">
                <div class="studio-modal-header">
                    <h4 class="studio-modal-title" x-text="sectionModalMode === 'create' ? 'Buat Seksi Kategori Baru' : 'Edit Seksi Kategori'"></h4>
                    <button type="button" style="background: none; border: none; font-size: 1.4rem; cursor: pointer; color: #64748b; line-height: 1;" @click="showSectionModal = false">&times;</button>
                </div>

                <form :action="sectionModalMode === 'create' ? '{{ route('admin.biolink.sections.store') }}' : '{{ url('admin/biolink/sections') }}/' + sectionForm.id" method="POST" class="studio-modal-body">
                    @csrf
                    <template x-if="sectionModalMode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="studio-form-group">
                        <label class="studio-form-label">Judul Seksi <span style="color: red;">*</span></label>
                        <input type="text" name="title" class="studio-form-control" x-model="sectionForm.title" required placeholder="Contoh: PPDB & Pendaftaran Online">
                    </div>

                    <div class="studio-form-group">
                        <label class="studio-form-label">Subjudul Seksi</label>
                        <input type="text" name="subtitle" class="studio-form-control" x-model="sectionForm.subtitle" placeholder="Contoh: Layanan terpadu calon santri">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="studio-form-group">
                            <label class="studio-form-label">Ikon (FontAwesome)</label>
                            <input type="text" name="icon" class="studio-form-control" x-model="sectionForm.icon" placeholder="fa-solid fa-graduation-cap">
                        </div>
                        <div class="studio-form-group">
                            <label class="studio-form-label">Urutan Tampil (Sort Order)</label>
                            <input type="number" name="sort_order" class="studio-form-control" x-model="sectionForm.sort_order" min="0">
                        </div>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                            <input type="checkbox" name="is_active" value="1" x-model="sectionForm.is_active">
                            <span>Seksi Aktif Ditampilkan</span>
                        </label>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 10px; padding-top: 0.5rem; border-top: 1px solid #f1f5f9;">
                        <button type="button" class="btn" style="background: #f1f5f9; color: #475569;" @click="showSectionModal = false">Batal</button>
                        <button type="submit" class="btn btn-primary" style="background: #006837;">Simpan Seksi</button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <!-- ============================================== -->
    <!-- MODAL: QR CODE -->
    <!-- ============================================== -->
    <template x-teleport="body">
        <div x-show="showQrModal" class="studio-modal-backdrop" x-cloak style="display: none;">
            <div class="studio-modal-box" style="max-width: 400px; text-align: center;" @click.away="showQrModal = false">
                <div class="studio-modal-header">
                    <h4 class="studio-modal-title">QR Code Biolink Resmi</h4>
                    <button type="button" style="background: none; border: none; font-size: 1.4rem; cursor: pointer; color: #64748b; line-height: 1;" @click="showQrModal = false">&times;</button>
                </div>

                <div class="studio-modal-body" style="padding: 2rem 1.5rem;">
                    <div style="background: #ffffff; padding: 16px; border-radius: 16px; display: inline-block; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #e2e8f0; margin-bottom: 1rem;">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode(route('biolink.show')) }}&color=006837" alt="QR Code Biolink" style="width: 200px; height: 200px; display: block;">
                    </div>

                    <h5 style="font-weight: 700; color: #0f172a; margin: 0 0 4px 0;">{{ $profile->title }}</h5>
                    <p style="font-size: 0.8rem; color: #64748b; margin: 0 0 1.25rem 0;">Scan untuk membuka halaman Biolink sekolah di smartphone.</p>

                    <div style="display: flex; justify-content: center; gap: 8px;">
                        <a href="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data={{ urlencode(route('biolink.show')) }}&color=006837" download="qrcode-biolink.png" target="_blank" class="btn btn-primary" style="background: #006837; font-size: 0.8rem;">
                            <i data-feather="download" style="width: 14px; height: 14px;"></i> Unduh Gambar QR
                        </a>
                        <button type="button" class="btn" style="background: #f1f5f9; color: #475569; font-size: 0.8rem;" @click="showQrModal = false">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Toast Notification -->
    <div x-show="toastMsg" class="studio-toast" x-cloak style="display: none;">
        <i data-feather="check" style="width: 16px; height: 16px;"></i>
        <span x-text="toastMsg"></span>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const frame = document.querySelector('.phone-frame');
        const iframe = document.getElementById('biolinkIframe');
        if (frame && iframe) {
            frame.addEventListener('wheel', function(e) {
                e.preventDefault();
                try {
                    if (iframe.contentWindow) {
                        iframe.contentWindow.scrollBy({
                            top: e.deltaY,
                            behavior: 'auto'
                        });
                    }
                } catch (err) {}
            }, { passive: false });
        }
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>
@endpush
