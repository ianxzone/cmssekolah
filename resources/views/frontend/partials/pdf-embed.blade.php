@php
    $pdfUrl = $pdfUrl ?? asset('storage/media/brosur-ppdb-2026-2027.pdf');
    $title = $title ?? 'Brosur Informasi Dokumen Resmi';
    $subtitle = $subtitle ?? 'Dokumen Resmi (PDF)';
    $downloadName = $downloadName ?? (basename(parse_url($pdfUrl, PHP_URL_PATH)) ?: 'dokumen.pdf');
@endphp

<div class="pdf-viewer-card my-8 rounded-2xl overflow-hidden border border-emerald-200/90 bg-gradient-to-b from-emerald-50/60 to-white shadow-lg transition-all duration-300">
    <!-- Header Bar -->
    <div class="p-4 sm:p-5 border-b border-emerald-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white/80 backdrop-blur-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-800 text-white flex items-center justify-center shadow-md shrink-0">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-base sm:text-lg mb-0.5 leading-snug">{{ $title }}</h4>
                <p class="text-xs sm:text-sm text-emerald-800 font-medium mb-0 flex items-center gap-1.5">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    {{ $subtitle }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2.5 flex-wrap sm:flex-nowrap shrink-0">
            <a href="{{ $pdfUrl }}" target="_blank" rel="noopener noreferrer" class="btn-pdf inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl text-xs sm:text-sm transition-all duration-200 shadow-sm hover:shadow-md no-underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                <span>Buka Layar Penuh</span>
            </a>
            <a href="{{ $pdfUrl }}" download="{{ $downloadName }}" class="btn-pdf inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-emerald-50 text-emerald-900 font-semibold rounded-xl text-xs sm:text-sm border border-emerald-300 transition-all duration-200 shadow-sm hover:shadow no-underline">
                <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>Unduh Dokumen</span>
            </a>
        </div>
    </div>

    <!-- PDF Embedded Viewer Frame (Bisa dibaca seperti lembaran buku / interactive viewer) -->
    <div class="w-full bg-slate-100 relative" style="height: 650px; min-height: 480px;">
        <object data="{{ $pdfUrl }}#toolbar=1&navpanes=0" type="application/pdf" class="w-full h-full border-0">
            <iframe src="{{ $pdfUrl }}#toolbar=1&navpanes=0" class="w-full h-full border-0" title="{{ $title }}">
                <div class="p-8 text-center bg-white h-full flex flex-col items-center justify-center">
                    <svg class="w-16 h-16 text-emerald-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h5 class="font-bold text-gray-800 text-lg mb-2">Pratinjau Dokumen PDF</h5>
                    <p class="text-sm text-gray-600 max-w-md mb-5">Browser atau perangkat Anda tidak mendukung penampilan PDF secara inline.</p>
                    <a href="{{ $pdfUrl }}" target="_blank" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl text-sm transition">
                        Klik di Sini untuk Membuka Dokumen
                    </a>
                </div>
            </iframe>
        </object>
    </div>
</div>
