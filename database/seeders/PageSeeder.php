<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Profil Sekolah',
                'slug' => 'profil-sekolah',
                'content' => '<div><h2>Tentang Sekolah Kami</h2><p>Ini adalah halaman contoh profil sekolah. Kami berdedikasi untuk memberikan pendidikan terbaik bagi putra-putri Anda dengan lingkungan Islami yang kondusif.</p><p>Visi kami adalah mencetak generasi Rabbani yang unggul dalam ilmu pengetahuan dan ketakwaan. Misi kami mencakup pendidikan holistik, fasilitas modern, dan tenaga pendidik yang profesional.</p><br><h3>Sejarah Singkat</h3><p>Sekolah kami didirikan pada tahun 2010 dengan komitmen penuh untuk membangun karakter anak bangsa.</p></div>',
                'type' => 'default',
                'seo_title' => 'Profil Sekolah - SDIT Contoh',
                'seo_description' => 'Halaman informasi mengenai profil dan sejarah sekolah kami.',
            ],
            [
                'title' => 'Fasilitas Unggulan',
                'slug' => 'fasilitas',
                'content' => '<div><h2>Fasilitas Kami</h2><ul><li>Gedung Kelas Full AC</li><li>Laboratorium Komputer & IPA</li><li>Perpustakaan Digital</li><li>Masjid Luas untuk Shalat Berjamaah</li><li>Lapangan Olahraga Terpadu</li></ul><p>Semua fasilitas dirancang untuk kenyamanan dan keamanan siswa selama belajar.</p></div>',
                'type' => 'default',
                'seo_title' => 'Fasilitas - SDIT Contoh',
                'seo_description' => 'Daftar fasilitas unggulan yang tersedia di sekolah.',
            ],
            [
                'title' => 'Panduan Pendaftaran (PPDB)',
                'slug' => 'panduan-ppdb',
                'content' => '<div><h2>Informasi PPDB</h2><p>Pendaftaran Peserta Didik Baru (PPDB) dibuka setiap awal tahun. Berikut adalah syarat pendaftarannya:</p><ol><li>Fotokopi Akte Kelahiran (2 Lembar)</li><li>Fotokopi Kartu Keluarga (2 Lembar)</li><li>Pas Foto 3x4 (4 Lembar)</li><li>Mengisi Formulir Pendaftaran Online</li></ol><p>Silakan hubungi bagian administrasi untuk informasi lebih lanjut.</p></div>',
                'type' => 'default',
                'seo_title' => 'Panduan PPDB - SDIT Contoh',
                'seo_description' => 'Informasi lengkap mengenai syarat dan cara pendaftaran siswa baru.',
            ]
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
