# CMS Sekolah Modern v3.0.0

[![Laravel Version](https://img.shields.io/badge/laravel-12.x-red)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/php-8.2+-blue)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)

**CMS Sekolah Modern** adalah solusi manajemen konten (CMS) khusus untuk institusi pendidikan (SD/SMP/SMA/SMK) yang dibangun dengan Laravel. Versi 3.0.0 memperkenalkan **Enterprise-Grade Security**, **Role-Based Access Control (RBAC)**, **Activity Logging**, dan sistem tema dinamis dengan desain yang sangat premium.

---

## ✨ Fitur Unggulan

### 🔐 **Security & Access Control (NEW!)**
- 🛡️ **Multi-Layer Security**: 7 lapisan keamanan (RCE, SQL Injection, XSS, CSRF protection)
- 👥 **Role-Based Access Control (RBAC)**: 4 role (Super Admin, Admin, Editor, Author)
- 🔑 **41+ Granular Permissions**: Kontrol akses detail untuk setiap modul
- 📝 **Activity Logging**: Audit trail lengkap semua aktivitas user
- ⚡ **Rate Limiting**: Proteksi dari brute force attacks
- 🔒 **Security Headers**: HSTS, CSP, X-Frame-Options, dll

### 🎨 **Tema & Customization**
- 🎨 **Sistem Tema Dinamis**: Ganti tampilan website (Tema Modern & Default) dalam satu klik
- 🌈 **Kustomisasi Warna**: Sesuaikan warna Primary & Secondary dengan color picker
- 📱 **Desain Immersive & Responsif**: Hero Image raksasa yang modern
- 🖼️ **Trix Editor Enhanced**: Rich text editor dengan icon SVG yang premium

### 📝 **Manajemen Konten**
- 📰 **Berita & Artikel**: Kelola postingan dengan kategori, tag, dan SEO
- 📅 **Agenda Sekolah**: Event management dengan detail lengkap
- 📄 **Halaman Statis**: About, Contact, PPDB info
- 👨‍🏫 **Guru & Staff**: Direktori lengkap dengan profil
- 💬 **Testimoni**: Testimonial dari siswa/alumni
- 📥 **PPDB Online**: Sistem pendaftaran siswa baru terintegrasi
- 🖼️ **Media Manager**: Galeri foto dan file management

### 🛠️ **Admin Features**
- 📊 **Dashboard Analytics**: Statistik konten dan aktivitas
- 🔍 **Search & Filter**: Pencarian cepat di semua modul
- 📤 **Export/Import**: Backup dan restore data
- 🔔 **Notifications**: Sistem notifikasi real-time
-  **Error Pages**: Halaman error kustom (404, 503, dll)

---

## 🚀 Instalasi Cepat

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/MariaDB

### Quick Start

1. **Clone Repository**
   ```bash
   git clone https://github.com/ianxzone/cmssekolah.git
   cd cmssekolah
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   Edit `.env` dan sesuaikan database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_DATABASE=nama_database
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Database Migration & Seeding**
   ```bash
   php artisan migrate --seed
   ```

5. **Build Assets**
   ```bash
   npm run build
   ```

6. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

7. **Run Development Server**
   ```bash
   php artisan serve
   ```
   
   Akses: `http://localhost:8000`

---

## 👤 Default User Credentials

Setelah seeding, gunakan kredensial berikut untuk login:

**Super Admin:**
- Email: `admin@school.com`
- Password: `password`

**Editor:**
- Email: `editor@school.com`
- Password: `password`

**Author:**
- Email: `author@school.com`
- Password: `password`

---

## 📚 Dokumentasi Lengkap

### Security Features
- [Security Implementation Guide](COMPLETE_SECURITY_GUIDE.md)
- [RBAC & Activity Log Documentation](PHASE3_RBAC_ACTIVITY_LOG.md)
- [Deployment Guide](DEPLOYMENT_GUIDE.md)

### User Guides
- [Executive Summary](EXECUTIVE_SUMMARY.md)
- [Complete Checklist](COMPLETE_CHECKLIST.md)
- [Next Steps](NEXT_STEPS.md)

---

## 🌐 Panduan Deploy ke Hosting

### 1. Deployment di cPanel (Shared Hosting)
1. **Upload File**: Upload semua file proyek ke root folder (di luar `public_html`) atau gunakan Git Version Control di cPanel.
2. **Setup Domain**: Arahkan *Document Root* domain/subdomain Anda ke folder `public`.
3. **Konfigurasi PHP**: Pastikan versi PHP minimal 8.2 dan aktifkan ekstensi yang diperlukan (bcmath, ctype, fileinfo, json, mbstring, openssl, pdo, tokenizer, xml).
4. **Setup Database**: Buat database & user di *MySQL® Databases*, lalu update `.env`.
5. **Simlink Storage**: Jika Anda tidak punya akses SSH, buat file `cronjob` atau `route` sementara untuk menjalankan `Storage::link()`.

### 2. Deployment di DirectAdmin
1. **File Manager**: Upload file ke folder aplikasi Anda.
2. **Domain Setup**: Masuk ke *Domain Setup* -> Pilih domain -> Ganti *Document Root* ke folder `public`.
3. **Terminal/SSH**: Jika tersedia, jalankan:
   ```bash
   composer install --no-dev
   php artisan migrate --seed
   php artisan storage:link
   ```
4. **Select PHP Version**: Pastikan versi PHP sesuai melalui *Select PHP version*.
5. **SSL**: Aktifkan SSL melalui *SSL Certificates* (Let's Encrypt) demi keamanan pendaftaran PPDB.

### 3. Deployment via Git (Recommended)
```bash
# Di server production
git clone https://github.com/ianxzone/cmssekolah.git
cd cmssekolah
cp .env.example .env
# Edit .env dengan database production
composer install --no-dev --optimize-autoloader
php artisan migrate --force --seed
php artisan storage:link
npm install && npm run build
```

---

## 🧪 Testing

Jalankan automated tests:

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --filter RBAC
php artisan test --filter Security

# Run with coverage
php artisan test --coverage
```

---

## 🛠️ Teknologi yang Digunakan

### Backend
- **Framework**: Laravel 12.x
- **PHP**: 8.2+
- **Database**: MySQL / MariaDB
- **Cache**: File/Redis (optional)

### Frontend
- **Template Engine**: Blade
- **CSS**: Vanilla CSS (Custom Properties/Variables)
- **JavaScript**: Vanilla JS (Minimal)
- **Icons**: Feather Icons
- **Rich Text Editor**: Trix Editor (Enhanced)

### Security
- **Rate Limiting**: Laravel Rate Limiter
- **CSRF Protection**: Built-in Laravel
- **Security Headers**: Custom Middleware
- **Input Validation**: Laravel Form Requests
- **Activity Logging**: Custom Implementation

### Development Tools
- **Package Manager**: Composer, NPM
- **Build Tool**: Vite
- **Testing**: PHPUnit
- **Code Style**: Laravel Pint

---

## 📊 Changelog

### Version 3.0.0 (March 2026) - **MAJOR RELEASE**

#### 🎉 New Features
- ✅ **Role-Based Access Control (RBAC)** with 4 roles
- ✅ **41+ Granular Permissions** across all modules
- ✅ **Activity Logging System** with complete audit trail
- ✅ **Enhanced Security** (7-layer protection)
- ✅ **Trix Editor Enhancement** with SVG icons
- ✅ **Testimonials Module**
- ✅ **Enhanced Media Manager** with alt text & captions

#### 🔐 Security Enhancements
- RCE protection (ZIP upload security)
- SQL Injection prevention
- XSS protection (Content-Security-Policy)
- CSRF protection
- Rate limiting (120 req/min)
- Security headers (HSTS, X-Frame-Options, etc.)
- Password policy enforcement

#### 🐛 Bug Fixes
- Fixed middleware registration issues
- Fixed Trix editor styling
- Fixed icon display in toolbar
- Various UI/UX improvements

#### 📝 Documentation
- Complete security guide
- RBAC implementation guide
- Deployment guide
- Executive summary
- Comprehensive checklist

### Version 2.0.0 (February 2026)
- Dynamic theme system
- Color customization
- Immersive responsive design
- PPDB online integration

### Version 1.0.0 (January 2026)
- Initial release
- Basic CMS features

---

## 🤝 Contributing

Terima kasih untuk semua kontributor! Untuk contribution guidelines, silakan lihat [CONTRIBUTING.md](CONTRIBUTING.md).

### Core Team
- **Lead Developer**: MATEK
- **Security**: Phase 1, 2, 3 Implementation
- **Frontend**: Premium UI/UX Design
- **Backend**: Laravel 12 Architecture

### Contributors
- [Your Name Here] - Become a contributor!

---

## 📄 License

Proyek ini berada di bawah lisensi **MIT**. Anda bebas menggunakan dan memodifikasinya untuk kebutuhan sekolah Anda.

```text
MIT License

Copyright (c) 2026 MATEK

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

## 📞 Support & Contact

Untuk pertanyaan, dukungan, atau kerja sama:

- **GitHub Issues**: [Buka issue baru](https://github.com/ianxzone/cmssekolah/issues)
- **Email**: support@cmssekolah.com (coming soon)
- **Documentation**: [Lihat dokumentasi lengkap](./docs/)

---

## 🙏 Acknowledgments

- Laravel Community
- Feather Icons
- Trix Editor
- All contributors

---

Developed with ❤️ by **MATEK** | Version 3.0.0

---
