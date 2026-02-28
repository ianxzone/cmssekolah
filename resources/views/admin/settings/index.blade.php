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
            scrollbar-width: none;
        }

        .tabs-nav::-webkit-scrollbar {
            display: none;
        }

        .tab-btn {
            padding: 0.75rem 1.5rem;
            background: transparent;
            border: none;
            font-weight: 600;
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
            gap: 1rem;
        }
    </style>
@endpush

@section('content')
    <div class="panel" style="max-width: 1000px; margin: 0 auto;" x-data="{ activeTab: 'identity' }">
        <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="panel-title">Homepage & System Settings</h2>
            <!-- Note: Form submits from the bottom button, this is just visual -->
        </div>

        <div class="panel-body">
            @if(session('success'))
                <div
                    style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 500;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- Tabs Navigation -->
            <div class="tabs-nav">
                <button type="button" class="tab-btn" :class="{ 'active': activeTab === 'identity' }"
                    @click="activeTab = 'identity'">Identitas & Kontak</button>
                <button type="button" class="tab-btn" :class="{ 'active': activeTab === 'scripts' }"
                    @click="activeTab = 'scripts'">Scripts Kustom</button>
                <button type="button" class="tab-btn" :class="{ 'active': activeTab === 'nav' }"
                    @click="activeTab = 'nav'">Navigasi & Hero</button>
                <button type="button" class="tab-btn" :class="{ 'active': activeTab === 'layout' }"
                    @click="activeTab = 'layout'">Widget & Layout</button>
                <button type="button" class="tab-btn" :class="{ 'active': activeTab === 'profile' }"
                    @click="activeTab = 'profile'">Profil & Visi</button>
                <button type="button" class="tab-btn" :class="{ 'active': activeTab === 'data1' }"
                    @click="activeTab = 'data1'">Program & Stats</button>
                <button type="button" class="tab-btn" :class="{ 'active': activeTab === 'data2' }"
                    @click="activeTab = 'data2'">Ekskul & Fasilitas</button>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- TAB 1: IDENTITAS & KONTAK -->
                <div x-show="activeTab === 'identity'" style="display: none;" x-transition>
                    <div class="setting-section">
                        <h3
                            style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Identitas Sekolah (Branding)</h3>

                        <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label class="form-label">Nama Sekolah / Institusi</label>
                                <input type="text" name="school_name" class="form-control"
                                    value="{{ $settings['school_name'] ?? 'SDIT Al Irsyad' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Slogan / Tagline</label>
                                <input type="text" name="school_tagline" class="form-control"
                                    value="{{ $settings['school_tagline'] ?? 'Sekolah Islam Teladan' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Logo Utama Sekolah <small>(Horizontal, disarankan PNG
                                        transparan)</small></label>
                                @if(isset($settings['school_logo']) && $settings['school_logo'])
                                    <div
                                        style="margin-bottom: 1rem; background: var(--bg-body); padding: 10px; border-radius: 8px; display: inline-block;">
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($settings['school_logo']) }}"
                                            alt="School Logo" style="height: 40px; object-fit: contain;">
                                    </div>
                                @endif
                                <input type="file" name="school_logo" class="form-control" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Favicon <small>(Ikon Tab Browser, kotak 1:1, disarankan
                                        PNG/ICO)</small></label>
                                @if(isset($settings['school_favicon']) && $settings['school_favicon'])
                                    <div
                                        style="margin-bottom: 1rem; background: var(--bg-body); padding: 10px; border-radius: 8px; display: inline-block;">
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($settings['school_favicon']) }}"
                                            alt="School Favicon" style="height: 32px; width: 32px; object-fit: contain;">
                                    </div>
                                @endif
                                <input type="file" name="school_favicon" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div class="setting-section">
                        <h3
                            style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Informasi Kontak (Top Bar & Footer)</h3>

                        <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label class="form-label">Telepon Utama</label>
                                <input type="text" name="contact_phone" class="form-control"
                                    value="{{ $settings['contact_phone'] ?? '(0267) 1234-567' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email Utama</label>
                                <input type="email" name="contact_email" class="form-control"
                                    value="{{ $settings['contact_email'] ?? 'info@alirsyadkarawang.sch.id' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jam Operasional</label>
                                <input type="text" name="contact_hours" class="form-control"
                                    value="{{ $settings['contact_hours'] ?? 'Senin - Jumat (07:00 - 15:30)' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Website Tautan Laporan PPDB</label>
                                <input type="text" name="contact_ppdb_link" class="form-control"
                                    value="{{ $settings['contact_ppdb_link'] ?? '#' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="contact_address" class="form-control"
                                rows="3">{{ $settings['contact_address'] ?? 'Jl. Raya Telukjambe, Karawang Barat, Jawa Barat 41361' }}</textarea>
                        </div>
                    </div>

                    <div class="setting-section">
                        <h3
                            style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Media Sosial</h3>
                        <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label class="form-label">Facebook URL</label>
                                <input type="text" name="social_facebook" class="form-control"
                                    value="{{ $settings['social_facebook'] ?? '#' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Instagram URL</label>
                                <input type="text" name="social_instagram" class="form-control"
                                    value="{{ $settings['social_instagram'] ?? '#' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">YouTube URL</label>
                                <input type="text" name="social_youtube" class="form-control"
                                    value="{{ $settings['social_youtube'] ?? '#' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Twitter URL</label>
                                <input type="text" name="social_twitter" class="form-control"
                                    value="{{ $settings['social_twitter'] ?? '#' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: NAVIGASI & HERO -->
                <div x-show="activeTab === 'nav'" style="display: none;" x-transition>
                    <!-- TBD: Dynamic Navigation list with Alpine -->
                    <div class="setting-section"
                        x-data="dynamicList({{ $settings['navbar_links'] ?? "[{'label':'Beranda', 'url':'/'}, {'label':'Berita', 'url':'/posts'}]" }})">
                        <h3
                            style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--primary-color);">
                            Menu Navigasi</h3>
                        <span class="form-text mb-4">Atur tautan menu pada bagian atas web. Tombol 'SPMB Online' diatur
                            terpisah.</span>

                        <template x-for="(item, index) in items" :key="index">
                            <div class="dynamic-row">
                                <div class="dynamic-row-content" style="grid-template-columns: 1fr 1fr;">
                                    <input type="text" x-model="item.label" :name="`navbar_links[${index}][label]`"
                                        class="form-control" placeholder="Label Menu (ex: Profil)">
                                    <input type="text" x-model="item.url" :name="`navbar_links[${index}][url]`"
                                        class="form-control" placeholder="URL (ex: /profil)">
                                </div>
                                <button type="button" @click="removeItem(index)" class="btn btn-danger"
                                    style="padding: 0.75rem; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px;"><i
                                        data-feather="trash-2"></i></button>
                            </div>
                        </template>
                        <button type="button" @click="addItem({label: '', url: ''})" class="btn"
                            style="background: var(--bg-body); border: 1px dashed var(--border-color); width: 100%;"><i
                                data-feather="plus"></i> Tambah Menu</button>
                    </div>

                    <div class="setting-section">
                        <h3
                            style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Banner Utama (Hero Section) & PPDB</h3>
                        <div class="form-group">
                            <label class="form-label">Headline (Judul Utama)</label>
                            <input type="text" name="hero_title" class="form-control"
                                value="{{ $settings['hero_title'] ?? 'SMA Islam Teladan Al Irsyad Karawang' }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sub-Headline (Deskripsi Singkat)</label>
                            <textarea name="hero_subtitle" class="form-control"
                                rows="2">{{ $settings['hero_subtitle'] ?? 'Menjadi Sekolah Islam Teladan Yang Berakhlakul Karimah, Unggul Dalam Prestasi & Berdaya Guna Di Masyarakat.' }}</textarea>
                        </div>

                        <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label class="form-label">Teks Tombol PPDB CTA</label>
                                <input type="text" name="hero_btn_text" class="form-control"
                                    value="{{ $settings['hero_btn_text'] ?? 'Daftar Sekarang' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Link Tombol PPDB</label>
                                <input type="text" name="hero_btn_link" class="form-control"
                                    value="{{ $settings['hero_btn_link'] ?? '#' }}">
                            </div>
                        </div>

                        <div class="form-group"
                            style="padding: 1rem; border: 1px dashed var(--border-color); border-radius: 8px;">
                            <label class="form-label">Tipe Background Hero</label>
                            <select name="hero_bg_type" class="form-control" style="margin-bottom: 1rem;">
                                <option value="color" {{ ($settings['hero_bg_type'] ?? '') == 'color' ? 'selected' : '' }}>
                                    Warna Solid / Gradasi Bawaan Tema</option>
                                <option value="image" {{ ($settings['hero_bg_type'] ?? 'image') == 'image' ? 'selected' : '' }}>Gambar Statis</option>
                            </select>
                            <label class="form-label">Gambar Latar Hero URL (Jika Tipe Gambar)</label>
                            <input type="text" name="hero_bg_image" class="form-control"
                                value="{{ $settings['hero_bg_image'] ?? 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&q=80&w=1920' }}">
                            <span class="form-text">Masukkan URL eksternal gambar. Untuk upload lokal, gunakan Trix
                                attachment di form lain lalu copy URLnya.</span>
                        </div>

                        <h3
                            style="font-size: 1.125rem; font-weight: 600; margin-top: 2rem; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Banner PPDB Sidebar (Semua Halaman)</h3>
                        <div class="form-group">
                            <label class="form-label">Judul Banner PPDB</label>
                            <input type="text" name="sidebar_ppdb_title" class="form-control"
                                value="{{ $settings['sidebar_ppdb_title'] ?? 'PPDB Dibuka!' }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Deskripsi Singkat PPDB</label>
                            <textarea name="sidebar_ppdb_desc" class="form-control"
                                rows="2">{{ $settings['sidebar_ppdb_desc'] ?? 'Daftarkan putra-putri Anda sekarang juga.' }}</textarea>
                        </div>
                        <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label class="form-label">Teks Tombol Banner</label>
                                <input type="text" name="sidebar_ppdb_btn_text" class="form-control"
                                    value="{{ $settings['sidebar_ppdb_btn_text'] ?? 'Info Selengkapnya' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Link Tombol (Menggunakan Link PPDB di Tab Identitas)</label>
                                <input type="text" class="form-control" value="{{ $settings['contact_ppdb_link'] ?? '#' }}"
                                    disabled>
                                <small class="form-text">Edit di Tab Identitas & Kontak</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: WIDGET & LAYOUT -->
                <div x-show="activeTab === 'layout'" style="display: none;" x-transition>
                    <div class="setting-section">
                        <h3
                            style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Tampilan Seksi</h3>

                        <div class="toggle-wrap">
                            <div>
                                <span class="toggle-label">Tampilkan Jadwal Sholat</span>
                                <span class="toggle-desc">Menampilkan widget dari Aladhan API</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="home_show_prayer" value="1" {{ ($settings['home_show_prayer'] ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="grid"
                            style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem;">
                            <div class="form-group">
                                <label class="form-label">Kota Jadwal Sholat (Latitude)</label>
                                <input type="text" name="prayer_lat" class="form-control"
                                    value="{{ $settings['prayer_lat'] ?? '-6.3227' }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kota Jadwal Sholat (Longitude)</label>
                                <input type="text" name="prayer_lon" class="form-control"
                                    value="{{ $settings['prayer_lon'] ?? '107.3075' }}">
                            </div>
                        </div>
                    </div>

                    <div class="setting-section">
                        <h3
                            style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Gaya Layout</h3>

                        <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label class="form-label">Style Agenda Kegiatan</label>
                                <select name="agenda_style" class="form-control">
                                    <option value="grid" {{ ($settings['agenda_style'] ?? 'grid') == 'grid' ? 'selected' : '' }}>Grid Kotak Besar (2 Kolom)</option>
                                    <option value="list" {{ ($settings['agenda_style'] ?? '') == 'list' ? 'selected' : '' }}>
                                        List Vertikal Minimalis</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Style Berita Terkini</label>
                                <select name="news_style" class="form-control">
                                    <option value="grid3" {{ ($settings['news_style'] ?? 'grid3') == 'grid3' ? 'selected' : '' }}>Grid 3 Kolom</option>
                                    <option value="slider" {{ ($settings['news_style'] ?? '') == 'slider' ? 'selected' : '' }}>Carousel Slider Berita</option>
                                </select>
                            </div>
                        </div>

                        <!-- Common Visibility Toggles from original settings -->
                        <div class="grid"
                            style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 2rem;">
                            @php
                                $toggles = [
                                    'home_show_stats' => 'Tampilkan Baris Statistik',
                                    'home_show_news' => 'Tampilkan Berita Terkini',
                                    'home_show_events' => 'Tampilkan Agenda Kegiatan',
                                    'home_show_testimonials' => 'Tampilkan Testimonial',
                                    'home_show_facilities' => 'Tampilkan Fasilitas & Ekskul',
                                    'home_show_teachers' => 'Tampilkan Tenaga Pendidik',
                                ];
                            @endphp
                            @foreach($toggles as $key => $label)
                                <div class="toggle-wrap" style="margin-bottom: 0;">
                                    <span class="toggle-label" style="font-size: 0.875rem;">{{ $label }}</span>
                                    <label class="switch" style="transform: scale(0.8);">
                                        <input type="checkbox" name="{{ $key }}" value="1" {{ ($settings[$key] ?? '1') == '1' ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- TAB 4: PROFIL & VISI MISI -->
                <div x-show="activeTab === 'profile'" style="display: none;" x-transition>
                    <div class="setting-section">
                        <div class="toggle-wrap mb-4">
                            <div><span class="toggle-label">Tampilkan Sambutan Kepala Sekolah</span></div>
                            <label class="switch"><input type="checkbox" name="home_show_headmaster" value="1" {{ ($settings['home_show_headmaster'] ?? '1') == '1' ? 'checked' : '' }}><span
                                    class="slider"></span></label>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="home_headmaster_name">Nama Kepala Sekolah</label>
                            <input type="text" id="home_headmaster_name" name="home_headmaster_name" class="form-control"
                                value="{{ $settings['home_headmaster_name'] ?? 'Ustadz Ahmad Fauzi, S.Pd.I' }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="home_headmaster_image">Foto Kepala Sekolah <small>(Disarankan
                                    800x800 px, JPG/PNG)</small></label>
                            @if(isset($settings['home_headmaster_image']) && $settings['home_headmaster_image'])
                                <div style="margin-bottom: 1rem;">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($settings['home_headmaster_image']) }}"
                                        alt="Headmaster"
                                        style="height: 100px; border-radius: 8px; border: 1px solid var(--border-color);">
                                </div>
                            @endif
                            <input type="file" id="home_headmaster_image" name="home_headmaster_image" class="form-control"
                                accept="image/*">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="home_headmaster_welcome">Isi Sambutan</label>
                            <input id="home_headmaster_welcome" type="hidden" name="home_headmaster_welcome"
                                value="{{ $settings['home_headmaster_welcome'] ?? 'Selamat datang di SMA Islam Teladan Al Irsyad...' }}">
                            <trix-editor input="home_headmaster_welcome" class="trix-content"></trix-editor>
                        </div>
                    </div>

                    <div class="setting-section">
                        <h3
                            style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Visi & Misi</h3>
                        <div class="form-group">
                            <label class="form-label">Teks Visi (Satu Paragraf Pendek)</label>
                            <textarea name="school_vision" class="form-control"
                                rows="3">{{ $settings['school_vision'] ?? 'Menjadi Sekolah Islam Teladan Yang Berakhlakul Karimah, Unggul Dalam Prestasi & Berdaya Guna Di Masyarakat' }}</textarea>
                        </div>

                        <div class="form-group"
                            x-data="dynamicList({{ $settings['school_missions'] ?? "[{'text':'Mewujudkan lingkungan sekolah yang religius.'}]" }})">
                            <label class="form-label">Daftar Misi</label>
                            <template x-for="(item, index) in items" :key="index">
                                <div class="dynamic-row">
                                    <div class="dynamic-row-content" style="grid-template-columns: 1fr;">
                                        <input type="text" x-model="item.text" :name="`school_missions[${index}][text]`"
                                            class="form-control" placeholder="Pernyataan Misi...">
                                    </div>
                                    <button type="button" @click="removeItem(index)" class="btn btn-danger"
                                        style="padding: 0.75rem; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px;"><i
                                            data-feather="trash-2"></i></button>
                                </div>
                            </template>
                            <button type="button" @click="addItem({text: ''})" class="btn"
                                style="background: var(--bg-body); border: 1px dashed var(--border-color); width: 100%;"><i
                                    data-feather="plus"></i> Tambah Misi</button>
                        </div>
                    </div>
                </div>

                <!-- TAB 5: PROGRAM & STATS -->
                <div x-show="activeTab === 'data1'" style="display: none;" x-transition>
                    <div class="setting-section"
                        x-data="dynamicList({{ $settings['superior_programs'] ?? "[{'icon':'globe', 'title':'English Assessment', 'desc':'Keterangan...'}]" }})">
                        <h3
                            style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--primary-color);">
                            Program Unggulan</h3>
                        <span class="form-text mb-4">Gunakan nama icon dari <a href="https://feathericons.com/"
                                target="_blank">Feather Icons</a> (ex: globe, book, heart)</span>

                        <template x-for="(item, index) in items" :key="index">
                            <div class="dynamic-row">
                                <div class="dynamic-row-content" style="grid-template-columns: 80px 1fr 2fr;">
                                    <input type="text" x-model="item.icon" :name="`superior_programs[${index}][icon]`"
                                        class="form-control" placeholder="Icon">
                                    <input type="text" x-model="item.title" :name="`superior_programs[${index}][title]`"
                                        class="form-control" placeholder="Judul Program">
                                    <input type="text" x-model="item.desc" :name="`superior_programs[${index}][desc]`"
                                        class="form-control" placeholder="Deskripsi Singkat">
                                </div>
                                <button type="button" @click="removeItem(index)" class="btn btn-danger"
                                    style="padding: 0.75rem; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px;"><i
                                        data-feather="trash-2"></i></button>
                            </div>
                        </template>
                        <button type="button" @click="addItem({icon: '', title: '', desc: ''})" class="btn"
                            style="background: var(--bg-body); border: 1px dashed var(--border-color); width: 100%;"><i
                                data-feather="plus"></i> Tambah Program</button>
                    </div>

                    <div class="setting-section"
                        x-data="dynamicList({{ $settings['stats_data'] ?? "[{'num':'450+', 'label':'Siswa Aktif'}]" }})">
                        <h3
                            style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--primary-color);">
                            Statistik Sekolah</h3>
                        <span class="form-text mb-4">Maksimal 5 untuk tampilan optimal di desktop.</span>

                        <template x-for="(item, index) in items" :key="index">
                            <div class="dynamic-row">
                                <div class="dynamic-row-content" style="grid-template-columns: 1fr 2fr;">
                                    <input type="text" x-model="item.num" :name="`stats_data[${index}][num]`"
                                        class="form-control" placeholder="Angka (ex: 450+)">
                                    <input type="text" x-model="item.label" :name="`stats_data[${index}][label]`"
                                        class="form-control" placeholder="Label (ex: Siswa Aktif)">
                                </div>
                                <button type="button" @click="removeItem(index)" class="btn btn-danger"
                                    style="padding: 0.75rem; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px;"><i
                                        data-feather="trash-2"></i></button>
                            </div>
                        </template>
                        <button type="button" @click="addItem({num: '', label: ''})" class="btn"
                            style="background: var(--bg-body); border: 1px dashed var(--border-color); width: 100%;"><i
                                data-feather="plus"></i> Tambah Statistik</button>
                    </div>
                </div>

                <!-- TAB 6: GURU, EKSKUL, FASILITAS -->
                <div x-show="activeTab === 'data2'" style="display: none;" x-transition>

                    <div class="setting-section"
                        x-data="dynamicList({{ $settings['facilities_list'] ?? "[{'name':'Masjid Jami Al Irsyad'}]" }})">
                        <h3
                            style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Daftar Fasilitas Utama</h3>
                        <template x-for="(item, index) in items" :key="index">
                            <div class="dynamic-row">
                                <div class="dynamic-row-content" style="grid-template-columns: 1fr;">
                                    <input type="text" x-model="item.name" :name="`facilities_list[${index}][name]`"
                                        class="form-control" placeholder="Nama Fasilitas...">
                                </div>
                                <button type="button" @click="removeItem(index)" class="btn btn-danger"
                                    style="padding: 0.75rem; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px;"><i
                                        data-feather="trash-2"></i></button>
                            </div>
                        </template>
                        <button type="button" @click="addItem({name: ''})" class="btn"
                            style="background: var(--bg-body); border: 1px dashed var(--border-color); width: 100%;"><i
                                data-feather="plus"></i> Tambah Fasilitas</button>
                    </div>

                    <div class="setting-section"
                        x-data="dynamicList({{ $settings['extracurriculars_list'] ?? "[{'name':'Coding & Dev', 'highlight':'1'}]" }})">
                        <h3
                            style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color);">
                            Daftar Ekstrakurikuler</h3>
                        <template x-for="(item, index) in items" :key="index">
                            <div class="dynamic-row">
                                <div class="dynamic-row-content" style="grid-template-columns: 3fr 1fr;">
                                    <input type="text" x-model="item.name" :name="`extracurriculars_list[${index}][name]`"
                                        class="form-control" placeholder="Nama Ekskul (ex: Basket, Coding)">
                                    <select x-model="item.highlight" :name="`extracurriculars_list[${index}][highlight]`"
                                        class="form-control">
                                        <option value="0">Normal</option>
                                        <option value="1">Di-Highlight (Warna Khusus)</option>
                                    </select>
                                </div>
                                <button type="button" @click="removeItem(index)" class="btn btn-danger"
                                    style="padding: 0.75rem; background: #fee2e2; color: #dc2626; border: none; border-radius: 8px;"><i
                                        data-feather="trash-2"></i></button>
                            </div>
                        </template>
                        <button type="button" @click="addItem({name: '', highlight: '0'})" class="btn"
                            style="background: var(--bg-body); border: 1px dashed var(--border-color); width: 100%;"><i
                                data-feather="plus"></i> Tambah Ekskul</button>
                    </div>

                </div>

                <!-- TAB 7: CUSTOM SCRIPTS -->
                <div x-show="activeTab === 'scripts'" style="display: none;" x-transition>
                    <div class="setting-section">
                        <h3
                            style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--primary-color);">
                            Custom Header & Footer Scripts</h3>
                        <span class="form-text mb-4">Gunakan bagian ini untuk memasukkan kode kustom seperti Google
                            Analytics, Meta Pixel, atau custom CSS/JS.</span>

                        <div class="form-group">
                            <label class="form-label">Header Scripts (Diletakkan sebelum &lt;/head&gt;)</label>
                            <textarea name="custom_header_scripts" class="form-control" rows="8"
                                placeholder="<!-- Masukkan script header di sini -->">{{ $settings['custom_header_scripts'] ?? '' }}</textarea>
                        </div>

                        <div class="form-group" style="margin-top: 1.5rem;">
                            <label class="form-label">Footer Scripts (Diletakkan sebelum &lt;/body&gt;)</label>
                            <textarea name="custom_footer_scripts" class="form-control" rows="8"
                                placeholder="<!-- Masukkan script footer di sini -->">{{ $settings['custom_footer_scripts'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div
                    style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--border-color); position: sticky; bottom: 0; background: var(--bg-card); padding-bottom: 20px; z-index: 50;">
                    <button type="submit" class="btn btn-primary"
                        style="width: 100%; justify-content: center; padding: 1rem; font-size: 1.1rem; box-shadow: 0 4px 6px rgba(79, 70, 229, 0.3);">
                        <i data-feather="save"></i> SIMPAN SEMUA PENGATURAN HOMEPAGE
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
                    this.items.push(template);
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