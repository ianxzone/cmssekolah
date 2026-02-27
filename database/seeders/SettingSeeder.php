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
            'school_name' => 'SDIT Murni Abadi',
            'school_tagline' => 'Mencetak Generasi Qurani yang Cendekia',
            'school_logo' => '', // Blank for fallback tests
            'school_favicon' => '',

            // Hero Section
            'hero_title' => 'Pendidikan Islam Modern & Berkualitas',
            'hero_subtitle' => 'Kami berkomitmen mencetak generasi berprestasi dengan fondasi akhlak Islami yang kuat, didukung fasilitas digital terkini.',
            'hero_btn_text' => 'Daftar Sekarang (PPDB)',
            'hero_btn_link' => '/panduan-ppdb',

            // Programs
            'superior_programs' => json_encode([
                ['icon' => 'book', 'title' => 'Tahfidz Al-Quran', 'desc' => 'Program hafalan intensif dengan target minimal 2 Juz sebelum lulus.'],
                ['icon' => 'globe', 'title' => 'Bilingual Classes', 'desc' => 'Pembiasaan bahasa Arab dan Inggris dalam komunikasi sehari-hari di sekolah.'],
                ['icon' => 'monitor', 'title' => 'Digital Literacy', 'desc' => 'Pengenalan teknologi dasar, coding, dan literasi digital sejak dini.'],
                ['icon' => 'award', 'title' => 'Karakter Kepemimpinan', 'desc' => 'Program outbound rutin dan kemah bakti untuk mencetak jiwa pemimpin.']
            ]),

            // Vision Mission
            'school_vision' => 'Menjadi pelopor pendidikan dasar Islam terpadu yang menghasilkan lulusan berakhlak mulia, cerdas, dan siap menghadapi era global.',
            'school_missions' => json_encode([
                ['text' => 'Menyelenggarakan pendidikan berkelanjutan berbasis keteladanan.'],
                ['text' => 'Mengintegrasikan nilai-nilai Islam ke dalam kurikulum nasional.'],
                ['text' => 'Mengembangkan minat bakat siswa (multiple intelligences).'],
                ['text' => 'Menjalin kemitraan edukatif dengan orang tua dan masyarakat.']
            ]),

            // Teachers
            'teachers_data' => json_encode([
                ['name' => 'Ust. Dr. Abdul Rahman', 'role' => 'Kepala Sekolah', 'image' => 'https://ui-avatars.com/api/?name=Abdul+Rahman&background=4f46e5&color=fff&size=300'],
                ['name' => 'Usth. Siti Khadijah, M.Pd.', 'role' => 'Waka Kurikulum', 'image' => 'https://ui-avatars.com/api/?name=Siti+Khadijah&background=7c3aed&color=fff&size=300'],
                ['name' => 'Ust. Ahmad Zaki, S.Kom.', 'role' => 'Guru IT & Robotik', 'image' => 'https://ui-avatars.com/api/?name=Ahmad+Zaki&background=10b981&color=fff&size=300'],
                ['name' => 'Usth. Fatimah, S.Ag.', 'role' => 'Kordinator Tahfidz', 'image' => 'https://ui-avatars.com/api/?name=Fatimah&background=f59e0b&color=fff&size=300']
            ]),

            // Facilities & Extracurriculars
            'facilities_list' => json_encode([
                ['name' => 'Ruang Kelas Full AC & Smart TV'],
                ['name' => 'Masjid Sekolah yang Luas'],
                ['name' => 'Laboratorium Komputer & Bahasa'],
                ['name' => 'Perpustakaan Digital (E-Library)'],
                ['name' => 'UKS dengan Perawat Siaga'],
                ['name' => 'Lapangan Basket & Futsal Terintegrasi']
            ]),
            'extracurriculars_list' => json_encode([
                ['name' => 'Robotik & Coding', 'highlight' => '1'],
                ['name' => 'Panahan (Archery)', 'highlight' => '1'],
                ['name' => 'Pramuka SIT', 'highlight' => '0'],
                ['name' => 'Klub Bahasa Inggris', 'highlight' => '0']
            ]),
        ];

        foreach ($settings as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
