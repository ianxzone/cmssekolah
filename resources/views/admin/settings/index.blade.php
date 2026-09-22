@extends('admin.layouts.app')

@section('title', 'Homepage & System Settings')

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .setting-section {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .setting-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.875rem;
            transition: all 0.15s ease;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .form-text {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
            display: block;
        }

        .toggle-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background: var(--bg-body);
            border-radius: 8px;
            margin-bottom: 0.75rem;
        }

        .toggle-label {
            font-weight: 500;
            color: var(--text-primary);
        }

        .toggle-desc {
            font-size: 0.75rem;
            color: var(--text-secondary);
            display: block;
            margin-top: 0.25rem;
        }

        /* Custom Switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: var(--primary-color);
        }

        input:checked+.slider:before {
            transform: translateX(20px);
        }

        trix-editor {
            min-height: 150px;
            background: #fff;
            border-radius: 8px;
            border-color: var(--border-color);
        }

        /* Tabs Styling */
        .tabs-nav {
            display: flex;
            gap: 0.5rem;
            border-bottom: 2px solid var(--border-color);
            margin-bottom: 2rem;
            overflow-x: auto;
            scrollbar-width: thin;
        }

        .tab-btn {
            padding: 0.75rem 1.25rem;
            background: transparent;
            border: none;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-secondary);
            cursor: pointer;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .tab-btn:hover {
            color: var(--primary-color);
        }

        .tab-btn.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        /* Dynamic Row Styling */
        .dynamic-row {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            margin-bottom: 1rem;
            padding: 1rem;
            background: var(--bg-body);
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .dynamic-row-content {
            flex-grow: 1;
            display: grid;
            gap: 0.75rem;
        }

        .unit-card-editor {
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.25rem;
            position: relative;
        }

        .unit-card-editor-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px dashed var(--border-color);
        }
    </style>
@endpush

@section('content')
    <div class="panel" style="max-width: 1040px; margin: 0 auto;" x-data="{ activeTab: 'identity' }">
        <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="panel-title">Pengaturan Beranda & Sistem</h2>
            <a href="{{ url('/') }}" target="_blank" class="btn" style="background: var(--bg-body); border-color: var(--border-color); font-size: 0.85rem;">
                <i data-feather="external-link"></i> Lihat Website
            </a>
        </div>

        <div class="panel-body">
            @if(session('success'))
                <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 500; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="check-circle" style="width: 18px; height: 18px;"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Tabs Navigation (8 Tabs) -->
            <div class="tabs-nav">
                <button type="button" class="tab-btn" :class="{ 'active': activeTab === 'identity' }" @click="activeTab = 'identity'">1. Identitas & Kontak</button>
                <button type="button" class="tab-btn" :class="{ 'active': activeTab === 'nav' }" @click="activeTab = 'nav'">2. Navigasi & Hero</button>
                <button type="button" class="tab-btn" :class="{ 'active': activeTab === 'ppdb' }" @click="activeTab = 'ppdb'">3. PPDB & Banner</button>
                <button type="button" class="tab-btn" :class="{ 'active': activeTab === 'profile' }" @click="activeTab = 'profile'">4. Profil & Visi Misi</button>
                <button type="button" class="tab-btn" :class="{ 'active': activeTab === 'units' }" @click="activeTab = 'units'">5. Unit Pendidikan</button>
                <button type="button" class="tab-btn" :class="{ 'active': activeTab === 'curriculum' }" @click="activeTab = 'curriculum'">6. Kurikulum & Program</button>
                <button type="button" class="tab-btn" :class="{ 'active': activeTab === 'layout' }" @click="activeTab = 'layout'">7. Widget & Statistik</button>
                <button type="button" class="tab-btn" :class="{ 'active': activeTab === 'data2' }" @click="activeTab = 'data2'">8. Fasilitas & Ekskul</button>
                <button type="button" class="tab-btn" :class="{ 'active': activeTab === 'seo' }" @click="activeTab = 'seo'">9. SEO & Analytics</button>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- TAB 1: IDENTITAS & KONTAK -->
                <div x-show="activeTab === 'identity'" style="display: none;" x-transition>
                    <div class="setting-section">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Informasi Kontak (Top Bar, Footer & Chat)
                        </h3>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label class="form-label">Telepon Kantor / Utama</label>
                                <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '(0267) 1234-567' }}">
                                <span class="form-text">Ditampilkan di bar paling atas dan footer.</span>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nomor WhatsApp Utama (Chat Floating)</label>
                                <input type="text" name="whatsapp_number" class="form-control" value="{{ $settings['whatsapp_number'] ?? ($settings['contact_phone'] ?? '6281234567890') }}" placeholder="Contoh: 6281234567890">
                                <span class="form-text">Gunakan format internasional diawali 62 (contoh: 6281234567890).</span>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email Utama</label>
                                <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? 'info@alirsyadkarawang.sch.id' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jam Operasional</label>
                                <input type="text" name="contact_hours" class="form-control" value="{{ $settings['contact_hours'] ?? 'Senin - Jumat (07:00 - 15:30)' }}">
                            </div>
                            <div class="form-group" style="grid-column: span 2;">
                                <label class="form-label">Tautan Website SPMB / PPDB Online Global</label>
                                <input type="text" name="contact_ppdb_link" class="form-control" value="{{ $settings['contact_ppdb_link'] ?? '#' }}" placeholder="https://spmb.alirsyadkarawang.sch.id">
                                <span class="form-text">Tautan default tombol SPMB pada menu navbar dan footer.</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alamat Lengkap Lembaga</label>
                            <textarea name="contact_address" class="form-control" rows="2">{{ $settings['contact_address'] ?? 'Jl. Raya Telukjambe, Sukaluyu, Telukjambe Timur, Karawang, Jawa Barat 41361' }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Deskripsi Singkat Lembaga di Footer</label>
                            <textarea name="footer_desc" class="form-control" rows="3">{{ $settings['footer_desc'] ?? 'LPP (Lajnah Pendidikan dan Pengajaran) Al Irsyad Al Islamiyyah Karawang menaungi dan mengelola seluruh unit pendidikan Islam terpadu (KB-TK, SDIT, SMPIT, SMAIT) yang berlandaskan Al-Qur\'an, As-Sunnah, dan keunggulan sains-teknologi global.' }}</textarea>
                            <span class="form-text">Ditampilkan di kolom kiri bawah pada footer website.</span>
                        </div>
                    </div>

                    <div class="setting-section">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Media Sosial Resmi Lembaga
                        </h3>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label class="form-label">Facebook URL</label>
                                <input type="text" name="social_facebook" class="form-control" value="{{ $settings['social_facebook'] ?? '#' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Instagram URL</label>
                                <input type="text" name="social_instagram" class="form-control" value="{{ $settings['social_instagram'] ?? '#' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">YouTube URL</label>
                                <input type="text" name="social_youtube" class="form-control" value="{{ $settings['social_youtube'] ?? '#' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Twitter / X URL</label>
                                <input type="text" name="social_twitter" class="form-control" value="{{ $settings['social_twitter'] ?? '#' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: NAVIGASI & HERO -->
                <div x-show="activeTab === 'nav'" style="display: none;" x-transition>
                    <div class="setting-section"
                        x-data="dynamicList({{ $settings['navbar_links'] ?? "[{'label':'Beranda', 'url':'/'}, {'label':'Ketua LPP', 'url':'#welcome'}, {'label':'Unit Pendidikan', 'url':'#unit-pendidikan'}, {'label':'Kurikulum Khas', 'url':'#kurikulum-khas'}, {'label':'Fasilitas', 'url':'#programs'}, {'label':'Berita', 'url':'/berita'}]" }})">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--primary-color);">
                            Menu Navigasi Website
                        </h3>
                        <span class="form-text" style="margin-bottom: 1rem;">Atur item menu pada header website. Tombol 'SPMB Online' diatur otomatis di sebelah kanan menu.</span>

                        <template x-for="(item, index) in items" :key="index">
                            <div class="dynamic-row">
                                <div class="dynamic-row-content" style="grid-template-columns: 1fr 1.5fr;">
                                    <input type="text" x-model="item.label" :name="`navbar_links[${index}][label]`" class="form-control" placeholder="Label Menu (ex: Profil)">
                                    <input type="text" x-model="item.url" :name="`navbar_links[${index}][url]`" class="form-control" placeholder="URL atau Anchor (ex: #unit-pendidikan atau /berita)">
                                </div>
                                <button type="button" @click="removeItem(index)" class="btn btn-danger" style="padding: 0.75rem; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px;">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </div>
                        </template>
                        <button type="button" @click="addItem({label: '', url: ''})" class="btn" style="background: var(--bg-body); border: 1px dashed var(--border-color); width: 100%;">
                            <i data-feather="plus"></i> Tambah Menu Navigasi
                        </button>
                    </div>

                    <div class="setting-section">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Slide Utama Beranda (Hero Slide 1)
                        </h3>
                        <div class="form-group">
                            <label class="form-label">Headline (Judul Utama Slide 1)</label>
                            <input type="text" name="hero_title" class="form-control" value="{{ $settings['hero_title'] ?? "Pendidikan Islam Terpadu & Rabbani\nLPP Al Irsyad Al Islamiyyah" }}">
                            <span class="form-text">Gunakan Enter / baris baru jika ingin teks judul bertingkat 2 baris.</span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sub-Headline (Deskripsi Pengantar Slide 1)</label>
                            <textarea name="hero_subtitle" class="form-control" rows="3">{{ $settings['hero_subtitle'] ?? 'Lajnah Pendidikan dan Pengajaran (LPP) Al Irsyad Karawang mengelola dan membina jenjang KB-TK, SDIT, SMPIT, hingga SMAIT dengan perpaduan nilai tauhid, adab nabawiyah, dan sains teknologi modern.' }}</textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label class="form-label">Teks Tombol Aksi Utama</label>
                                <input type="text" name="hero_btn_text" class="form-control" value="{{ $settings['hero_btn_text'] ?? 'Daftar SPMB Online' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tautan Tombol Aksi Utama</label>
                                <input type="text" name="hero_btn_link" class="form-control" value="{{ $settings['hero_btn_link'] ?? '#' }}">
                            </div>
                        </div>

                        <div class="form-group" style="padding: 1rem; border: 1px dashed var(--border-color); border-radius: 8px;">
                            <label class="form-label">Tipe Background Slide 1</label>
                            <select name="hero_bg_type" class="form-control" style="margin-bottom: 1rem;">
                                <option value="image" {{ ($settings['hero_bg_type'] ?? 'image') == 'image' ? 'selected' : '' }}>Gambar Latar (Image)</option>
                                <option value="color" {{ ($settings['hero_bg_type'] ?? '') == 'color' ? 'selected' : '' }}>Warna Gradasi Solid Bawaan Tema</option>
                            </select>
                            <label class="form-label">URL Gambar Latar Slide 1</label>
                            <input type="text" name="hero_bg_image" class="form-control" value="{{ $settings['hero_bg_image'] ?? 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&q=80&w=1920' }}">
                            <span class="form-text">Bisa menggunakan link gambar online (Unsplash/CDN) atau path file lokal.</span>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: PPDB & BANNER -->
                <div x-show="activeTab === 'ppdb'" style="display: none;" x-transition>
                    <div class="setting-section">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Pengaturan Konten Banner Pendaftaran (SPMB / PPDB)
                        </h3>

                        <div class="form-group">
                            <label class="form-label">Label / Tagline Badge PPDB di Beranda</label>
                            <input type="text" name="ppdb_badge" class="form-control" value="{{ $settings['ppdb_badge'] ?? 'SPMB TA 2025/2026 - LPP Al Irsyad Karawang' }}" placeholder="Contoh: SPMB TA 2025/2026 - LPP Al Irsyad Karawang">
                            <span class="form-text">Muncul pada badge animasi di bagian atas hero slide utama.</span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Judul Utama Banner PPDB (Tengah Beranda)</label>
                            <input type="text" name="ppdb_title" class="form-control" value="{{ $settings['ppdb_title'] ?? 'Pendaftaran Santri Baru (SPMB) Telah Dibuka!' }}" placeholder="Pendaftaran Santri Baru (SPMB) Telah Dibuka!">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Deskripsi Lengkap Banner PPDB</label>
                            <textarea name="ppdb_desc" class="form-control" rows="3" placeholder="Deskripsi informasi pendaftaran...">{{ $settings['ppdb_desc'] ?? 'Raih kesempatan emas mendaftarkan putra-putri tercinta di unit pendidikan unggulan LPP Al Irsyad Karawang (KB-TK, SDIT, SMPIT, SMAIT).' }}</textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label class="form-label">Teks Tombol Banner PPDB</label>
                                <input type="text" name="ppdb_btn_text" class="form-control" value="{{ $settings['ppdb_btn_text'] ?? 'Daftar Sekarang' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nomor WhatsApp Khusus Konsultasi SPMB</label>
                                <input type="text" name="ppdb_wa_number" class="form-control" value="{{ $settings['ppdb_wa_number'] ?? ($settings['whatsapp_number'] ?? ($settings['contact_phone'] ?? '6281234567890')) }}" placeholder="Contoh: 6281234567890">
                                <span class="form-text">Nomor yang dihubungi calon orang tua saat menekan tombol Chat SPMB.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 4: PROFIL & VISI MISI -->
                <div x-show="activeTab === 'profile'" style="display: none;" x-transition>
                    <div class="setting-section">
                        <div class="toggle-wrap" style="margin-bottom: 1.5rem;">
                            <div>
                                <span class="toggle-label">Tampilkan Seksi Sambutan Ketua LPP</span>
                                <span class="toggle-desc">Menampilkan foto dan sambutan pimpinan lembaga di beranda</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="home_show_headmaster" value="1" {{ ($settings['home_show_headmaster'] ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="home_headmaster_name">Nama Lengkap & Gelar Ketua LPP</label>
                            <input type="text" id="home_headmaster_name" name="home_headmaster_name" class="form-control" value="{{ $settings['home_headmaster_name'] ?? 'Ketua LPP Al Irsyad Karawang' }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="home_headmaster_image">Foto Ketua LPP <small>(Disarankan foto vertikal/kotak jernih, JPG/PNG)</small></label>
                            @if(isset($settings['home_headmaster_image']) && $settings['home_headmaster_image'])
                                <div style="margin-bottom: 1rem; display: flex; align-items: center; gap: 12px;">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($settings['home_headmaster_image']) }}" alt="Ketua LPP" style="height: 100px; border-radius: 8px; border: 1px solid var(--border-color); object-fit: cover;">
                                    <span class="form-text">Foto saat ini terpasang. Pilih file di bawah jika ingin mengganti.</span>
                                </div>
                            @endif
                            <input type="file" id="home_headmaster_image" name="home_headmaster_image" class="form-control" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="home_headmaster_welcome">Isi Sambutan Ketua LPP</label>
                            <input id="home_headmaster_welcome" type="hidden" name="home_headmaster_welcome" value="{{ $settings['home_headmaster_welcome'] ?? '' }}">
                            <trix-editor input="home_headmaster_welcome" class="trix-content"></trix-editor>
                            <span class="form-text">Jika dikosongkan, teks sambutan standar Lembaga Al Irsyad akan otomatis digunakan.</span>
                        </div>
                    </div>

                    <div class="setting-section">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Visi & Misi Lembaga (LPP)
                        </h3>
                        <div class="form-group">
                            <label class="form-label">Pernyataan Visi Lembaga</label>
                            <textarea name="school_vision" class="form-control" rows="3">{{ $settings['school_vision'] ?? 'Menjadi Lembaga Dakwah Pendidikan Terdepan Dalam Akhlak & Prestasi Serta Menjadi Teladan Bagi Lembaga Lain' }}</textarea>
                        </div>

                        @php
                            $defaultMissionsJson = json_encode([
                                ['text' => 'Menjalankan pendidikan terbaik dalam Akhlak, Al quran, Bahasa Arab dan Bahasa Inggris'],
                                ['text' => 'Menciptakan lingkungan yang mendukung LPP, guru dan siswa untuk berprestasi ditingkat Nasional maupun Internasional'],
                                ['text' => 'Memiliki lembaga training yang mensupport pendidikan di internal maupun eksternal'],
                                ['text' => 'Meningkatkan kualifikasi dan kompetensi SDM dan memiliki karakter da\'i dibidang pendidikan'],
                                ['text' => 'Meningkatkan system pendidikan hingga bertaraf Internasional'],
                                ['text' => 'Melakukan pengembangan lembaga untuk meningkatkan layanan pendidikan kepada masyarakat luas'],
                                ['text' => 'Menyiapkan sarana prasarana pendidikan yang memadai'],
                                ['text' => 'Layak menjadi teladan bagi lembaga lain']
                            ]);
                        @endphp
                        <div class="form-group" x-data="dynamicList({{ !empty($settings['school_missions']) ? $settings['school_missions'] : $defaultMissionsJson }})">
                            <label class="form-label">Poin-Poin Misi Lembaga</label>
                            <template x-for="(item, index) in items" :key="index">
                                <div class="dynamic-row">
                                    <div style="font-weight: 700; color: var(--primary-color); min-width: 24px; padding-top: 0.75rem;" x-text="index + 1 + '.'"></div>
                                    <div class="dynamic-row-content" style="grid-template-columns: 1fr;">
                                        <input type="text" x-model="item.text" :name="`school_missions[${index}][text]`" class="form-control" placeholder="Pernyataan Misi...">
                                    </div>
                                    <button type="button" @click="removeItem(index)" class="btn btn-danger" style="padding: 0.75rem; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px;">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </div>
                            </template>
                            <button type="button" @click="addItem({text: ''})" class="btn" style="background: var(--bg-body); border: 1px dashed var(--border-color); width: 100%;">
                                <i data-feather="plus"></i> Tambah Poin Misi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- TAB 5: UNIT PENDIDIKAN -->
                <div x-show="activeTab === 'units'" style="display: none;" x-transition>
                    <div class="setting-section">
                        <div class="toggle-wrap" style="margin-bottom: 1.5rem;">
                            <div>
                                <span class="toggle-label">Tampilkan Seksi Unit Pendidikan</span>
                                <span class="toggle-desc">Menampilkan kartu jenjang pendidikan terpadu (KB-TK, SDIT, SMPIT, SMAIT)</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="home_show_units" value="1" {{ ($settings['home_show_units'] ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                            <div class="form-group">
                                <label class="form-label">Judul Seksi Unit Pendidikan</label>
                                <input type="text" name="units_section_title" class="form-control" value="{{ $settings['units_section_title'] ?? 'Unit Pendidikan LPP Al Irsyad' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tagline Kecil di Atas Judul</label>
                                <input type="text" name="units_section_tag" class="form-control" value="{{ $settings['units_section_tag'] ?? 'JENJANG PENDIDIKAN TERPADU' }}">
                            </div>
                            <div class="form-group" style="grid-column: span 2;">
                                <label class="form-label">Deskripsi Pengantar Seksi Unit</label>
                                <textarea name="units_section_desc" class="form-control" rows="2">{{ $settings['units_section_desc'] ?? 'LPP Al Irsyad Al Islamiyyah Karawang menyelenggarakan pendidikan berjenjang dan berkelanjutan dari usia emas anak (PAUD) hingga kematangan akademik tingkat menengah atas.' }}</textarea>
                            </div>
                        </div>

                        @php
                            $defaultUnitsJson = json_encode([
                                [
                                    'badge' => 'DAYCARE, KB & TK',
                                    'age' => 'Usia 0 - 6 Thn (Sejak Lahir)',
                                    'title' => 'Daycare, Playgroup & TK Islam Al Irsyad',
                                    'desc' => 'Layanan terpadu pengasuhan & pendidikan usia emas anak dalam 1 unit: Daycare sejak bayi (newborn/brojol), Playgroup, dan TK Islam berbasis metode Montessori Islami, stimulasi sensori motorik, serta adab nabawiyah sejak dini.',
                                    'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&q=80&w=600',
                                    'pills' => 'Daycare Sejak Bayi, Metode Montessori, Playgroup & TK, Tahfidz Balita',
                                    'spmb_link' => ''
                                ],
                                [
                                    'badge' => 'SEKOLAH DASAR',
                                    'age' => 'Kelas 1 - 6 SD',
                                    'title' => 'SDIT Al Irsyad 01 & 02',
                                    'desc' => 'Sekolah Dasar Islam Terpadu berakreditasi A (Unggul), mengintegrasikan kurikulum nasional, tahfidz intensif, dan pembelajaran sains aplikatif.',
                                    'image' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&q=80&w=600',
                                    'pills' => 'Akreditasi A Unggul, Tahfidz 2-3 Juz, Kelas Internasional (ICP)',
                                    'spmb_link' => ''
                                ],
                                [
                                    'badge' => 'MENENGAH PERTAMA',
                                    'age' => 'Kelas 7 - 9 SMP',
                                    'title' => 'SMPIT Al Irsyad Karawang',
                                    'desc' => 'Pembinaan karakter pemuda Rabbani melalui program Bina Pribadi Islami (BPI), bilingual habit aktif, bimbingan tahfidz, dan eksplorasi STEAM.',
                                    'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&q=80&w=600',
                                    'pills' => 'Bina Pribadi Islami, Bilingual Arab & Inggris, Kelas Internasional (ICP)',
                                    'spmb_link' => ''
                                ],
                                [
                                    'badge' => 'MENENGAH ATAS',
                                    'age' => 'Kelas 10 - 12 SMA',
                                    'title' => 'SMAIT Al Irsyad Karawang',
                                    'desc' => 'Mencetak kader pemimpin dan da\'i berprestasi tinggi yang siap menembus PTN favorit, kedinasan, kampus Timur Tengah, maupun perguruan tinggi dunia.',
                                    'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=600',
                                    'pills' => 'Lulusan PTN & Kedinasan, Sanad Tahfidz Lanjutan, Riset & Kelas Internasional',
                                    'spmb_link' => ''
                                ]
                            ]);
                        @endphp

                        <div x-data="dynamicList({{ !empty($settings['units_data']) ? $settings['units_data'] : $defaultUnitsJson }})">
                            <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem; color: var(--text-primary);">
                                Daftar Kartu Unit Pendidikan
                            </h4>

                            <template x-for="(item, index) in items" :key="index">
                                <div class="unit-card-editor">
                                    <div class="unit-card-editor-header">
                                        <strong style="color: var(--primary-color); font-size: 0.95rem;">
                                            Unit #<span x-text="index + 1"></span>: <span x-text="item.title || 'Unit Baru'"></span>
                                        </strong>
                                        <button type="button" @click="removeItem(index)" class="btn btn-danger" style="padding: 0.4rem 0.8rem; font-size: 0.8rem; background: #fee2e2; color: #dc2626; border: none; border-radius: 6px;">
                                            <i data-feather="trash-2" style="width: 14px; height: 14px;"></i> Hapus Unit
                                        </button>
                                    </div>

                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 0.75rem;">
                                        <div>
                                            <label class="form-label" style="font-size: 0.8rem;">Nama Unit</label>
                                            <input type="text" x-model="item.title" :name="`units_data[${index}][title]`" class="form-control" placeholder="Contoh: SDIT Al Irsyad 01 & 02" required>
                                        </div>
                                        <div>
                                            <label class="form-label" style="font-size: 0.8rem;">Badge Jenjang</label>
                                            <input type="text" x-model="item.badge" :name="`units_data[${index}][badge]`" class="form-control" placeholder="Contoh: SEKOLAH DASAR">
                                        </div>
                                    </div>

                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 0.75rem;">
                                        <div>
                                            <label class="form-label" style="font-size: 0.8rem;">Rentang Usia / Kelas</label>
                                            <input type="text" x-model="item.age" :name="`units_data[${index}][age]`" class="form-control" placeholder="Contoh: Kelas 1 - 6 SD">
                                        </div>
                                        <div>
                                            <label class="form-label" style="font-size: 0.8rem;">URL Foto Cover Unit</label>
                                            <input type="text" x-model="item.image" :name="`units_data[${index}][image]`" class="form-control" placeholder="https://...">
                                        </div>
                                    </div>

                                    <div class="form-group" style="margin-bottom: 0.75rem;">
                                        <label class="form-label" style="font-size: 0.8rem;">Deskripsi Singkat Keunggulan Unit</label>
                                        <textarea x-model="item.desc" :name="`units_data[${index}][desc]`" class="form-control" rows="2" placeholder="Deskripsi ringkas unit..."></textarea>
                                    </div>

                                    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 1rem;">
                                        <div>
                                            <label class="form-label" style="font-size: 0.8rem;">Poin-Poin Tag Keunggulan (Pisahkan dengan koma)</label>
                                            <input type="text" x-model="item.pills" :name="`units_data[${index}][pills]`" class="form-control" placeholder="Akreditasi A Unggul, Tahfidz 2 Juz, Smart Class">
                                        </div>
                                        <div>
                                            <label class="form-label" style="font-size: 0.8rem;">Link SPMB Unit (Opsional)</label>
                                            <input type="text" x-model="item.spmb_link" :name="`units_data[${index}][spmb_link]`" class="form-control" placeholder="Kosongkan jika pakai default">
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <button type="button" @click="addItem({title: '', badge: '', age: '', desc: '', image: '', pills: '', spmb_link: ''})" class="btn" style="background: var(--bg-body); border: 1px dashed var(--border-color); width: 100%;">
                                <i data-feather="plus"></i> Tambah Kartu Unit Pendidikan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- TAB 6: KURIKULUM & PROGRAM -->
                <div x-show="activeTab === 'curriculum'" style="display: none;" x-transition>
                    <!-- Pearson Partnership Hero Slide Configuration -->
                    <div class="setting-section" style="border-left: 4px solid #f59e0b;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--primary-color); display: flex; align-items: center; gap: 8px;">
                            <i data-feather="globe" style="color: #f59e0b;"></i> Slide Kerjasama Kurikulum Pearson (Hero Slider)
                        </h3>
                        <span class="form-text" style="margin-bottom: 1.25rem;">Pengaturan slide khusus program Sekolah Internasional / Pearson International Curriculum pada banner slider beranda.</span>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1rem;">
                            <div class="form-group">
                                <label class="form-label">Badge Label Slide</label>
                                <input type="text" name="pearson_slide_badge" class="form-control" value="{{ $settings['pearson_slide_badge'] ?? 'OFFICIAL PEARSON EDEXCEL PARTNER' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Link Tombol Slide</label>
                                <input type="text" name="pearson_slide_link" class="form-control" value="{{ $settings['pearson_slide_link'] ?? 'https://www.pearson.com' }}">
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label class="form-label">Judul Besar Slide</label>
                            <input type="text" name="pearson_slide_title" class="form-control" value="{{ $settings['pearson_slide_title'] ?? 'Sekolah Internasional & Kurikulum Pearson (UK)' }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Deskripsi / Subtitle Slide</label>
                            <textarea name="pearson_slide_subtitle" class="form-control" rows="2">{{ $settings['pearson_slide_subtitle'] ?? 'LPP Al Irsyad Al Islamiyyah Karawang menyelenggarakan International Class Program (ICP) yang mengadopsi kurikulum internasional Pearson Edexcel, memadukan standar akademik dunia, bilingual aktif (Inggris & Arab), serta adab tauhid Rabbani.' }}</textarea>
                        </div>
                    </div>

                    <div class="setting-section">
                        <div class="toggle-wrap" style="margin-bottom: 1.5rem;">
                            <div>
                                <span class="toggle-label">Tampilkan Seksi Kurikulum Khas & Program Unggulan</span>
                                <span class="toggle-desc">Menampilkan showcase pilar kurikulum khas dan kartu program unggulan</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="home_show_curriculum" value="1" {{ ($settings['home_show_curriculum'] ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Showcase Kurikulum Khas Terpadu Al Irsyad
                        </h3>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                            <div class="form-group">
                                <label class="form-label">Tagline Showcase</label>
                                <input type="text" name="curriculum_tag" class="form-control" value="{{ $settings['curriculum_tag'] ?? 'KURIKULUM KHAS TERPADU' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Judul Besar Showcase</label>
                                <input type="text" name="curriculum_headline" class="form-control" value="{{ $settings['curriculum_headline'] ?? 'Fondasi Adab Qur\'ani & Keunggulan Intelektual' }}">
                            </div>
                            <div class="form-group" style="grid-column: span 2;">
                                <label class="form-label">Deskripsi Showcase Kurikulum</label>
                                <textarea name="curriculum_desc" class="form-control" rows="3">{{ $settings['curriculum_desc'] ?? 'Kurikulum Khas dirancang secara komprehensif memadukan Kurikulum Merdeka Nasional dengan Kurikulum Internasional Pearson (UK), hafalan Al-Qur\'an bersanad, kemampuan bilingual aktif (Arab & Inggris), serta adab luhur sesuai teladan Rasulullah ﷺ.' }}</textarea>
                            </div>
                        </div>

                        @php
                            $defaultPillarsJson = json_encode([
                                [
                                    'icon' => 'book-open',
                                    'title' => '1. Tahfidz & Tahsin Bersanad',
                                    'desc' => 'Bimbingan talaqqi intensif, munaqosyah bersanad, tasmi\' berkala, dan sertifikasi tahfidz mutqin.'
                                ],
                                [
                                    'icon' => 'heart',
                                    'title' => '2. Bina Pribadi Islami (BPI)',
                                    'desc' => 'Pembiasaan adab nabawiyah, sholat fardhu & dhuha berjamaah, dzikir matsurat, serta adab birrul walidain.'
                                ],
                                [
                                    'icon' => 'globe',
                                    'title' => '3. Pearson Curriculum & Bilingual',
                                    'desc' => 'Adopsi kurikulum internasional Pearson (UK), daily immersion bahasa Inggris & Arab, dan persiapan kualifikasi global.'
                                ],
                                [
                                    'icon' => 'cpu',
                                    'title' => '4. STEAM & Coding Literacy',
                                    'desc' => 'Eksperimen sains aplikatif, nalar berpikir komputasi, robotic dasar, dan literasi teknologi era digital.'
                                ]
                            ]);
                        @endphp

                        <div x-data="dynamicList({{ !empty($settings['curriculum_pillars']) ? $settings['curriculum_pillars'] : $defaultPillarsJson }})" style="margin-bottom: 2rem;">
                            <label class="form-label" style="font-weight: 700; color: var(--primary-color);">4 Pilar Utama Kurikulum Khas</label>
                            <span class="form-text" style="margin-bottom: 1rem;">Gunakan nama icon dari <a href="https://feathericons.com/" target="_blank">Feather Icons</a> (misal: book-open, heart, globe, cpu, code, award).</span>

                            <template x-for="(item, index) in items" :key="index">
                                <div class="dynamic-row">
                                    <div class="dynamic-row-content" style="grid-template-columns: 100px 1.5fr 2.5fr;">
                                        <input type="text" x-model="item.icon" :name="`curriculum_pillars[${index}][icon]`" class="form-control" placeholder="Icon">
                                        <input type="text" x-model="item.title" :name="`curriculum_pillars[${index}][title]`" class="form-control" placeholder="Judul Pilar">
                                        <input type="text" x-model="item.desc" :name="`curriculum_pillars[${index}][desc]`" class="form-control" placeholder="Keterangan Pilar">
                                    </div>
                                    <button type="button" @click="removeItem(index)" class="btn btn-danger" style="padding: 0.75rem; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px;">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </div>
                            </template>
                            <button type="button" @click="addItem({icon: 'star', title: '', desc: ''})" class="btn" style="background: var(--bg-body); border: 1px dashed var(--border-color); width: 100%;">
                                <i data-feather="plus"></i> Tambah Pilar Kurikulum
                            </button>
                        </div>
                    </div>

                    <div class="setting-section" x-data="dynamicList({{ $settings['superior_programs'] ?? "[{'icon':'globe', 'title':'Pearson International Curriculum', 'desc':'Kurikulum internasional Pearson (UK) untuk penguasaan bahasa Inggris, matematika, dan sains global.'}, {'icon':'book', 'title':'Kurikulum Khas Al Irsyad', 'desc':'Kurikulum khusus Al Irsyad menyeimbangkan dunia dan akhirat berakar adab Qur\'ani.'}, {'icon':'heart', 'title':'Tahsin & Tahfidz Bersanad', 'desc':'Program talaqqi intensif dan munaqosyah hafalan Al-Qur\'an hingga bersanad mutqin.'}, {'icon':'monitor', 'title':'STEAM & Coding Dev', 'desc':'Pelatihan logika pemrograman dasar, eksperimen sains, dan robotika.'}]" }})">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--primary-color);">
                            Fokus Pengembangan & Program Unggulan (Grid Kartu)
                        </h3>
                        <span class="form-text" style="margin-bottom: 1rem;">Gunakan nama icon dari <a href="https://feathericons.com/" target="_blank">Feather Icons</a> (ex: globe, book, heart, monitor, star, shield)</span>

                        <template x-for="(item, index) in items" :key="index">
                            <div class="dynamic-row">
                                <div class="dynamic-row-content" style="grid-template-columns: 100px 1.5fr 2.5fr;">
                                    <input type="text" x-model="item.icon" :name="`superior_programs[${index}][icon]`" class="form-control" placeholder="Icon">
                                    <input type="text" x-model="item.title" :name="`superior_programs[${index}][title]`" class="form-control" placeholder="Judul Program">
                                    <input type="text" x-model="item.desc" :name="`superior_programs[${index}][desc]`" class="form-control" placeholder="Deskripsi Singkat">
                                </div>
                                <button type="button" @click="removeItem(index)" class="btn btn-danger" style="padding: 0.75rem; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px;">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </div>
                        </template>
                        <button type="button" @click="addItem({icon: 'award', title: '', desc: ''})" class="btn" style="background: var(--bg-body); border: 1px dashed var(--border-color); width: 100%;">
                            <i data-feather="plus"></i> Tambah Program Unggulan
                        </button>
                    </div>
                </div>

                <!-- TAB 7: WIDGET & STATISTIK -->
                <div x-show="activeTab === 'layout'" style="display: none;" x-transition>
                    <div class="setting-section">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Widget Jadwal Sholat (Aladhan API)
                        </h3>

                        <div class="toggle-wrap">
                            <div>
                                <span class="toggle-label">Tampilkan Widget Jadwal Sholat</span>
                                <span class="toggle-desc">Menghitung otomatis jadwal 5 waktu sholat berdasarkan koordinat lokasi</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="home_show_prayer" value="1" {{ ($settings['home_show_prayer'] ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem;">
                            <div class="form-group">
                                <label class="form-label">Koordinat Latitude (Karawang: -6.3227)</label>
                                <input type="text" name="prayer_lat" class="form-control" value="{{ $settings['prayer_lat'] ?? '-6.3227' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Koordinat Longitude (Karawang: 107.3075)</label>
                                <input type="text" name="prayer_lon" class="form-control" value="{{ $settings['prayer_lon'] ?? '107.3075' }}">
                            </div>
                        </div>
                    </div>

                    <div class="setting-section" x-data="dynamicList({{ $settings['stats_data'] ?? "[{'num':'4', 'label':'Unit Pendidikan (TK-SMA)'}, {'num':'1.500+', 'label':'Santri & Siswa Aktif'}, {'num':'120+', 'label':'Asatidz & Pendidik'}, {'num':'A', 'label':'Akreditasi Unggul'}, {'num':'300+', 'label':'Prestasi & Penghargaan'}]" }})">
                        <div class="toggle-wrap" style="margin-bottom: 1.5rem;">
                            <div>
                                <span class="toggle-label">Tampilkan Baris Angka Statistik</span>
                                <span class="toggle-desc">Menampilkan banner angka prestasi dan statistik lembaga</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="home_show_stats" value="1" {{ ($settings['home_show_stats'] ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <h4 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--primary-color);">Data Angka Statistik</h4>
                        <span class="form-text" style="margin-bottom: 1rem;">Maksimal 5 item untuk tampilan optimal di layar desktop.</span>

                        <template x-for="(item, index) in items" :key="index">
                            <div class="dynamic-row">
                                <div class="dynamic-row-content" style="grid-template-columns: 1fr 2fr;">
                                    <input type="text" x-model="item.num" :name="`stats_data[${index}][num]`" class="form-control" placeholder="Angka (ex: 1.500+)">
                                    <input type="text" x-model="item.label" :name="`stats_data[${index}][label]`" class="form-control" placeholder="Label Keterangan (ex: Santri & Siswa Aktif)">
                                </div>
                                <button type="button" @click="removeItem(index)" class="btn btn-danger" style="padding: 0.75rem; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px;">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </div>
                        </template>
                        <button type="button" @click="addItem({num: '', label: ''})" class="btn" style="background: var(--bg-body); border: 1px dashed var(--border-color); width: 100%;">
                            <i data-feather="plus"></i> Tambah Angka Statistik
                        </button>
                    </div>

                    <div class="setting-section">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Gaya Tampilan & Saklar Seksi Lainnya
                        </h3>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                            <div class="form-group">
                                <label class="form-label">Style Tampilan Agenda Kegiatan</label>
                                <select name="agenda_style" class="form-control">
                                    <option value="grid" {{ ($settings['agenda_style'] ?? 'grid') == 'grid' ? 'selected' : '' }}>Grid Kotak Besar (2 Kolom)</option>
                                    <option value="list" {{ ($settings['agenda_style'] ?? '') == 'list' ? 'selected' : '' }}>List Vertikal Minimalis</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Style Tampilan Berita Terkini</label>
                                <select name="news_style" class="form-control">
                                    <option value="grid3" {{ ($settings['news_style'] ?? 'grid3') == 'grid3' ? 'selected' : '' }}>Grid 3 Kolom</option>
                                    <option value="slider" {{ ($settings['news_style'] ?? '') == 'slider' ? 'selected' : '' }}>Carousel Slider Berita (Bisa Digeser)</option>
                                </select>
                            </div>
                            <div class="form-group" style="grid-column: span 2;">
                                <label class="form-label">Jumlah Maksimal Testimoni di Slider Beranda</label>
                                <input type="number" name="home_testimonials_limit" class="form-control" min="1" max="20" value="{{ $settings['home_testimonials_limit'] ?? '5' }}" placeholder="5">
                                <span class="form-text">Berapa banyak kartu testimoni yang dimuat di carousel beranda sebelum pengunjung mengklik tombol 'Lihat Semua Testimoni' (disarankan: 4 - 6).</span>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            @php
                                $toggles = [
                                    'home_show_news' => ['Tampilkan Seksi Berita Terkini', 'Berita & pengumuman dari database posts'],
                                    'home_show_events' => ['Tampilkan Seksi Agenda Kegiatan', 'Kalender kegiatan sekolah terdekat'],
                                    'home_show_testimonials' => ['Tampilkan Seksi Testimonial', 'Kutipan apresiasi orang tua, siswa, dan alumni'],
                                    'home_show_teachers' => ['Tampilkan Pimpinan & SDM', 'Daftar pendidik dari menu Data SDM & Pimpinan'],
                                ];
                            @endphp
                            @foreach($toggles as $key => $info)
                                <div class="toggle-wrap" style="margin-bottom: 0;">
                                    <div>
                                        <span class="toggle-label" style="font-size: 0.875rem;">{{ $info[0] }}</span>
                                        <span class="toggle-desc">{{ $info[1] }}</span>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" name="{{ $key }}" value="1" {{ ($settings[$key] ?? '1') == '1' ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- TAB 8: FASILITAS & EKSKUL -->
                <div x-show="activeTab === 'data2'" style="display: none;" x-transition>
                    <div class="setting-section">
                        <div class="toggle-wrap" style="margin-bottom: 1.5rem;">
                            <div>
                                <span class="toggle-label">Tampilkan Seksi Fasilitas & Ekstrakurikuler</span>
                                <span class="toggle-desc">Menampilkan daftar sarana kampus modern dan kegiatan ekstrakurikuler santri</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="home_show_facilities" value="1" {{ ($settings['home_show_facilities'] ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="setting-section" x-data="dynamicList({{ $settings['facilities_list'] ?? "[{'name':'Masjid Jami Al Irsyad'}, {'name':'Lab Komputer (iMac & PC)'}, {'name':'Perpustakaan Digital & E-Library'}, {'name':'Laboratorium Sains IPA & Fisika'}, {'name':'Sport Center (Futsal, Basket, Panahan)'}, {'name':'Ruang Kelas Smart AC & Proyektor'}]" }})">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--primary-color);">
                            Daftar Fasilitas Utama Sekolah
                        </h3>
                        <span class="form-text" style="margin-bottom: 1rem;">Daftar sarana penunjang yang tampil pada seksi Fasilitas Sekolah.</span>

                        <template x-for="(item, index) in items" :key="index">
                            <div class="dynamic-row">
                                <div class="dynamic-row-content" style="grid-template-columns: 1fr;">
                                    <input type="text" x-model="item.name" :name="`facilities_list[${index}][name]`" class="form-control" placeholder="Nama Fasilitas...">
                                </div>
                                <button type="button" @click="removeItem(index)" class="btn btn-danger" style="padding: 0.75rem; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px;">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </div>
                        </template>
                        <button type="button" @click="addItem({name: ''})" class="btn" style="background: var(--bg-body); border: 1px dashed var(--border-color); width: 100%;">
                            <i data-feather="plus"></i> Tambah Fasilitas
                        </button>
                    </div>

                    <div class="setting-section" x-data="dynamicList({{ $settings['extracurriculars_list'] ?? "[{'name':'Coding & Robotik', 'highlight':'1'}, {'name':'Tahfidz Club', 'highlight':'1'}, {'name':'Panahan Tradisional', 'highlight':'1'}, {'name':'Desain Grafis & Multimedia', 'highlight':'1'}, {'name':'Basket & Futsal', 'highlight':'0'}, {'name':'Pramuka SIT', 'highlight':'0'}, {'name':'English Club & Muhadhoroh', 'highlight':'0'}, {'name':'Pencak Silat', 'highlight':'0'}]" }})">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--primary-color);">
                            Daftar Ekstrakurikuler
                        </h3>
                        <span class="form-text" style="margin-bottom: 1rem;">Tandai 'Di-Highlight' untuk memberi lencana warna emas/hijau khusus.</span>

                        <template x-for="(item, index) in items" :key="index">
                            <div class="dynamic-row">
                                <div class="dynamic-row-content" style="grid-template-columns: 3fr 1fr;">
                                    <input type="text" x-model="item.name" :name="`extracurriculars_list[${index}][name]`" class="form-control" placeholder="Nama Ekskul (ex: Robotik, Panahan)">
                                    <select x-model="item.highlight" :name="`extracurriculars_list[${index}][highlight]`" class="form-control">
                                        <option value="0">Normal</option>
                                        <option value="1">Di-Highlight (Lencana Unggulan)</option>
                                    </select>
                                </div>
                                <button type="button" @click="removeItem(index)" class="btn btn-danger" style="padding: 0.75rem; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px;">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </div>
                        </template>
                        <button type="button" @click="addItem({name: '', highlight: '0'})" class="btn" style="background: var(--bg-body); border: 1px dashed var(--border-color); width: 100%;">
                            <i data-feather="plus"></i> Tambah Ekstrakurikuler
                        </button>
                    </div>
                </div>

                <!-- Sticky Submit Button -->
                <!-- SEO & ANALYTICS TAB -->
                <div x-show="activeTab === 'seo'" style="display: none;" x-transition>
                    <div class="setting-section">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            <i data-feather="search" style="width: 18px; height: 18px; margin-right: 6px; vertical-align: middle;"></i> Pengaturan SEO Global
                        </h3>
                        
                        <div class="form-group">
                            <label class="form-label" for="seo_default_title_format">Title Format</label>
                            <input type="text" id="seo_default_title_format" name="seo_default_title_format" class="form-control"
                                value="{{ old('seo_default_title_format', $settings['seo_default_title_format'] ?? '%title% - SDIT Al Irsyad') }}">
                            <small style="color: var(--text-secondary); display: block; margin-top: 4px;">Gunakan <code>%title%</code> sebagai variabel untuk judul halaman.</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="seo_default_description">Default Meta Description</label>
                            <textarea id="seo_default_description" name="seo_default_description" class="form-control" rows="3">{{ old('seo_default_description', $settings['seo_default_description'] ?? '') }}</textarea>
                            <small style="color: var(--text-secondary); display: block; margin-top: 4px;">Deskripsi ini akan digunakan jika halaman atau berita tidak memiliki deskripsi SEO khusus.</small>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="seo_default_keywords">Default Meta Keywords</label>
                            <input type="text" id="seo_default_keywords" name="seo_default_keywords" class="form-control"
                                value="{{ old('seo_default_keywords', $settings['seo_default_keywords'] ?? '') }}" placeholder="sekolah, islam, karawang, sdit">
                            <small style="color: var(--text-secondary); display: block; margin-top: 4px;">Pisahkan dengan tanda koma.</small>
                        </div>
                    </div>

                    <div class="setting-section">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            <i data-feather="share-2" style="width: 18px; height: 18px; margin-right: 6px; vertical-align: middle;"></i> Open Graph (Sosial Media)
                        </h3>
                        <p style="color: var(--text-secondary); font-size: 0.875rem; margin-bottom: 1rem;">Gambar default yang akan muncul saat link website dibagikan ke WhatsApp, Facebook, dll.</p>

                        <div class="form-group">
                            @if(!empty($settings['seo_default_image']))
                                <div style="margin-bottom: 1rem;">
                                    <img src="{{ Storage::url($settings['seo_default_image']) }}" alt="Default OG Image" style="max-width: 300px; border-radius: 8px; border: 1px solid var(--border-color);">
                                </div>
                            @endif
                            <input type="file" name="seo_default_image" class="form-control" accept="image/*">
                            <small style="color: var(--text-secondary); display: block; margin-top: 4px;">Disarankan ukuran 1200x630 pixels (Rasio 1.91:1).</small>
                        </div>
                    </div>

                    <div class="setting-section">
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            <i data-feather="bar-chart-2" style="width: 18px; height: 18px; margin-right: 6px; vertical-align: middle;"></i> Google Search Console & Google Analytics 4 (GA4)
                        </h3>
                        
                        <div class="form-group">
                            <label class="form-label" for="seo_google_site_verification">Google Site Verification Code (Search Console)</label>
                            <input type="text" id="seo_google_site_verification" name="seo_google_site_verification" class="form-control"
                                value="{{ old('seo_google_site_verification', $settings['seo_google_site_verification'] ?? '') }}" placeholder="Ketik kode verifikasi di sini (misal: google-site-verification=...)">
                            <span class="form-text">Digunakan untuk verifikasi kepemilikan website di Google Search Console.</span>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="seo_google_analytics">Google Analytics 4 Measurement ID (GA4)</label>
                            <input type="text" id="seo_google_analytics" name="seo_google_analytics" class="form-control"
                                value="{{ old('seo_google_analytics', $settings['seo_google_analytics'] ?? '') }}" placeholder="Contoh: G-XXXXXXXXXX">
                            <span class="form-text">Masukkan Measurement ID dari Google Analytics 4 (diawali huruf G-). Kosongkan jika tidak menggunakan GA4.</span>
                        </div>
                    </div>

                    <div class="setting-section">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--primary-color); margin: 0;">
                                <i data-feather="activity" style="width: 18px; height: 18px; margin-right: 6px; vertical-align: middle;"></i> Matomo Analytics (Self-Hosted & Cloud)
                            </h3>
                            <span style="background: #e0e7ff; color: #3730a3; padding: 2px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">Multi-Tracker Supported</span>
                        </div>
                        <p style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 1.25rem;">
                            Anda dapat mengaktifkan <strong>Matomo Self-Hosted</strong>, <strong>Matomo Cloud</strong>, atau <strong>keduanya sekaligus</strong>. Jika keduanya diisi, sistem secara otomatis menerapkan multi-tracking resmi Matomo tanpa memperlambat website.
                        </p>

                        <!-- Matomo Self-Hosted Box -->
                        <div style="background: var(--bg-body); border: 1px solid var(--border-color); border-radius: 8px; padding: 1.25rem; margin-bottom: 1.25rem;">
                            <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.75rem; display: flex; align-items: center; gap: 6px;">
                                <i data-feather="server" style="width: 16px; height: 16px; color: #0284c7;"></i> 1. Matomo Self-Hosted (Server Sendiri / VPS)
                            </h4>
                            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem;">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" for="matomo_self_hosted_url">URL Server Matomo Self-Hosted</label>
                                    <input type="text" id="matomo_self_hosted_url" name="matomo_self_hosted_url" class="form-control"
                                        value="{{ old('matomo_self_hosted_url', $settings['matomo_self_hosted_url'] ?? '') }}" placeholder="https://matomo.domain-sekolah.sch.id">
                                    <span class="form-text">URL instalasi Matomo di server Anda (bisa tanpa atau dengan slash di akhir).</span>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" for="matomo_self_hosted_site_id">Site ID Matomo</label>
                                    <input type="text" id="matomo_self_hosted_site_id" name="matomo_self_hosted_site_id" class="form-control"
                                        value="{{ old('matomo_self_hosted_site_id', $settings['matomo_self_hosted_site_id'] ?? '') }}" placeholder="1">
                                    <span class="form-text">Nomor ID situs (biasanya angka, misal: 1).</span>
                                </div>
                            </div>
                        </div>

                        <!-- Matomo Cloud Box -->
                        <div style="background: var(--bg-body); border: 1px solid var(--border-color); border-radius: 8px; padding: 1.25rem; margin-bottom: 1.25rem;">
                            <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.75rem; display: flex; align-items: center; gap: 6px;">
                                <i data-feather="cloud" style="width: 16px; height: 16px; color: #8b5cf6;"></i> 2. Matomo Cloud (Akun Resmi Cloud)
                            </h4>
                            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem;">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" for="matomo_cloud_url">URL Subdomain Matomo Cloud</label>
                                    <input type="text" id="matomo_cloud_url" name="matomo_cloud_url" class="form-control"
                                        value="{{ old('matomo_cloud_url', $settings['matomo_cloud_url'] ?? '') }}" placeholder="https://namaorganisasi.matomo.cloud">
                                    <span class="form-text">URL instans Cloud Anda (contoh: https://namasekolah.matomo.cloud).</span>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label class="form-label" for="matomo_cloud_site_id">Site ID Matomo Cloud</label>
                                    <input type="text" id="matomo_cloud_site_id" name="matomo_cloud_site_id" class="form-control"
                                        value="{{ old('matomo_cloud_site_id', $settings['matomo_cloud_site_id'] ?? '') }}" placeholder="1">
                                    <span class="form-text">Nomor ID situs di Matomo Cloud (misal: 1).</span>
                                </div>
                            </div>
                        </div>

                        <!-- Matomo Privacy Setting -->
                        <div class="toggle-wrap">
                            <div>
                                <span class="toggle-label">Mode Tanpa Cookie / Cookieless Tracking (GDPR / Privasi)</span>
                                <span class="toggle-desc">Mengaktifkan <code>_paq.push(['disableCookies']);</code> sehingga website tidak menanam cookie analitik di browser dan tidak memerlukan pop-up persetujuan cookie.</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="matomo_disable_cookies" value="1" {{ ($settings['matomo_disable_cookies'] ?? '0') == '1' ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); position: sticky; bottom: 0; background: var(--bg-card); padding-bottom: 20px; z-index: 50;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1rem; font-size: 1.1rem; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35); display: flex; align-items: center; gap: 8px;">
                        <i data-feather="save"></i> SIMPAN SEMUA PENGATURAN
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Alpine.js component for dynamic lists
        document.addEventListener('alpine:init', () => {
            Alpine.data('dynamicList', (initialData) => ({
                items: Array.isArray(initialData) && initialData.length > 0 ? initialData : [{}],
                addItem(template) {
                    this.items.push(Object.assign({}, template));
                    this.$nextTick(() => {
                        if (window.feather) feather.replace();
                    });
                },
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    } else {
                        alert('Minimal harus ada 1 baris data.');
                    }
                }
            }))
        });
    </script>
@endsection