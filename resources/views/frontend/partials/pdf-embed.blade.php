@php
    $rawUrl = $pdfUrl ?? asset('storage/media/brosur-ppdb-2026-2027.pdf');
    if (!str_starts_with($rawUrl, 'http://') && !str_starts_with($rawUrl, 'https://')) {
        $pdfUrl = asset(ltrim($rawUrl, '/'));
    } else {
        $pdfUrl = $rawUrl;
    }

    $rawTitle = $title ?? 'Buku Informasi Resmi Al Irsyad';
    // Clean up technical strings like Compressed, extensions, hyphens, and underscores
    $cleanTitle = preg_replace('/(\.pdf|_|-|\bcompressed\b|\bcopy\b)/i', ' ', $rawTitle);
    $cleanTitle = ucwords(trim(preg_replace('/\s+/', ' ', $cleanTitle)));
    $displayTitle = !empty($cleanTitle) ? $cleanTitle : 'Buku Informasi Resmi';

    $downloadName = $downloadName ?? (basename(parse_url($pdfUrl, PHP_URL_PATH)) ?: 'dokumen-alirsyad.pdf');
    $flipId = 'df_' . substr(md5($pdfUrl . $displayTitle . uniqid()), 0, 8);
    $waNumber = \App\Models\Setting::get('contact_whatsapp', '62895708351313');
    $waClean = preg_replace('/[^0-9]/', '', $waNumber);
@endphp

<div class="pdf-flipbook-wrapper my-6 md:my-10 rounded-2xl md:rounded-3xl overflow-hidden border border-slate-200/90 bg-slate-900 shadow-2xl transition-all duration-300">
    <!-- Top Action Bar -->
    <div class="p-3.5 sm:p-4 md:px-6 bg-slate-900/95 border-b border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-white">
        <div class="flex items-center gap-3 min-w-0">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 text-white flex items-center justify-center shadow-md shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div class="truncate">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        3D Flipbook
                    </span>
                    <span class="text-xs text-slate-400 hidden sm:inline">Publikasi Digital Interaktif</span>
                </div>
                <h4 class="font-bold text-slate-100 text-sm sm:text-base truncate mb-0 leading-snug">{{ $displayTitle }}</h4>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0 self-end sm:self-auto">
            <button type="button" onclick="triggerFlipbookFullscreen('{{ $flipId }}', '{{ $pdfUrl }}')" class="btn-pdf inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-xl text-xs transition shadow-sm hover:shadow-md cursor-pointer border-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                </svg>
                <span>Buka Layar Penuh</span>
            </button>
            <a href="{{ $pdfUrl }}" download="{{ $downloadName }}" class="btn-pdf inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold rounded-xl text-xs border border-slate-700 transition shadow-sm hover:shadow no-underline">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>Unduh PDF</span>
            </a>
        </div>
    </div>

    <!-- 3D Flipbook Stage -->
    <div class="relative w-full bg-slate-950 overflow-hidden" style="min-height: 480px;">
        <div class="_df_book dflip-container w-full" id="{{ $flipId }}" source="{{ $pdfUrl }}" style="height: 680px; width: 100%;">
            <!-- Initial Loading Placeholder -->
            <div class="df-loading-placeholder p-8 text-center text-white h-full flex flex-col items-center justify-center bg-slate-950" style="min-height: 480px;">
                <div class="w-12 h-12 border-3 border-emerald-500 border-t-transparent rounded-full animate-spin mb-4"></div>
                <h5 class="text-slate-200 font-bold text-base mb-1">Membuka Buku Digital Interaktif...</h5>
                <p class="text-slate-400 text-xs max-w-sm mb-4">Memuat simulasi lembaran buku 3D dengan efek visual realistis.</p>
                <a href="{{ $pdfUrl }}" target="_blank" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-emerald-400 font-semibold rounded-lg text-xs transition border border-slate-700">
                    Buka Dokumen PDF Langsung &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom Helper & Navigation Guide -->
    <div class="p-3 sm:px-6 bg-slate-900 border-t border-slate-800/80 flex flex-col md:flex-row md:items-center justify-between gap-3 text-xs text-slate-400">
        <div class="flex items-center gap-2">
            <span class="text-emerald-400 font-bold shrink-0">💡 Tips:</span>
            <span>Klik & seret sudut lembaran kertas, geser layar, atau gunakan tombol navigasi di bawah untuk membalik halaman seperti buku fisik.</span>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="/smart#daftar" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-emerald-400 hover:text-emerald-300 font-semibold transition no-underline">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Daftar SPMB Online</span>
            </a>
            <span class="text-slate-700">&bull;</span>
            <a href="https://wa.me/{{ $waClean }}?text={{ urlencode('Bismillah, Assalamu\'alaikum Panitia PPDB Al Irsyad, saya ingin konsultasi pendaftaran setelah membaca booklet: ' . $displayTitle) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-emerald-400 hover:text-emerald-300 font-semibold transition no-underline">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.173.086.275.071.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.086s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/></svg>
                <span>Tanya Humas</span>
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Scoped DearFlip 3D Flipbook Styling */
    .dflip-container {
        height: 680px;
        background-color: #020617 !important;
        position: relative;
    }
    @media (max-width: 1024px) {
        .dflip-container {
            height: 580px !important;
        }
    }
    @media (max-width: 640px) {
        .dflip-container {
            height: 480px !important;
        }
    }
    .df-container {
        background-color: #020617 !important;
    }
    .df-ui-controls {
        background: rgba(15, 23, 42, 0.92) !important;
        backdrop-filter: blur(10px) !important;
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
    }
    .df-ui-btn {
        color: #cbd5e1 !important;
        transition: all 0.2s ease !important;
    }
    .df-ui-btn:hover {
        color: #34d399 !important;
        transform: scale(1.1) !important;
    }
    .df-ui-page {
        color: #e2e8f0 !important;
    }
</style>
@endpush

<script>
(function() {
    var bookId = "{{ $flipId }}";
    var pdfUrl = "{{ $pdfUrl }}";

    // Set configuration for DearFlip
    window['option_' + bookId] = {
        source: pdfUrl,
        webgl: true,
        soundEnable: true,
        soundFile: "https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/sound/turn2.mp3",
        height: 680,
        duration: 750,
        backgroundColor: "#020617",
        controlsPosition: "bottom",
        direction: 1, // Left-to-Right
        enableDownload: true,
        autoPlay: false,
        pageMode: 2, // 2-page book spread on desktop
        singlePageMode: 0, // Auto single-page on mobile
        pageSize: 0,
        autoEnableOutline: false,
        autoEnableThumbnail: false,
        moreControls: "pageMode,startPage,endPage,sound",
        onReady: function(flipbook) {
            window['fb_instance_' + bookId] = flipbook;
            var placeholder = document.querySelector('#' + bookId + ' .df-loading-placeholder');
            if (placeholder) {
                placeholder.style.display = 'none';
            }
        }
    };

    // Load Stylesheets if not present
    if (!document.getElementById('dflip-css')) {
        var l1 = document.createElement('link');
        l1.id = 'dflip-css';
        l1.rel = 'stylesheet';
        l1.type = 'text/css';
        l1.href = 'https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/css/dflip.min.css';
        document.head.appendChild(l1);
    }
    if (!document.getElementById('dflip-themify-css')) {
        var l2 = document.createElement('link');
        l2.id = 'dflip-themify-css';
        l2.rel = 'stylesheet';
        l2.type = 'text/css';
        l2.href = 'https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/css/themify-icons.min.css';
        document.head.appendChild(l2);
    }

    // Set dFlip asset location for lazy worker/three.js loading
    window.dFlipLocation = "https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/";

    function initThisFlipbook() {
        if (window.jQuery && window.jQuery.fn && window.jQuery.fn.flipBook) {
            var $el = window.jQuery('#' + bookId);
            if (!$el.hasClass('df-initialized') && !$el.find('.df-container').length) {
                $el.addClass('df-initialized').flipBook(pdfUrl, window['option_' + bookId]);
            }
        }
    }

    function loadScript(src, id, callback) {
        if (document.getElementById(id)) {
            if (callback) callback();
            return;
        }
        var s = document.createElement('script');
        s.id = id;
        s.src = src;
        s.type = 'text/javascript';
        s.onload = function() {
            if (callback) callback();
        };
        document.head.appendChild(s);
    }

    if (!window.jQuery) {
        loadScript('https://code.jquery.com/jquery-3.7.1.min.js', 'dflip-jquery-js', function() {
            loadScript('https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/js/dflip.min.js', 'dflip-core-js', function() {
                initThisFlipbook();
            });
        });
    } else {
        if (!window.jQuery.fn.flipBook) {
            loadScript('https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/js/dflip.min.js', 'dflip-core-js', function() {
                initThisFlipbook();
            });
        } else {
            initThisFlipbook();
        }
    }

    window.triggerFlipbookFullscreen = function(targetId, fallbackUrl) {
        var fb = window['fb_instance_' + targetId];
        if (fb && fb.ui && fb.ui.fullScreen) {
            fb.ui.fullScreen.trigger('click');
        } else {
            window.open(fallbackUrl, '_blank');
        }
    };
})();
</script>
