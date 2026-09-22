<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->title ?? 'Portal Buku Tamu' }} - Al Irsyad</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ $settings->logo_path ? asset('storage/' . $settings->logo_path) : 'https://www.alirsyad.sch.id/wp-content/uploads/2025/03/cropped-logo-al-irsyad.png' }}" type="image/png">

    @include('partials.analytics')

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed { animation: float 8s ease-in-out infinite 2s; }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(3deg); }
        }
        .canvas-container {
            touch-action: none;
            cursor: crosshair;
        }
        /* Custom scrollbar for modal */
        .modal-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .modal-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .modal-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-emerald-950 via-emerald-900 to-teal-950 min-h-screen flex items-center justify-center p-4 relative overflow-x-hidden selection:bg-emerald-500 selection:text-white">

    <!-- Latar Belakang Ornamen Pendidikan & Cahaya -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <!-- Efek Glowing Orbs -->
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-emerald-500/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-teal-400/20 rounded-full blur-[120px]"></div>
        <div class="absolute top-[40%] right-[10%] w-[35%] h-[35%] bg-amber-500/10 rounded-full blur-[140px]"></div>

        <!-- Ikon Topi Toga Melayang -->
        <div class="absolute top-[8%] left-[8%] text-emerald-100/15 animate-float w-24 h-24 hidden md:block">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14v7" /></svg>
        </div>
        <!-- Ikon Buku -->
        <div class="absolute bottom-[12%] right-[8%] text-emerald-100/15 animate-float-delayed w-28 h-28 hidden md:block">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
        </div>
        <!-- Ikon Pensil -->
        <div class="absolute top-[18%] right-[12%] text-amber-200/15 animate-float-delayed w-20 h-20 hidden md:block">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
        </div>
        <!-- Ikon Tabung Sains -->
        <div class="absolute bottom-[18%] left-[12%] text-amber-200/15 animate-float w-24 h-24 hidden md:block">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
        </div>
    </div>

    <!-- Main Card Container -->
    <div class="max-w-md w-full bg-white rounded-3xl shadow-[0_25px_60px_rgba(0,0,0,0.45)] border border-emerald-100/20 overflow-hidden relative z-10 my-8 backdrop-blur-sm">
        
        <!-- Header Section with Banner & Logo -->
        <div class="relative p-8 text-center overflow-hidden">
            <!-- Background Image with Dark Emerald Overlay -->
            <div class="absolute inset-0 z-0">
                @if ($settings->banner_path)
                    <img src="{{ asset('storage/' . $settings->banner_path) }}" alt="Banner" class="w-full h-full object-cover">
                @else
                    <img src="https://www.alirsyad.sch.id/wp-content/uploads/2025/11/gerbang-sekolah-al-irsyad-dengan-logo-min-1.jpg" alt="Gerbang Al Irsyad" class="w-full h-full object-cover">
                @endif
                <div class="absolute inset-0 bg-gradient-to-b from-emerald-950/85 via-emerald-900/80 to-emerald-950/90 backdrop-blur-[2px]"></div>
            </div>
            
            <div class="relative z-10">
                <!-- Logo -->
                <div class="w-20 h-20 bg-white rounded-2xl mx-auto flex items-center justify-center mb-4 shadow-xl p-2 border border-white/30 transform hover:scale-105 transition-transform duration-300">
                    @if ($settings->logo_path)
                        <img src="{{ asset('storage/' . $settings->logo_path) }}" alt="Logo" class="max-w-full max-h-full object-contain">
                    @else
                        <img src="https://www.alirsyad.sch.id/wp-content/uploads/2025/03/cropped-logo-al-irsyad.png" alt="Logo Al Irsyad" class="max-w-full max-h-full object-contain">
                    @endif
                </div>
                <h1 class="text-2xl font-black text-white tracking-tight mb-1">{{ $settings->title ?? 'Portal Buku Tamu' }}</h1>
                <p class="text-emerald-200 text-sm font-medium italic">{{ $settings->subtitle ?? 'Ahlan wa Sahlan di Al Irsyad' }}</p>
            </div>
        </div>

        <!-- Notification Alert -->
        @if (session('success'))
            <div class="mx-6 mt-4 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start gap-3 shadow-sm">
                <i class="fas fa-check-circle text-emerald-600 text-lg mt-0.5 shrink-0"></i>
                <div class="flex-1 font-medium">{{ session('success') }}</div>
            </div>
        @endif

        <!-- Content Section -->
        <div class="p-6">
            <div class="text-center mb-6">
                <h2 class="text-emerald-700 font-bold text-lg mb-1 flex items-center justify-center gap-2">
                    <span>{{ $settings->greeting_title ?? "Assalamu'alaikum" }}</span>
                    <span class="inline-block animate-pulse text-amber-500">✨</span>
                </h2>
                <p class="text-slate-600 text-sm leading-relaxed">
                    {{ $settings->greeting_text ?? 'Bismillah. Tafadhdhol, silakan pilih layanan yang Anda tuju atau isi buku tamu digital:' }}
                </p>
            </div>

            <!-- Digital Guest Book Quick Action Button -->
            @if ($settings->enable_direct_form)
                <div class="mb-5">
                    <button type="button" onclick="openCheckinModal()" class="w-full group relative overflow-hidden p-4 rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 text-white shadow-lg shadow-emerald-700/25 hover:shadow-emerald-700/40 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-between">
                        <div class="flex items-center gap-3.5 text-left">
                            <div class="w-12 h-12 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center text-white text-xl group-hover:rotate-6 transition-transform">
                                <i class="fas fa-signature"></i>
                            </div>
                            <div>
                                <div class="font-bold text-base tracking-wide flex items-center gap-2">
                                    <span>Isi Buku Tamu Digital</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-amber-400 text-emerald-950 tracking-wider">Langsung</span>
                                </div>
                                <div class="text-xs text-emerald-100 font-normal mt-0.5">Check-in kehadiran tamu & tanda tangan</div>
                            </div>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center group-hover:translate-x-1 transition-transform">
                            <i class="fas fa-arrow-right text-sm"></i>
                        </div>
                    </button>
                </div>

                <div class="relative flex py-2 items-center mb-4">
                    <div class="flex-grow border-t border-slate-200"></div>
                    <span class="flex-shrink mx-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">Atau Pilih Layanan</span>
                    <div class="flex-grow border-t border-slate-200"></div>
                </div>
            @endif

            <!-- Services List -->
            <div class="space-y-3">
                @forelse ($services as $service)
                    <a href="{{ route('guestbook.click', $service->id) }}" class="group flex items-center p-3.5 bg-slate-50 hover:bg-emerald-50/80 border border-slate-200/80 hover:border-emerald-300 rounded-2xl transition-all duration-300 shadow-sm hover:shadow-md relative overflow-hidden">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl mr-3.5 shrink-0 transition-transform group-hover:scale-105 shadow-sm"
                             style="background-color: {{ $service->icon_bg_color ?? '#ecfdf5' }}; color: {{ $service->icon_color ?? '#059669' }};">
                            <i class="fas fa-{{ $service->icon ?? 'link' }}"></i>
                        </div>
                        <div class="flex-1 min-w-0 pr-2">
                            <h3 class="text-slate-800 font-bold text-[15px] group-hover:text-emerald-800 transition-colors truncate">{{ $service->title }}</h3>
                            @if ($service->subtitle)
                                <p class="text-xs text-slate-500 mt-0.5 truncate">{{ $service->subtitle }}</p>
                            @endif
                        </div>
                        <div class="text-slate-300 group-hover:text-emerald-600 transform group-hover:translate-x-1 transition-all shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-6 text-slate-400 text-sm">
                        <i class="fas fa-folder-open text-2xl mb-2 block"></i>
                        Belum ada layanan yang ditambahkan.
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Footer -->
        <div class="bg-slate-50/80 p-4 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-500 font-medium">
                {{ $settings->footer_text ?? '© 2026 Al Irsyad. Jazakumullahu khairan.' }}
            </p>
        </div>
    </div>

    <!-- Digital Check-In Modal with Signature Pad -->
    <div id="checkinModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-lg w-full max-h-[92vh] flex flex-col shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300 overflow-hidden" id="checkinModalContent">
            
            <!-- Modal Header -->
            <div class="px-6 py-5 bg-gradient-to-r from-emerald-800 to-teal-800 text-white flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg">
                        <i class="fas fa-pen-nib"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-white">Formulir Buku Tamu</h3>
                        <p class="text-xs text-emerald-100">Silakan isi data kunjungan Anda</p>
                    </div>
                </div>
                <button type="button" onclick="closeCheckinModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <!-- Modal Body (Scrollable Form) -->
            <form id="checkinForm" action="{{ route('guestbook.store') }}" method="POST" class="flex-1 overflow-y-auto p-6 space-y-4 modal-scroll">
                @csrf
                <input type="hidden" name="signature" id="signatureInput">

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                        <input type="text" name="name" required placeholder="Contoh: Ahmad Fauzan" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-slate-800 font-medium">
                    </div>
                </div>

                <!-- Kategori & Instansi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Tamu <span class="text-rose-500">*</span></label>
                        <select name="category" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-slate-800 font-medium">
                            <option value="Wali Murid">Wali Murid / Orang Tua</option>
                            <option value="Tamu Instansi / Dinas">Tamu Dinas / Instansi</option>
                            <option value="Mitra / Vendor">Mitra / Vendor</option>
                            <option value="Umum" selected>Kunjungan Umum</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Asal Instansi / Hubungan</label>
                        <input type="text" name="institution" placeholder="Contoh: Dinas Pendidikan / Wali Fulan" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-slate-800 font-medium">
                    </div>
                </div>

                <!-- Kontak WhatsApp & Email -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">No. WhatsApp / HP <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fab fa-whatsapp text-sm"></i>
                            </div>
                            <input type="tel" name="phone" required placeholder="08xxxxxxxxxx" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-slate-800 font-medium">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email (Opsional)</label>
                        <input type="email" name="email" placeholder="nama@email.com" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-slate-800 font-medium">
                    </div>
                </div>

                <!-- Bertemu Dengan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Bertemu Dengan / Ditujukan Kepada</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-user-tie text-sm"></i>
                        </div>
                        <input type="text" name="meet_with" placeholder="Contoh: Kepala Sekolah / Bagian Tata Usaha / Ust. Ahmad" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-slate-800 font-medium">
                    </div>
                </div>

                <!-- Keperluan Kunjungan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Keperluan Kunjungan <span class="text-rose-500">*</span></label>
                    <textarea name="purpose" rows="2" required placeholder="Jelaskan maksud dan tujuan kedatangan Anda secara singkat..." class="w-full p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-slate-800 font-medium resize-none"></textarea>
                </div>

                <!-- Tanda Tangan Digital Canvas -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Tanda Tangan Digital <span class="text-slate-400 font-normal lowercase">(sentuh/goreskan di bawah)</span></label>
                        <button type="button" onclick="clearSignature()" class="text-xs font-semibold text-rose-600 hover:text-rose-700 flex items-center gap-1">
                            <i class="fas fa-rotate-left"></i> Bersihkan
                        </button>
                    </div>
                    <div class="border-2 border-dashed border-slate-300 rounded-2xl bg-slate-50/70 p-1 overflow-hidden relative canvas-container">
                        <canvas id="signatureCanvas" class="w-full h-32 rounded-xl bg-white block"></canvas>
                        <div id="signaturePlaceholder" class="absolute inset-0 flex items-center justify-center pointer-events-none text-slate-400 text-xs font-medium gap-2">
                            <i class="fas fa-signature text-slate-300 text-lg"></i>
                            <span>Tanda tangan di area ini</span>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" id="btnSubmitCheckin" class="w-full py-3.5 px-6 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md shadow-emerald-600/30 hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        <span>Kirim Data Kunjungan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300">
            <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 mx-auto flex items-center justify-center text-2xl mb-4">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-1">Alhamdulillah!</h3>
            <p class="text-slate-600 text-sm mb-5 leading-relaxed" id="successMsgText">
                Data kunjungan Anda telah berhasil dicatat oleh sistem SDIT Al Irsyad.
            </p>
            <div class="space-y-2.5">
                <a id="waContactBtn" href="#" target="_blank" class="hidden w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all flex items-center justify-center gap-2 shadow-sm">
                    <i class="fab fa-whatsapp text-sm"></i> Konfirmasi ke Resepsionis
                </a>
                <button type="button" onclick="closeSuccessModal()" class="w-full py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                    Selesai & Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Script: Canvas Signature Pad & Modal Interactions -->
    <script>
        const checkinModal = document.getElementById('checkinModal');
        const checkinModalContent = document.getElementById('checkinModalContent');
        const successModal = document.getElementById('successModal');
        const canvas = document.getElementById('signatureCanvas');
        const placeholder = document.getElementById('signaturePlaceholder');
        const signatureInput = document.getElementById('signatureInput');
        const checkinForm = document.getElementById('checkinForm');
        let ctx = null;
        let isDrawing = false;
        let hasSigned = false;

        function initCanvas() {
            if (!canvas) return;
            const rect = canvas.getBoundingClientRect();
            // High DPI support
            const scale = window.devicePixelRatio || 1;
            canvas.width = rect.width * scale;
            canvas.height = rect.height * scale;
            ctx = canvas.getContext('2d');
            ctx.scale(scale, scale);
            ctx.strokeStyle = '#065f46';
            ctx.lineWidth = 2.5;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
        }

        function openCheckinModal() {
            checkinModal.classList.remove('hidden');
            setTimeout(() => {
                checkinModal.classList.remove('opacity-0');
                checkinModalContent.classList.remove('scale-95');
                checkinModalContent.classList.add('scale-100');
                initCanvas();
            }, 10);
        }

        function closeCheckinModal() {
            checkinModal.classList.add('opacity-0');
            checkinModalContent.classList.add('scale-95');
            checkinModalContent.classList.remove('scale-100');
            setTimeout(() => {
                checkinModal.classList.add('hidden');
            }, 300);
        }

        function clearSignature() {
            if (!ctx) return;
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            hasSigned = false;
            placeholder.classList.remove('hidden');
            signatureInput.value = '';
        }

        function getPos(e) {
            const rect = canvas.getBoundingClientRect();
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            return {
                x: clientX - rect.left,
                y: clientY - rect.top
            };
        }

        function startDrawing(e) {
            isDrawing = true;
            hasSigned = true;
            placeholder.classList.add('hidden');
            const pos = getPos(e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
            e.preventDefault();
        }

        function draw(e) {
            if (!isDrawing) return;
            const pos = getPos(e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
            e.preventDefault();
        }

        function stopDrawing(e) {
            if (isDrawing) {
                isDrawing = false;
                signatureInput.value = canvas.toDataURL('image/png');
            }
        }

        // Event listeners for Canvas
        if (canvas) {
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', draw);
            window.addEventListener('mouseup', stopDrawing);

            canvas.addEventListener('touchstart', startDrawing, { passive: false });
            canvas.addEventListener('touchmove', draw, { passive: false });
            window.addEventListener('touchend', stopDrawing);
        }

        // Handle Form Submission via AJAX
        checkinForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (hasSigned) {
                signatureInput.value = canvas.toDataURL('image/png');
            }

            const btn = document.getElementById('btnSubmitCheckin');
            const originalContent = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

            const formData = new FormData(checkinForm);

            fetch(checkinForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalContent;

                if (data.success) {
                    closeCheckinModal();
                    checkinForm.reset();
                    clearSignature();

                    // Open Success Modal
                    document.getElementById('successMsgText').innerText = data.message;
                    const waBtn = document.getElementById('waContactBtn');
                    if (data.wa_url) {
                        waBtn.href = data.wa_url;
                        waBtn.classList.remove('hidden');
                    } else {
                        waBtn.classList.add('hidden');
                    }

                    successModal.classList.remove('hidden');
                    setTimeout(() => {
                        successModal.classList.remove('opacity-0');
                    }, 10);
                } else {
                    alert(data.message || 'Gagal menyimpan data.');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalContent;
                // Fallback to regular form submission if fetch error occurs
                checkinForm.submit();
            });
        });

        function closeSuccessModal() {
            successModal.classList.add('opacity-0');
            setTimeout(() => {
                successModal.classList.add('hidden');
            }, 300);
        }

        window.addEventListener('resize', () => {
            if (!checkinModal.classList.contains('hidden')) {
                initCanvas();
            }
        });
    </script>
</body>
</html>
