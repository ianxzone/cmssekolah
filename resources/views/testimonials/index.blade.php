<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimoni Orang Tua & Alumni | LPP Al Irsyad Karawang</title>
    <meta name="description" content="Kumpulan testimoni dan cerita pengalaman nyata dari orang tua santri, alumni, dan siswa LPP Al Irsyad Al Islamiyyah Karawang.">
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    
    <style>
        :root {
            --primary: #064e3b;
            --primary-light: #047857;
            --primary-dark: #022c22;
            --secondary: #fbbf24;
            --secondary-hover: #f59e0b;
            --accent: #10b981;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --white: #ffffff;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 20px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 15px rgba(0,0,0,0.06);
            --shadow-lg: 0 10px 25px rgba(0,0,0,0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--bg-light); color: var(--text-main); line-height: 1.6; display: flex; flex-direction: column; min-height: 100vh; }
        a { text-decoration: none; color: inherit; }
        .container { width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        /* Topbar & Navbar */
        .topbar { background: var(--primary-dark); color: #e2e8f0; font-size: 0.85rem; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .topbar .container { display: flex; justify-content: space-between; align-items: center; }
        .topbar-info { display: flex; gap: 20px; }
        .topbar-info div { display: flex; align-items: center; gap: 6px; }

        .navbar { background: var(--white); box-shadow: var(--shadow-sm); position: sticky; top: 0; z-index: 100; transition: var(--transition); }
        .navbar .container { display: flex; justify-content: space-between; align-items: center; height: 80px; }
        .logo { display: flex; align-items: center; gap: 12px; }
        .logo-emblem { width: 44px; height: 44px; background: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--secondary); font-weight: 800; font-size: 0.95rem; border: 2px solid var(--secondary); }
        .logo-text h1 { font-size: 1.15rem; font-weight: 800; color: var(--primary); line-height: 1.1; margin: 0; letter-spacing: -0.5px; }
        .logo-text p { font-size: 0.65rem; color: var(--text-muted); font-weight: 600; letter-spacing: 1px; margin: 0; }

        .nav-menu { display: flex; list-style: none; gap: 25px; align-items: center; }
        .nav-link { font-weight: 600; font-size: 0.95rem; color: var(--text-main); transition: var(--transition); }
        .nav-link:hover, .nav-link.active { color: var(--primary); }
        .nav-spmb { background: var(--primary); color: var(--white); padding: 10px 22px; border-radius: 50px; font-weight: 700; font-size: 0.9rem; transition: var(--transition); display: inline-block; }
        .nav-spmb:hover { background: var(--primary-light); color: var(--white); transform: translateY(-2px); }

        .mobile-toggle { display: none; cursor: pointer; color: var(--primary); }

        /* Page Hero */
        .page-hero {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            color: var(--white);
            padding: 70px 0 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .page-hero::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 80% 20%, rgba(251, 191, 36, 0.15) 0%, transparent 50%);
            pointer-events: none;
        }
        .page-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(251, 191, 36, 0.3);
            color: var(--secondary);
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 6px 16px;
            border-radius: 50px;
            margin-bottom: 15px;
        }
        .page-hero h1 { font-size: 2.8rem; font-weight: 800; margin-bottom: 15px; line-height: 1.2; }
        .page-hero p { font-size: 1.1rem; color: #cbd5e1; max-width: 720px; margin: 0 auto; line-height: 1.6; }

        /* Filter Pills */
        .filter-section {
            margin-top: -30px;
            margin-bottom: 45px;
            position: relative;
            z-index: 10;
        }
        .filter-wrap {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            background: var(--white);
            padding: 12px 20px;
            border-radius: 60px;
            box-shadow: var(--shadow-lg);
            max-width: 650px;
            margin: 0 auto;
            border: 1px solid #e2e8f0;
        }
        .filter-btn {
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-muted);
            transition: var(--transition);
            border: none;
            background: transparent;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .filter-btn:hover { color: var(--primary); background: #f1f5f9; }
        .filter-btn.active { background: var(--primary); color: var(--white); box-shadow: 0 4px 10px rgba(6, 78, 59, 0.25); }

        /* Testimonials Grid */
        .testi-page-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 60px;
        }
        .testi-page-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 35px 30px 30px;
            box-shadow: var(--shadow-md);
            border: 1px solid #e2e8f0;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }
        .testi-page-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            border-color: var(--primary-light);
        }
        .testi-stars { color: #f59e0b; font-size: 1.1rem; margin-bottom: 15px; display: flex; gap: 3px; }
        .testi-quote-mark { position: absolute; top: 25px; right: 25px; color: #e2e8f0; width: 40px; height: 40px; }
        .testi-text {
            font-size: 0.98rem;
            font-style: italic;
            color: #334155;
            line-height: 1.7;
            margin-bottom: 25px;
            flex-grow: 1;
        }
        .testi-author {
            display: flex;
            align-items: center;
            gap: 15px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
        }
        .testi-author-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid var(--secondary);
            flex-shrink: 0;
            box-shadow: var(--shadow-sm);
        }
        .testi-author-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .testi-author-info h4 { font-size: 1.02rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 2px; }
        .testi-author-occupation { font-size: 0.82rem; font-weight: 600; color: var(--primary); margin-bottom: 5px; display: flex; align-items: center; gap: 5px; }
        .testi-role-badge {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 20px;
            background: #f1f5f9;
            color: var(--text-muted);
        }
        .testi-role-badge.parent { background: #dcfce7; color: #166534; }
        .testi-role-badge.alumni { background: #fef3c7; color: #92400e; }
        .testi-role-badge.student { background: #e0e7ff; color: #3730a3; }

        /* Pagination */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: 70px;
        }

        /* CTA Banner */
        .cta-section {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            border-radius: var(--radius-lg);
            padding: 50px 40px;
            text-align: center;
            margin-bottom: 70px;
            box-shadow: var(--shadow-lg);
        }
        .cta-section h2 { font-size: 2rem; font-weight: 800; margin-bottom: 12px; }
        .cta-section p { font-size: 1.05rem; opacity: 0.9; max-width: 650px; margin: 0 auto 25px; }

        /* Footer */
        footer { background: #0f172a; color: #cbd5e1; padding: 70px 0 25px; margin-top: auto; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 40px; margin-bottom: 40px; }
        .footer-logo h3 { color: var(--white); font-size: 1.4rem; margin-bottom: 15px; font-weight: 800; }
        .footer-logo p { margin-bottom: 20px; font-size: 0.9rem; color: #94a3b8; }
        .social-links { display: flex; gap: 10px; }
        .social-links a { width: 38px; height: 38px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--white); transition: var(--transition); }
        .social-links a:hover { background: var(--secondary); color: var(--primary-dark); }
        .footer-col h4 { color: var(--white); font-size: 1.15rem; margin-bottom: 20px; font-weight: 700; }
        .footer-links li { margin-bottom: 10px; list-style: none; }
        .footer-links a:hover { color: var(--secondary); padding-left: 4px; }
        .contact-list li { display: flex; gap: 12px; margin-bottom: 12px; align-items: flex-start; list-style: none; font-size: 0.9rem; }
        .contact-list i { color: var(--secondary); margin-top: 4px; width: 16px; flex-shrink: 0; }
        .footer-bottom { text-align: center; padding-top: 25px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.85rem; display: flex; flex-direction: column; gap: 6px; }

        .mobile-fab-whatsapp {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #25D366;
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            box-shadow: 0 8px 20px rgba(37, 211, 102, 0.4);
            z-index: 99;
            transition: var(--transition);
        }
        .mobile-fab-whatsapp:hover { transform: translateY(-3px) scale(1.03); color: #fff; }

        @media (max-width: 1024px) {
            .testi-page-grid { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .topbar { display: none; }
            .mobile-toggle { display: block; }
            .nav-menu { position: absolute; top: 100%; left: 0; width: 100%; background: var(--white); flex-direction: column; padding: 16px 20px 24px; display: none; box-shadow: 0 15px 30px rgba(0,0,0,0.12); border-top: 1px solid #f1f5f9; }
            .nav-menu.active { display: flex; }
            .page-hero h1 { font-size: 2.1rem; }
            .testi-page-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .filter-wrap { border-radius: 16px; justify-content: flex-start; overflow-x: auto; }
        }
    </style>
</head>
<body>

    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="topbar-info">
                <div><i data-feather="phone" style="width: 14px;"></i> {{ $settings['contact_phone'] ?? '(0267) 1234-567' }}</div>
                <div><i data-feather="mail" style="width: 14px;"></i> {{ $settings['contact_email'] ?? 'info@alirsyadkarawang.sch.id' }}</div>
            </div>
            <div>Jam Operasional: {{ $settings['contact_hours'] ?? 'Senin - Jumat (07:00 - 15:30)' }}</div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar" id="mainNavbar">
        <div class="container">
            <a href="/" class="logo">
                <div class="logo-emblem">
                    <span>LPP</span>
                </div>
                <div class="logo-text">
                    <h1>LPP AL IRSYAD</h1>
                    <p>LAJNAH PENDIDIKAN & PENGAJARAN</p>
                </div>
            </a>
            <ul class="nav-menu" id="navMenu">
                <li><a href="/" class="nav-link">Beranda</a></li>
                <li><a href="/#welcome" class="nav-link">Ketua LPP</a></li>
                <li><a href="/#unit-pendidikan" class="nav-link">Unit Pendidikan</a></li>
                <li><a href="/#kurikulum-khas" class="nav-link">Kurikulum Khas</a></li>
                <li><a href="{{ route('posts.index') }}" class="nav-link">Berita</a></li>
                <li><a href="{{ route('testimonials.index') }}" class="nav-link active" style="color: var(--primary);">Testimoni</a></li>
                <li><a href="{{ $settings['contact_ppdb_link'] ?? '#' }}" class="nav-spmb">SPMB Online</a></li>
            </ul>
            <div class="mobile-toggle" onclick="toggleMenu()">
                <i data-feather="menu"></i>
            </div>
        </div>
    </nav>

    <!-- Page Hero -->
    <section class="page-hero">
        <div class="container">
            <span class="page-hero-badge">
                <i data-feather="heart" style="width:14px; height:14px;"></i> Cerita & Pengalaman Nyata
            </span>
            <h1>Apa Kata Mereka?</h1>
            <p>
                Apresiasi dan kisah inspiratif dari para orang tua santri, alumni, serta siswa yang telah merasakan dedikasi pendidikan beradab dan berprestasi di LPP Al Irsyad Al Islamiyyah Karawang.
            </p>
        </div>
    </section>

    <!-- Content & Filter -->
    <main class="container">
        @php
            $currentRole = request('role');
        @endphp

        <div class="filter-section">
            <div class="filter-wrap">
                <a href="{{ route('testimonials.index') }}" class="filter-btn {{ empty($currentRole) ? 'active' : '' }}">
                    <i data-feather="grid" style="width:14px; height:14px;"></i> Semua
                </a>
                <a href="{{ route('testimonials.index', ['role' => 'parent']) }}" class="filter-btn {{ $currentRole === 'parent' ? 'active' : '' }}">
                    <i data-feather="users" style="width:14px; height:14px;"></i> Orang Tua Santri
                </a>
                <a href="{{ route('testimonials.index', ['role' => 'alumni']) }}" class="filter-btn {{ $currentRole === 'alumni' ? 'active' : '' }}">
                    <i data-feather="award" style="width:14px; height:14px;"></i> Alumni
                </a>
                <a href="{{ route('testimonials.index', ['role' => 'student']) }}" class="filter-btn {{ $currentRole === 'student' ? 'active' : '' }}">
                    <i data-feather="smile" style="width:14px; height:14px;"></i> Siswa / Santri
                </a>
            </div>
        </div>

        @if($testimonials->count() > 0)
            <div class="testi-page-grid">
                @foreach($testimonials as $testi)
                    <article class="testi-page-card">
                        <i data-feather="message-square" class="testi-quote-mark"></i>
                        <div>
                            <div class="testi-stars">
                                ★★★★★
                            </div>
                            <p class="testi-text">
                                "{{ $testi->content }}"
                            </p>
                        </div>
                        <div class="testi-author">
                            <div class="testi-author-avatar">
                                <img src="{{ $testi->image_url ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=200' }}" alt="{{ $testi->name }}" onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=200'">
                            </div>
                            <div class="testi-author-info">
                                <h4>{{ $testi->name }}</h4>
                                @if(!empty($testi->occupation))
                                    <div class="testi-author-occupation">
                                        <i data-feather="briefcase" style="width: 12px; height: 12px; flex-shrink: 0;"></i>
                                        <span>{{ $testi->occupation }}</span>
                                    </div>
                                @endif
                                <span class="testi-role-badge {{ $testi->role }}">{{ $testi->role_label }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="pagination-wrap">
                {{ $testimonials->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; background: #fff; border-radius: var(--radius-lg); margin-bottom: 60px; border: 1px dashed #cbd5e1;">
                <i data-feather="message-circle" style="width: 48px; height: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                <h3 style="color: var(--text-muted); font-weight: 600;">Belum ada testimoni pada kategori ini.</h3>
                <a href="{{ route('testimonials.index') }}" class="btn" style="margin-top: 15px; display: inline-block; color: var(--primary); font-weight: 700;">Lihat Semua Testimoni</a>
            </div>
        @endif

        <!-- Bottom CTA -->
        <div class="cta-section">
            <h2>Wujudkan Generasi Rabbani & Berprestasi</h2>
            <p>Mari bergabung bersama ribuan keluarga muslim lainnya di Karawang dalam mendidik putra-putri tercinta berakar adab Qur'ani dan siap memimpin masa depan.</p>
            <a href="{{ $settings['contact_ppdb_link'] ?? '#' }}" class="nav-spmb" style="padding: 14px 35px; font-size: 1.05rem; background: var(--secondary); color: var(--primary-dark);">
                Daftar SPMB Online Sekarang <i data-feather="arrow-right" style="width:16px; height:16px; vertical-align: middle;"></i>
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-logo">
                    <h3 style="display: flex; align-items: center; gap: 10px;">
                        <div class="logo-emblem" style="width: 36px; height: 36px; font-size: 0.8rem;">
                            <span>LPP</span>
                        </div>
                        LPP AL IRSYAD
                    </h3>
                    <p>{{ $settings['footer_desc'] ?? 'LPP (Lajnah Pendidikan dan Pengajaran) Al Irsyad Al Islamiyyah Karawang menaungi dan mengelola seluruh unit pendidikan Islam terpadu (KB-TK, SDIT, SMPIT, SMAIT).' }}</p>
                    <div class="social-links">
                        <a href="{{ $settings['social_facebook'] ?? '#' }}"><i data-feather="facebook"></i></a>
                        <a href="{{ $settings['social_instagram'] ?? '#' }}"><i data-feather="instagram"></i></a>
                        <a href="{{ $settings['social_youtube'] ?? '#' }}"><i data-feather="youtube"></i></a>
                        <a href="{{ $settings['social_twitter'] ?? '#' }}"><i data-feather="twitter"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Tautan Cepat</h4>
                    <ul class="footer-links">
                        <li><a href="/">Beranda</a></li>
                        <li><a href="/#welcome">Ketua LPP</a></li>
                        <li><a href="/#unit-pendidikan">Unit Pendidikan</a></li>
                        <li><a href="/#kurikulum-khas">Kurikulum Khas</a></li>
                        <li><a href="{{ route('posts.index') }}">Berita & Artikel</a></li>
                        <li><a href="{{ route('testimonials.index') }}">Testimoni</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Unit Pendidikan</h4>
                    <ul class="footer-links">
                        <li><a href="/#unit-pendidikan">KB-TK Islam Al Irsyad</a></li>
                        <li><a href="/#unit-pendidikan">SDIT Al Irsyad 01 & 02</a></li>
                        <li><a href="/#unit-pendidikan">SMPIT Al Irsyad Karawang</a></li>
                        <li><a href="/#unit-pendidikan">SMAIT Al Irsyad Karawang</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Hubungi Kami</h4>
                    <ul class="contact-list">
                        <li><i data-feather="map-pin"></i> <span>{{ $settings['contact_address'] ?? 'Jl. Raya Telukjambe, Sukaluyu, Karawang' }}</span></li>
                        <li><i data-feather="phone"></i> <span>{{ $settings['contact_phone'] ?? '(0267) 1234-567' }}</span></li>
                        <li><i data-feather="mail"></i> <span>{{ $settings['contact_email'] ?? 'info@alirsyadkarawang.sch.id' }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} LPP Al Irsyad Al Islamiyyah Karawang. All rights reserved.</p>
                <span id="credit-link">Developed by <a href="https://www.murniabadi.co.id" target="_blank" style="color: var(--secondary); font-weight: 700;">MATEK</a></span>
            </div>
        </div>
    </footer>

    <!-- Mobile Floating WhatsApp Action Button -->
    @php
        $waNum = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? ($settings['ppdb_wa_number'] ?? ($settings['contact_phone'] ?? '6281234567890')));
        if (empty($waNum)) $waNum = '6281234567890';
    @endphp
    <a href="https://wa.me/{{ $waNum }}?text=Halo%20Admin%20Sekolah,%20saya%20ingin%20konsultasi%20pendaftaran%20SPMB." target="_blank" class="mobile-fab-whatsapp" aria-label="Konsultasi WhatsApp">
        <i data-feather="message-circle" style="width: 18px; height: 18px;"></i>
        <span>Chat SPMB</span>
    </a>

    <script>
        feather.replace();

        function toggleMenu() {
            const menu = document.getElementById('navMenu');
            menu.classList.toggle('active');
        }

        (function() {
            function checkCredit() {
                const credit = document.getElementById('credit-link');
                const link = credit ? credit.querySelector('a') : null;
                if (!credit || !link || link.getAttribute('href') !== 'https://www.murniabadi.co.id' || link.innerText.trim() !== 'MATEK') {
                    document.body.innerHTML = '<div style="background: #000; color: #fff; height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; font-family: sans-serif; padding: 20px;"><div><h1>System Dependency Error</h1><p>This template requires original attribution to function. Please restore the footer credit to MATEK.</p></div></div>';
                }
            }
            setInterval(checkCredit, 3000);
            window.addEventListener('load', checkCredit);
        })();
    </script>
</body>
</html>
