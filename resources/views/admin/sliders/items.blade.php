@extends('admin.layouts.app')

@section('title', 'Kelola Slide: ' . $slider->name)

@push('styles')
<style>
    /* Topbar Studio */
    .slider-studio-header {
        background: linear-gradient(135deg, #022c19 0%, #004d28 100%);
        border-radius: 16px;
        padding: 1.5rem 2rem;
        color: #ffffff;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 25px -5px rgba(2, 44, 25, 0.25);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.25rem;
    }
    .header-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 6px;
    }
    .header-breadcrumb a {
        color: #FBB03B;
        text-decoration: none;
        font-weight: 600;
    }
    .header-breadcrumb a:hover {
        text-decoration: underline;
    }
    .header-main-title h2 {
        font-size: 1.45rem;
        font-weight: 800;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        letter-spacing: -0.02em;
    }
    .header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .btn-header-back {
        background: rgba(255, 255, 255, 0.12);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 0.65rem 1.15rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    .btn-header-back:hover {
        background: rgba(255, 255, 255, 0.22);
        color: #ffffff;
    }
    .btn-header-add {
        background: #FBB03B;
        color: #022c19;
        font-weight: 700;
        padding: 0.65rem 1.3rem;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 14px rgba(251, 176, 59, 0.35);
        font-size: 0.875rem;
    }
    .btn-header-add:hover {
        background: #f59e0b;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(251, 176, 59, 0.45);
        color: #022c19;
    }

    /* Sub-bar status */
    .slider-status-banner {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .slider-status-banner.is-active {
        border-left: 4px solid #006837;
        background: #f0fdf4;
    }
    .active-pill-tag {
        background: #006837;
        color: #ffffff;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        letter-spacing: 0.04em;
    }
    .pulse-dot-green {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #4ade80;
        box-shadow: 0 0 0 2px rgba(74, 222, 128, 0.4);
    }

    /* Empty state */
    .empty-slider-hero {
        background: #ffffff;
        border-radius: 20px;
        border: 2px dashed #cbd5e1;
        padding: 4.5rem 2rem;
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .empty-icon-circle {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: #f0fdf4;
        color: #006837;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        box-shadow: 0 8px 16px -4px rgba(0, 104, 55, 0.15);
    }
    .empty-slider-hero h3 {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 0.5rem 0;
    }
    .empty-slider-hero p {
        font-size: 0.92rem;
        color: #64748b;
        max-width: 580px;
        margin: 0 auto 1.75rem auto;
        line-height: 1.55;
    }
    .empty-cta-group {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    /* Slide Cards List */
    .slides-deck {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        margin-bottom: 3rem;
    }
    .slide-deck-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04);
        display: grid;
        grid-template-columns: 280px 1fr 140px;
        overflow: hidden;
        transition: all 0.25s ease;
    }
    .slide-deck-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px -4px rgba(0, 0, 0, 0.08);
        border-color: #cbd5e1;
    }
    .slide-deck-card.is-inactive {
        background: #f8fafc;
        opacity: 0.75;
    }

    /* Mini Live Canvas in card */
    .slide-mini-canvas {
        position: relative;
        height: 100%;
        min-height: 190px;
        background-color: #022c19;
        background-size: cover;
        background-position: center;
        padding: 12px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: hidden;
    }
    .slide-mini-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(2, 44, 25, 0.85) 0%, rgba(0, 0, 0, 0.6) 100%);
        z-index: 1;
    }
    .slide-number-pill {
        position: relative;
        z-index: 2;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
        color: #ffffff;
        font-weight: 800;
        font-size: 0.72rem;
        padding: 4px 10px;
        border-radius: 20px;
        align-self: flex-start;
        border: 1px solid rgba(255, 255, 255, 0.25);
    }
    .slide-side-mini-thumb {
        position: absolute;
        bottom: 8px;
        right: 8px;
        z-index: 2;
        width: 58px;
        height: 58px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #ffffff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    /* Card Details */
    .slide-card-details {
        padding: 1.35rem 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .slide-kicker-tag {
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #006837;
        margin-bottom: 4px;
        display: inline-block;
    }
    .slide-title-text {
        font-size: 1.18rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 6px 0;
        line-height: 1.35;
    }
    .slide-subtitle-text {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0 0 0.85rem 0;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .slide-meta-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        align-items: center;
    }
    .chip-cta {
        font-size: 0.75rem;
        font-weight: 600;
        background: #f1f5f9;
        color: #334155;
        padding: 3px 9px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .chip-pill {
        font-size: 0.72rem;
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
        padding: 2px 8px;
        border-radius: 16px;
        font-weight: 600;
    }

    /* Card Right Actions */
    .slide-card-actions {
        padding: 1.25rem 1.2rem;
        background: #fafbfc;
        border-left: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 8px;
    }
    .btn-deck-action {
        width: 100%;
        padding: 7px 10px;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 600;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-deck-action:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .btn-deck-action.btn-deck-edit:hover {
        background: #006837;
        color: #ffffff;
        border-color: #006837;
    }
    .btn-deck-action.btn-deck-status.active {
        color: #059669;
        background: #ecfdf5;
        border-color: #a7f3d0;
    }
    .btn-deck-action.btn-deck-delete:hover {
        background: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
    }

    /* ========================================================
       THE PROFESSIONAL SLIDE STUDIO MODAL (Live Preview + Form)
       ======================================================== */
    .slide-studio-modal {
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(8px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    .slide-studio-modal.show {
        display: flex;
        opacity: 1;
    }
    .slide-studio-dialog {
        background: #ffffff;
        width: 100%;
        max-width: 1140px;
        height: 88vh;
        max-height: 88vh;
        border-radius: 20px;
        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.4);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transform: translateY(15px);
        transition: transform 0.25s ease;
    }
    .slide-studio-modal.show .slide-studio-dialog {
        transform: translateY(0);
    }
    #slideStudioForm {
        display: flex;
        flex-direction: column;
        height: 100%;
        max-height: 100%;
        min-height: 0;
        overflow: hidden;
    }
    .slide-studio-header {
        flex-shrink: 0;
        padding: 1.25rem 1.75rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fafbfc;
    }
    .studio-modal-heading h3 {
        margin: 0 0 2px 0;
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .studio-modal-heading p {
        margin: 0;
        font-size: 0.8rem;
        color: #64748b;
    }
    .btn-close-studio {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-close-studio:hover {
        background: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
    }

    /* 2-Columns Studio Body */
    .slide-studio-body {
        display: grid;
        grid-template-columns: 46% 54%;
        flex: 1;
        min-height: 0;
        height: 100%;
        overflow: hidden;
    }

    /* Left: Live Preview Canvas */
    .studio-preview-pane {
        background: #091e14;
        padding: 1.75rem;
        display: flex;
        flex-direction: column;
        border-right: 1px solid #e2e8f0;
        overflow-y: auto;
        height: 100%;
        max-height: 100%;
    }
    .preview-header-tag {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    .preview-header-tag span {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #4ade80;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .preview-device-badge {
        font-size: 0.7rem;
        background: rgba(255, 255, 255, 0.1);
        color: #cbd5e1;
        padding: 2px 8px;
        border-radius: 6px;
        font-family: monospace;
    }

    /* Real-Time Mockup Hero Banner */
    .mockup-hero-stage {
        position: relative;
        border-radius: 14px;
        overflow: hidden;
        min-height: 340px;
        background-color: #022c19;
        background-size: cover;
        background-position: center;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.15);
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 1.5rem;
        transition: background-image 0.3s ease;
    }
    .mockup-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(2, 44, 25, 0.9) 0%, rgba(0, 0, 0, 0.75) 100%);
        z-index: 1;
    }
    .mockup-hero-content {
        position: relative;
        z-index: 2;
        color: #ffffff;
    }
    .mockup-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(251, 176, 59, 0.18);
        border: 1px solid rgba(251, 176, 59, 0.4);
        color: #FBB03B;
        font-size: 0.68rem;
        font-weight: 800;
        padding: 3px 10px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 0.75rem;
    }
    .mockup-hero-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 0.5rem 0;
        line-height: 1.3;
        white-space: pre-line;
    }
    .mockup-hero-subtitle {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.45;
        margin: 0 0 1rem 0;
    }
    .mockup-hero-btns {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 0.75rem;
    }
    .mockup-btn-primary {
        background: #006837;
        color: #ffffff;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        box-shadow: 0 2px 6px rgba(0, 104, 55, 0.4);
    }
    .mockup-btn-secondary {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #ffffff;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 6px;
    }
    .mockup-hero-pills {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    .mockup-pill-item {
        font-size: 0.68rem;
        color: #e2e8f0;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: rgba(255, 255, 255, 0.08);
        padding: 2px 8px;
        border-radius: 12px;
    }
    .mockup-side-thumb {
        position: absolute;
        bottom: 12px;
        right: 12px;
        width: 70px;
        height: 70px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #ffffff;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
        z-index: 3;
    }

    /* Right: Form Settings Pane */
    .studio-form-pane {
        padding: 1.75rem;
        overflow-y: auto;
        height: 100%;
        max-height: 100%;
        background: #ffffff;
        scroll-behavior: smooth;
    }
    .studio-form-pane::-webkit-scrollbar {
        width: 8px;
    }
    .studio-form-pane::-webkit-scrollbar-track {
        background: #f8fafc;
    }
    .studio-form-pane::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .studio-form-pane::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    .studio-preview-pane::-webkit-scrollbar {
        width: 6px;
    }
    .studio-preview-pane::-webkit-scrollbar-track {
        background: #091e14;
    }
    .studio-preview-pane::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 4px;
    }
    .studio-section-title {
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #006837;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 0.85rem;
        padding-bottom: 4px;
        border-bottom: 1px solid #f1f5f9;
    }
    .studio-field-group {
        margin-bottom: 1.15rem;
    }
    .studio-field-label {
        display: block;
        font-size: 0.83rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 5px;
    }
    .studio-input {
        width: 100%;
        padding: 0.65rem 0.85rem;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 0.875rem;
        color: #0f172a;
        background: #ffffff;
        outline: none;
        transition: all 0.2s;
    }
    .studio-input:focus {
        border-color: #006837;
        box-shadow: 0 0 0 3px rgba(0, 104, 55, 0.15);
    }
    .studio-field-hint {
        font-size: 0.73rem;
        color: #64748b;
        margin-top: 4px;
        display: block;
    }

    /* Dropzone file upload box */
    .studio-upload-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 1rem;
    }
    .upload-switch-tabs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    /* Quick Pills Suggestions */
    .pills-suggestion-box {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-top: 6px;
    }
    .btn-suggest-pill {
        background: #f1f5f9;
        border: 1px dashed #cbd5e1;
        color: #475569;
        font-size: 0.72rem;
        padding: 3px 8px;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-suggest-pill:hover {
        background: #ecfdf5;
        border-color: #006837;
        color: #006837;
    }

    /* Footer of studio */
    .slide-studio-footer {
        flex-shrink: 0;
        padding: 1rem 1.75rem;
        background: #fafbfc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.04);
        z-index: 10;
    }
    .btn-studio-cancel {
        background: #e2e8f0;
        color: #475569;
        font-weight: 600;
        padding: 0.65rem 1.25rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    .btn-studio-cancel:hover {
        background: #cbd5e1;
        color: #0f172a;
    }
    .btn-studio-save {
        background: #006837;
        color: #ffffff;
        font-weight: 700;
        padding: 0.65rem 1.6rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(0, 104, 55, 0.3);
    }
    .btn-studio-save:hover {
        background: #022c19;
        transform: translateY(-1px);
    }

    @media (max-width: 950px) {
        .slide-deck-card {
            grid-template-columns: 1fr;
        }
        .slide-mini-canvas {
            min-height: 180px;
        }
        .slide-card-actions {
            border-left: none;
            border-top: 1px solid #f1f5f9;
            flex-direction: row;
        }
        .slide-studio-dialog {
            height: 94vh;
            max-height: 94vh;
        }
        .slide-studio-body {
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        .studio-preview-pane {
            border-right: none;
            border-bottom: 1px solid #e2e8f0;
            height: auto;
            max-height: none;
            flex-shrink: 0;
        }
        .studio-form-pane {
            height: auto;
            max-height: none;
            overflow-y: visible;
        }
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">

    @if(session('success'))
    <div class="alert alert-success" style="background:#ecfdf5; border-left:4px solid #10b981; color:#065f46; padding:1rem 1.25rem; border-radius:10px; margin-bottom:1.5rem; display:flex; align-items:center; justify-content:space-between; box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">
        <div style="display:flex; align-items:center; gap:10px;">
            <i data-feather="check-circle" style="color:#10b981;"></i>
            <span style="font-weight:600;">{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="background:none; border:none; color:#065f46; cursor:pointer;"><i data-feather="x"></i></button>
    </div>
    @endif

    @if(isset($errors) && $errors->any())
    <div class="alert alert-danger" style="background:#fef2f2; border-left:4px solid #ef4444; color:#991b1b; padding:1rem 1.25rem; border-radius:10px; margin-bottom:1.5rem;">
        <div style="font-weight:700; margin-bottom:4px;">Mohon periksa kembali input Anda:</div>
        <ul style="margin:0; padding-left:1.25rem; font-size:0.875rem;">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Topbar Studio Header -->
    <div class="slider-studio-header">
        <div>
            <div class="header-breadcrumb">
                <a href="{{ route('admin.sliders.index') }}">Sliders & Banner</a>
                <span>/</span>
                <span>Tema: {{ $slider->name }}</span>
            </div>
            <div class="header-main-title">
                <h2><i data-feather="film" style="color: #FBB03B;"></i> Kelola Slide: {{ $slider->name }}</h2>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.sliders.index') }}" class="btn-header-back">
                <i data-feather="arrow-left"></i> Kembali ke Semua Tema
            </a>
            <button type="button" class="btn-header-add" onclick="openCreateSlideModal()">
                <i data-feather="plus-circle"></i> Tambah Slide Baru
            </button>
        </div>
    </div>

    <!-- Active Status Ribbon -->
    <div class="slider-status-banner {{ $slider->is_active ? 'is-active' : '' }}">
        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
            @if($slider->is_active)
            <span class="active-pill-tag">
                <span class="pulse-dot-green"></span> TEMA SEDANG AKTIF DI BERANDA
            </span>
            <span style="color:#065f46; font-size:0.85rem; font-weight:600;">
                Semua slide di bawah ini langsung tayang secara dinamis di Hero Banner halaman utama website.
            </span>
            @else
            <span style="background:#e2e8f0; color:#475569; padding:4px 12px; border-radius:20px; font-size:0.78rem; font-weight:700;">
                TEMA STANDBY / CADANGAN
            </span>
            <span style="color:#64748b; font-size:0.85rem;">
                Tema ini tidak sedang tayang di beranda. Anda dapat mengaktifkannya kapan saja.
            </span>
            @endif
        </div>
        @if(!$slider->is_active)
        <form action="{{ route('admin.sliders.active', $slider->id) }}" method="POST" onsubmit="return confirm('Jadikan tema ini sebagai banner aktif di Beranda utama?');">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn" style="background:#006837; color:#ffffff; font-weight:700; padding:7px 15px; border-radius:8px; border:none; cursor:pointer; font-size:0.83rem; display:inline-flex; align-items:center; gap:6px;">
                <i data-feather="check"></i> Aktifkan Tema Ini Sekarang
            </button>
        </form>
        @endif
    </div>

    <!-- Slide Cards / Empty State -->
    @if($slider->items->isEmpty())
    <div class="empty-slider-hero">
        <div class="empty-icon-circle">
            <i data-feather="layers" style="width: 32px; height: 32px;"></i>
        </div>
        <h3>Belum Ada Slide pada Tema "{{ $slider->name }}"</h3>
        <p>
            Tema ini belum memiliki slide. Anda bisa mulai membuat slide pertama secara kustom dengan <strong>Live Preview</strong>, atau langsung memuat template slide rekomendasi Al Irsyad (Kurikulum Pearson ICP, Kurikulum Khas, Fasilitas, Testimoni).
        </p>
        <div class="empty-cta-group">
            <button type="button" class="btn-header-add" onclick="openCreateSlideModal()">
                <i data-feather="plus-circle"></i> Buat Slide Pertama Sekarang
            </button>
            <form action="{{ route('admin.sliders.presets', $slider->id) }}" method="POST" onsubmit="return confirm('Muat 5 template slide standar Al Irsyad ke tema ini?');">
                @csrf
                <button type="submit" class="btn" style="background:#006837; color:#ffffff; font-weight:700; padding:0.65rem 1.3rem; border-radius:10px; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:8px; font-size:0.875rem;">
                    <i data-feather="zap"></i> Muat Template Slide Rekomendasi
                </button>
            </form>
        </div>
    </div>
    @else
    <div class="slides-deck">
        @foreach($slider->items as $index => $item)
        <div class="slide-deck-card {{ !$item->is_active ? 'is-inactive' : '' }}">
            <!-- Left Live Mini Canvas -->
            <div class="slide-mini-canvas" style="background-image: url('{{ $item->image_url }}');">
                <div class="slide-mini-overlay"></div>
                <div class="slide-number-pill">
                    Slide #{{ $index + 1 }} &bull; Urutan {{ $item->sort_order }}
                </div>
                @if($item->side_image_url)
                <img src="{{ $item->side_image_url }}" alt="Visual Samping" class="slide-side-mini-thumb" title="Visual Samping (Santri)">
                @endif
            </div>

            <!-- Middle Details -->
            <div class="slide-card-details">
                <div>
                    @if($item->badge)
                    <span class="slide-kicker-tag">{{ $item->badge }}</span>
                    @endif
                    <h4 class="slide-title-text">{{ $item->title ?: '(Tanpa Judul)' }}</h4>
                    <p class="slide-subtitle-text">{{ $item->subtitle ?: 'Tidak ada deskripsi subjudul.' }}</p>
                </div>

                <div class="slide-meta-chips">
                    @if($item->btn_text)
                    <span class="chip-cta" title="{{ $item->btn_link }}">
                        <i data-feather="link-2" style="width:11px; height:11px;"></i>
                        <strong>CTA 1:</strong> {{ $item->btn_text }}
                    </span>
                    @endif
                    @if($item->btn2_text)
                    <span class="chip-cta" title="{{ $item->btn2_link }}">
                        <i data-feather="link-2" style="width:11px; height:11px;"></i>
                        <strong>CTA 2:</strong> {{ $item->btn2_text }}
                    </span>
                    @endif
                    @if(!empty($item->pills) && is_array($item->pills))
                        @foreach($item->pills as $pill)
                        <span class="chip-pill"><i data-feather="check" style="width:9px; height:9px;"></i> {{ $pill }}</span>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Right Actions -->
            <div class="slide-card-actions">
                <button type="button" class="btn-deck-action btn-deck-edit" onclick="openEditSlideModal({{ json_encode($item) }})">
                    <i data-feather="edit-2" style="width:13px; height:13px;"></i> Edit Slide
                </button>

                <form action="{{ route('admin.sliders.items.toggle', [$slider->id, $item->id]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-deck-action btn-deck-status {{ $item->is_active ? 'active' : '' }}" title="Klik untuk ubah status tampil">
                        <i data-feather="{{ $item->is_active ? 'eye' : 'eye-off' }}" style="width:13px; height:13px;"></i>
                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                    </button>
                </form>

                <form action="{{ route('admin.sliders.items.destroy', [$slider->id, $item->id]) }}" method="POST" onsubmit="return confirm('Hapus slide ini dari tema?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-deck-action btn-deck-delete">
                        <i data-feather="trash-2" style="width:13px; height:13px;"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>

<!-- ====================================================================
     STUDIO MODAL: UNIFIED SLIDE EDITOR DENGAN REAL-TIME LIVE PREVIEW
     ==================================================================== -->
<div class="slide-studio-modal" id="slideStudioModal">
    <div class="slide-studio-dialog">
        <form id="slideStudioForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="methodSpoofContainer"></div>

            <!-- Studio Header -->
            <div class="slide-studio-header">
                <div class="studio-modal-heading">
                    <h3 id="studioModalTitle">
                        <i data-feather="edit-3" style="color:#006837;"></i>
                        <span>Studio Editor Slide</span>
                    </h3>
                    <p id="studioModalSubtitle">Atur visual dan konten. Hasilnya langsung tersimulasi di layar Live Preview sebelah kiri.</p>
                </div>
                <button type="button" class="btn-close-studio" onclick="closeSlideStudioModal()" title="Tutup Studio (ESC)">
                    <i data-feather="x"></i>
                </button>
            </div>

            <!-- Studio Body: 2 Columns Layout -->
            <div class="slide-studio-body">
                
                <!-- LEFT COLUMN: REAL-TIME LIVE PREVIEW CANVAS -->
                <div class="studio-preview-pane">
                    <div class="preview-header-tag">
                        <span><i data-feather="eye" style="width:13px; height:13px;"></i> Live Preview Beranda</span>
                        <span class="preview-device-badge">Hero Banner 16:9</span>
                    </div>

                    <div class="mockup-hero-stage" id="liveMockupStage" style="background-image: url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=1920');">
                        <div class="mockup-hero-overlay"></div>
                        
                        <div class="mockup-hero-content">
                            <div class="mockup-hero-badge" id="liveMockupBadge">
                                <span style="width:6px; height:6px; border-radius:50%; background:#FBB03B; display:inline-block;"></span>
                                <span id="liveBadgeText">OFFICIAL PEARSON EDEXCEL PARTNER</span>
                            </div>

                            <h2 class="mockup-hero-title" id="liveMockupTitle">Kurikulum Internasional Pearson (UK)</h2>
                            <p class="mockup-hero-subtitle" id="liveMockupSubtitle">International Class Program (ICP) berstandar global Pearson Edexcel UK, memadukan sains internasional dengan adab tauhid Rabbani.</p>

                            <div class="mockup-hero-btns">
                                <span class="mockup-btn-primary" id="liveMockupBtn1">
                                    <span id="liveBtn1Text">Pelajari Pearson ICP</span> <i data-feather="arrow-right" style="width:12px; height:12px;"></i>
                                </span>
                                <span class="mockup-btn-secondary" id="liveMockupBtn2" style="display:none;">
                                    <span id="liveBtn2Text">Hubungi Kami</span>
                                </span>
                            </div>

                            <div class="mockup-hero-pills" id="liveMockupPills">
                                <span class="mockup-pill-item"><i data-feather="check" style="width:10px; height:10px; color:#4ade80;"></i> Pearson Edexcel UK</span>
                                <span class="mockup-pill-item"><i data-feather="check" style="width:10px; height:10px; color:#4ade80;"></i> Global Qualifications</span>
                            </div>
                        </div>

                        <!-- Side Student Visual if present -->
                        <img id="liveMockupSideThumb" src="" alt="Side Visual" class="mockup-side-thumb" style="display:none;">
                    </div>

                    <div style="margin-top:1.25rem; background:rgba(255,255,255,0.06); border-radius:10px; padding:10px 14px; color:#cbd5e1; font-size:0.75rem; line-height:1.45;">
                        <i data-feather="info" style="width:13px; height:13px; color:#FBB03B; vertical-align:middle;"></i>
                        Tampilan preview di atas merefleksikan posisi elemen (badge, judul, subjudul, tombol, dan background) saat slide ditayangkan di halaman depan website.
                    </div>
                </div>

                <!-- RIGHT COLUMN: FORM SETTINGS CONTROLS -->
                <div class="studio-form-pane">

                    <!-- SECTION 1: KONTEN TEKS & BADGE -->
                    <div class="studio-section-title">
                        <i data-feather="type" style="width:14px; height:14px;"></i> 1. Konten Teks & Tipografi
                    </div>

                    <div class="studio-field-group">
                        <label class="studio-field-label">Badge / Label Kicker (Atas)</label>
                        <input type="text" name="badge" id="form_badge" class="studio-input" placeholder="Contoh: OFFICIAL PEARSON EDEXCEL PARTNER">
                        <span class="studio-field-hint">Label kecil yang muncul di atas judul utama slide.</span>
                    </div>

                    <div class="studio-field-group">
                        <label class="studio-field-label">Judul Utama Slide <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="title" id="form_title" class="studio-input" placeholder="Contoh: Kurikulum Internasional Pearson (UK)" required>
                    </div>

                    <div class="studio-field-group">
                        <label class="studio-field-label">Deskripsi / Subjudul</label>
                        <textarea name="subtitle" id="form_subtitle" rows="2" class="studio-input" placeholder="Penjelasan ringkas isi slide..."></textarea>
                    </div>

                    <!-- SECTION 2: VISUAL & BACKGROUND -->
                    <div class="studio-section-title" style="margin-top:1.5rem;">
                        <i data-feather="image" style="width:14px; height:14px;"></i> 2. Foto Background & Visual
                    </div>

                    <div class="studio-upload-box">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                            <label class="studio-field-label" style="margin:0;">Foto / Background Slide (Landscape 1920x1080)</label>
                            <button type="button" class="btn" style="background:#e0e7ff; color:#3730a3; font-size:0.75rem; font-weight:700; padding:4px 10px; border-radius:6px; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:5px;" onclick="openMediaPickerForBackground()">
                                <i data-feather="image" style="width:12px; height:12px;"></i> Pilih dari Media Library
                            </button>
                        </div>
                        <div class="upload-switch-tabs">
                            <div>
                                <span style="font-size:0.72rem; color:#64748b; font-weight:600; display:block; margin-bottom:4px;">Upload File Foto:</span>
                                <input type="file" name="image_file" id="form_image_file" accept="image/*" class="studio-input" style="padding:5px 8px;">
                            </div>
                            <div>
                                <span style="font-size:0.72rem; color:#64748b; font-weight:600; display:block; margin-bottom:4px;">Atau Masukkan URL Gambar:</span>
                                <input type="text" name="image_url" id="form_image_url" class="studio-input" placeholder="https://images.unsplash.com/...">
                            </div>
                        </div>
                    </div>

                    <div class="studio-upload-box">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                            <label class="studio-field-label" style="margin:0;">Gambar Santri / Visual Samping (Opsional)</label>
                            <button type="button" class="btn" style="background:#e0e7ff; color:#3730a3; font-size:0.75rem; font-weight:700; padding:4px 10px; border-radius:6px; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:5px;" onclick="openMediaPickerForSide()">
                                <i data-feather="image" style="width:12px; height:12px;"></i> Pilih dari Media Library
                            </button>
                        </div>
                        <div class="upload-switch-tabs">
                            <div>
                                <span style="font-size:0.72rem; color:#64748b; font-weight:600; display:block; margin-bottom:4px;">Upload File PNG Transparan:</span>
                                <input type="file" name="side_image_file" id="form_side_file" accept="image/*" class="studio-input" style="padding:5px 8px;">
                            </div>
                            <div>
                                <span style="font-size:0.72rem; color:#64748b; font-weight:600; display:block; margin-bottom:4px;">Atau Path / URL:</span>
                                <input type="text" name="side_image_url" id="form_side_url" class="studio-input" placeholder="images/hero-students.png">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: TOMBOL AKSI (CTA) -->
                    <div class="studio-section-title" style="margin-top:1.5rem;">
                        <i data-feather="mouse-pointer" style="width:14px; height:14px;"></i> 3. Tombol Aksi (Call To Action)
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                        <div class="studio-field-group">
                            <label class="studio-field-label">Teks Tombol Utama</label>
                            <input type="text" name="btn_text" id="form_btn_text" class="studio-input" placeholder="Pelajari Pearson ICP">
                        </div>
                        <div class="studio-field-group">
                            <label class="studio-field-label">Link Tombol Utama</label>
                            <input type="text" name="btn_link" id="form_btn_link" class="studio-input" placeholder="/pearson-icp atau https://...">
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                        <div class="studio-field-group">
                            <label class="studio-field-label">Teks Tombol 2 (Opsional)</label>
                            <input type="text" name="btn2_text" id="form_btn2_text" class="studio-input" placeholder="Hubungi Kami">
                        </div>
                        <div class="studio-field-group">
                            <label class="studio-field-label">Link Tombol 2</label>
                            <input type="text" name="btn2_link" id="form_btn2_link" class="studio-input" placeholder="#contact">
                        </div>
                    </div>

                    <!-- SECTION 4: POIN FITUR / PILLS -->
                    <div class="studio-section-title" style="margin-top:1.5rem;">
                        <i data-feather="tag" style="width:14px; height:14px;"></i> 4. Tag / Poin Keunggulan (Pills)
                    </div>

                    <div class="studio-field-group">
                        <label class="studio-field-label">Daftar Poin Keunggulan</label>
                        <input type="text" name="pills_raw" id="form_pills_raw" class="studio-input" placeholder="Pisahkan dengan koma: Pearson Edexcel UK, Global Qualifications, dll">
                        
                        <div class="pills-suggestion-box">
                            <span style="font-size:0.72rem; color:#64748b; align-self:center;">Rekomendasi Cepat:</span>
                            <button type="button" class="btn-suggest-pill" onclick="appendPill('Pearson Edexcel UK')">+ Pearson Edexcel UK</button>
                            <button type="button" class="btn-suggest-pill" onclick="appendPill('Tahfidz Bersanad')">+ Tahfidz Bersanad</button>
                            <button type="button" class="btn-suggest-pill" onclick="appendPill('Akreditasi A Unggul')">+ Akreditasi A</button>
                            <button type="button" class="btn-suggest-pill" onclick="appendPill('STEAM & Coding')">+ STEAM & Coding</button>
                        </div>
                    </div>

                    <!-- SECTION 5: URUTAN & STATUS -->
                    <div class="studio-section-title" style="margin-top:1.5rem;">
                        <i data-feather="settings" style="width:14px; height:14px;"></i> 5. Urutan & Visibilitas
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px; align-items:center;">
                        <div class="studio-field-group" style="margin:0;">
                            <label class="studio-field-label">Nomor Urutan Tampil</label>
                            <input type="number" name="sort_order" id="form_sort_order" class="studio-input" value="{{ $slider->items->count() + 1 }}" min="1">
                        </div>
                        <div style="padding-top:1rem;">
                            <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-weight:700; font-size:0.875rem; color:#065f46;">
                                <input type="checkbox" name="is_active" id="form_is_active" value="1" checked style="width:18px; height:18px; accent-color:#006837;">
                                Aktifkan & Tayangkan Slide Ini
                            </label>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Studio Footer -->
            <div class="slide-studio-footer">
                <button type="button" class="btn-studio-cancel" onclick="closeSlideStudioModal()">Batal</button>
                <button type="submit" class="btn-studio-save">
                    <i data-feather="check-circle" style="width:16px; height:16px;"></i> Simpan Slide
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const sliderBaseUrl = "{{ url('admin/sliders/' . $slider->id . '/items') }}";

    // Live Preview Elements
    const liveStage = document.getElementById('liveMockupStage');
    const liveBadge = document.getElementById('liveMockupBadge');
    const liveBadgeText = document.getElementById('liveBadgeText');
    const liveTitle = document.getElementById('liveMockupTitle');
    const liveSubtitle = document.getElementById('liveMockupSubtitle');
    const liveBtn1 = document.getElementById('liveMockupBtn1');
    const liveBtn1Text = document.getElementById('liveBtn1Text');
    const liveBtn2 = document.getElementById('liveMockupBtn2');
    const liveBtn2Text = document.getElementById('liveBtn2Text');
    const livePills = document.getElementById('liveMockupPills');
    const liveSideThumb = document.getElementById('liveMockupSideThumb');

    // Form inputs
    const inBadge = document.getElementById('form_badge');
    const inTitle = document.getElementById('form_title');
    const inSubtitle = document.getElementById('form_subtitle');
    const inImageUrl = document.getElementById('form_image_url');
    const inImageFile = document.getElementById('form_image_file');
    const inSideUrl = document.getElementById('form_side_url');
    const inSideFile = document.getElementById('form_side_file');
    const inBtn1Text = document.getElementById('form_btn_text');
    const inBtn2Text = document.getElementById('form_btn2_text');
    const inPills = document.getElementById('form_pills_raw');

    // Real-Time Sync function
    function syncLivePreview() {
        // Badge
        if (inBadge.value.trim()) {
            liveBadge.style.display = 'inline-flex';
            liveBadgeText.innerText = inBadge.value.trim();
        } else {
            liveBadge.style.display = 'none';
        }

        // Title
        liveTitle.innerText = inTitle.value.trim() || 'Judul Utama Slide';

        // Subtitle
        liveSubtitle.innerText = inSubtitle.value.trim() || 'Keterangan ringkas subjudul slide akan ditampilkan di sini.';

        // Background Image
        if (inImageUrl.value.trim()) {
            liveStage.style.backgroundImage = `url('${inImageUrl.value.trim()}')`;
        }

        // Side Image
        if (inSideUrl.value.trim()) {
            liveSideThumb.src = inSideUrl.value.trim();
            liveSideThumb.style.display = 'block';
        } else {
            liveSideThumb.style.display = 'none';
        }

        // CTA 1
        if (inBtn1Text.value.trim()) {
            liveBtn1.style.display = 'inline-flex';
            liveBtn1Text.innerText = inBtn1Text.value.trim();
        } else {
            liveBtn1.style.display = 'none';
        }

        // CTA 2
        if (inBtn2Text.value.trim()) {
            liveBtn2.style.display = 'inline-flex';
            liveBtn2Text.innerText = inBtn2Text.value.trim();
        } else {
            liveBtn2.style.display = 'none';
        }

        // Pills
        livePills.innerHTML = '';
        if (inPills.value.trim()) {
            const raw = inPills.value.split(/[,;\n]+/);
            raw.forEach(p => {
                const t = p.trim();
                if (t) {
                    const span = document.createElement('span');
                    span.className = 'mockup-pill-item';
                    span.innerHTML = `<i data-feather="check" style="width:10px; height:10px; color:#4ade80;"></i> ${t}`;
                    livePills.appendChild(span);
                }
            });
            if (window.feather) feather.replace();
        }
    }

    // Attach real-time listeners
    [inBadge, inTitle, inSubtitle, inImageUrl, inSideUrl, inBtn1Text, inBtn2Text, inPills].forEach(el => {
        el.addEventListener('input', syncLivePreview);
    });

    // File Preview Listener for background image
    inImageFile.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                liveStage.style.backgroundImage = `url('${evt.target.result}')`;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // File Preview Listener for side image
    inSideFile.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                liveSideThumb.src = evt.target.result;
                liveSideThumb.style.display = 'block';
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    function appendPill(pillName) {
        let current = inPills.value.trim();
        if (current) {
            inPills.value = current + ', ' + pillName;
        } else {
            inPills.value = pillName;
        }
        syncLivePreview();
    }

    // Open Modal: Tambah Baru
    function openCreateSlideModal() {
        const form = document.getElementById('slideStudioForm');
        form.action = sliderBaseUrl;
        document.getElementById('methodSpoofContainer').innerHTML = ''; // POST

        document.getElementById('studioModalTitle').innerHTML = '<i data-feather="plus-circle" style="color:#006837;"></i> <span>Tambah Slide Baru ke Tema</span>';
        document.getElementById('studioModalSubtitle').innerText = 'Buat slide baru dengan live preview real-time.';

        // Reset inputs
        inBadge.value = 'OFFICIAL PEARSON EDEXCEL PARTNER';
        inTitle.value = '';
        inSubtitle.value = '';
        inImageUrl.value = 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=1920';
        inImageFile.value = '';
        inSideUrl.value = '';
        inSideFile.value = '';
        inBtn1Text.value = 'Pelajari Lebih Lanjut';
        document.getElementById('form_btn_link').value = '#';
        inBtn2Text.value = '';
        document.getElementById('form_btn2_link').value = '';
        inPills.value = 'Kurikulum Internasional, Adab Tauhid, Prestasi Global';
        document.getElementById('form_sort_order').value = "{{ $slider->items->count() + 1 }}";
        document.getElementById('form_is_active').checked = true;

        syncLivePreview();
        document.getElementById('slideStudioModal').classList.add('show');
        if (window.feather) feather.replace();
    }

    // Open Modal: Edit Slide
    function openEditSlideModal(slide) {
        const form = document.getElementById('slideStudioForm');
        form.action = sliderBaseUrl + '/' + slide.id;
        document.getElementById('methodSpoofContainer').innerHTML = '@method("PUT")';

        document.getElementById('studioModalTitle').innerHTML = `<i data-feather="edit-2" style="color:#006837;"></i> <span>Edit Slide #${slide.sort_order}</span>`;
        document.getElementById('studioModalSubtitle').innerText = `Perbarui data slide "${slide.title || 'Tanpa Judul'}".`;

        inBadge.value = slide.badge || '';
        inTitle.value = slide.title || '';
        inSubtitle.value = slide.subtitle || '';
        inImageUrl.value = (slide.image && slide.image.startsWith('http')) ? slide.image : '';
        inImageFile.value = '';
        inSideUrl.value = (slide.side_image && slide.side_image.startsWith('http')) ? slide.side_image : (slide.side_image || '');
        inSideFile.value = '';
        inBtn1Text.value = slide.btn_text || '';
        document.getElementById('form_btn_link').value = slide.btn_link || '';
        inBtn2Text.value = slide.btn2_text || '';
        document.getElementById('form_btn2_link').value = slide.btn2_link || '';
        document.getElementById('form_sort_order').value = slide.sort_order || 1;
        document.getElementById('form_is_active').checked = slide.is_active == 1;

        if (Array.isArray(slide.pills)) {
            inPills.value = slide.pills.join(', ');
        } else {
            inPills.value = '';
        }

        // Stage preview background from slide accessor
        if (slide.image_url) {
            liveStage.style.backgroundImage = `url('${slide.image_url}')`;
        }

        syncLivePreview();
        document.getElementById('slideStudioModal').classList.add('show');
        if (window.feather) feather.replace();
    }

    function closeSlideStudioModal() {
        document.getElementById('slideStudioModal').classList.remove('show');
    }

    // Close on click backdrop
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('slideStudioModal');
        if (e.target === modal) closeSlideStudioModal();
    });

    // Media Library Integration
    window.onSliderMediaSelected = function(item) {
        if (!item) return;
        const url = (typeof item === 'object' && item.url) ? item.url : item;
        inImageFile.value = '';
        inImageUrl.value = url;
        liveStage.style.backgroundImage = `url('${url}')`;
        syncLivePreview();
    };
    function openMediaPickerForBackground() {
        window.dispatchEvent(new CustomEvent('open-media-picker', { detail: { callback: 'onSliderMediaSelected' } }));
    }

    window.onSliderSideMediaSelected = function(item) {
        if (!item) return;
        const url = (typeof item === 'object' && item.url) ? item.url : item;
        inSideFile.value = '';
        inSideUrl.value = url;
        liveSideThumb.src = url;
        liveSideThumb.style.display = 'block';
        syncLivePreview();
    };
    function openMediaPickerForSide() {
        window.dispatchEvent(new CustomEvent('open-media-picker', { detail: { callback: 'onSliderSideMediaSelected' } }));
    }
</script>
@endpush
@endsection
