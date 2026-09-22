<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat atau ambil kategori berita
        $catPrestasi = Category::firstOrCreate(
            ['slug' => 'prestasi'],
            [
                'name' => 'Prestasi & Penghargaan',
                'description' => 'Kabar capaian prestasi santri dan asatidz LPP Al Irsyad Karawang.',
                'seo_title' => 'Prestasi Santri LPP Al Irsyad Karawang',
                'seo_description' => 'Daftar prestasi akademik, tahfidz, dan kompetisi santri Al Irsyad.'
            ]
        );

        $catAkademik = Category::firstOrCreate(
            ['slug' => 'akademik'],
            [
                'name' => 'Akademik & Kurikulum',
                'description' => 'Informasi kurikulum khas, pembelajaran, dan kegiatan akademik.',
                'seo_title' => 'Akademik & Kurikulum Terpadu LPP Al Irsyad',
                'seo_description' => 'Informasi pembelajaran integratif nasional dan kepesantrenan.'
            ]
        );

        $catKegiatan = Category::firstOrCreate(
            ['slug' => 'kegiatan'],
            [
                'name' => 'Kegiatan Santri',
                'description' => 'Dokumentasi aktivitas, ekstrakurikuler, dan pembiasaan adab harian.',
                'seo_title' => 'Kegiatan Santri LPP Al Irsyad Karawang',
                'seo_description' => 'Aktivitas santri mulai dari KB-TK, SDIT, SMPIT, hingga SMAIT.'
            ]
        );

        $catPengumuman = Category::firstOrCreate(
            ['slug' => 'pengumuman'],
            [
                'name' => 'Pengumuman & Info',
                'description' => 'Pengumuman resmi lembaga, SPMB, dan agenda penting madrasah.',
                'seo_title' => 'Pengumuman Resmi LPP Al Irsyad Karawang',
                'seo_description' => 'Informasi penting dan pengumuman resmi bagi orang tua dan santri.'
            ]
        );

        // 2. Daftar Berita & Artikel
        $posts = [
            [
                'title' => 'Santri LPP Al Irsyad Raih Juara 1 MHQ 10 Juz Tingkat Provinsi Jawa Barat',
                'subtitle' => 'Prestasi Gemilang Pembinaan Tahfidz Bersanad Santri Karawang',
                'slug' => 'santri-lpp-al-irsyad-raih-juara-1-mhq-jabar',
                'category_id' => $catPrestasi->id,
                'image' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&q=80&w=800',
                'description' => 'Alhamdulillah, ananda Muhammad Fatih berhasil meraih Juara 1 Musabaqah Hifdzil Qur\'an (MHQ) 10 Juz pada ajang kompetisi tingkat Provinsi Jawa Barat.',
                'content' => '<p><strong>Karawang</strong> — Prestasi membanggakan kembali ditorehkan oleh santri LPP Al Irsyad Al Islamiyyah Karawang. Dalam ajang Musabaqah Hifdzil Qur\'an (MHQ) tingkat Provinsi Jawa Barat yang diselenggarakan akhir pekan kemarin, ananda Muhammad Fatih, santri kelas IX SMPIT Al Irsyad Karawang, sukses meraih predikat <strong>Juara 1 kategori 10 Juz</strong>.</p><p>Keberhasilan ini merupakan buah dari pembinaan intensif program <em>Tahfidz &amp; Tahsin Bersanad</em> yang secara konsisten diterapkan di seluruh unit LPP Al Irsyad Karawang. Pembimbing tahfidz, Ustadz Ridwan, menyampaikan rasa syukur yang mendalam atas pencapaian santri binaannya.</p><blockquote>"Alhamdulillah, ananda Fatih menunjukkan ketekunan luar biasa dalam muraja\'ah dan talaqqi setiap harinya. Semoga berkah Al-Qur\'an senantiasa menyertai ananda dan memotivasi santri lainnya," tutur beliau.</blockquote><p>Lembaga mengucapkan barakallahu fiik kepada ananda Fatih, kedua orang tua, serta seluruh dewan asatidz yang telah membimbing tanpa kenal lelah.</p>',
                'published_at' => now()->subDays(1),
                'seo_title' => 'Juara 1 MHQ 10 Juz Tingkat Jabar - LPP Al Irsyad Karawang',
                'seo_description' => 'Santri LPP Al Irsyad Karawang berhasil meraih juara pertama dalam ajang MHQ 10 Juz tingkat Jawa Barat.'
            ],
            [
                'title' => 'Pendaftaran Santri Baru (SPMB) TA 2025/2026 Resmi Dibuka Serentak untuk Seluruh Unit',
                'subtitle' => 'Raih Kesempatan Pendidikan Berkualitas di KB-TK, SDIT, SMPIT, dan SMAIT',
                'slug' => 'spmb-ta-2025-2026-resmi-dibuka-serentak',
                'category_id' => $catPengumuman->id,
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=800',
                'description' => 'LPP Al Irsyad Karawang membuka pendaftaran santri baru tahun ajaran 2025/2026 melalui sistem online terpadu dengan kuota terbatas.',
                'content' => '<p><strong>Karawang</strong> — Lajnah Pendidikan dan Pengajaran (LPP) Al Irsyad Al Islamiyyah Karawang secara resmi membuka <strong>Sistem Penerimaan Murid Baru (SPMB) Tahun Ajaran 2025/2026</strong>. Pendaftaran dilakukan secara daring (online) untuk memudahkan calon wali santri dari berbagai wilayah di Kabupaten Karawang dan sekitarnya.</p><p>Pendaftaran dibuka serentak untuk seluruh unit jenjang pendidikan:</p><ul><li><strong>KB-TK Islam Al Irsyad</strong> (Sentra Karakter &amp; Stimulasi Motorik)</li><li><strong>SDIT Al Irsyad 01 &amp; 02</strong> (Akreditasi A Unggul &amp; Smart Class)</li><li><strong>SMPIT Al Irsyad Karawang</strong> (Bina Pribadi Islami &amp; Bilingual Habit)</li><li><strong>SMAIT Al Irsyad Karawang</strong> (Kader Da\'i &amp; Persiapan PTN/Internasional)</li></ul><p>Mengingat kapasitas kelas yang terjaga untuk efektivitas proses belajar, calon wali santri diimbau segera melakukan registrasi awal pada gelombang pertama guna mengamankan kursi kuota.</p>',
                'published_at' => now()->subDays(2),
                'seo_title' => 'SPMB 2025/2026 Dibuka - LPP Al Irsyad Karawang',
                'seo_description' => 'Informasi lengkap pendaftaran santri baru LPP Al Irsyad Karawang tahun ajaran 2025/2026.'
            ],
            [
                'title' => 'Implementasi Literasi Coding & Eksperimen STEAM: Menyiapkan Generasi Rabbani Berdaya Saing Global',
                'subtitle' => 'Kolaborasi Kurikulum Sains Modern dan Logika Pemrograman Siswa',
                'slug' => 'literasi-coding-dan-eksperimen-steam-al-irsyad',
                'category_id' => $catAkademik->id,
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&q=80&w=800',
                'description' => 'Santri Al Irsyad Karawang dibekali kemampuan pemecahan masalah melalui kelas coding robotik dan praktikum sains berbasis STEAM.',
                'content' => '<p><strong>Karawang</strong> — Dalam rangka menjawab tantangan era kecerdasan buatan (AI) dan otomatisasi, LPP Al Irsyad Karawang memperkuat kurikulum khas dengan integrasi <em>STEAM (Science, Technology, Engineering, Arts, and Mathematics)</em> serta kelas literasi coding dasar.</p><p>Melalui fasilitas laboratorium komputer modern dan alat peraga sains aplikatif, peserta didik tidak hanya menjadi konsumen teknologi, tetapi diajak memahami logika komputasional, algoritma pemecahan masalah, dan etika digital berlandaskan akhlakul karimah.</p><p>Program ini mencakup perakitan robotik sederhana, pemrograman berbasis blok (visual coding), hingga pembuatan web portofolio karya ilmiah santri tingkat menengah.</p>',
                'published_at' => now()->subDays(4),
                'seo_title' => 'Coding & STEAM di LPP Al Irsyad Karawang',
                'seo_description' => 'Penerapan kurikulum coding dan STEAM sains di unit pendidikan Al Irsyad Karawang.'
            ],
            [
                'title' => 'Khotmil Qur\'an & Wisuda Tahfidz Mutqin Ke-XIV: 85 Santri Sukses Menyelesaikan Ujian Munaqosyah',
                'subtitle' => 'Mencetak Generasi Penjaga Kalamullah yang Beradab dan Mutqin',
                'slug' => 'khotmil-quran-dan-wisuda-tahfidz-ke-xiv',
                'category_id' => $catPrestasi->id,
                'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&q=80&w=800',
                'description' => 'Sebanyak 85 santri dari jenjang SDIT hingga SMAIT dinyatakan lulus ujian tasmi\' dan munaqosyah bersanad hafalan Al-Qur\'an.',
                'content' => '<p><strong>Karawang</strong> — Suasana haru dan penuh rasa syukur menyelimuti Auditorium LPP Al Irsyad Karawang dalam prosesi <strong>Wisuda Tahfidz &amp; Khotmil Qur\'an Ke-XIV</strong>. Sebanyak 85 santri dari berbagai tingkatan berhasil menuntaskan hafalan sesuai target capaian masing-masing jenjang dengan predikat mutqin.</p><p>Kegiatan ini diawali dengan tasmi\' bil ghoib di hadapan para penguji bersanad, dilanjutkan dengan penyematan mahkota kehormatan secara simbolis kepada orang tua santri. Ketua LPP Al Irsyad berpesan agar para santri senantiasa menjaga hafalannya dan mengamalkan nilai-nilai Al-Qur\'an dalam kehidupan bermasyarakat.</p>',
                'published_at' => now()->subDays(6),
                'seo_title' => 'Wisuda Tahfidz Mutqin Ke-XIV - LPP Al Irsyad Karawang',
                'seo_description' => 'Prosesi wisuda tahfidz Al-Qur\'an santri LPP Al Irsyad Karawang angkatan XIV.'
            ],
            [
                'title' => 'Membangun Karakter Melalui Program Bina Pribadi Islami (BPI) dan Pembiasaan Sholat Berjamaah',
                'subtitle' => 'Internalisasi Adab Nabawiyah dalam Rutinitas Keseharian Santri',
                'slug' => 'program-bina-pribadi-islami-dan-adab-harian',
                'category_id' => $catKegiatan->id,
                'image' => 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?auto=format&fit=crop&q=80&w=800',
                'description' => 'Program BPI menjadi ruh pendidikan karakter di LPP Al Irsyad Karawang melalui kelompok halaqah kecil dan keteladanan asatidz.',
                'content' => '<p><strong>Karawang</strong> — Salah satu keunggulan khas pendidikan di LPP Al Irsyad adalah program <strong>Bina Pribadi Islami (BPI)</strong>. Program pembinaan kepribadian ini dilaksanakan secara rutin dalam kelompok-kelompok kecil (halaqah) yang dibina langsung oleh guru pendamping.</p><p>Materi BPI difokuskan pada penguatan akidah shahihah, ibadah yang benar sesuai sunnah, adab kepada orang tua dan sesama (birrul walidain), serta dzikir matsurat pagi dan petang. Dengan pendekatan yang ramah dan penuh keteladanan, santri terbiasa menjalankan sholat berjamaah tepat waktu dan menjunjung tinggi adab Islami.</p>',
                'published_at' => now()->subDays(8),
                'seo_title' => 'Program BPI & Adab Santri LPP Al Irsyad Karawang',
                'seo_description' => 'Pembiasaan karakter Islami dan pembinaan pribadi santri di LPP Al Irsyad Karawang.'
            ]
        ];

        foreach ($posts as $postData) {
            Post::updateOrCreate(
                ['slug' => $postData['slug']],
                $postData
            );
        }
    }
}
