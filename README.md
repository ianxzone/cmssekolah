# CMS Sekolah - Murni Abadi

CMS Sekolah adalah platform pengelolaan konten (Content Management System) modern yang dirancang khusus untuk kebutuhan sekolah. Dibangun dengan **Laravel 12** dan **PHP 8.2+**, sistem ini menawarkan antarmuka yang elegan (Joyful UI) dengan fitur lengkap untuk pengelolaan berita, halaman statis, agenda, dan data sekolah lainnya.

## ✨ Fitur Utama

-   **Joyful UI & Dark Mode**: Desain premium yang responsif dengan dukungan Dark/Light mode otomatis.
-   **Media Manager Modern**: Kelola foto dan dokumen dengan mudah. Mendukung pengaturan *Alt Text* dan *Caption* untuk optimasi SEO.
-   **Maintenance Mode Terintegrasi**: Halaman pemeliharaan kustom dengan fitur upload update, pembersihan cache, dan optimasi sistem langsung dari panel admin.
-   **Custom Scripts**: Masukkan script pihak ketiga (Google Analytics, Meta Pixel, Custom CSS/JS) secara aman melalui menu pengaturan.
-   **Dynamic Forms & Excel Export**: Buat formulir kustom dan ekspor datanya langsung ke Excel untuk keperluan administrasi.
-   **Pengaturan Navigasi & Branding**: Ubah logo, favicon, menu navigasi, dan informasi kontak sekolah tanpa menyentuh kode.
-   **Visi, Misi & Program Unggulan**: Kelola profil sekolah secara dinamis untuk ditampilkan di beranda.

## 🛠️ Stack Teknologi

-   **Framework**: Laravel 12
-   **Bahasa**: PHP 8.2+
-   **Frontend**: Tailwind CSS / Vanilla CSS (Modern), Alpine.js, Feather Icons
-   **Editor**: Trix Editor
-   **Database**: MySQL / SQLite

## 🚀 Instalasi

Pastikan Anda memiliki [Composer](https://getcomposer.org/), [Node.js](https://nodejs.org/), dan PHP 8.2+ terinstal di sistem Anda.

1.  **Clone Repository**
    ```bash
    git clone https://github.com/ianxzone/cmssekolah.git
    cd cmssekolah
    ```

2.  **Install Dependensi PHP**
    ```bash
    composer install
    ```

3.  **Persiapkan Environment**
    Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturan database Anda.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Migrasi Database**
    ```bash
    php artisan migrate
    ```

5.  **Install Dependensi Frontend**
    ```bash
    npm install
    npm run build
    ```

6.  **Jalankan Server**
    ```bash
    php artisan serve
    ```

## 🤝 Kontribusi

Aplikasi ini dikembangkan untuk mempermudah digitalisasi sekolah. Jika Anda ingin berkontribusi dalam pengembangan, silakan lakukan *Fork* repository ini dan buat *Pull Request*.

## 📄 Lisensi

Proyek ini berlisensi [MIT](LICENSE).

---
*Developed with ❤️ by [MATEK](https://www.murniabadi.co.id)*
