<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Ensure a default category exists
        $category = Category::firstOrCreate(
            ['slug' => 'berita-sekolah'],
            [
                'name' => 'Berita Sekolah',
                'description' => 'Kabar terbaru dari kegiatan dan prestasi sekolah.',
                'seo_title' => 'Berita Sekolah Terkini',
            ]
        );

        $posts = [
            [
                'title' => 'Juara 1 Lomba Tahfiz Tingkat Provinsi',
                'slug' => 'juara-1-lomba-tahfiz-provinsi',
                'subtitle' => 'Prestasi membanggakan dari siswa kelas 6',
                'content' => '<div>Alhamdulillah, segala puji bagi Allah. Siswa kita bernama Ahmad dari kelas 6 baru saja memenangkan juara 1 pada lomba Tahfiz Al-Quran tingkat provinsi. Prestasi ini merupakan buah dari ketekunan dan bimbingan para ustaz.</div>',
                'description' => 'Siswa SDIT berhasil meraih juara 1 pada ajang lomba Tahfiz tingkat provinsi tahun ini.',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'category_id' => $category->id,
            ],
            [
                'title' => 'Penerimaan Peserta Didik Baru (PPDB) Resmi Dibuka',
                'slug' => 'ppdb-resmi-dibuka',
                'subtitle' => 'Daftarkan putra-putri Anda segera',
                'content' => '<div>Kami mengundang para insan pendidik dan orang tua untuk mendaftarkan putra-putrinya di sekolah kami. Pendaftaran PPDB telah resmi dibuka mulai hari ini. Silakan kunjungi halaman panduan PPDB untuk informasi syarat dan ketentuan pendaftaran secara online maupun offline.</div>',
                'description' => 'Informasi pembukaan pendaftaran siswa baru (PPDB) tahun ajaran baru.',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'category_id' => $category->id,
            ],
            [
                'title' => 'Kegiatan Outbound dan Kemah Bakti Siswa',
                'slug' => 'kegiatan-outbound-kemah-bakti',
                'subtitle' => 'Membangun karakter tangguh dan mandiri',
                'content' => '<div>Kegiatan tahunan outbound dan kemah bakti siswa kembali sukses diselenggarakan. Acara yang berlangsung selama dua hari di bumi perkemahan ini bertujuan untuk melatih mental, kemandirian, dan kerja sama tim antar siswa.</div>',
                'description' => 'Ringkasan kegiatan seru kemah bakti dan outbound siswa tahunan.',
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'category_id' => $category->id,
            ]
        ];

        foreach ($posts as $post) {
            Post::firstOrCreate(
                ['slug' => $post['slug']],
                $post
            );
        }
    }
}
