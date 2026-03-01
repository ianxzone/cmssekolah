# Changelog

Semua perubahan penting dalam proyek ini akan dicatat dalam file ini. Format ini didasarkan pada [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) dan mengikuti standar [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2026-03-01
### Added
- **Sistem Tema Dinamis**: Mendukung penggantian tema (Modern & Default) langsung dari Admin Panel.
- **Tema Modern**: Desain baru dengan tipografi Plus Jakarta Sans, glassmorphism navbar, dan layout immersive.
- **Pengaturan Warna**: Kustomisasi warna Primary dan Secondary melalui Admin Settings.
- **Halaman Error Kustom**: Desain premium untuk halaman 404, 500, 403, 419, dan 429 yang sesuai dengan tema.
- **Sistem Shortcode**: Dukungan parsing shortcode di dalam konten post, page, dan event.

### Changed
- Refaktor struktur View menggunakan namespace `theme::`.
- Pembaruan UI Admin Panel (Visual Settings Tab).
- Layout Berita & Agenda menjadi model *single-column* untuk fokus bacaan.

### Fixed
- Error `View not found` saat berpindah sistem tema.
- Sinkronisasi label pada Color Picker di Admin Panel.

---

## [1.0.0] - 2026-02-27
### Added
- Rilis awal CMS Sekolah.
- CRUD Berita, Agenda, Halaman, dan Guru.
- Sistem Pendaftaran PPDB terintegrasi.
- Manajemen Media (Gallery).
