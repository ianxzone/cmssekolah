<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'school_name', 'value' => 'SDIT Murni Abadi', 'type' => 'text'],
            ['key' => 'school_tagline', 'value' => 'Mencetak Generasi Qurani yang Cendekia', 'type' => 'text'],
            ['key' => 'school_logo', 'value' => '', 'type' => 'image'],
            ['key' => 'school_favicon', 'value' => '', 'type' => 'image'],

            // Hero Section
            ['key' => 'hero_title', 'value' => 'Pendidikan Islam Modern & Berkualitas', 'type' => 'text'],
            ['key' => 'hero_subtitle', 'value' => 'Kami berkomitmen mencetak generasi berprestasi dengan fondasi akhlak Islami yang kuat, didukung fasilitas digital terkini.', 'type' => 'text'],
            ['key' => 'hero_btn_text', 'value' => 'Daftar Sekarang (PPDB)', 'type' => 'text'],
            ['key' => 'hero_btn_link', 'value' => '/panduan-ppdb', 'type' => 'text'],

            // Sidebar PPDB (New)
            ['key' => 'sidebar_ppdb_title', 'value' => 'PPDB Dibuka!', 'type' => 'text'],
            ['key' => 'sidebar_ppdb_desc', 'value' => 'Daftarkan putra-putri Anda sekarang juga.', 'type' => 'text'],
            ['key' => 'sidebar_ppdb_btn_text', 'value' => 'Info Selengkapnya', 'type' => 'text'],

            // Programs
            [
                'key' => 'superior_programs',
                'value' => json_encode([
                    ['icon' => 'book', 'title' => 'Tahfidz Al-Quran', 'desc' => 'Program hafalan intensif dengan target minimal 2 Juz sebelum lulus.'],
                    ['icon' => 'globe', 'title' => 'Bilingual Classes', 'desc' => 'Pembiasaan bahasa Arab dan Inggris dalam komunikasi sehari-hari di sekolah.'],
                    ['icon' => 'monitor', 'title' => 'Digital Literacy', 'desc' => 'Pengenalan teknologi dasar, coding, dan literasi digital sejak dini.'],
                    ['icon' => 'award', 'title' => 'Karakter Kepemimpinan', 'desc' => 'Program outbound rutin dan kemah bakti untuk mencetak jiwa pemimpin.']
                ]),
                'type' => 'json'
            ],

            // Vision Mission
            ['key' => 'school_vision', 'value' => 'Menjadi pelopor pendidikan dasar Islam terpadu yang menghasilkan lulusan berakhlak mulia, cerdas, dan siap menghadapi era global.', 'type' => 'text'],
            [
                'key' => 'school_missions',
                'value' => json_encode([
                    ['text' => 'Menyelenggarakan pendidikan berkelanjutan berbasis keteladanan.'],
                    ['text' => 'Mengintegrasikan nilai-nilai Islam ke dalam kurikulum nasional.'],
                    ['text' => 'Mengembangkan minat bakat siswa (multiple intelligences).'],
                    ['text' => 'Menjalin kemitraan edukatif dengan orang tua dan masyarakat.'],
                    ['text' => 'Membentuk generasi pembelajar yang adaptif dan inovatif.'],
                    ['text' => 'Memfasilitasi sarana prasarana modern pendukung proses KBM.']
                ]),
                'type' => 'json'
            ],

            // Teachers
            [
                'key' => 'teachers_data',
                'value' => json_encode([
                    ['name' => 'Ust. Dr. Abdul Rahman', 'role' => 'Kepala Sekolah', 'image' => 'https://ui-avatars.com/api/?name=Abdul+Rahman&background=4f46e5&color=fff&size=300'],
                    ['name' => 'Usth. Siti Khadijah, M.Pd.', 'role' => 'Waka Kurikulum', 'image' => 'https://ui-avatars.com/api/?name=Siti+Khadijah&background=7c3aed&color=fff&size=300'],
                    ['name' => 'Ust. Ahmad Zaki, S.Kom.', 'role' => 'Guru IT & Robotik', 'image' => 'https://ui-avatars.com/api/?name=Ahmad+Zaki&background=10b981&color=fff&size=300'],
                    ['name' => 'Usth. Fatimah, S.Ag.', 'role' => 'Kordinator Tahfidz', 'image' => 'https://ui-avatars.com/api/?name=Fatimah&background=f59e0b&color=fff&size=300']
                ]),
                'type' => 'json'
            ],

            // Facilities & Extracurriculars
            [
                'key' => 'facilities_list',
                'value' => json_encode([
                    ['name' => 'Ruang Kelas Full AC & Smart TV'],
                    ['name' => 'Masjid Sekolah yang Luas'],
                    ['name' => 'Laboratorium Komputer & Bahasa'],
                    ['name' => 'Perpustakaan Digital (E-Library)'],
                    ['name' => 'UKS dengan Perawat Siaga'],
                    ['name' => 'Lapangan Basket & Futsal Terintegrasi']
                ]),
                'type' => 'json'
            ],
            [
                'key' => 'extracurriculars_list',
                'value' => json_encode([
                    ['name' => 'Robotik & Coding', 'highlight' => '1'],
                    ['name' => 'Panahan (Archery)', 'highlight' => '1'],
                    ['name' => 'Pramuka SIT', 'highlight' => '0'],
                    ['name' => 'Klub Bahasa Inggris', 'highlight' => '0'],
                    ['name' => 'Futsal', 'highlight' => '0'],
                    ['name' => 'Renang', 'highlight' => '0'],
                    ['name' => 'Tahfidz Quran', 'highlight' => '1'],
                    ['name' => 'Seni Lukis', 'highlight' => '0'],
                    ['name' => 'Sains Club', 'highlight' => '1']
                ]),
                'type' => 'json'
            ],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'type' => $setting['type']]
            );
        }
    }
}
