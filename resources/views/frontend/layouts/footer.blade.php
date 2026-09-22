<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-logo">
                <h3 style="display: flex; align-items: center; gap: 10px;">
                    <div class="logo-emblem" style="width: 38px; height: 38px;">
                        <span style="font-size: 0.78rem;">LPP</span>
                    </div>
                    LPP AL IRSYAD
                </h3>
                <p style="color: #94a3b8; font-size: 0.9rem;">{{ $settings['footer_desc'] ?? 'LPP (Lajnah Pendidikan dan Pengajaran) Al Irsyad Al Islamiyyah Karawang menaungi dan mengelola seluruh unit pendidikan Islam terpadu (Daycare, KB-TK Montessori, SDIT, SMPIT, SMAIT) yang berlandaskan Al-Qur\'an, As-Sunnah, dan keunggulan sains-teknologi global.' }}</p>
                <div class="social-links">
                    <a href="{{ $settings['social_facebook'] ?? '#' }}" target="_blank" rel="noopener noreferrer"><i data-feather="facebook"></i></a>
                    <a href="{{ $settings['social_instagram'] ?? '#' }}" target="_blank" rel="noopener noreferrer"><i data-feather="instagram"></i></a>
                    <a href="{{ $settings['social_youtube'] ?? '#' }}" target="_blank" rel="noopener noreferrer"><i data-feather="youtube"></i></a>
                    <a href="{{ $settings['social_twitter'] ?? '#' }}" target="_blank" rel="noopener noreferrer"><i data-feather="twitter"></i></a>
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
                    <li><a href="{{ $settings['contact_ppdb_link'] ?? '#' }}">SPMB Online</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Unit & Layanan</h4>
                <ul class="footer-links">
                    <li><a href="/#unit-pendidikan">Daycare, KB & TK Islam Al Irsyad</a></li>
                    <li><a href="/#unit-pendidikan">SDIT Al Irsyad 01 & 02</a></li>
                    <li><a href="/#unit-pendidikan">SMPIT Al Irsyad Karawang</a></li>
                    <li><a href="/#unit-pendidikan">SMAIT Al Irsyad Karawang</a></li>
                    <li><a href="#">Sistem Informasi Lembaga</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Hubungi Kami</h4>
                <ul class="contact-list">
                    <li><i data-feather="map-pin"></i> <span>{{ $settings['contact_address'] ?? 'Jl. Raya Telukjambe, Sukaluyu, Telukjambe Timur, Karawang' }}</span></li>
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
    if (typeof feather !== 'undefined') {
        feather.replace();
    }

    window.addEventListener('scroll', function () {
        const navbar = document.getElementById('mainNavbar');
        if (!navbar) return;
        if (window.scrollY > 50) {
            navbar.classList.add('sticky-active');
        } else {
            navbar.classList.remove('sticky-active');
        }
    });

    function toggleMenu() {
        const menu = document.getElementById('navMenu');
        if (menu) menu.classList.toggle('active');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const navLinks = document.querySelectorAll('.nav-menu a');
        const menu = document.getElementById('navMenu');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (menu && menu.classList.contains('active')) {
                    menu.classList.remove('active');
                }
            });
        });

        document.addEventListener('click', function (e) {
            const toggle = document.querySelector('.mobile-toggle');
            if (menu && menu.classList.contains('active') && !menu.contains(e.target) && (!toggle || !toggle.contains(e.target))) {
                menu.classList.remove('active');
            }
        });
    });

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
