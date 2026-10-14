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
        border-color: #059669;
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
        max-height: 70px;
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
        color: #059669;
        font-weight: 700;
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

        .sidebar-collapsed .main-content {
            margin-left: 0 !important;
        }

        /* Sheet full width without card border / shadow */
        .report-sheet {
            display: block !important;
            position: static !important;
            box-shadow: none !important;
            border: none !important;
            border-radius: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
            background: transparent !important;
        }

        .report-header-kop {
            border-bottom: 2px solid #0f172a !important;
            padding-bottom: 12px !important;
            margin-bottom: 16px !important;
        }

        .report-doc-title {
            margin-bottom: 1.25rem !important;
        }

        .report-doc-title h2 {
            font-size: 1.2rem !important;
        }

        .report-meta-grid {
            background: #f8fafc !important;
            border: 1px solid #94a3b8 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            padding: 10px 14px !important;
            margin-bottom: 18px !important;
            gap: 0.75rem !important;
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
        <a href="{{ route('admin.security.index', ['tab' => 'overview']) }}" class="btn" style="background:#f1f5f9; color:#475569; display: flex; align-items: center; gap: 6px; padding: 8px 14px;">
            <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i> Kembali
        </a>
        <h2 style="font-size: 1.15rem; font-weight: 800; margin: 0; color: #0f172a;">Laporan Keamanan Siber</h2>
    </div>

    <!-- Filter Form -->
    <form action="{{ route('admin.security.report') }}" method="GET" class="report-filters">
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

        <button type="button" class="btn btn-primary" onclick="window.print()" style="display: flex; align-items: center; gap: 6px; padding: 8px 16px;">
            <i data-feather="printer" style="width: 16px; height: 16px;"></i> Cetak Laporan (PDF)
        </button>
    </form>
</div>

<!-- Formal Report Sheet -->
<div class="report-sheet">
    <!-- Kop Surat Sekolah -->
    <div class="report-header-kop">
        @if(\App\Models\Setting::logoUrl())
            <img src="{{ \App\Models\Setting::logoUrl() }}" alt="Logo" class="report-logo">
        @else
            <div style="width: 60px; height: 60px; background: #059669; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                <i data-feather="shield" style="width: 32px; height: 32px;"></i>
            </div>
        @endif
        <div class="report-org-info">
            <h1>{{ \App\Models\Setting::siteName() }}</h1>
            <p>{{ \App\Models\Setting::siteTagline() }} &bull; Sistem Manajemen Keamanan Informasi & Pertahanan Aplikasi Web</p>
            <p>Dokumen Laporan Resmi Evaluasi Kepatuhan OWASP & Perlindungan Siber</p>
        </div>
    </div>

    <!-- Judul Dokumen -->
    <div class="report-doc-title">
        <h2>{{ $report['title'] }}</h2>
        <p>Periode: {{ $report['subtitle'] }}</p>
    </div>

    <!-- Metrik Utama -->
    <div class="report-meta-grid">
        <div class="report-meta-item">
            <div class="lbl">Total Ancaman Ditangkal</div>
            <div class="val" style="color: #b91c1c;">{{ number_format($report['total_threats']) }}</div>
        </div>
        <div class="report-meta-item">
            <div class="lbl">Rata-rata / Hari</div>
            <div class="val" style="color: #0369a1;">{{ number_format($report['daily_average'], 1) }}</div>
        </div>
        <div class="report-meta-item">
            <div class="lbl">Efektivitas Blokir</div>
            <div class="val" style="color: #059669;">{{ $report['block_rate'] }}%</div>
        </div>
        <div class="report-meta-item">
            <div class="lbl">Skor Kepatuhan OWASP</div>
            <div class="val" style="color: #059669;">{{ $report['health_score']['score'] }}/100</div>
        </div>
    </div>

    <!-- Section 1: Ringkasan Eksekutif -->
    <div class="report-section">
        <div class="report-section-title">
            <i data-feather="file-text" style="width: 18px; height: 18px; color: #059669;"></i> I. Ringkasan Eksekutif
        </div>
        <p style="font-size: 0.88rem; line-height: 1.6; color: #334155; margin-bottom: 0.75rem;">
            Selama periode <strong>{{ $report['subtitle'] }}</strong> (total <strong>{{ (int)$report['total_days'] }} hari</strong>), 
            sistem keamanan CMS Sekolah secara aktif memantau seluruh lalu lintas web dan berhasil menggagalkan 
            <strong>{{ number_format($report['total_threats']) }} percobaan serangan berbahaya</strong> dengan tingkat keberhasilan penangkalan sebesar 
            <strong>{{ $report['block_rate'] }}%</strong>. Rata-rata serangan bot dan peretas yang dicegat adalah <strong>{{ number_format($report['daily_average'], 1) }} serangan per hari</strong>.
        </p>
        <p style="font-size: 0.88rem; line-height: 1.6; color: #334155; margin: 0;">
            Kondisi ketahanan sistem saat ini berada pada status <strong>Terlindungi Baik (Skor {{ $report['health_score']['score'] }}/100)</strong> 
            berdasarkan standar keamanan industri <em>OWASP Top 10 Web Application Security Risks</em>.
        </p>
    </div>

    <!-- Section 2: Rekapitulasi Jenis Serangan -->
    <div class="report-section">
        <div class="report-section-title">
            <i data-feather="pie-chart" style="width: 18px; height: 18px; color: #059669;"></i> II. Rekapitulasi Klasifikasi Ancaman Dicegat
        </div>
        @if($report['categories']->isEmpty())
            <p style="font-size: 0.85rem; color: #64748b;">Tidak ada insiden serangan yang tercatat pada periode ini.</p>
        @else
            <table class="report-table">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">No</th>
                        <th>Kategori Ancaman</th>
                        <th>Tingkat Risiko</th>
                        <th style="text-align: right;">Jumlah Percobaan</th>
                        <th style="text-align: right;">Persentase</th>
                        <th>Tindakan Firewall</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($report['categories'] as $idx => $cat)
                        @php
                            $pct = $report['total_threats'] > 0 ? round(($cat->count / $report['total_threats']) * 100, 1) : 0;
                        @endphp
                        <tr>
                            <td style="text-align: center;">{{ $idx + 1 }}</td>
                            <td style="font-weight: 700;">{{ ucwords(str_replace('_', ' ', $cat->threat_type)) }}</td>
                            <td>
                                @if($cat->severity === 'critical')
                                    <span style="color: #b91c1c; font-weight: 700;">Critical</span>
                                @elseif($cat->severity === 'high')
                                    <span style="color: #ea580c; font-weight: 700;">High</span>
                                @else
                                    <span style="color: #ca8a04; font-weight: 700;">Medium</span>
                                @endif
                            </td>
                            <td style="text-align: right; font-weight: 700;">{{ number_format($cat->count) }}</td>
                            <td style="text-align: right;">{{ $pct }}%</td>
                            <td><span style="color: #059669; font-weight: 600;">Ditolak Otomatis (HTTP 403 Forbidden)</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Section 3: Sumber Serangan Terbanyak (Top Attackers) -->
    <div class="report-section">
        <div class="report-section-title">
            <i data-feather="shield-off" style="width: 18px; height: 18px; color: #059669;"></i> III. Alamat IP Penyerang Paling Agresif
        </div>
        @if($report['top_ips']->isEmpty())
            <p style="font-size: 0.85rem; color: #64748b;">Tidak ada data IP penyerang pada periode ini.</p>
        @else
            <table class="report-table">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">No</th>
                        <th>Alamat IP Sumber</th>
                        <th>Jenis Serangan Dominan</th>
                        <th style="text-align: right;">Frekuensi Serangan</th>
                        <th>Status Pertahanan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($report['top_ips'] as $idx => $ip)
                        <tr>
                            <td style="text-align: center;">{{ $idx + 1 }}</td>
                            <td style="font-family: monospace; font-weight: 700;">{{ $ip->ip_address }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $ip->sample_threat)) }}</td>
                            <td style="text-align: right; font-weight: 700; color: #b91c1c;">{{ number_format($ip->attack_count) }} kali</td>
                            <td><span style="color: #059669; font-weight: 600;">Terblokir Firewall / Auto-ban</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Section 4: Status Kepatuhan Modul Pertahanan -->
    <div class="report-section">
        <div class="report-section-title">
            <i data-feather="check-circle" style="width: 18px; height: 18px; color: #059669;"></i> IV. Status Kepatuhan Pilar Keamanan OWASP
        </div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Komponen Keamanan</th>
                    <th>Fungsi Perlindungan</th>
                    <th style="width: 120px; text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report['health_score']['checks'] as $chk)
                    <tr>
                        <td style="font-weight: 700;">{{ $chk['title'] }}</td>
                        <td style="font-size: 0.8rem; color: #64748b;">{{ $chk['description'] }}</td>
                        <td style="text-align: center;">
                            @if($chk['passed'])
                                <span style="color: #059669; font-weight: 700;">Terpenuhi</span>
                            @else
                                <span style="color: #dc2626; font-weight: 700;">Perlu Atensi</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Section 5: Kesimpulan & Rekomendasi -->
    <div class="report-section">
        <div class="report-section-title">
            <i data-feather="info" style="width: 18px; height: 18px; color: #059669;"></i> V. Kesimpulan & Rekomendasi Tim IT
        </div>
        <ol style="font-size: 0.85rem; line-height: 1.6; color: #334155; padding-left: 1.25rem; margin: 0;">
            <li>Sistem WAF dan Firewall otomatis bekerja optimal dengan mencegat seluruh percobaan eksploitasi sebelum menyentuh logika aplikasi.</li>
            <li>Sebagian besar serangan teridentifikasi sebagai *automated vulnerability scanner* (bot probe mencari path WordPress / `.env` lama) yang telah diamankan secara penuh.</li>
            <li>Disarankan untuk tetap mewajibkan penerapan **Two-Factor Authentication (2FA)** bagi seluruh akun dengan hak akses Administrator dan melakukan rotasi kata sandi secara berkala.</li>
        </ol>
    </div>

    <!-- Kolom Tanda Tangan -->
    <div class="report-signatures">
        <div class="sig-box">
            <div class="sig-title">Mengetahui,<br><strong>Pimpinan / Kepala Sekolah</strong></div>
            <div class="sig-name">( .................................................... )</div>
            <div class="sig-role">NIP / NBM.</div>
        </div>
        <div class="sig-box">
            <div class="sig-title">Diterbitkan pada {{ $report['generated_at']->translatedFormat('d F Y') }},<br><strong>Administrator Sistem & Tim IT</strong></div>
            <div class="sig-name">( {{ $report['generated_by'] }} )</div>
            <div class="sig-role">Penanggung Jawab Keamanan Siber</div>
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
