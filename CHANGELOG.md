# Changelog

Semua perubahan penting dalam proyek ini akan dicatat dalam file ini. Format ini didasarkan pada [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) dan mengikuti standar [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [3.1.0] - 2026-03-16

### 🎉 Added

#### Rich Text Editor Upgrade
- **Summernote WYSIWYG Editor**: Replaced Trix Editor dengan Summernote v0.9.0
- **Enhanced Toolbar**: 25+ formatting tools organized in logical groups
  - Text formatting (Bold, Italic, Underline, Strikethrough)
  - Font effects (Superscript, Subscript)
  - Paragraph styles (Heading 1-3, Blockquote, Preformatted)
  - Lists (Bullet, Numbered, Indent/Outdent)
  - Insert media (Link, Picture, Video, Horizontal Rule)
  - Tables with customizable rows/columns
  - Text color picker with palette
  - Line height control
  - Fullscreen mode for distraction-free writing
  - Code view for direct HTML editing
- **jQuery Integration**: Added jQuery 3.6.0 dependency for Summernote
- **Drag & Drop Upload**: Image upload via drag & drop functionality
- **Copy-Paste Support**: Automatic image handling from clipboard
- **Real-time Word Count**: Live word counter for content tracking
- **Responsive Design**: Mobile-friendly editor interface

### 🔧 Changed

#### Editor Migration
- **Removed Trix Editor**: Completely removed Trix Editor v2.0.8 dependencies
- **Updated Blade Templates**: Modified create.blade.php dan edit.blade.php untuk Summernote
- **Updated Layout**: Added jQuery CDN to admin layout template
- **Simplified Codebase**: Removed 200+ lines of complex Trix customization code
- **Better Bootstrap Integration**: Native Bootstrap compatibility

#### User Experience
- **Familiar Interface**: More intuitive toolbar similar to Microsoft Word
- **Enhanced Features**: Table support, text colors, font sizes
- **Better Image Handling**: Resize, align, and style images directly
- **Improved Mobile Experience**: Touch-optimized toolbar

### 📚 Documentation

#### New Guides
- **SUMMERNOTE_GUIDE.md**: Complete user guide dengan tutorials
  - Feature overview
  - Step-by-step tutorials
  - Keyboard shortcuts
  - Best practices
  - Troubleshooting tips
  - Security notes
  - Mobile usage guide

### 🐛 Fixed

#### Issues Resolved
- **Icon Visibility**: No more invisible icons issue (problem di Trix)
- **Limited Features**: Overcame Trix limitations (no tables, no colors)
- **Complex Customization**: Simplified editor customization
- **Learning Curve**: Easier adoption for users familiar with Word processors

### ⚡ Performance

#### Improvements
- **Lightweight**: Summernote Lite version for faster loading
- **CDN Delivery**: Fast asset delivery from reliable CDNs
- **Optimized Initialization**: Smart editor initialization on document ready
- **Efficient Image Upload**: AJAX-based upload without page refresh

### 🎯 Benefits Over Previous Editor

| Feature | Trix (Old) | Summernote (New) |
|---------|-----------|------------------|
| Tables | ❌ | ✅ Built-in |
| Text Color | ❌ | ✅ Built-in |
| Font Size | ❌ | ✅ Built-in |
| Image Resize | ❌ | ✅ Yes |
| Code View | ❌ | ✅ Yes |
| Fullscreen | ❌ | ✅ Yes |
| Video Embed | ⚠️ Limited | ✅ Full Support |
| Mobile UI | ⚠️ Good | ✅ Excellent |
| Learning Curve | ⚠️ Medium | ✅ Easy |

---

## [3.0.0] - 2026-03-16

### 🎉 Added

#### Security Features (Phase 1 & 2)
- **RCE Protection**: Secure ZIP upload validation dengan whitelist ekstensi dan mime type checking
- **SQL Injection Prevention**: Parameterized queries dan input sanitization
- **XSS Protection**: Content-Security-Policy headers dan output escaping
- **CSRF Protection**: Token validation untuk semua form submissions
- **Rate Limiting**: 120 requests per minute untuk API routes
- **Security Headers Middleware**: HSTS, X-Frame-Options, X-Content-Type-Options, Referrer-Policy
- **Password Policy**: Minimum 8 karakter dengan kombinasi huruf dan angka
- **Clickjacking Protection**: X-Frame-Options header

#### RBAC System (Phase 3)
- **Role-Based Access Control**: 4 roles (Super Admin, Admin, Editor, Author)
- **41+ Granular Permissions**: Kontrol akses detail untuk semua modul
  - Posts (5 permissions)
  - Pages (5 permissions)
  - Media (3 permissions)
  - Categories & Tags (4 permissions)
  - Events (4 permissions)
  - Testimonials (4 permissions)
  - Forms (6 permissions)
  - Users (5 permissions)
  - Settings (5 permissions)
- **Role Middleware**: Route protection berdasarkan role
- **Permission Middleware**: Route protection berdasarkan permission
- **User Model Enhancement**: Methods untuk role checking dan permission assignment

#### Activity Logging
- **Complete Audit Trail**: Logging semua aktivitas user (create, update, delete)
- **Polymorphic Relations**: Support untuk semua model
- **IP Address Tracking**: Pencatatan IP address user
- **User Agent Logging**: Browser/device information
- **JSON Properties**: Flexible metadata storage
- **Query Scopes**: Filter logs by user, type, event

#### New Modules
- **Testimonials Module**: CRUD testimoni dengan foto dan profesi
- **Enhanced Media Manager**: Alt text dan caption support untuk accessibility
- **Form Submissions**: Tracking dan export form entries

#### UI/UX Enhancements
- **Trix Editor Enhancement**: SVG icons replacement untuk semua toolbar buttons
- **Enhanced Toolbar**: Custom styling dengan hover effects dan active states
- **Icon System**: 12 custom SVG icons (Bold, Italic, Link, Heading, Quote, Code, Lists, dll)

#### Testing
- **19 Automated Tests** untuk RBAC & Activity Logging
- **Security Tests** untuk vulnerability prevention
- **Middleware Tests** untuk role & permission checking
- **Integration Tests** untuk workflow validation

#### Documentation
- COMPLETE_SECURITY_GUIDE.md - Panduan keamanan lengkap
- PHASE3_RBAC_ACTIVITY_LOG.md - Dokumentasi RBAC
- DEPLOYMENT_GUIDE.md - Panduan deployment step-by-step
- EXECUTIVE_SUMMARY.md - Ringkasan eksekutif
- COMPLETE_CHECKLIST.md - Checklist implementasi
- NEXT_STEPS.md - Panduan next steps

### 🔐 Changed

#### Security Improvements
- **Enhanced File Upload**: Multiple validation layers untuk ZIP files
- **Database Security**: Prepared statements untuk semua queries
- **Session Security**: Improved session configuration
- **Error Handling**: Custom error pages tanpa stack trace exposure

#### Code Quality
- **PSR-12 Compliance**: Code style standardization
- **Type Hinting**: Strict typing untuk functions
- **Error Handling**: Try-catch blocks untuk critical operations
- **Code Comments**: Comprehensive documentation

### 🐛 Fixed

#### Critical Bugs
- **Trix Editor Icons**: Fixed icon display dengan inline SVG
- **Middleware Registration**: Fixed alias registration in bootstrap/app.php
- **Permission Sync**: Fixed spread operator issue dengan Laravel sync() method
- **CSS Variables**: Fixed variable scoping untuk dark mode

#### UI Issues
- **Responsive Design**: Mobile layout improvements
- **Dark Mode**: Consistent color scheme across all pages
- **Form Validation**: Better error messages dan user feedback

### ⚡ Performance

#### Optimizations
- **Query Optimization**: Eager loading untuk N+1 prevention
- **Caching**: Configuration dan route caching
- **Asset Optimization**: Vite build dengan minification
- **Database Indexing**: Proper indexes untuk frequently queried columns

### 📚 Documentation

#### New Documentation Files
- Security implementation guides
- RBAC architecture documentation
- Deployment procedures
- Testing guidelines
- API documentation

#### Code Documentation
- PHPDoc blocks untuk semua classes dan methods
- Inline comments untuk complex logic
- README updates dengan comprehensive guides

---

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
