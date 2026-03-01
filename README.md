# CMS Sekolah Modern v2.0.0

[![Laravel Version](https://img.shields.io/badge/laravel-12.x-red)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/php-8.3-blue)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)

**CMS Sekolah Modern** adalah solusi manajemen konten (CMS) khusus untuk institusi pendidikan (SD/SMP/SMA/SMK) yang dibangun dengan Laravel. Versi 2.0.0 memperkenalkan sistem tema dinamis dengan desain yang sangat premium dan berfokus pada pengalaman pengguna yang ceria namun profesional.

---

## ✨ Fitur Unggulan

- 🎨 **Sistem Tema Dinamis**: Ganti tampilan website (Tema Modern & Default) dalam satu klik dari Admin Panel.
- 🌈 **Kustomisasi Warna**: Sesuaikan warna Primary & Secondary sekolah Anda tanpa menyentuh kode (Color Picker terintegrasi).
- 📱 **Desain Immersive & Responsif**: Tampilan artikel dan agenda dengan Hero Image raksasa yang modern dan adaptif di semua perangkat.
- 📝 **Manajemen Konten Lengkap**: Kelola Berita, Agenda, Halaman Statis, Guru, dan Testimoni dengan mudah.
- 📥 **PPDB Online Terintegrasi**: Sistem pendaftaran siswa baru yang mudah dikelola.
- 🖼️ **Media Manager**: Manajemen galeri foto dan file aset sekolah yang rapi.
- 🛠️ **Maintenance & Onboarding**: Mode pemeliharaan dan petunjuk instalasi yang memudahkan admin.
- 🚨 **Halaman Error Kustom**: Desain halaman 404, 500, dll yang konsisten dengan desain sekolah Anda.

---

## 🚀 Instalasi Cepat

1. **Clone Repository**
   ```bash
   git clone https://github.com/username/sdit.git
   cd sdit
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Konfigurasi Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Setup Database**
   Sesuaikan `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di `.env`, lalu jalankan:
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```

---

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 12.x
- **Frontend**: Blade Templating, Vanilla CSS (Premium Aesthetics)
- **Icons**: Feather Icons
- **Database**: MySQL / MariaDB
- **Editor**: Trix Editor

---

## 📄 Lisensi

Proyek ini berada di bawah lisensi **MIT**. Anda bebas menggunakan dan memodifikasinya untuk kebutuhan sekolah Anda.

---

Developed with ❤️ by **MATEK**
