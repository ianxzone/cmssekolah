<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testimonial::create([
            'name' => 'Bapak Budi Santoso',
            'role' => 'parent',
            'content' => 'Alhamdulillah, semenjak anak saya bersekolah di SDIT Al Irsyad, perkembangan tahfidz dan akhlaknya sangat membanggakan. Guru-gurunya sangat perhatian dan selalu memberi kabar terbaru.',
            'is_active' => true,
        ]);

        Testimonial::create([
            'name' => 'Ibu Siti Aminah',
            'role' => 'parent',
            'content' => 'Fasilitas komputernya sangat bagus. Anak saya antusias setiap ada kelas ekstrakurikuler robotik. Sekolah yang memadukan ilmu agama dan teknologi dengan sempurna.',
            'is_active' => true,
        ]);

        Testimonial::create([
            'name' => 'Ahmad Raihan',
            'role' => 'alumni',
            'content' => 'Saya bangga menjadi alumni SDIT Al Irsyad. Ilmu agama dan dasar kepemimpinan yang ditanamkan sangat berarti bagi perjalanan saya melanjutkan pendidikan menengah.',
            'is_active' => true,
        ]);

        Testimonial::create([
            'name' => 'Aisyah Putri',
            'role' => 'student',
            'content' => 'Aku betah belajar di sini. Teman-temannya ramah, guru-gurunya asyik dan sabar. Kami juga terbiasa sholat dhuha dan dzuhur berjamaah bersama.',
            'is_active' => true,
        ]);
    }
}
