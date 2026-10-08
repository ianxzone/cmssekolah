@extends('admin.layouts.app')

@section('title', 'Security Center & Monitoring')

@push('styles')
<style>
    /* ========================================================
       SECURITY CENTER ENTERPRISE UI STYLES
       ======================================================== */
    :root {
        --sec-primary: #065f46;
        --sec-primary-dark: #064e3b;
        --sec-primary-light: #10b981;
        --sec-accent: #f59e0b;
        --sec-danger: #ef4444;
        --sec-indigo: #6366f1;
        --sec-surface: #ffffff;
        --sec-border: #e2e8f0;
        --sec-text-main: #0f172a;
        --sec-text-muted: #64748b;
    }

    /* Page Header */
    .sec-header {
        background: #ffffff;
        border: 1px solid var(--sec-border);
        border-radius: 16px;
        padding: 1.5rem 1.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1.25rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .sec-header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .sec-header-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: linear-gradient(135deg, #065f46 0%, #064e3b 100%);
        color: #fbbf24;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 16px -4px rgba(6, 95, 70, 0.3);
        border: 1px solid rgba(251, 191, 36, 0.3);
        flex-shrink: 0;
    }
    .sec-header-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--sec-text-main);
        letter-spacing: -0.02em;
        margin: 0;
    }
    .sec-header-desc {
        font-size: 0.85rem;
        color: var(--sec-text-muted);
        margin: 3px 0 0;
    }
    .sec-header-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
    }
    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #10b981;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulseAnimation 2s infinite;
    }
    @keyframes pulseAnimation {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    /* Segmented Navigation Tabs */
    .sec-nav-tabs {
        background: #f1f5f9;
        padding: 6px;
        border-radius: 14px;
        display: flex;
        gap: 4px;
        margin-bottom: 1.75rem;
        border: 1px solid #e2e8f0;
        overflow-x: auto;
    }
    .sec-tab-btn {
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        white-space: nowrap;
        border: none;
        background: transparent;
    }
    .sec-tab-btn:hover {
        color: #0f172a;
        background: rgba(255, 255, 255, 0.6);
    }
    .sec-tab-btn.active {
        background: #ffffff;
        color: #065f46;
        font-weight: 700;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
    }
    .sec-tab-btn.active svg {
        stroke: #065f46;
    }

    /* Modern Card Container */
    .sec-card {
        background: #ffffff;
        border: 1px solid var(--sec-border);
        border-radius: 16px;
        padding: 1.75rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        transition: box-shadow 0.2s ease;
    }
    .sec-card:hover {
        box-shadow: 0 6px 18px -4px rgba(0, 0, 0, 0.05);
    }
    .sec-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 1.25rem;
        gap: 1rem;
    }
    .sec-card-title-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .sec-card-icon-badge {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .sec-card-icon-badge.emerald { background: #ecfdf5; color: #065f46; }
    .sec-card-icon-badge.amber   { background: #fef3c7; color: #b45309; }
    .sec-card-icon-badge.indigo  { background: #e0e7ff; color: #4338ca; }
    .sec-card-icon-badge.teal    { background: #ccfbf1; color: #0f766e; }
    .sec-card-icon-badge.rose    { background: #ffe4e6; color: #e11d48; }

    .sec-card-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--sec-text-main);
        margin: 0;
    }
    .sec-card-desc {
        font-size: 0.83rem;
        color: var(--sec-text-muted);
        margin: 2px 0 0;
    }

    /* iOS Style Toggle Switch Component */
    .sec-toggle-row {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.25rem;
        transition: background 0.2s ease, border-color 0.2s ease;
    }
    .sec-toggle-row:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }
    .sec-toggle-label-title {
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--sec-text-main);
        display: block;
    }
    .sec-toggle-label-sub {
        font-size: 0.78rem;
        color: var(--sec-text-muted);
        margin-top: 2px;
        display: block;
    }

    /* Modern Switch Input */
    .ios-switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 26px;
        flex-shrink: 0;
    }
    .ios-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .ios-slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #cbd5e1;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 30px;
    }
    .ios-slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .ios-switch input:checked + .ios-slider {
        background-color: #065f46;
    }
    .ios-switch input:checked + .ios-slider:before {
        transform: translateX(22px);
    }

    /* Interactive Radio Cards for Provider Selection */
    .sec-provider-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .sec-provider-card {
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.25rem;
        background: #ffffff;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    .sec-provider-card:hover {
        border-color: #94a3b8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }
    .sec-provider-card.selected {
        border-color: #065f46;
        background: #f0fdf4;
        box-shadow: 0 0 0 3px rgba(6, 95, 70, 0.12);
    }
    .sec-provider-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .sec-provider-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        font-weight: 800;
    }
    .sec-provider-icon.builtin   { background: #dcfce7; color: #166534; }
    .sec-provider-icon.turnstile { background: #ffedd5; color: #c2410c; }
    .sec-provider-icon.recaptcha { background: #dbeafe; color: #1e40af; }

    .sec-provider-pill {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 3px 8px;
        border-radius: 20px;
    }
    .sec-provider-pill.badge-ready { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
    .sec-provider-pill.badge-rec   { background: #fef3c7; color: #b45309; border: 1px solid #fcd34d; }
    .sec-provider-pill.badge-pop   { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

    .sec-provider-name {
        font-size: 0.98rem;
        font-weight: 800;
        color: var(--sec-text-main);
        margin-bottom: 4px;
    }
    .sec-provider-desc {
        font-size: 0.78rem;
        color: var(--sec-text-muted);
        line-height: 1.4;
        margin: 0;
        flex-grow: 1;
    }

    /* Target Forms Interactive Selection Cards */
    .sec-targets-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
        margin-top: 10px;
    }
    .sec-target-checkbox-card {
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
        background: #ffffff;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }
    .sec-target-checkbox-card:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }
    .sec-target-checkbox-card.checked {
        border-color: #065f46;
        background: #f0fdf4;
    }
    .sec-target-custom-box {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        border: 2px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: all 0.2s;
        flex-shrink: 0;
    }
    .sec-target-checkbox-card.checked .sec-target-custom-box {
        background: #065f46;
        border-color: #065f46;
    }
    .sec-target-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--sec-text-main);
    }

    /* Number Stepper Inputs with Suffix */
    .sec-input-addon-group {
        display: flex;
        align-items: stretch;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        transition: border-color 0.2s;
    }
    .sec-input-addon-group:focus-within {
        border-color: #065f46;
        box-shadow: 0 0 0 3px rgba(6, 95, 70, 0.12);
    }
    .sec-input-addon-field {
        border: none;
        padding: 10px 14px;
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
        width: 100%;
        outline: none;
    }
    .sec-input-addon-suffix {
        background: #f1f5f9;
        color: #475569;
        font-size: 0.8rem;
        font-weight: 700;
        padding: 0 14px;
        display: flex;
        align-items: center;
        border-left: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    /* Modern Input Field */
    .sec-input {
        width: 100%;
        padding: 10px 14px;
        font-size: 0.95rem;
        color: var(--sec-text-main);
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        outline: none;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        transition: all 0.2s ease;
    }
    .sec-input:focus {
        border-color: #065f46;
        box-shadow: 0 0 0 3px rgba(6, 95, 70, 0.12);
    }
    .sec-input::placeholder {
        color: #94a3b8;
        font-weight: 400;
    }

    /* Floating Save Bar */
    .sec-action-bar {
        background: #ffffff;
        border: 1px solid var(--sec-border);
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.05);
        margin-top: 1rem;
    }
    .sec-save-btn {
        background: linear-gradient(135deg, #065f46 0%, #064e3b 100%);
        color: #ffffff;
        border: none;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.92rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(6, 95, 70, 0.3);
        transition: all 0.2s;
    }
    .sec-save-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(6, 95, 70, 0.4);
        background: linear-gradient(135deg, #047857 0%, #064e3b 100%);
    }

    /* Stats & Score Cards */
    .sec-score-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.3);
    }
    .sec-score-banner::before {
        content: '';
        position: absolute;
        right: -30px;
        bottom: -30px;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
        pointer-events: none;
    }
    .sec-score-ring {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 4px solid #10b981;
        box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        flex-shrink: 0;
    }
    .sec-score-ring.warn {
        border-color: #f59e0b;
        box-shadow: 0 0 20px rgba(245, 158, 11, 0.3);
    }

    .sec-metric-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }
    .sec-metric-card {
        background: #ffffff;
        border: 1px solid var(--sec-border);
        border-radius: 14px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .sec-metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px -2px rgba(0, 0, 0, 0.05);
    }
    .sec-metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .sec-metric-icon.green  { background: #ecfdf5; color: #065f46; }
    .sec-metric-icon.amber  { background: #fffbeb; color: #b45309; }
    .sec-metric-icon.red    { background: #fef2f2; color: #b91c1c; }
    .sec-metric-icon.sky    { background: #f0f9ff; color: #0369a1; }
    .sec-metric-val {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--sec-text-main);
        line-height: 1.1;
    }
    .sec-metric-lbl {
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--sec-text-muted);
        margin-top: 3px;
    }

    /* Modal Styling */
    .sec-modal-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 1050;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .sec-modal-backdrop.show { display: flex; }
    .sec-modal-card {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 620px;
        padding: 1.75rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        animation: secModalZoom 0.2s ease-out;
    }
    @keyframes secModalZoom {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">

    <!-- TOP HEADER -->
    <div class="sec-header">
        <div class="sec-header-left">
            <div class="sec-header-icon">
                <i data-feather="shield" style="width: 26px; height: 26px;"></i>
            </div>
            <div>
                <h1 class="sec-header-title">Security Center & Monitoring</h1>
                <p class="sec-header-desc">Pusat kendali pertahanan OWASP, audit jejak aktivitas, dan manajemen firewall aplikasi.</p>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <div class="sec-header-badge">
                <span class="pulse-dot"></span>
                <span>WAF & Firewall Aktif</span>
            </div>
        </div>
    </div>

    <!-- MODERN NAVIGATION TABS -->
    <div class="sec-nav-tabs">
        <a href="{{ route('admin.security.index', ['tab' => 'overview']) }}" class="sec-tab-btn {{ $tab === 'overview' ? 'active' : '' }}">
            <i data-feather="activity" style="width: 16px; height: 16px;"></i>
            <span>Ringkasan & Skor OWASP</span>
        </a>
        <a href="{{ route('admin.security.index', ['tab' => 'audit']) }}" class="sec-tab-btn {{ $tab === 'audit' ? 'active' : '' }}">
            <i data-feather="file-text" style="width: 16px; height: 16px;"></i>
            <span>Audit Logs (Jejak Admin)</span>
        </a>
        <a href="{{ route('admin.security.index', ['tab' => 'threats']) }}" class="sec-tab-btn {{ $tab === 'threats' ? 'active' : '' }}">
            <i data-feather="alert-octagon" style="width: 16px; height: 16px;"></i>
            <span>Threat Monitor & Blokir IP</span>
        </a>
        <a href="{{ route('admin.security.index', ['tab' => 'settings']) }}" class="sec-tab-btn {{ $tab === 'settings' ? 'active' : '' }}">
            <i data-feather="sliders" style="width: 16px; height: 16px;"></i>
            <span>Pengaturan & CAPTCHA</span>
        </a>
    </div>

    <!-- ========================================================
         TAB 1: OVERVIEW & POSTURE SCORE
         ======================================================== -->
    @if($tab === 'overview')
        @php
            $score = $healthScore['score'];
            $isHealthy = $score >= 80;
        @endphp

        <!-- Hero Score Banner -->
        <div class="sec-score-banner">
            <div style="max-width: 600px;">
                <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.1); padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #38bdf8; margin-bottom: 12px;">
                    <i data-feather="check-shield" style="width: 14px; height: 14px;"></i> OWASP Security Posture
                </div>
                <h2 style="font-size: 1.7rem; font-weight: 800; margin-bottom: 8px;">Skor Keamanan Sistem: {{ $score }}/100</h2>
                <p style="color: #94a3b8; font-size: 0.92rem; line-height: 1.6; margin: 0;">
                    @if($isHealthy)
                        Sistem dalam status <strong>Terlindungi Baik</strong>. Autentikasi terlindungi, Mini-WAF aktif mendeteksi SQLi/XSS, anti-brute force aktif, dan direktori uploads terkunci dari eksekusi script.
                    @else
                        Sistem memerlukan penyesuaian. Pastikan semua modul perlindungan aktif untuk meminimalkan potensi celah keamanan.
                    @endif
                </p>
            </div>
            <div class="sec-score-ring {{ $isHealthy ? '' : 'warn' }}">
                <span style="font-size: 2.3rem; font-weight: 900; line-height: 1; color: {{ $isHealthy ? '#34d399' : '#fbbf24' }};">{{ $score }}%</span>
                <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: #cbd5e1; margin-top: 4px;">Kesehatan</span>
            </div>
        </div>

        <!-- 4 Metrics Row -->
        <div class="sec-metric-grid">
            <div class="sec-metric-card">
                <div class="sec-metric-icon green"><i data-feather="user-check"></i></div>
                <div>
                    <div class="sec-metric-val">{{ $todaySuccessfulLogins }}</div>
                    <div class="sec-metric-lbl">Login Sukses Hari Ini</div>
                </div>
            </div>
            <div class="sec-metric-card">
                <div class="sec-metric-icon amber"><i data-feather="user-x"></i></div>
                <div>
                    <div class="sec-metric-val" style="color: #b45309;">{{ $todayFailedLogins }}</div>
                    <div class="sec-metric-lbl">Percobaan Gagal Hari Ini</div>
                </div>
            </div>
            <div class="sec-metric-card">
                <div class="sec-metric-icon red"><i data-feather="shield-off"></i></div>
                <div>
                    <div class="sec-metric-val" style="color: #b91c1c;">{{ $todayThreatsBlocked }}</div>
                    <div class="sec-metric-lbl">Ancaman Ditangkal Hari Ini</div>
                </div>
            </div>
            <div class="sec-metric-card">
                <div class="sec-metric-icon sky"><i data-feather="slash"></i></div>
                <div>
                    <div class="sec-metric-val" style="color: #0369a1;">{{ $totalBlockedIps }}</div>
                    <div class="sec-metric-lbl">Alamat IP Terblokir</div>
                </div>
            </div>
        </div>

        <!-- 2 Columns: Checklist & Recent Threats -->
        <div style="display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <!-- Checklist Card -->
            <div class="sec-card">
                <div class="sec-card-header">
                    <div class="sec-card-title-group">
                        <div class="sec-card-icon-badge emerald"><i data-feather="check-circle"></i></div>
                        <div>
                            <h3 class="sec-card-title">Indikator Kepatuhan OWASP</h3>
                            <p class="sec-card-desc">Status pemenuhan pilar keamanan standar industri.</p>
                        </div>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach($healthScore['checks'] as $c)
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
                            <div>
                                <div style="font-weight: 700; font-size: 0.88rem; color: #1e293b;">{{ $c['title'] }}</div>
                                <div style="font-size: 0.78rem; color: #64748b;">{{ $c['description'] }}</div>
                            </div>
                            <span class="badge {{ $c['passed'] ? 'badge-success' : 'badge-danger' }}" style="font-size: 0.72rem; padding: 4px 10px;">
                                {{ $c['passed'] ? 'Terpenuhi' : 'Perlu Atensi' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Threats Card -->
            <div class="sec-card">
                <div class="sec-card-header">
                    <div class="sec-card-title-group">
                        <div class="sec-card-icon-badge rose"><i data-feather="alert-triangle"></i></div>
                        <div>
                            <h3 class="sec-card-title">Ancaman Terkini</h3>
                            <p class="sec-card-desc">Percobaan serangan terakhir yang berhasil dicegat.</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.security.index', ['tab' => 'threats']) }}" style="font-size: 0.8rem; color: #065f46; font-weight: 700;">Lihat Semua &rarr;</a>
                </div>

                @if($recentThreats->isEmpty())
                    <div style="text-align: center; padding: 3rem 1rem; color: #94a3b8;">
                        <i data-feather="check-shield" style="width: 40px; height: 40px; color: #10b981; margin-bottom: 8px;"></i>
                        <p style="margin: 0; font-size: 0.88rem;">Belum ada aktivitas ancaman mencurigakan.</p>
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        @foreach($recentThreats as $t)
                            <div style="padding: 10px 12px; border-radius: 10px; border: 1px solid #fee2e2; background: #fff5f5;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                    <span style="font-size: 0.8rem; font-weight: 800; color: #b91c1c; text-transform: uppercase;">
                                        {{ str_replace('_', ' ', $t->threat_type) }}
                                    </span>
                                    <span style="font-size: 0.72rem; color: #64748b;">{{ $t->created_at->diffForHumans() }}</span>
                                </div>
                                <div style="font-family: monospace; font-size: 0.75rem; color: #334155; word-break: break-all;">
                                    {{ $t->ip_address }} &bull; {{ $t->method }} {{ Str::limit($t->url, 40) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Audit Activity Strip -->
        <div class="sec-card">
            <div class="sec-card-header">
                <div class="sec-card-title-group">
                    <div class="sec-card-icon-badge indigo"><i data-feather="file-text"></i></div>
                    <div>
                        <h3 class="sec-card-title">Jejak Aktivitas Admin Terkini</h3>
                        <p class="sec-card-desc">Riwayat perubahan data penting di CMS.</p>
                    </div>
                </div>
                <a href="{{ route('admin.security.index', ['tab' => 'audit']) }}" style="font-size: 0.8rem; color: #065f46; font-weight: 700;">Buka Riwayat Audit &rarr;</a>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e2e8f0; color: #64748b;">
                            <th style="padding: 10px;">Waktu</th>
                            <th style="padding: 10px;">Pengguna</th>
                            <th style="padding: 10px;">Modul</th>
                            <th style="padding: 10px;">Aksi</th>
                            <th style="padding: 10px;">Deskripsi</th>
                            <th style="padding: 10px;">Alamat IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentAudits as $a)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 10px; color: #64748b; white-space: nowrap;">{{ $a->created_at->format('d/m H:i') }}</td>
                                <td style="padding: 10px; font-weight: 700; color: #0f172a;">{{ $a->user_name }}</td>
                                <td style="padding: 10px;"><span class="badge" style="background:#f1f5f9; color:#334155;">{{ $a->module }}</span></td>
                                <td style="padding: 10px;">
                                    @if(in_array($a->action, ['created', 'login']))
                                        <span class="badge badge-success">{{ $a->action }}</span>
                                    @elseif($a->action === 'updated')
                                        <span class="badge badge-warning">{{ $a->action }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $a->action }}</span>
                                    @endif
                                </td>
                                <td style="padding: 10px;">{{ Str::limit($a->description, 60) }}</td>
                                <td style="padding: 10px; font-family: monospace; color: #0284c7; font-weight: 600;">{{ $a->ip_address }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- ========================================================
         TAB 2: AUDIT LOGS
         ======================================================== -->
    @if($tab === 'audit')
        <div class="sec-card">
            <div class="sec-card-header">
                <div class="sec-card-title-group">
                    <div class="sec-card-icon-badge indigo"><i data-feather="file-text"></i></div>
                    <div>
                        <h2 class="sec-card-title">Jejak Audit Aktivitas Administrator</h2>
                        <p class="sec-card-desc">Merekam riwayat perubahan data, aksi tambah, ubah, hapus, dan sesi login admin.</p>
                    </div>
                </div>
            </div>

            <!-- Filter Toolbar -->
            <form method="GET" action="{{ route('admin.security.index') }}" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 1.25rem; margin-bottom: 1.5rem; display: flex; gap: 16px; flex-wrap: wrap; align-items: flex-end; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                <input type="hidden" name="tab" value="audit">
                <div style="flex: 3; min-width: 220px;">
                    <label style="font-size: 0.75rem; font-weight: 700; color: #475569; display: block; margin-bottom: 6px; letter-spacing: 0.5px;">KATA KUNCI PENCARIAN</label>
                    <input type="text" name="search" class="sec-input" placeholder="Cari nama, aksi, atau alamat IP..." value="{{ request('search') }}">
                </div>
                <div style="flex: 1.5; min-width: 160px;">
                    <label style="font-size: 0.75rem; font-weight: 700; color: #475569; display: block; margin-bottom: 6px; letter-spacing: 0.5px;">FILTER MODUL</label>
                    <select name="module" class="sec-input" style="cursor: pointer;">
                        <option value="">Semua Modul</option>
                        @foreach(['auth', 'alumni', 'posts', 'pages', 'settings', 'teachers', 'security', 'media'] as $m)
                            <option value="{{ $m }}" {{ request('module') === $m ? 'selected' : '' }}>{{ ucfirst($m) }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="flex: 1.5; min-width: 160px;">
                    <label style="font-size: 0.75rem; font-weight: 700; color: #475569; display: block; margin-bottom: 6px; letter-spacing: 0.5px;">TIPE AKSI</label>
                    <select name="action_type" class="sec-input" style="cursor: pointer;">
                        <option value="">Semua Aksi</option>
                        <option value="login" {{ request('action_type') === 'login' ? 'selected' : '' }}>Login</option>
                        <option value="logout" {{ request('action_type') === 'logout' ? 'selected' : '' }}>Logout</option>
                        <option value="created" {{ request('action_type') === 'created' ? 'selected' : '' }}>Created</option>
                        <option value="updated" {{ request('action_type') === 'updated' ? 'selected' : '' }}>Updated</option>
                        <option value="deleted" {{ request('action_type') === 'deleted' ? 'selected' : '' }}>Deleted</option>
                        <option value="failed_login" {{ request('action_type') === 'failed_login' ? 'selected' : '' }}>Failed Login</option>
                    </select>
                </div>
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="sec-save-btn" style="padding: 10px 20px; font-size: 0.9rem; margin: 0; box-shadow: 0 2px 8px rgba(6, 95, 70, 0.25);">
                        <i data-feather="filter" style="width: 16px; height: 16px;"></i> Filter
                    </button>
                    <a href="{{ route('admin.security.index', ['tab' => 'audit']) }}" style="background: #e2e8f0; color: #475569; padding: 10px 16px; font-size: 0.9rem; font-weight: 700; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;">Reset</a>
                </div>
            </form>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e2e8f0; background: #f8fafc; color: #64748b;">
                            <th style="padding: 12px 10px;">Waktu</th>
                            <th style="padding: 12px 10px;">Pengguna</th>
                            <th style="padding: 12px 10px;">Modul</th>
                            <th style="padding: 12px 10px;">Aksi</th>
                            <th style="padding: 12px 10px;">Deskripsi</th>
                            <th style="padding: 12px 10px;">Alamat IP</th>
                            <th style="padding: 12px 10px; text-align: center;">Perubahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auditLogs as $log)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 10px; color: #64748b; font-size: 0.8rem; white-space: nowrap;">
                                    {{ $log->created_at->format('d M Y') }}<br>
                                    <strong style="color: #0f172a;">{{ $log->created_at->format('H:i:s') }}</strong>
                                </td>
                                <td style="padding: 10px;">
                                    <div style="font-weight: 700; color: #0f172a;">{{ $log->user_name }}</div>
                                    @if($log->user)
                                        <div style="font-size: 0.75rem; color: #64748b;">{{ $log->user->email }} ({{ $log->user->role }})</div>
                                    @endif
                                </td>
                                <td style="padding: 10px;">
                                    <span class="badge" style="background:#e2e8f0; color:#1e293b;">{{ $log->module }}</span>
                                </td>
                                <td style="padding: 10px;">
                                    @if(in_array($log->action, ['created', 'login']))
                                        <span class="badge badge-success">{{ $log->action }}</span>
                                    @elseif($log->action === 'updated')
                                        <span class="badge badge-warning">{{ $log->action }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $log->action }}</span>
                                    @endif
                                </td>
                                <td style="padding: 10px; color: #334155;">
                                    {{ $log->description }}
                                    @if($log->target_id)
                                        <span style="font-size: 0.75rem; color: #64748b;">(ID: {{ $log->target_id }})</span>
                                    @endif
                                </td>
                                <td style="padding: 10px; font-size: 0.8rem; font-family: monospace; font-weight: 700; color: #0284c7;">
                                    {{ $log->ip_address }}
                                </td>
                                <td style="padding: 10px; text-align: center;">
                                    @if($log->old_values || $log->new_values)
                                        <button type="button" class="btn-icon" style="background: #ecfdf5; color: #065f46;" onclick='showAuditDetail(@json($log))' title="Lihat Diff Data">
                                            <i data-feather="eye" style="width: 16px; height: 16px;"></i>
                                        </button>
                                    @else
                                        <span style="color: #cbd5e1;">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 3rem 1rem; color: #94a3b8;">
                                    <i data-feather="file-text" style="width: 42px; height: 42px; opacity: 0.3; margin-bottom: 8px;"></i>
                                    <p>Tidak ada riwayat audit yang sesuai filter.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 1.5rem;">
                {{ $auditLogs->links() }}
            </div>
        </div>
    @endif

    <!-- ========================================================
         TAB 3: THREATS & IP RULES
         ======================================================== -->
    @if($tab === 'threats')
        <div class="sec-card">
            <div class="sec-card-header">
                <div class="sec-card-title-group">
                    <div class="sec-card-icon-badge rose"><i data-feather="slash"></i></div>
                    <div>
                        <h2 class="sec-card-title">Daftar Aturan IP (Blacklist & Whitelist)</h2>
                        <p class="sec-card-desc">Kelola alamat IP yang dilarang mengakses sistem atau yang selalu diizinkan.</p>
                    </div>
                </div>
                <div style="display: flex; gap: 10px;">
                    <form action="{{ route('admin.security.ip.clearAutoBan') }}" method="POST" onsubmit="return confirm('Hapus semua IP yang diblokir otomatis oleh sistem?');" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn" style="background:#fff7ed; color:#c2410c; border: 1px solid #fed7aa;">
                            <i data-feather="refresh-cw"></i> Bersihkan Auto-Ban
                        </button>
                    </form>
                    <button type="button" class="btn btn-primary" onclick="openIpModal()">
                        <i data-feather="plus"></i> Tambah Aturan IP
                    </button>
                </div>
            </div>

            @if($ipRules->isEmpty())
                <div style="text-align: center; padding: 2rem; background: #f8fafc; border-radius: 12px; color: #64748b; font-size: 0.88rem;">
                    Belum ada aturan IP aktif di sistem.
                </div>
            @else
                <div style="overflow-x: auto; margin-bottom: 2rem;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e2e8f0; color: #64748b;">
                                <th style="padding: 10px;">Alamat IP</th>
                                <th style="padding: 10px;">Tipe Aturan</th>
                                <th style="padding: 10px;">Alasan</th>
                                <th style="padding: 10px;">Kadaluarsa</th>
                                <th style="padding: 10px;">Dibuat Oleh</th>
                                <th style="padding: 10px; text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ipRules as $r)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 10px; font-family: monospace; font-weight: 700; color: #0f172a;">{{ $r->ip_address }}</td>
                                    <td style="padding: 10px;">
                                        @if($r->rule_type === 'blacklist')
                                            <span class="badge badge-danger">Blacklist (Blokir)</span>
                                        @else
                                            <span class="badge badge-success">Whitelist (Izinkan)</span>
                                        @endif
                                    </td>
                                    <td style="padding: 10px; color: #334155;">{{ $r->reason ?? '-' }}</td>
                                    <td style="padding: 10px;">
                                        @if($r->expires_at)
                                            {{ $r->expires_at->format('d/m/Y H:i') }}
                                        @else
                                            <span style="color: #065f46; font-weight: 700;">Permanen</span>
                                        @endif
                                    </td>
                                    <td style="padding: 10px; color: #64748b;">{{ $r->creator?->name ?? 'Sistem Otomatis' }}</td>
                                    <td style="padding: 10px; text-align: right;">
                                        <form action="{{ route('admin.security.ip.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus aturan IP ini?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon btn-delete" title="Buka Blokir">
                                                <i data-feather="trash-2" style="width: 15px; height: 15px;"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Threat Logs Table -->
            <div style="border-top: 1px dashed #cbd5e1; padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h3 style="font-size: 1.05rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px; margin: 0;">
                    <i data-feather="alert-octagon" style="color: #ef4444; width: 18px; height: 18px;"></i> Log Percobaan Serangan Real-time
                </h3>
                <form action="{{ route('admin.security.threats.clear') }}" method="POST" onsubmit="return confirm('Kosongkan semua riwayat log ancaman?');" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn" style="background:#fee2e2; color:#b91c1c; padding: 6px 12px; font-size: 0.8rem; display: flex; align-items: center; gap: 5px;">
                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i> Bersihkan Log Serangan
                    </button>
                </form>
            </div>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e2e8f0; background: #f8fafc; color: #64748b;">
                                <th style="padding: 10px;">Waktu</th>
                                <th style="padding: 10px;">Tipe Serangan</th>
                                <th style="padding: 10px;">Tingkat</th>
                                <th style="padding: 10px;">IP Address</th>
                                <th style="padding: 10px;">Request</th>
                                <th style="padding: 10px;">Cuplikan Payload</th>
                                <th style="padding: 10px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($threatLogs as $t)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 10px; color: #64748b; font-size: 0.78rem; white-space: nowrap;">
                                        {{ $t->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td style="padding: 10px; font-weight: 800; text-transform: uppercase;">
                                        {{ str_replace('_', ' ', $t->threat_type) }}
                                    </td>
                                    <td style="padding: 10px;">
                                        @if($t->severity === 'critical')
                                            <span class="badge badge-danger">Critical</span>
                                        @elseif($t->severity === 'high')
                                            <span class="badge" style="background:#fee2e2; color:#b91c1c;">High</span>
                                        @else
                                            <span class="badge badge-warning">Medium</span>
                                        @endif
                                    </td>
                                    <td style="padding: 10px; font-family: monospace; font-weight: 700; color: #0284c7;">
                                        {{ $t->ip_address }}
                                    </td>
                                    <td style="padding: 10px; font-size: 0.8rem;">
                                        <span style="font-weight: 700;">{{ $t->method }}</span>
                                        <span style="color: #64748b;">{{ Str::limit($t->url, 40) }}</span>
                                    </td>
                                    <td style="padding: 10px; font-size: 0.75rem; color: #475569; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $t->payload ?? '-' }}
                                    </td>
                                    <td style="padding: 10px;">
                                        <span class="badge {{ $t->is_blocked ? 'badge-danger' : 'badge-warning' }}">
                                            {{ $t->is_blocked ? 'Diblokir (403)' : 'Tercatat' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 3rem 1rem; color: #94a3b8;">
                                        <i data-feather="check-shield" style="width: 42px; height: 42px; opacity: 0.3; margin-bottom: 8px;"></i>
                                        <p>Tidak ada riwayat ancaman yang tercatat.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 1.5rem;">
                    {{ $threatLogs->links() }}
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================
         TAB 4: SETTINGS (REDESIGNED FOR WORLD-CLASS UX)
         ======================================================== -->
    @if($tab === 'settings')
        <form action="{{ route('admin.security.settings.update') }}" method="POST">
            @csrf

            <!-- 1. CAPTCHA & ANTI-SPAM SECTION -->
            <div class="sec-card">
                <div class="sec-card-header">
                    <div class="sec-card-title-group">
                        <div class="sec-card-icon-badge emerald"><i data-feather="shield-check"></i></div>
                        <div>
                            <h3 class="sec-card-title">Proteksi CAPTCHA & Anti-Spam Bot</h3>
                            <p class="sec-card-desc">Cegah pendaftaran spam, bot flooding, dan automated brute-force pada formulir.</p>
                        </div>
                    </div>
                </div>

                <!-- Global Toggle Row -->
                <div class="sec-toggle-row">
                    <div>
                        <span class="sec-toggle-label-title">Aktifkan Proteksi CAPTCHA Secara Global</span>
                        <span class="sec-toggle-label-sub">Master switch untuk mengaktifkan perlindungan CAPTCHA pada seluruh sistem website.</span>
                    </div>
                    <label class="ios-switch">
                        <input type="hidden" name="security_captcha_enabled" value="0">
                        <input type="checkbox" name="security_captcha_enabled" value="1" {{ ($settings['security_captcha_enabled'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="ios-slider"></span>
                    </label>
                </div>

                <!-- Provider Selection Cards (Radio Cards) -->
                <label style="font-size: 0.88rem; font-weight: 700; color: #1e293b; display: block; margin-bottom: 8px;">Pilih Penyedia Layanan CAPTCHA:</label>
                <input type="hidden" name="security_captcha_provider" id="activeCaptchaProvider" value="{{ $settings['security_captcha_provider'] ?? 'builtin' }}">

                <div class="sec-provider-grid">
                    <!-- Option 1: Built-in Math -->
                    <div class="sec-provider-card {{ ($settings['security_captcha_provider'] ?? 'builtin') === 'builtin' ? 'selected' : '' }}" onclick="selectProvider('builtin')" id="provider-card-builtin">
                        <div class="sec-provider-card-top">
                            <div class="sec-provider-icon builtin"><i data-feather="hash"></i></div>
                            <span class="sec-provider-pill badge-ready">Siap Pakai</span>
                        </div>
                        <div class="sec-provider-name">Built-in Math CAPTCHA</div>
                        <p class="sec-provider-desc">Bawaan internal CMS tanpa perlu API key pihak ketiga. Siap pakai secara instan.</p>
                    </div>

                    <!-- Option 2: Cloudflare Turnstile -->
                    <div class="sec-provider-card {{ ($settings['security_captcha_provider'] ?? '') === 'turnstile' ? 'selected' : '' }}" onclick="selectProvider('turnstile')" id="provider-card-turnstile">
                        <div class="sec-provider-card-top">
                            <div class="sec-provider-icon turnstile"><i data-feather="cloud"></i></div>
                            <span class="sec-provider-pill badge-rec">Rekomendasi</span>
                        </div>
                        <div class="sec-provider-name">Cloudflare Turnstile</div>
                        <p class="sec-provider-desc">Sangat cepat, ramah privasi, dan tanpa puzzle yang menyulitkan pengunjung.</p>
                    </div>

                    <!-- Option 3: Google reCAPTCHA -->
                    <div class="sec-provider-card {{ ($settings['security_captcha_provider'] ?? '') === 'recaptcha' ? 'selected' : '' }}" onclick="selectProvider('recaptcha')" id="provider-card-recaptcha">
                        <div class="sec-provider-card-top">
                            <div class="sec-provider-icon recaptcha"><i data-feather="check-square"></i></div>
                            <span class="sec-provider-pill badge-pop">Populer</span>
                        </div>
                        <div class="sec-provider-name">Google reCAPTCHA</div>
                        <p class="sec-provider-desc">Standar industri Google reCAPTCHA v2 checkbox atau v3 invisible score.</p>
                    </div>
                </div>

                <!-- Turnstile API Keys Panel -->
                <div id="turnstileConfig" style="display: {{ ($settings['security_captcha_provider'] ?? '') === 'turnstile' ? 'block' : 'none' }}; background: linear-gradient(145deg, #fffbeb, #fef3c7); border: 1px solid #fde68a; border-radius: 14px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: inset 0 2px 4px rgba(255,255,255,0.4);">
                    <div style="font-weight: 800; font-size: 0.95rem; color: #92400e; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                        <div style="background: #f59e0b; color: white; width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center;"><i data-feather="key" style="width: 14px; height: 14px;"></i></div> 
                        Kredensial Cloudflare Turnstile
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="font-size: 0.8rem; font-weight: 700; color: #78350f; display: block; margin-bottom: 6px;">Site Key</label>
                            <input type="text" name="security_turnstile_site_key" class="sec-input" style="border-color: #fcd34d;" value="{{ $settings['security_turnstile_site_key'] ?? '' }}" placeholder="0x4AAAAAA...">
                        </div>
                        <div>
                            <label style="font-size: 0.8rem; font-weight: 700; color: #78350f; display: block; margin-bottom: 6px;">Secret Key</label>
                            <input type="password" name="security_turnstile_secret_key" class="sec-input" style="border-color: #fcd34d;" value="{{ $settings['security_turnstile_secret_key'] ?? '' }}" placeholder="0x4AAAAAA...">
                        </div>
                    </div>
                </div>

                <!-- Google reCAPTCHA Keys Panel -->
                <div id="recaptchaConfig" style="display: {{ ($settings['security_captcha_provider'] ?? '') === 'recaptcha' ? 'block' : 'none' }}; background: linear-gradient(145deg, #eff6ff, #dbeafe); border: 1px solid #bfdbfe; border-radius: 14px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: inset 0 2px 4px rgba(255,255,255,0.4);">
                    <div style="font-weight: 800; font-size: 0.95rem; color: #1e40af; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                        <div style="background: #3b82f6; color: white; width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center;"><i data-feather="key" style="width: 14px; height: 14px;"></i></div>
                        Kredensial Google reCAPTCHA
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="font-size: 0.8rem; font-weight: 700; color: #1e3a8a; display: block; margin-bottom: 6px;">Site Key</label>
                            <input type="text" name="security_recaptcha_site_key" class="sec-input" style="border-color: #93c5fd;" value="{{ $settings['security_recaptcha_site_key'] ?? '' }}" placeholder="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI">
                        </div>
                        <div>
                            <label style="font-size: 0.8rem; font-weight: 700; color: #1e3a8a; display: block; margin-bottom: 6px;">Secret Key</label>
                            <input type="password" name="security_recaptcha_secret_key" class="sec-input" style="border-color: #93c5fd;" value="{{ $settings['security_recaptcha_secret_key'] ?? '' }}" placeholder="6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe">
                        </div>
                    </div>
                </div>

                <!-- Target Form Checkboxes as Interactive Cards -->
                <label style="font-size: 0.88rem; font-weight: 700; color: #1e293b; display: block; margin-bottom: 4px;">Terapkan CAPTCHA Pada Formulir Berikut:</label>
                <div class="sec-targets-grid">
                    <!-- Login Admin -->
                    <label class="sec-target-checkbox-card {{ ($settings['security_captcha_login'] ?? '1') == '1' ? 'checked' : '' }}">
                        <input type="hidden" name="security_captcha_login" value="0">
                        <input type="checkbox" name="security_captcha_login" value="1" {{ ($settings['security_captcha_login'] ?? '1') == '1' ? 'checked' : '' }} style="display:none;" onchange="toggleTargetCard(this)">
                        <div class="sec-target-custom-box"><i data-feather="check" style="width: 14px; height: 14px;"></i></div>
                        <div>
                            <div class="sec-target-title">Login Admin</div>
                            <span style="font-size: 0.72rem; color: #64748b;">Portal Administrator</span>
                        </div>
                    </label>

                    <!-- Buku Tamu -->
                    <label class="sec-target-checkbox-card {{ ($settings['security_captcha_guestbook'] ?? '1') == '1' ? 'checked' : '' }}">
                        <input type="hidden" name="security_captcha_guestbook" value="0">
                        <input type="checkbox" name="security_captcha_guestbook" value="1" {{ ($settings['security_captcha_guestbook'] ?? '1') == '1' ? 'checked' : '' }} style="display:none;" onchange="toggleTargetCard(this)">
                        <div class="sec-target-custom-box"><i data-feather="check" style="width: 14px; height: 14px;"></i></div>
                        <div>
                            <div class="sec-target-title">Buku Tamu</div>
                            <span style="font-size: 0.72rem; color: #64748b;">Kunjungan Publik</span>
                        </div>
                    </label>

                    <!-- Komentar Berita -->
                    <label class="sec-target-checkbox-card {{ ($settings['security_captcha_comments'] ?? '1') == '1' ? 'checked' : '' }}">
                        <input type="hidden" name="security_captcha_comments" value="0">
                        <input type="checkbox" name="security_captcha_comments" value="1" {{ ($settings['security_captcha_comments'] ?? '1') == '1' ? 'checked' : '' }} style="display:none;" onchange="toggleTargetCard(this)">
                        <div class="sec-target-custom-box"><i data-feather="check" style="width: 14px; height: 14px;"></i></div>
                        <div>
                            <div class="sec-target-title">Komentar Berita</div>
                            <span style="font-size: 0.72rem; color: #64748b;">Interaksi Pembaca</span>
                        </div>
                    </label>

                    <!-- Formulir Dinamis -->
                    <label class="sec-target-checkbox-card {{ ($settings['security_captcha_forms'] ?? '1') == '1' ? 'checked' : '' }}">
                        <input type="hidden" name="security_captcha_forms" value="0">
                        <input type="checkbox" name="security_captcha_forms" value="1" {{ ($settings['security_captcha_forms'] ?? '1') == '1' ? 'checked' : '' }} style="display:none;" onchange="toggleTargetCard(this)">
                        <div class="sec-target-custom-box"><i data-feather="check" style="width: 14px; height: 14px;"></i></div>
                        <div>
                            <div class="sec-target-title">Formulir PPDB</div>
                            <span style="font-size: 0.72rem; color: #64748b;">Pendaftaran & Survei</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- 2. BRUTE FORCE LOCKOUT SECTION -->
            <div class="sec-card">
                <div class="sec-card-header">
                    <div class="sec-card-title-group">
                        <div class="sec-card-icon-badge amber"><i data-feather="lock"></i></div>
                        <div>
                            <h3 class="sec-card-title">Proteksi Brute-Force Login Admin</h3>
                            <p class="sec-card-desc">Cegah upaya peretasan kata sandi administrator secara berulang.</p>
                        </div>
                    </div>
                </div>

                <div class="sec-toggle-row">
                    <div>
                        <span class="sec-toggle-label-title">Aktifkan Pembekuan Akun Brute-Force</span>
                        <span class="sec-toggle-label-sub">Secara otomatis mengunci akses login jika terjadi kegagalan sandi berulang kali.</span>
                    </div>
                    <label class="ios-switch">
                        <input type="hidden" name="security_login_lockout_enabled" value="0">
                        <input type="checkbox" name="security_login_lockout_enabled" value="1" {{ ($settings['security_login_lockout_enabled'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="ios-slider"></span>
                    </label>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <label style="font-size: 0.82rem; font-weight: 700; color: #334155; display: block; margin-bottom: 6px;">Batas Maksimal Percobaan Gagal</label>
                        <div class="sec-input-addon-group">
                            <input type="number" name="security_login_max_attempts" class="sec-input-addon-field" value="{{ $settings['security_login_max_attempts'] ?? '5' }}" min="3" max="20">
                            <span class="sec-input-addon-suffix">Kali Percobaan</span>
                        </div>
                        <span style="font-size: 0.75rem; color: #64748b; margin-top: 4px; display: block;">Rekomendasi: 5 kali berturut-turut.</span>
                    </div>
                    <div>
                        <label style="font-size: 0.82rem; font-weight: 700; color: #334155; display: block; margin-bottom: 6px;">Durasi Pembekuan Login</label>
                        <div class="sec-input-addon-group">
                            <input type="number" name="security_login_lockout_duration" class="sec-input-addon-field" value="{{ $settings['security_login_lockout_duration'] ?? '15' }}" min="5" max="1440">
                            <span class="sec-input-addon-suffix">Menit Terkunci</span>
                        </div>
                        <span style="font-size: 0.75rem; color: #64748b; margin-top: 4px; display: block;">Lama IP/akun dibekukan sementara.</span>
                    </div>
                </div>
            </div>

            <!-- 3. MINI-WAF & AUTO-BAN SECTION -->
            <div class="sec-card">
                <div class="sec-card-header">
                    <div class="sec-card-title-group">
                        <div class="sec-card-icon-badge indigo"><i data-feather="cpu"></i></div>
                        <div>
                            <h3 class="sec-card-title">Mini-WAF & Auto-Ban IP Otomatis</h3>
                            <p class="sec-card-desc">Pemindai real-time untuk mendeteksi injeksi SQL, script XSS, dan pemindaian direktori sensitif (.env / wp-admin).</p>
                        </div>
                    </div>
                </div>

                <div class="sec-toggle-row">
                    <div>
                        <span class="sec-toggle-label-title">Aktifkan Mini-WAF (Deteksi & Blokir Serangan Otomatis)</span>
                        <span class="sec-toggle-label-sub">Mencegat request berbahaya pada URI & parameter input sebelum dieksekusi database.</span>
                    </div>
                    <label class="ios-switch">
                        <input type="hidden" name="security_waf_enabled" value="0">
                        <input type="checkbox" name="security_waf_enabled" value="1" {{ ($settings['security_waf_enabled'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="ios-slider"></span>
                    </label>
                </div>

                <div class="sec-toggle-row">
                    <div>
                        <span class="sec-toggle-label-title">Auto-Ban IP Jika Terdeteksi Ancaman Berulang</span>
                        <span class="sec-toggle-label-sub">Otomatis memasukkan IP penyerang ke daftar Blacklist jika melanggar ambang batas.</span>
                    </div>
                    <label class="ios-switch">
                        <input type="hidden" name="security_auto_ban_enabled" value="0">
                        <input type="checkbox" name="security_auto_ban_enabled" value="1" {{ ($settings['security_auto_ban_enabled'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="ios-slider"></span>
                    </label>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <label style="font-size: 0.82rem; font-weight: 700; color: #334155; display: block; margin-bottom: 6px;">Ambang Batas Pelanggaran</label>
                        <div class="sec-input-addon-group">
                            <input type="number" name="security_auto_ban_threshold" class="sec-input-addon-field" value="{{ $settings['security_auto_ban_threshold'] ?? '5' }}" min="3" max="50">
                            <span class="sec-input-addon-suffix">Pelanggaran / Jam</span>
                        </div>
                    </div>
                    <div>
                        <label style="font-size: 0.82rem; font-weight: 700; color: #334155; display: block; margin-bottom: 6px;">Durasi Blokir IP Otomatis</label>
                        <div class="sec-input-addon-group">
                            <input type="number" name="security_auto_ban_duration" class="sec-input-addon-field" value="{{ $settings['security_auto_ban_duration'] ?? '60' }}" min="5" max="10080">
                            <span class="sec-input-addon-suffix">Menit Diblokir</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. OWASP HEADERS SECTION -->
            <div class="sec-card">
                <div class="sec-card-header">
                    <div class="sec-card-title-group">
                        <div class="sec-card-icon-badge teal"><i data-feather="globe"></i></div>
                        <div>
                            <h3 class="sec-card-title">OWASP HTTP Security Headers</h3>
                            <p class="sec-card-desc">Sertakan header keamanan standar industri pada seluruh respon website sekolah.</p>
                        </div>
                    </div>
                </div>

                <div class="sec-toggle-row" style="margin-bottom: 1rem;">
                    <div>
                        <span class="sec-toggle-label-title">Aktifkan OWASP HTTP Headers</span>
                        <span class="sec-toggle-label-sub">Melindungi dari clickjacking (iframe embedding), MIME sniffing, dan kebocoran referrer.</span>
                    </div>
                    <label class="ios-switch">
                        <input type="hidden" name="security_headers_enabled" value="0">
                        <input type="checkbox" name="security_headers_enabled" value="1" {{ ($settings['security_headers_enabled'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span class="ios-slider"></span>
                    </label>
                </div>

                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    <span class="badge" style="background:#f1f5f9; color:#475569; padding: 6px 12px; font-family: monospace;">X-Frame-Options: SAMEORIGIN</span>
                    <span class="badge" style="background:#f1f5f9; color:#475569; padding: 6px 12px; font-family: monospace;">X-Content-Type-Options: nosniff</span>
                    <span class="badge" style="background:#f1f5f9; color:#475569; padding: 6px 12px; font-family: monospace;">Referrer-Policy: strict-origin</span>
                    <span class="badge" style="background:#f1f5f9; color:#475569; padding: 6px 12px; font-family: monospace;">Permissions-Policy: camera=(), mic=()</span>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="sec-action-bar">
                <span style="font-size: 0.85rem; color: #64748b;">
                    <i data-feather="info" style="width: 14px; height: 14px; vertical-align: middle;"></i>
                    Setiap perubahan konfigurasi akan langsung tercatat di <strong>Audit Logs</strong>.
                </span>
                <button type="submit" class="sec-save-btn">
                    <i data-feather="save" style="width: 18px; height: 18px;"></i> Simpan Konfigurasi Keamanan
                </button>
            </div>
        </form>
    @endif

</div>

<!-- ========================================================
     MODALS
     ======================================================== -->
<!-- Modal Add IP -->
<div id="secIpModal" class="sec-modal-backdrop">
    <div class="sec-modal-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.75rem;">
            <h3 style="font-size: 1.15rem; font-weight: 800; margin: 0; color: #0f172a;">Tambah Aturan Alamat IP</h3>
            <button type="button" class="btn-icon" onclick="closeIpModal()"><i data-feather="x"></i></button>
        </div>
        <form action="{{ route('admin.security.ip.store') }}" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label" style="font-weight: 700;">Alamat IP <span style="color:red;">*</span></label>
                <input type="text" name="ip_address" class="form-control" required placeholder="Contoh: 192.168.1.100 atau 2001:db8::1">
            </div>
            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label" style="font-weight: 700;">Tipe Tindakan</label>
                <select name="rule_type" class="form-control">
                    <option value="blacklist">Blacklist (Blokir Akses ke Website)</option>
                    <option value="whitelist">Whitelist (Selalu Izinkan / Bebaskan dari Firewall)</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label" style="font-weight: 700;">Alasan / Keterangan</label>
                <input type="text" name="reason" class="form-control" placeholder="Contoh: Spam bot berulang pada formulir">
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="font-weight: 700;">Durasi Blokir (Menit)</label>
                <input type="number" name="duration_minutes" class="form-control" placeholder="Kosongkan jika ingin diblokir permanen">
                <span class="form-text">Biarkan kosong untuk pemblokiran permanen tanpa batas waktu.</span>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn" style="background: #e2e8f0; color: #475569;" onclick="closeIpModal()">Batal</button>
                <button type="submit" class="sec-save-btn" style="padding: 10px 22px;">Simpan Aturan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Audit Detail -->
<div id="secAuditModal" class="sec-modal-backdrop">
    <div class="sec-modal-card" style="max-width: 720px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.75rem;">
            <h3 style="font-size: 1.15rem; font-weight: 800; margin: 0; color: #0f172a;" id="auditDetailTitle">Detail Perubahan Data</h3>
            <button type="button" class="btn-icon" onclick="closeAuditModal()"><i data-feather="x"></i></button>
        </div>
        <div id="auditDetailMeta" style="font-size: 0.85rem; color: #64748b; margin-bottom: 1rem;"></div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <strong style="font-size: 0.8rem; color: #b91c1c; display: block; margin-bottom: 6px; text-transform: uppercase;">Data Lama (Old):</strong>
                <pre id="auditOldValues" style="background: #0f172a; color: #e2e8f0; padding: 12px; border-radius: 10px; font-family: monospace; font-size: 0.75rem; max-height: 250px; overflow-y: auto; white-space: pre-wrap;"></pre>
            </div>
            <div>
                <strong style="font-size: 0.8rem; color: #15803d; display: block; margin-bottom: 6px; text-transform: uppercase;">Data Baru (New):</strong>
                <pre id="auditNewValues" style="background: #0f172a; color: #e2e8f0; padding: 12px; border-radius: 10px; font-family: monospace; font-size: 0.75rem; max-height: 250px; overflow-y: auto; white-space: pre-wrap;"></pre>
            </div>
        </div>
        <div style="display: flex; justify-content: flex-end; margin-top: 1.25rem;">
            <button type="button" class="btn" style="background: #e2e8f0; color: #475569;" onclick="closeAuditModal()">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Provider Card Selection
    function selectProvider(provider) {
        document.getElementById('activeCaptchaProvider').value = provider;
        
        document.querySelectorAll('.sec-provider-card').forEach(c => c.classList.remove('selected'));
        const activeCard = document.getElementById('provider-card-' + provider);
        if (activeCard) activeCard.classList.add('selected');

        const turnstileConfig = document.getElementById('turnstileConfig');
        const recaptchaConfig = document.getElementById('recaptchaConfig');
        
        if (turnstileConfig) turnstileConfig.style.display = provider === 'turnstile' ? 'block' : 'none';
        if (recaptchaConfig) recaptchaConfig.style.display = provider === 'recaptcha' ? 'block' : 'none';
    }

    // Toggle Checkbox Cards for Forms
    function toggleTargetCard(input) {
        const card = input.closest('.sec-target-checkbox-card');
        if (card) {
            if (input.checked) {
                card.classList.add('checked');
            } else {
                card.classList.remove('checked');
            }
        }
    }

    // Modal Helpers
    function openIpModal() {
        document.getElementById('secIpModal').classList.add('show');
    }
    function closeIpModal() {
        document.getElementById('secIpModal').classList.remove('show');
    }

    function showAuditDetail(log) {
        document.getElementById('auditDetailTitle').innerText = 'Audit ID #' + log.id + ' - ' + log.module.toUpperCase() + ' (' + log.action + ')';
        document.getElementById('auditDetailMeta').innerHTML = 'Oleh: <strong>' + log.user_name + '</strong> &bull; IP: ' + log.ip_address + ' &bull; ' + log.created_at;
        document.getElementById('auditOldValues').innerText = log.old_values ? JSON.stringify(log.old_values, null, 2) : 'Tidak ada data lama';
        document.getElementById('auditNewValues').innerText = log.new_values ? JSON.stringify(log.new_values, null, 2) : 'Tidak ada data baru';
        document.getElementById('secAuditModal').classList.add('show');
    }
    function closeAuditModal() {
        document.getElementById('secAuditModal').classList.remove('show');
    }

    window.onclick = function(e) {
        const ipM = document.getElementById('secIpModal');
        const auditM = document.getElementById('secAuditModal');
        if (e.target === ipM) closeIpModal();
        if (e.target === auditM) closeAuditModal();
    }
</script>
@endpush
