@extends('admin.layouts.app')

@section('title', 'Buku Tamu - Al Irsyad')

@push('styles')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --bt-primary: #006837;
            --bt-primary-dark: #022c19;
            --bt-primary-light: #ecfdf5;
            --bt-accent: #FBB03B;
            --bt-accent-hover: #f59e0b;
            --bt-border: #e2e8f0;
            --bt-border-light: #f1f5f9;
            --bt-text-dark: #0f172a;
            --bt-text-muted: #64748b;
            --bt-bg-soft: #f8fafc;
            --bt-radius: 14px;
            --bt-radius-sm: 10px;
        }

        /* Top Bar Banner */
        .bt-topbar {
            background: linear-gradient(135deg, #022c19 0%, #004d28 60%, #006837 100%);
            border-radius: 18px;
            padding: 1.5rem 1.75rem;
            color: #ffffff;
            margin-bottom: 1.75rem;
            box-shadow: 0 10px 25px -5px rgba(2, 44, 25, 0.25);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.25rem;
        }

        .bt-title-area h2 {
            font-size: 1.45rem;
            font-weight: 800;
            margin: 0 0 0.35rem 0;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.02em;
            color: #ffffff;
        }

        .bt-badge {
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

        .bt-url-box {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 12px;
            padding: 6px 6px 6px 14px;
            gap: 10px;
        }

        .bt-url-text {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.85rem;
            color: #f1f5f9;
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
            transition: all 0.2s ease;
        }
        .btn-copy-link:hover {
            background: #f59e0b;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
        }

        .btn-visit {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-visit:hover {
            background: rgba(255, 255, 255, 0.25);
            color: #fff;
            transform: translateY(-1px);
        }

        /* Stat KPI Cards */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
            margin-bottom: 1.75rem;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid var(--bt-border);
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.06);
        }

        .stat-info h4 {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--bt-text-muted);
            margin: 0 0 0.4rem 0;
            letter-spacing: 0.05em;
        }

        .stat-info .stat-value {
            font-size: 1.85rem;
            font-weight: 800;
            line-height: 1;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        /* Tabs Navigation */
        .bt-tabs {
            display: flex;
            background: #ffffff;
            padding: 6px;
            border-radius: 16px;
            border: 1px solid var(--bt-border);
            margin-bottom: 1.75rem;
            gap: 8px;
            overflow-x: auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
        }

        .bt-tab-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 12px;
            border: none;
            background: transparent;
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--bt-text-muted);
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .bt-tab-btn.active {
            background: var(--bt-primary);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(0, 104, 55, 0.25);
        }

        .bt-tab-btn:not(.active):hover {
            background: #f1f5f9;
            color: var(--bt-text-dark);
        }

        /* Generic Card Box */
        .card-box {
            background: #ffffff;
            border: 1px solid var(--bt-border);
            border-radius: 18px;
            padding: 1.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            margin-bottom: 1.75rem;
        }

        .card-box-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .card-box-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--bt-text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-box-subtitle {
            font-size: 0.82rem;
            color: var(--bt-text-muted);
            margin: 0.25rem 0 0 0;
        }

        /* Settings Card Sections */
        .settings-section-card {
            background: #ffffff;
            border: 1px solid var(--bt-border);
            border-radius: 18px;
            padding: 1.75rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
            transition: border-color 0.2s ease;
        }
        .settings-section-card:hover {
            border-color: #cbd5e1;
        }

        .settings-header {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid var(--bt-border-light);
        }

        .settings-header-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            flex-shrink: 0;
        }

        .settings-header-text h4 {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--bt-text-dark);
            margin: 0 0 0.25rem 0;
        }

        .settings-header-text p {
            font-size: 0.8rem;
            color: var(--bt-text-muted);
            margin: 0;
            line-height: 1.4;
        }

        /* Form Controls */
        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }
        @media (max-width: 768px) {
            .form-grid-2 {
                grid-template-columns: 1fr;
            }
        }

        .form-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }
        @media (max-width: 768px) {
            .form-grid-3 {
                grid-template-columns: 1fr;
            }
        }

        .bt-form-group {
            margin-bottom: 1.25rem;
        }
        .bt-form-group:last-child {
            margin-bottom: 0;
        }

        .bt-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 0.5rem;
        }

        .bt-input, .bt-textarea, .bt-select {
            width: 100%;
            padding: 0.75rem 1rem;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: var(--bt-radius-sm);
            font-size: 0.88rem;
            color: #1e293b;
            font-weight: 500;
            transition: all 0.2s ease;
            box-sizing: border-box;
            outline: none;
        }

        .bt-input:focus, .bt-textarea:focus, .bt-select:focus {
            background: #ffffff;
            border-color: var(--bt-primary);
            box-shadow: 0 0 0 3.5px rgba(0, 104, 55, 0.12);
        }

        .bt-textarea {
            resize: vertical;
            min-height: 85px;
            line-height: 1.5;
        }

        .bt-help-text {
            display: block;
            font-size: 0.75rem;
            color: #94a3b8;
            margin-top: 0.35rem;
            line-height: 1.35;
        }

        /* Upload Preview Cards */
        .upload-preview-box {
            background: #f8fafc;
            border: 1.5px dashed #cbd5e1;
            border-radius: var(--bt-radius);
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            transition: border-color 0.2s;
            text-align: center;
        }
        .upload-preview-box:hover {
            border-color: var(--bt-primary);
        }

        .upload-img-frame {
            border-radius: 10px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .upload-img-banner {
            width: 100%;
            max-width: 320px;
            height: 110px;
        }
        .upload-img-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .upload-img-logo {
            width: 90px;
            height: 90px;
            padding: 8px;
        }
        .upload-img-logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .file-input-wrapper {
            position: relative;
            display: inline-block;
            margin-top: 0.25rem;
        }

        .btn-choose-file {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 700;
            color: #334155;
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-choose-file:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
            color: #0f172a;
        }

        /* Toggle Card */
        .toggle-card {
            background: #f8fafc;
            border: 1px solid var(--bt-border);
            border-radius: var(--bt-radius);
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.25rem;
        }

        .toggle-info {
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
        }

        .toggle-icon-wrap {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #ecfdf5;
            color: #059669;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .toggle-info h5 {
            font-size: 0.92rem;
            font-weight: 800;
            color: var(--bt-text-dark);
            margin: 0 0 0.2rem 0;
        }

        .toggle-info p {
            font-size: 0.78rem;
            color: var(--bt-text-muted);
            margin: 0;
            line-height: 1.35;
        }

        /* iOS-style toggle switch */
        .bt-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 28px;
            flex-shrink: 0;
        }

        .bt-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .bt-slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: #cbd5e1;
            transition: 0.3s;
            border-radius: 34px;
        }

        .bt-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.3s;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        input:checked + .bt-slider {
            background-color: var(--bt-primary);
        }

        input:checked + .bt-slider:before {
            transform: translateX(22px);
        }

        /* Button Primary */
        .btn-bt-primary {
            background: linear-gradient(135deg, #006837 0%, #004d28 100%);
            color: #ffffff;
            border: none;
            padding: 10px 22px;
            border-radius: 10px;
            font-size: 0.88rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(0, 104, 55, 0.25);
            text-decoration: none;
        }
        .btn-bt-primary:hover {
            background: linear-gradient(135deg, #007a41 0%, #005c30 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 104, 55, 0.35);
            color: #fff;
        }

        .btn-bt-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
        }
        .btn-bt-secondary:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        /* Filter Toolbar */
        .filter-toolbar {
            background: #f8fafc;
            border: 1px solid var(--bt-border);
            border-radius: 14px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }

        .filter-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .filter-inputs-group {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.65rem;
            flex: 1;
        }

        .search-input-wrapper {
            position: relative;
            min-width: 240px;
            flex: 1;
        }

        .search-input-wrapper i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.85rem;
            pointer-events: none;
        }

        .search-input-wrapper input {
            padding-left: 36px;
        }

        .btn-filter-submit {
            background: var(--bt-primary);
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .btn-filter-submit:hover {
            background: #00522c;
        }

        .btn-filter-reset {
            background: #e2e8f0;
            color: #475569;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
        }
        .btn-filter-reset:hover {
            background: #cbd5e1;
            color: #1e293b;
        }

        .btn-export-excel {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s;
        }
        .btn-export-excel:hover {
            background: #d1fae5;
            border-color: #6ee7b7;
            transform: translateY(-1px);
        }

        /* Custom Table */
        .table-responsive {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid var(--bt-border);
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            text-align: left;
        }

        .table-custom th {
            background: #f8fafc;
            padding: 12px 14px;
            font-weight: 700;
            color: #475569;
            border-bottom: 1px solid var(--bt-border);
            text-transform: uppercase;
            font-size: 0.72rem;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }

        .table-custom td {
            padding: 12px 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
            background: #ffffff;
        }

        .table-custom tbody tr:hover td {
            background-color: #f8fafc;
        }

        /* Status Badges */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 700;
            white-space: nowrap;
        }
        .badge-pending {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
        }
        .badge-accepted {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .badge-completed {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .badge-category {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        /* Action Icon Buttons */
        .btn-action-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.15s;
            background: #f8fafc;
            color: #64748b;
        }
        .btn-action-icon:hover {
            background: #ecfdf5;
            color: var(--bt-primary);
        }
        .btn-action-icon.btn-danger:hover {
            background: #fef2f2;
            color: #ef4444;
        }

        /* Services Grid Layout */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.25rem;
        }

        .service-card {
            background: #ffffff;
            border: 1.5px solid var(--bt-border);
            border-radius: 16px;
            padding: 1.35rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            transition: all 0.2s ease;
            position: relative;
        }
        .service-card:hover {
            border-color: #a7f3d0;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(0, 104, 55, 0.08);
        }

        .service-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .service-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            flex-shrink: 0;
        }

        .service-card h4 {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--bt-text-dark);
            margin: 0 0 0.35rem 0;
        }

        .service-card p {
            font-size: 0.8rem;
            color: var(--bt-text-muted);
            margin: 0 0 0.85rem 0;
            line-height: 1.4;
        }

        .service-url-pill {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 6px 10px;
            border-radius: 8px;
            font-family: ui-monospace, SFMono-Regular, monospace;
            font-size: 0.72rem;
            color: #64748b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
            margin-bottom: 1rem;
        }

        .service-card-footer {
            padding-top: 0.85rem;
            border-top: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Modal Dialogs */
        .bt-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .bt-modal-dialog {
            background: #ffffff;
            border-radius: 20px;
            width: 100%;
            max-width: 520px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #f1f5f9;
            padding: 1.5rem 1.75rem;
            position: relative;
        }

        .bt-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 1rem;
            margin-bottom: 1.25rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .bt-modal-header h3 {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--bt-text-dark);
            margin: 0;
        }

        .btn-modal-close {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f1f5f9;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-modal-close:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
    </style>
@endpush

@section('content')
<div x-data="{
    activeTab: '{{ request('tab', 'entries') }}',
    detailModalOpen: false,
    selectedEntry: null,
    serviceModalOpen: false,
    serviceModalMode: 'create',
    serviceForm: { id: '', title: '', subtitle: '', url: '', icon: 'link', icon_color: '#059669', icon_bg_color: '#ecfdf5', sort_order: 1, is_active: true },
    openDetail(entry) {
        this.selectedEntry = entry;
        this.detailModalOpen = true;
    },
    openCreateService() {
        this.serviceModalMode = 'create';
        this.serviceForm = { id: '', title: '', subtitle: '', url: '', icon: 'link', icon_color: '#059669', icon_bg_color: '#ecfdf5', sort_order: {{ $services->count() + 1 }}, is_active: true };
        this.serviceModalOpen = true;
    },
    openEditService(item) {
        this.serviceModalMode = 'edit';
        this.serviceForm = { ...item };
        this.serviceModalOpen = true;
    },
    copyUrl() {
        navigator.clipboard.writeText('{{ url('/buku-tamu') }}');
        alert('Tautan halaman Buku Tamu berhasil disalin!');
    }
}">

    <!-- Top Action Bar -->
    <div class="bt-topbar">
        <div class="bt-title-area">
            <h2>
                <i class="fas fa-book-open" style="color: #FBB03B;"></i>
                Buku Tamu & Portal Layanan
                <span class="bt-badge">Digital Receptionist</span>
            </h2>
            <p style="margin: 0; color: #cbd5e1; font-size: 0.85rem;">
                Kelola log kunjungan buku tamu digital, tanda tangan tamu, dan kartu layanan portal
            </p>
        </div>

        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <div class="bt-url-box">
                <span class="bt-url-text">{{ url('/buku-tamu') }}</span>
                <button type="button" class="btn-copy-link" @click="copyUrl()">
                    <i class="fas fa-copy"></i> Salin Link
                </button>
            </div>
            <a href="{{ url('/buku-tamu') }}" target="_blank" class="btn-visit">
                <i class="fas fa-external-link-alt"></i> Buka Halaman
            </a>
        </div>
    </div>

    <!-- Feedback Notification -->
    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 1rem 1.25rem; border-radius: 14px; margin-bottom: 1.5rem; font-weight: 600; display: flex; align-items: center; justify-content: space-between; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-check-circle" style="color: #059669; font-size: 1.1rem;"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #059669; cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- 4 KPI Stat Cards -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h4>Kunjungan Hari Ini</h4>
                <div class="stat-value" style="color: #047857;">{{ $todayCount }}</div>
            </div>
            <div class="stat-icon" style="background: #ecfdf5; color: #059669;">
                <i class="fas fa-calendar-check"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h4>Menunggu Konfirmasi</h4>
                <div class="stat-value" style="color: #d97706;">{{ $pendingCount }}</div>
            </div>
            <div class="stat-icon" style="background: #fffbeb; color: #d97706;">
                <i class="fas fa-clock"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h4>Tamu Diterima</h4>
                <div class="stat-value" style="color: #2563eb;">{{ $acceptedCount }}</div>
            </div>
            <div class="stat-icon" style="background: #eff6ff; color: #2563eb;">
                <i class="fas fa-user-check"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h4>Total Klik Layanan</h4>
                <div class="stat-value" style="color: #9333ea;">{{ $totalClicks }}</div>
            </div>
            <div class="stat-icon" style="background: #faf5ff; color: #9333ea;">
                <i class="fas fa-mouse-pointer"></i>
            </div>
        </div>
    </div>

    <!-- Studio Tab Navigation -->
    <div class="bt-tabs">
        <button type="button" class="bt-tab-btn" :class="{ 'active': activeTab === 'entries' }" @click="activeTab = 'entries'">
            <i class="fas fa-clipboard-list"></i>
            <span>Log Kunjungan Tamu ({{ $entries->total() }})</span>
        </button>
        <button type="button" class="bt-tab-btn" :class="{ 'active': activeTab === 'services' }" @click="activeTab = 'services'">
            <i class="fas fa-shapes"></i>
            <span>Manajemen Layanan Portal ({{ $services->count() }})</span>
        </button>
        <button type="button" class="bt-tab-btn" :class="{ 'active': activeTab === 'settings' }" @click="activeTab = 'settings'">
            <i class="fas fa-sliders"></i>
            <span>Pengaturan Portal & Notifikasi</span>
        </button>
    </div>

    <!-- TAB 1: Log Kunjungan Tamu -->
    <div x-show="activeTab === 'entries'" x-cloak>
        <div class="card-box">
            <!-- Filter Bar -->
            <form action="{{ route('admin.guestbook.index') }}" method="GET">
                <input type="hidden" name="tab" value="entries">
                
                <div class="filter-toolbar">
                    <div class="filter-row">
                        <div class="filter-inputs-group">
                            <!-- Search Box -->
                            <div class="search-input-wrapper">
                                <i class="fas fa-search"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, instansi, no HP, tujuan..." class="bt-input" style="padding-top: 8px; padding-bottom: 8px; font-size: 0.82rem;">
                            </div>

                            <!-- Status Filter -->
                            <div style="min-width: 140px;">
                                <select name="status" class="bt-select" style="padding-top: 8px; padding-bottom: 8px; font-size: 0.82rem;">
                                    <option value="all">Semua Status</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Diterima</option>
                                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>

                            <!-- Category Filter -->
                            <div style="min-width: 160px;">
                                <select name="category" class="bt-select" style="padding-top: 8px; padding-bottom: 8px; font-size: 0.82rem;">
                                    <option value="all">Semua Kategori</option>
                                    <option value="Wali Murid" {{ request('category') === 'Wali Murid' ? 'selected' : '' }}>Wali Murid</option>
                                    <option value="Tamu Instansi / Dinas" {{ request('category') === 'Tamu Instansi / Dinas' ? 'selected' : '' }}>Tamu Instansi / Dinas</option>
                                    <option value="Mitra / Vendor" {{ request('category') === 'Mitra / Vendor' ? 'selected' : '' }}>Mitra / Vendor</option>
                                    <option value="Umum" {{ request('category') === 'Umum' ? 'selected' : '' }}>Umum</option>
                                </select>
                            </div>

                            <!-- Date Filter -->
                            <div style="min-width: 135px;">
                                <input type="date" name="date" value="{{ request('date') }}" class="bt-input" style="padding-top: 7px; padding-bottom: 7px; font-size: 0.82rem;">
                            </div>

                            <button type="submit" class="btn-filter-submit">
                                <i class="fas fa-filter"></i> Filter
                            </button>

                            @if (request()->hasAny(['search', 'status', 'category', 'date']))
                                <a href="{{ route('admin.guestbook.index', ['tab' => 'entries']) }}" class="btn-filter-reset">
                                    <i class="fas fa-undo"></i> Reset
                                </a>
                            @endif
                        </div>

                        <!-- Export Button -->
                        <div>
                            <a href="{{ route('admin.guestbook.export', request()->all()) }}" class="btn-export-excel">
                                <i class="fas fa-file-excel" style="color: #059669; font-size: 0.95rem;"></i> Export CSV / Excel
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Table of Entries -->
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 120px;">Waktu & Tanggal</th>
                            <th>Nama & Kategori</th>
                            <th>Instansi / Lembaga</th>
                            <th>Kontak WhatsApp</th>
                            <th>Bertemu Dengan</th>
                            <th>Keperluan</th>
                            <th style="width: 110px;">Status</th>
                            <th style="width: 80px; text-align: center;">TTD</th>
                            <th style="width: 90px; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($entries as $entry)
                            <tr>
                                <td>
                                    <div style="font-weight: 700; color: #0f172a;">{{ $entry->created_at->format('d M Y') }}</div>
                                    <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 500;">{{ $entry->created_at->format('H:i') }} WIB</div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #0f172a; margin-bottom: 2px;">{{ $entry->name }}</div>
                                    <span class="badge-category">{{ $entry->category }}</span>
                                </td>
                                <td>
                                    <div style="color: #334155; font-weight: 500;">{{ $entry->institution ?: '-' }}</div>
                                </td>
                                <td>
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $entry->phone);
                                        if (str_starts_with($cleanPhone, '0')) {
                                            $cleanPhone = '62' . substr($cleanPhone, 1);
                                        }
                                    @endphp
                                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" style="color: #059669; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fab fa-whatsapp" style="font-size: 0.95rem;"></i> {{ $entry->phone }}
                                    </a>
                                </td>
                                <td>
                                    <span style="font-weight: 600; color: #334155;">{{ $entry->meet_with ?: '-' }}</span>
                                </td>
                                <td>
                                    <div style="max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #64748b; font-size: 0.82rem;" title="{{ $entry->purpose }}">
                                        {{ $entry->purpose }}
                                    </div>
                                </td>
                                <td>
                                    @if ($entry->status === 'accepted')
                                        <span class="badge-status badge-accepted"><i class="fas fa-check-circle"></i> Diterima</span>
                                    @elseif ($entry->status === 'completed')
                                        <span class="badge-status badge-completed"><i class="fas fa-flag-checkered"></i> Selesai</span>
                                    @else
                                        <span class="badge-status badge-pending"><i class="fas fa-clock"></i> Menunggu</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if ($entry->signature)
                                        <div style="width: 54px; height: 32px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 6px; padding: 2px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: transform 0.15s;" @click="openDetail({{ json_encode($entry) }})" title="Klik untuk memperbesar tanda tangan">
                                            <img src="{{ $entry->signature }}" alt="TTD" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                        </div>
                                    @else
                                        <span style="font-size: 0.75rem; color: #cbd5e1; font-style: italic;">Tanpa TTD</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; align-items: center; gap: 6px;">
                                        <button type="button" @click="openDetail({{ json_encode($entry) }})" class="btn-action-icon" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <form action="{{ route('admin.guestbook.entries.destroy', $entry->id) }}" method="POST" onsubmit="return confirm('Hapus catatan kunjungan tamu ini?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-icon btn-danger" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 3rem 1.5rem; color: #94a3b8;">
                                    <i class="fas fa-clipboard-user" style="font-size: 2.5rem; color: #cbd5e1; margin-bottom: 0.75rem; display: block;"></i>
                                    <div style="font-weight: 700; font-size: 1rem; color: #475569; margin-bottom: 0.25rem;">Belum ada data kunjungan tamu</div>
                                    <div style="font-size: 0.82rem;">Tamu yang mengisi buku tamu melalui portal publik akan otomatis tercatat di sini.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 1.25rem;">
                {{ $entries->links() }}
            </div>
        </div>
    </div>

    <!-- TAB 2: Manajemen Layanan Portal -->
    <div x-show="activeTab === 'services'" x-cloak>
        <div class="card-box">
            <div class="card-box-header">
                <div>
                    <h3 class="card-box-title">
                        <i class="fas fa-th-large" style="color: var(--bt-primary);"></i>
                        Kartu Layanan Portal Buku Tamu
                    </h3>
                    <p class="card-box-subtitle">
                        Kartu menu tujuan yang tampil di portal publik <code>{{ url('/buku-tamu') }}</code> untuk memudahkan tamu memilih keperluan.
                    </p>
                </div>
                <button type="button" @click="openCreateService()" class="btn-bt-primary">
                    <i class="fas fa-plus"></i> Tambah Layanan Baru
                </button>
            </div>

            <!-- Services Grid -->
            <div class="services-grid">
                @forelse ($services as $service)
                    <div class="service-card">
                        <div>
                            <div class="service-card-top">
                                <div class="service-icon-box" style="background-color: {{ $service->icon_bg_color ?? '#ecfdf5' }}; color: {{ $service->icon_color ?? '#059669' }};">
                                    <i class="fas fa-{{ $service->icon ?? 'link' }}"></i>
                                </div>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span style="font-size: 0.72rem; font-weight: 700; padding: 3px 8px; border-radius: 20px; {{ $service->is_active ? 'background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;' : 'background: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1;' }}">
                                        {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                    <span style="font-size: 0.72rem; font-weight: 700; padding: 3px 8px; border-radius: 20px; background: #faf5ff; color: #7e22ce; border: 1px solid #e9d5ff;" title="Total Klik Pengunjung">
                                        <i class="fas fa-mouse-pointer" style="font-size: 0.65rem;"></i> {{ $service->clicks_count }}
                                    </span>
                                </div>
                            </div>

                            <h4>{{ $service->title }}</h4>
                            <p>{{ $service->subtitle ?: 'Tidak ada keterangan tambahan' }}</p>
                            
                            <span class="service-url-pill" title="{{ $service->url }}">
                                <i class="fas fa-link" style="margin-right: 4px; color: #94a3b8;"></i> {{ $service->url ?: 'Belum diatur' }}
                            </span>
                        </div>

                        <div class="service-card-footer">
                            <span style="font-size: 0.75rem; font-weight: 700; color: #94a3b8;">
                                <i class="fas fa-arrow-down-1-9"></i> Urutan: #{{ $service->sort_order }}
                            </span>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <button type="button" @click="openEditService({{ json_encode($service) }})" class="btn-bt-secondary" style="padding: 5px 12px; font-size: 0.75rem;">
                                    <i class="fas fa-pen-to-square"></i> Edit
                                </button>
                                <form action="{{ route('admin.guestbook.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Hapus kartu layanan ini?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-icon btn-danger" style="width: 28px; height: 28px;" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 16px; color: #94a3b8;">
                        <i class="fas fa-shapes" style="font-size: 2.5rem; color: #cbd5e1; margin-bottom: 0.75rem; display: block;"></i>
                        <h4 style="font-size: 1rem; font-weight: 700; color: #475569; margin: 0 0 0.25rem 0;">Belum Ada Layanan Portal</h4>
                        <p style="font-size: 0.82rem; margin: 0 0 1rem 0;">Tambahkan tautan layanan seperti Form SPMB, Layanan Keuangan, atau WhatsApp Konsultasi.</p>
                        <button type="button" @click="openCreateService()" class="btn-bt-primary" style="font-size: 0.8rem; padding: 8px 16px;">
                            <i class="fas fa-plus"></i> Tambah Layanan Sekarang
                        </button>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- TAB 3: Pengaturan Portal & Notifikasi (Overhauled UI/UX) -->
    <div x-show="activeTab === 'settings'" x-cloak>
        <form action="{{ route('admin.guestbook.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Section 1: Identitas & Teks Sambutan -->
            <div class="settings-section-card">
                <div class="settings-header">
                    <div class="settings-header-icon" style="background: #ecfdf5; color: #059669;">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div class="settings-header-text">
                        <h4>Identitas & Teks Sambutan Portal</h4>
                        <p>Atur judul portal, slogan sekolah, salam pembuka, dan panduan bagi pengunjung saat membuka halaman buku tamu.</p>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="bt-form-group">
                        <label class="bt-label">Judul Header Portal <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $settings->title) }}" required placeholder="Contoh: Portal Buku Tamu & Layanan" class="bt-input">
                        <span class="bt-help-text">Tampil sebagai judul utama pada banner portal.</span>
                    </div>

                    <div class="bt-form-group">
                        <label class="bt-label">Sub-Judul / Slogan</label>
                        <input type="text" name="subtitle" value="{{ old('subtitle', $settings->subtitle) }}" placeholder="Contoh: SDIT Al Irsyad Al Islamiyyah Karawang" class="bt-input">
                        <span class="bt-help-text">Keterangan singkat di bawah judul portal.</span>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="bt-form-group">
                        <label class="bt-label">Judul Salam Pembuka <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="greeting_title" value="{{ old('greeting_title', $settings->greeting_title) }}" required placeholder="Contoh: Ahlan wa Sahlan di Al Irsyad" class="bt-input">
                        <span class="bt-help-text">Judul sambutan resepsionis kepada tamu.</span>
                    </div>

                    <div class="bt-form-group">
                        <label class="bt-label">No. WhatsApp Resepsionis</label>
                        <input type="text" name="wa_notification_number" value="{{ old('wa_notification_number', $settings->wa_notification_number) }}" placeholder="Contoh: 08123456789 atau 628123456789" class="bt-input">
                        <span class="bt-help-text">Nomor admin/resepsionis untuk konfirmasi otomatis dari tamu.</span>
                    </div>
                </div>

                <div class="bt-form-group">
                    <label class="bt-label">Teks Panduan / Sambutan Resepsionis</label>
                    <textarea name="greeting_text" rows="3" placeholder="Tuliskan petunjuk bagi tamu, misal: Silakan memilih kartu layanan atau mengisi buku tamu mandiri..." class="bt-textarea">{{ old('greeting_text', $settings->greeting_text) }}</textarea>
                    <span class="bt-help-text">Pesan ramah yang memberikan petunjuk kepada para pengunjung.</span>
                </div>
            </div>

            <!-- Section 2: Branding & Media Visual -->
            <div class="settings-section-card">
                <div class="settings-header">
                    <div class="settings-header-icon" style="background: #eff6ff; color: #2563eb;">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div class="settings-header-text">
                        <h4>Branding & Media Visual</h4>
                        <p>Kustomisasi banner latar belakang header dan logo resmi yang tampil di halaman portal publik.</p>
                    </div>
                </div>

                <div class="form-grid-2">
                    <!-- Banner Image -->
                    <div class="bt-form-group">
                        <label class="bt-label">Gambar Banner Header</label>
                        <div class="upload-preview-box">
                            <div class="upload-img-frame upload-img-banner">
                                @if ($settings->banner_path)
                                    <img src="{{ asset('storage/' . $settings->banner_path) }}" alt="Banner Header">
                                @else
                                    <div style="color: #94a3b8; font-size: 0.8rem; display: flex; flex-direction: column; align-items: center; gap: 4px;">
                                        <i class="fas fa-image" style="font-size: 1.5rem; color: #cbd5e1;"></i>
                                        <span>Belum ada gambar banner</span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <label class="btn-choose-file">
                                    <i class="fas fa-cloud-arrow-up" style="color: var(--bt-primary);"></i> Pilih Gambar Banner
                                    <input type="file" name="banner_image" accept="image/*" style="display: none;" onchange="this.parentElement.nextElementSibling.innerText = this.files[0]?.name || ''">
                                </label>
                                <div style="font-size: 0.72rem; color: #64748b; margin-top: 4px; font-weight: 500;"></div>
                                <span class="bt-help-text">Rekomendasi ukuran: 1200 x 400 px (Maks. 2MB, JPG/PNG/WebP)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Logo Image -->
                    <div class="bt-form-group">
                        <label class="bt-label">Logo Sekolah</label>
                        <div class="upload-preview-box">
                            <div class="upload-img-frame upload-img-logo">
                                @if ($settings->logo_path)
                                    <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="Logo">
                                @else
                                    <div style="color: #94a3b8; font-size: 0.75rem; display: flex; flex-direction: column; align-items: center; gap: 4px;">
                                        <i class="fas fa-school" style="font-size: 1.3rem; color: #cbd5e1;"></i>
                                        <span>Logo Standar</span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <label class="btn-choose-file">
                                    <i class="fas fa-cloud-arrow-up" style="color: var(--bt-primary);"></i> Pilih Logo Sekolah
                                    <input type="file" name="logo_image" accept="image/*" style="display: none;" onchange="this.parentElement.nextElementSibling.innerText = this.files[0]?.name || ''">
                                </label>
                                <div style="font-size: 0.72rem; color: #64748b; margin-top: 4px; font-weight: 500;"></div>
                                <span class="bt-help-text">Format PNG transparan atau SVG dianjurkan (Maks. 2MB)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Notifikasi, Footer & Fitur Tambahan -->
            <div class="settings-section-card">
                <div class="settings-header">
                    <div class="settings-header-icon" style="background: #faf5ff; color: #9333ea;">
                        <i class="fas fa-gear"></i>
                    </div>
                    <div class="settings-header-text">
                        <h4>Fitur Tambahan & Hak Cipta</h4>
                        <p>Pengaturan integrasi formulir digital mandiri dan teks hak cipta pada bagian bawah halaman portal.</p>
                    </div>
                </div>

                <!-- Direct Form Toggle Card -->
                <div class="bt-form-group">
                    <div class="toggle-card">
                        <div class="toggle-info">
                            <div class="toggle-icon-wrap">
                                <i class="fas fa-signature"></i>
                            </div>
                            <div>
                                <h5>Aktifkan Tombol "Isi Buku Tamu Digital Langsung"</h5>
                                <p>Menampilkan tombol check-in mandiri dengan fitur tanda tangan digital di halaman portal buku tamu.</p>
                            </div>
                        </div>
                        <label class="bt-switch">
                            <input type="checkbox" name="enable_direct_form" value="1" {{ $settings->enable_direct_form ? 'checked' : '' }}>
                            <span class="bt-slider"></span>
                        </label>
                    </div>
                </div>

                <!-- Footer Copyright Text -->
                <div class="bt-form-group" style="margin-top: 1.25rem;">
                    <label class="bt-label">Teks Hak Cipta / Footer</label>
                    <input type="text" name="footer_text" value="{{ old('footer_text', $settings->footer_text) }}" placeholder="Contoh: © 2026 SDIT Al Irsyad Al Islamiyyah Karawang. All rights reserved." class="bt-input">
                    <span class="bt-help-text">Tampil pada baris paling bawah halaman publik portal.</span>
                </div>
            </div>

            <!-- Action Save Bar -->
            <div style="background: #ffffff; border: 1px solid var(--bt-border); border-radius: 16px; padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04); flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 8px; color: #64748b; font-size: 0.85rem;">
                    <i class="fas fa-info-circle" style="color: #059669;"></i>
                    <span>Perubahan akan langsung diterapkan ke halaman portal publik.</span>
                </div>
                <button type="submit" class="btn-bt-primary" style="padding: 11px 26px; font-size: 0.92rem;">
                    <i class="fas fa-floppy-disk"></i> Simpan Semua Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- MODAL: Detail Kunjungan & Tanda Tangan -->
    <div x-show="detailModalOpen" x-cloak class="bt-modal-backdrop">
        <div class="bt-modal-dialog" @click.outside="detailModalOpen = false">
            <template x-if="selectedEntry">
                <div>
                    <div class="bt-modal-header">
                        <div>
                            <h3 x-text="selectedEntry.name"></h3>
                            <span style="font-size: 0.75rem; color: #64748b;" x-text="'Kategori: ' + selectedEntry.category"></span>
                        </div>
                        <button type="button" @click="detailModalOpen = false" class="btn-modal-close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 1rem; font-size: 0.85rem;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.85rem; background: #f8fafc; padding: 1rem; border-radius: 12px; border: 1px solid #f1f5f9;">
                            <div>
                                <span style="font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block;">Instansi / Hubungan</span>
                                <span style="font-weight: 700; color: #1e293b;" x-text="selectedEntry.institution || '-'"></span>
                            </div>
                            <div>
                                <span style="font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block;">WhatsApp</span>
                                <a :href="'https://wa.me/' + selectedEntry.phone" target="_blank" style="font-weight: 700; color: #059669; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fab fa-whatsapp"></i> <span x-text="selectedEntry.phone"></span>
                                </a>
                            </div>
                            <div>
                                <span style="font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block;">Bertemu Dengan</span>
                                <span style="font-weight: 700; color: #1e293b;" x-text="selectedEntry.meet_with || '-'"></span>
                            </div>
                            <div>
                                <span style="font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block;">Waktu Kunjungan</span>
                                <span style="font-weight: 700; color: #1e293b;" x-text="new Date(selectedEntry.created_at).toLocaleString('id-ID')"></span>
                            </div>
                        </div>

                        <div>
                            <span class="bt-label" style="font-size: 0.75rem;">Keperluan Kunjungan</span>
                            <div style="padding: 0.75rem 1rem; background: #f8fafc; border-radius: 10px; color: #334155; font-size: 0.82rem; line-height: 1.5; border: 1px solid #f1f5f9;" x-text="selectedEntry.purpose"></div>
                        </div>

                        <!-- Tanda Tangan Digital Display -->
                        <div>
                            <span class="bt-label" style="font-size: 0.75rem;">Tanda Tangan Digital</span>
                            <div style="height: 130px; background: #ffffff; border-radius: 12px; border: 1.5px dashed #cbd5e1; padding: 6px; display: flex; align-items: center; justify-content: center;">
                                <template x-if="selectedEntry.signature">
                                    <img :src="selectedEntry.signature" alt="Tanda Tangan" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                </template>
                                <template x-if="!selectedEntry.signature">
                                    <span style="font-size: 0.78rem; color: #94a3b8; font-style: italic;">Tidak ada tanda tangan</span>
                                </template>
                            </div>
                        </div>

                        <!-- Update Status Form -->
                        <form :action="'{{ url('admin/guestbook/entries') }}/' + selectedEntry.id + '/status'" method="POST" style="padding-top: 1rem; border-top: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 0.85rem;">
                            @csrf
                            @method('PATCH')
                            <div>
                                <label class="bt-label" style="font-size: 0.75rem;">Update Status Kunjungan</label>
                                <select name="status" class="bt-select">
                                    <option value="pending" :selected="selectedEntry.status === 'pending'">Menunggu</option>
                                    <option value="accepted" :selected="selectedEntry.status === 'accepted'">Diterima</option>
                                    <option value="completed" :selected="selectedEntry.status === 'completed'">Selesai</option>
                                </select>
                            </div>
                            <div>
                                <label class="bt-label" style="font-size: 0.75rem;">Catatan Petugas Resepsionis</label>
                                <input type="text" name="admin_notes" :value="selectedEntry.admin_notes" placeholder="Contoh: Tamu sudah diarahkan ke ruang Kepala Sekolah..." class="bt-input">
                            </div>
                            <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 0.5rem;">
                                <button type="button" @click="detailModalOpen = false" class="btn-bt-secondary">Tutup</button>
                                <button type="submit" class="btn-bt-primary">Simpan Status</button>
                            </div>
                        </form>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- MODAL: Tambah / Edit Layanan Portal -->
    <div x-show="serviceModalOpen" x-cloak class="bt-modal-backdrop">
        <div class="bt-modal-dialog" @click.outside="serviceModalOpen = false">
            <div class="bt-modal-header">
                <h3 x-text="serviceModalMode === 'create' ? 'Tambah Layanan Portal Baru' : 'Edit Layanan Portal'"></h3>
                <button type="button" @click="serviceModalOpen = false" class="btn-modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form :action="serviceModalMode === 'create' ? '{{ route('admin.guestbook.services.store') }}' : '{{ url('admin/guestbook/services') }}/' + serviceForm.id" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
                @csrf
                <template x-if="serviceModalMode === 'edit'">
                    @method('PUT')
                </template>

                <div class="bt-form-group">
                    <label class="bt-label">Nama Layanan <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="title" x-model="serviceForm.title" required placeholder="Contoh: Layanan Keuangan" class="bt-input">
                </div>

                <div class="bt-form-group">
                    <label class="bt-label">Keterangan / Subtitle</label>
                    <input type="text" name="subtitle" x-model="serviceForm.subtitle" placeholder="Contoh: Administrasi & Pembayaran SPP" class="bt-input">
                </div>

                <div class="bt-form-group">
                    <label class="bt-label">URL Tujuan <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="url" x-model="serviceForm.url" required placeholder="https://... atau /form/keuangan" class="bt-input" style="font-family: monospace;">
                </div>

                <div class="form-grid-3">
                    <div class="bt-form-group">
                        <label class="bt-label">Icon FA</label>
                        <input type="text" name="icon" x-model="serviceForm.icon" placeholder="link" class="bt-input" style="font-family: monospace;">
                    </div>
                    <div class="bt-form-group">
                        <label class="bt-label">Warna Icon</label>
                        <input type="color" name="icon_color" x-model="serviceForm.icon_color" class="bt-input" style="height: 42px; padding: 2px 4px; cursor: pointer;">
                    </div>
                    <div class="bt-form-group">
                        <label class="bt-label">Warna BG</label>
                        <input type="color" name="icon_bg_color" x-model="serviceForm.icon_bg_color" class="bt-input" style="height: 42px; padding: 2px 4px; cursor: pointer;">
                    </div>
                </div>

                <div class="form-grid-2" style="align-items: center;">
                    <div class="bt-form-group">
                        <label class="bt-label">Urutan Tampil</label>
                        <input type="number" name="sort_order" x-model="serviceForm.sort_order" class="bt-input">
                    </div>
                    <div class="bt-form-group" style="padding-top: 1.25rem;">
                        <label class="bt-switch" style="display: flex; align-items: center; gap: 10px; width: auto; cursor: pointer;">
                            <input type="checkbox" name="is_active" value="1" x-model="serviceForm.is_active" style="width: 18px; height: 18px; cursor: pointer;">
                            <span style="font-size: 0.82rem; font-weight: 700; color: #334155;">Status Aktif</span>
                        </label>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 0.75rem; padding-top: 1rem; border-top: 1px solid #f1f5f9;">
                    <button type="button" @click="serviceModalOpen = false" class="btn-bt-secondary">Batal</button>
                    <button type="submit" class="btn-bt-primary">
                        <span x-text="serviceModalMode === 'create' ? 'Tambah Layanan' : 'Simpan Perubahan'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
