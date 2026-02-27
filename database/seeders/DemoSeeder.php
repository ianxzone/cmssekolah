<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Event;
use App\Models\Page;
use App\Models\Form;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $catPrestasi = Category::create(['name' => 'Prestasi', 'slug' => 'prestasi']);
        $catKegiatan = Category::create(['name' => 'Kegiatan', 'slug' => 'kegiatan']);
        $catAkademik = Category::create(['name' => 'Akademik', 'slug' => 'akademik']);

        // Tags
        $tagSiswa = Tag::create(['name' => 'Siswa', 'slug' => 'siswa']);
        $tagJuara = Tag::create(['name' => 'Juara', 'slug' => 'juara']);
        $tagRobotik = Tag::create(['name' => 'Robotik', 'slug' => 'robotik']);

        // Posts
        Post::create([
            'title' => 'Siswa SDIT Al Irsyad Raih Medali Emas Olimpiade Coding',
            'slug' => 'siswa-raih-medali-emas-coding',
            'content' => '<p>Alhamdulillah, ananda Fulan bin Fulan berhasil mengharumkan nama sekolah dengan meraih juara 1 pada kategori Web Design di ajang Olimpiade TIK Nasional.</p><p>Prestasi ini membuktikan bahwa siswa SDIT Al Irsyad mampu bersaing di kancah nasional dalam bidang teknologi.</p>',
            'published_at' => now(),
            'category_id' => $catPrestasi->id,
        ]);

        Post::create([
            'title' => 'Kunjungan Edukatif ke Museum Geologi Bandung',
            'slug' => 'kunjungan-museum-geologi',
            'content' => '<p>Siswa kelas 5 melakukan kunjungan edukatif ke Museum Geologi Bandung untuk mempelajari sejarah bumi dan bebatuan secara langsung.</p>',
            'published_at' => now()->subDays(2),
            'category_id' => $catKegiatan->id,
        ]);

        Post::create([
            'title' => 'Penerimaan Peserta Didik Baru Tahun Ajaran 2025/2026',
            'slug' => 'ppdb-2025-2026',
            'content' => '<p>SDIT Al Irsyad Al Islamiyah Karawang membuka pendaftaran siswa baru. Segera daftarkan putra-putri Anda sebelum kuota terpenuhi.</p>',
            'published_at' => now()->subDays(5),
            'category_id' => $catAkademik->id,
        ]);


        // Events
        Event::create([
            'title' => 'Seminar Parenting Islami',
            'description' => 'Mendidik anak di era digital dengan pendekatan Nabawi. Narasumber: Ustadz Fulan, Lc.',
            'start_time' => now()->addDays(5)->setTime(8, 0),
            'end_time' => now()->addDays(5)->setTime(11, 30),
            'location' => 'Aula SDIT Al Irsyad',
            'capacity' => 200,
        ]);

        Event::create([
            'title' => 'Robotics Workshop for Kids',
            'description' => 'Workshop pengenalan dasar-dasar robotika menggunakan LEGO Mindstorms.',
            'start_time' => now()->addDays(12)->setTime(9, 0),
            'end_time' => now()->addDays(12)->setTime(15, 0),
            'location' => 'Lab Komputer',
            'capacity' => 30,
        ]);

        // Static Pages
        Page::create([
            'title' => 'Tentang Kami',
            'slug' => 'tentang-kami',
            'content' => '<h2>Sejarah Sekolah</h2><p>SDIT Al Irsyad Al Islamiyah Karawang berdiri sejak tahun...</p><h2>Visi & Misi</h2><p>Mewujudkan generasi Rabbani yang unggul dalam IMTAQ dan IPTEK.</p>',
            'type' => 'standard',
        ]);

        // Form
        Form::create([
            'title' => 'Formulir Pendaftaran Ekskul Robotik',
            'slug' => 'daftar-robotik',
            'description' => 'Silakan isi formulir di bawah ini untuk mendaftar ekstrakurikuler Robotik.',
            'is_active' => true,
            'fields' => [
                [
                    'type' => 'text',
                    'label' => 'Nama Lengkap Siswa',
                    'name' => 'nama_siswa',
                    'required' => true,
                ],
                [
                    'type' => 'text',
                    'label' => 'Kelas',
                    'name' => 'kelas',
                    'required' => true,
                ],
                [
                    'type' => 'select',
                    'label' => 'Pilihan Hari',
                    'name' => 'hari',
                    'required' => true,
                    'options' => [
                        ['option' => 'Senin'],
                        ['option' => 'Kamis'],
                    ]
                ],
                [
                    'type' => 'textarea',
                    'label' => 'Catatan Khusus (Alergi/Kebutuhan Khusus)',
                    'name' => 'catatan',
                    'required' => false,
                ]
            ],
        ]);

        // One submit
        // FormSubmission created via controller usually, but can seed if needed.
    }
}
