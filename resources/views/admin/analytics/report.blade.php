@extends('admin.layouts.app')

@section('title', $report['title'])

@section('content')
<style>
    /* Screen Styles */
    .report-control-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        background: #ffffff;
        padding: 1rem 1.5rem;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    }

    .report-filters {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .report-select {
        padding: 8px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.88rem;
        background: #f8fafc;
        color: #0f172a;
        font-weight: 500;
        cursor: pointer;
    }

    .report-select:focus {
        outline: none;
        border-color: #2563eb;
        background: #ffffff;
    }

    .report-sheet {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 3rem 3.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        max-width: 1000px;
        margin: 0 auto;
        color: #1e293b;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .report-header-kop {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        border-bottom: 3px double #0f172a;
        padding-bottom: 1.5rem;
        margin-bottom: 2rem;
    }

    .report-logo {
        max-height: 75px;
        max-width: 160px;
        object-fit: contain;
    }

    .report-org-info h1 {
        font-size: 1.45rem;
        font-weight: 800;
        margin: 0 0 4px 0;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .report-org-info p {
        margin: 0;
        font-size: 0.82rem;
        color: #64748b;
        line-height: 1.5;
    }

    .report-doc-title {
        text-align: center;
        margin-bottom: 2rem;
    }

    .report-doc-title h2 {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 6px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .report-doc-title p {
        margin: 0;
        font-size: 0.9rem;
        color: #2563eb;
        font-weight: 700;
    }

    .report-doc-number {
        font-size: 0.78rem;
        color: #64748b;
        margin-top: 4px;
        font-family: ui-monospace, SFMono-Regular, monospace;
    }

    .report-meta-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 2rem;
    }

    .report-meta-item .lbl {
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .report-meta-item .val {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
    }

    .report-section {
        margin-bottom: 2.25rem;
    }

    .report-section-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1rem;
        padding-bottom: 6px;
        border-bottom: 1.5px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    .report-table th {
        background: #f1f5f9;
        color: #475569;
        font-weight: 700;
        text-align: left;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
    }

    .report-table td {
        padding: 9px 14px;
        border: 1px solid #cbd5e1;
        color: #334155;
    }

    .report-signatures {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        margin-top: 4rem;
        page-break-inside: avoid;
    }

    .sig-box {
        text-align: center;
    }

    .sig-box .sig-title {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 4.5rem;
    }

    .sig-box .sig-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: #0f172a;
        text-decoration: underline;
    }

    .sig-box .sig-role {
        font-size: 0.8rem;
        color: #64748b;
    }

    /* Print Styles */
    @page {
        size: A4 portrait;
        margin: 15mm 15mm 15mm 15mm;
    }

    @media print {
        /* Hide all admin layout chrome */
        .sidebar,
        #sidebar,
        .topbar,
        .menu-toggle,
        .collapse-toggle,
        #menu-toggle-btn,
        #sidebar-collapse-btn,
        #topbar-menu-toggle-btn,
        .report-control-bar,
        .overlay,
        #mobile-overlay,
        .btn,
        header,
        footer,
        .sec-header,
        .alert {
            display: none !important;
        }

        /* Reset main document body and wrappers */
        html, body {
            background: #ffffff !important;
            color: #000000 !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            min-width: 100% !important;
            font-size: 9.5pt !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .admin-layout,
        .main-content,
        .content-area,
        main {
            display: block !important;
            position: static !important;
            margin: 0 !important;
            margin-left: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 100% !important;
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }

        .report-sheet {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
        }

        .report-meta-grid {
            background: #f8fafc !important;
            border: 1px solid #94a3b8 !important;
            padding: 10px !important;
            margin-bottom: 16px !important;
        }

        .report-meta-item .val {
            font-size: 1.2rem !important;
        }

        .report-section {
            margin-bottom: 18px !important;
            page-break-inside: auto;
        }

        .report-section-title {
            font-size: 0.95rem !important;
            margin-bottom: 8px !important;
            border-bottom: 1.5px solid #94a3b8 !important;
        }

        .report-table {
            width: 100% !important;
            page-break-inside: auto;
        }

        .report-table tr {
            page-break-inside: avoid !important;
        }

        .report-table th {
            background: #f1f5f9 !important;
            color: #0f172a !important;
            border: 1px solid #64748b !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            font-size: 8.5pt !important;
            padding: 6px 10px !important;
        }

        .report-table td {
            border: 1px solid #94a3b8 !important;
            font-size: 8.5pt !important;
            padding: 6px 10px !important;
            color: #0f172a !important;
        }

        .report-signatures {
            margin-top: 30px !important;
            page-break-inside: avoid !important;
        }
    }
</style>

<!-- Control & Filter Bar (Hidden when printing) -->
<div class="report-control-bar">
    <div style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ route('admin.dashboard') }}" class="btn" style="background:#f1f5f9; color:#475569; display: flex; align-items: center; gap: 6px; padding: 8px 14px; text-decoration: none; border-radius: 8px; font-size: 0.88rem; font-weight: 600;">
            <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i> Kembali ke Dashboard
        </a>
        <h2 style="font-size: 1.15rem; font-weight: 800; margin: 0; color: #0f172a;">Laporan Analitik Web & PPDB</h2>
    </div>

    <!-- Filter Form -->
    <form action="{{ route('admin.analytics.report') }}" method="GET" class="report-filters">
        <label style="font-size: 0.85rem; font-weight: 700; color: #475569;">Periode:</label>

        <select name="type" class="report-select" onchange="toggleFilterFields(this.value); this.form.submit();">
            <option value="month" {{ $type === 'month' ? 'selected' : '' }}>Bulanan</option>
            <option value="quarter" {{ $type === 'quarter' ? 'selected' : '' }}>Triwulan / Kuartal</option>
            <option value="year" {{ $type === 'year' ? 'selected' : '' }}>Tahunan</option>
        </select>

        <select name="year" class="report-select" onchange="this.form.submit();">
            @for($y = (int)date('Y'); $y >= (int)date('Y') - 3; $y--)
                <option value="{{ $y }}" {{ $year === $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
            @endfor
        </select>

        <span id="monthSelectWrap" style="{{ $type === 'month' ? 'display:inline-block;' : 'display:none;' }}">
            <select name="month" class="report-select" onchange="this.form.submit();">
                @for($m = 1; $m <= 12; $m++)
                    @php $monthName = \Carbon\Carbon::create(2026, $m, 1)->translatedFormat('F'); @endphp
                    <option value="{{ $m }}" {{ $month === $m ? 'selected' : '' }}>{{ $monthName }}</option>
                @endfor
            </select>
        </span>

        <span id="quarterSelectWrap" style="{{ $type === 'quarter' ? 'display:inline-block;' : 'display:none;' }}">
            <select name="quarter" class="report-select" onchange="this.form.submit();">
                <option value="1" {{ $quarter === 1 ? 'selected' : '' }}>Kuartal I (Jan - Mar)</option>
                <option value="2" {{ $quarter === 2 ? 'selected' : '' }}>Kuartal II (Apr - Jun)</option>
                <option value="3" {{ $quarter === 3 ? 'selected' : '' }}>Kuartal III (Jul - Sep)</option>
                <option value="4" {{ $quarter === 4 ? 'selected' : '' }}>Kuartal IV (Okt - Des)</option>
            </select>
        </span>

        <button type="button" class="btn btn-primary" onclick="window.print()" style="display: flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-weight: 600;">
            <i data-feather="printer" style="width: 16px; height: 16px;"></i> Cetak Laporan (PDF)
        </button>
    </form>
</div>

<!-- Formal Report Sheet -->
<div class="report-sheet">
    <!-- Kop Surat Resmi Sekolah -->
    <div class="report-header-kop">
        @if(!empty($report['school_logo']))
            <img src="{{ $report['school_logo'] }}" alt="Logo" class="report-logo">
        @else
            <div style="width: 65px; height: 65px; background: #2563eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                <i data-feather="award" style="width: 32px; height: 32px;"></i>
            </div>
        @endif
        <div class="report-org-info">
            <h1>{{ $report['school_name'] }}</h1>
            <p>{{ $report['school_tagline'] }} &bull; Panitia Penerimaan Peserta Didik Baru (PPDB)</p>
            <p>{{ $report['school_address'] }} &bull; Telp/WA: {{ $report['school_phone'] }} &bull; Email: {{ $report['school_email'] }}</p>
        </div>
    </div>

    <!-- Judul Dokumen -->
    <div class="report-doc-title">
        <h2>{{ $report['title'] }}</h2>
        <p>Periode: {{ $report['subtitle'] }}</p>
        <div class="report-doc-number">No. Dokumen: {{ $report['doc_number'] }}</div>
    </div>

    <!-- Metrik Utama / KPI Grid -->
    <div class="report-meta-grid">
        <div class="report-meta-item">
            <div class="lbl">Total Calon Pendaftar (Leads)</div>
            <div class="val" style="color: #059669;">{{ number_format($report['total_hot_leads']) }}</div>
        </div>
        <div class="report-meta-item">
            <div class="lbl">Total Kunjungan Web</div>
            <div class="val" style="color: #0284c7;">{{ number_format($report['total_visits']) }}</div>
        </div>
        <div class="report-meta-item">
            <div class="lbl">Rasio Konversi PPDB</div>
            <div class="val" style="color: #d97706;">{{ $report['conversion_rate'] }}%</div>
        </div>
        <div class="report-meta-item">
            <div class="lbl">Konsultasi WhatsApp</div>
            <div class="val" style="color: #16a34a;">{{ number_format($report['wa_ppdb_clicks']) }}</div>
        </div>
    </div>

    <!-- Section I: Ringkasan Eksekutif -->
    <div class="report-section">
        <div class="report-section-title">
            <i data-feather="file-text" style="width: 18px; height: 18px; color: #2563eb;"></i> I. Ringkasan Eksekutif
        </div>
        <p style="font-size: 0.88rem; line-height: 1.6; color: #334155; margin-bottom: 0.75rem;">
            Selama periode pelaporan <strong>{{ $report['subtitle'] }}</strong> (total <strong>{{ (int)$report['total_days'] }} hari</strong>), 
            ekosistem digital dan situs web sekolah mencatatkan sebanyak <strong>{{ number_format($report['total_visits']) }} total kunjungan</strong> 
            dengan <strong>{{ number_format($report['total_pageviews']) }} tayangan halaman</strong>. Dari lalu lintas tersebut, sistem penjaringan 
            berhasil mengonversi calon wali murid menjadi <strong>{{ number_format($report['total_hot_leads']) }} calon pendaftar potensial (hot leads)</strong> 
            dengan tingkat konversi (conversion rate) sebesar <strong>{{ $report['conversion_rate'] }}%</strong>.
        </p>
        <p style="font-size: 0.88rem; line-height: 1.6; color: #334155; margin: 0;">
            Kanal komunikasi langsung WhatsApp mendominasi interaksi pendaftaran dengan <strong>{{ number_format($report['wa_ppdb_clicks']) }} klik konsultasi</strong>, 
            disusul oleh <strong>{{ number_format($report['spmb_clicks']) }} akses ke Portal SPMB Online</strong> dan 
            <strong>{{ number_format($report['brochure_downloads']) }} unduhan brosur digital</strong>.
        </p>
    </div>

    <!-- Section II: Corong Konversi PPDB (Acquisition Funnel) -->
    <div class="report-section">
        <div class="report-section-title">
            <i data-feather="filter" style="width: 18px; height: 18px; color: #2563eb;"></i> II. Corong Konversi Pendaftaran (PPDB Acquisition Funnel)
        </div>
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width: 40px; text-align: center;">No</th>
                    <th>Tahapan Corong (Funnel Stage)</th>
                    <th style="width: 120px; text-align: right;">Volume Interaksi</th>
                    <th style="width: 110px; text-align: right;">Rasio (%)</th>
                    <th>Deskripsi Perilaku Calon Wali Murid</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($report['funnel'] as $key => $stage)
                <tr>
                    <td style="text-align: center; font-weight: 600;">{{ $no++ }}</td>
                    <td style="font-weight: 700; color: #0f172a;">{{ $stage['name'] }}</td>
                    <td style="text-align: right; font-weight: 700;">{{ number_format($stage['count']) }}</td>
                    <td style="text-align: right; font-weight: 600; color: #059669;">{{ $stage['rate'] }}%</td>
                    <td style="font-size: 0.82rem; color: #475569;">{{ $stage['desc'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Section III: Evaluasi Efektivitas Saluran Promosi (UTM Attribution) -->
    <div class="report-section">
        <div class="report-section-title">
            <i data-feather="share-2" style="width: 18px; height: 18px; color: #2563eb;"></i> III. Kinerja Saluran Kampanye & Promosi (UTM Attribution)
        </div>
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width: 40px; text-align: center;">No</th>
                    <th>Saluran Promosi / Kampanye</th>
                    <th style="width: 110px; text-align: right;">Jumlah Minat</th>
                    <th style="width: 100px; text-align: right;">Pangsa Minat</th>
                    <th style="width: 120px; text-align: center;">Status Kinerja</th>
                    <th>Keterangan Pelacakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report['channels'] as $idx => $ch)
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td style="font-weight: 600; color: #0f172a;">{{ $ch['channel'] }}</td>
                    <td style="text-align: right; font-weight: 700;">{{ number_format($ch['count']) }}</td>
                    <td style="text-align: right; font-weight: 600; color: #0284c7;">{{ $ch['percent'] }}%</td>
                    <td style="text-align: center;">
                        <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 0.74rem; font-weight: 600; background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;">
                            {{ $ch['status'] }}
                        </span>
                    </td>
                    <td style="font-size: 0.8rem; color: #64748b;">{{ $ch['desc'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Section IV: Konten & Halaman Berita Paling Efektif Menjaring Pendaftar -->
    <div class="report-section">
        <div class="report-section-title">
            <i data-feather="trending-up" style="width: 18px; height: 18px; color: #2563eb;"></i> IV. Konten Berita & Halaman Pemicu Konversi Terbanyak
        </div>
        @if($report['top_pages']->isNotEmpty())
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width: 40px; text-align: center;">No</th>
                    <th>Judul Artikel Berita / Halaman</th>
                    <th>URL Halaman</th>
                    <th style="width: 120px; text-align: right;">Pemicu Klik PPDB</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report['top_pages'] as $i => $page)
                <tr>
                    <td style="text-align: center;">{{ $i + 1 }}</td>
                    <td style="font-weight: 600; color: #0f172a;">{{ $page->label }}</td>
                    <td style="font-size: 0.78rem; font-family: monospace; color: #64748b;">{{ \Illuminate\Support\Str::limit($page->url, 45) }}</td>
                    <td style="text-align: right; font-weight: 700; color: #16a34a;">{{ number_format($page->click_count) }} kali</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p style="font-size: 0.85rem; color: #64748b; font-style: italic; background: #f8fafc; padding: 10px; border-radius: 6px; border: 1px solid #e2e8f0;">
            Belum ada aktivitas konversi spesifik halaman yang tercatat pada rentang tanggal ini.
        </p>
        @endif
    </div>

    <!-- Section V: Catatan Analisis & Rekomendasi Tindak Lanjut -->
    <div class="report-section">
        <div class="report-section-title">
            <i data-feather="check-circle" style="width: 18px; height: 18px; color: #2563eb;"></i> V. Catatan Evaluasi & Rekomendasi Tindak Lanjut
        </div>
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            @foreach($report['recommendations'] as $rec)
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #2563eb; border-radius: 6px; padding: 0.75rem 1rem;">
                <div style="font-weight: 700; font-size: 0.88rem; color: #0f172a; margin-bottom: 2px;">
                    {{ $rec['title'] }}
                </div>
                <div style="font-size: 0.82rem; color: #475569; line-height: 1.5;">
                    {{ $rec['desc'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Kolom Tanda Tangan Resmi -->
    <div class="report-signatures">
        <div class="sig-box">
            <div class="sig-title">Mengetahui,<br><strong>Pimpinan / Kepala Sekolah</strong></div>
            <div class="sig-name">( .................................................... )</div>
            <div class="sig-role">NIP / NBM.</div>
        </div>
        <div class="sig-box">
            <div class="sig-title">Diterbitkan pada {{ $report['generated_at']->translatedFormat('d F Y') }},<br><strong>Koordinator Humas & Tim Media PPDB</strong></div>
            <div class="sig-name">( {{ $report['generated_by'] }} )</div>
            <div class="sig-role">Penanggung Jawab Sistem Informasi & Analitik</div>
        </div>
    </div>
</div>

<script>
    feather.replace();

    function toggleFilterFields(type) {
        const monthWrap = document.getElementById('monthSelectWrap');
        const quarterWrap = document.getElementById('quarterSelectWrap');
        if (monthWrap) monthWrap.style.display = type === 'month' ? 'inline-block' : 'none';
        if (quarterWrap) quarterWrap.style.display = type === 'quarter' ? 'inline-block' : 'none';
    }
</script>
@endsection
