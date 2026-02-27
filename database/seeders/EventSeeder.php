<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'Penerimaan Peserta Didik Baru (PPDB) 2026/2027',
                'description' => '<p>Pendaftaran Gelombang 1 untuk Penerimaan Peserta Didik Baru tahun ajaran 2026/2027 telah dibuka. Segera daftarkan putra/putri Anda karena kuota terbatas!</p>',
                'location' => 'Kampus SDIT Al Irsyad Karawang / Online',
                'start_time' => Carbon::now()->addDays(5)->setHour(8)->setMinute(0),
                'end_time' => Carbon::now()->addDays(30)->setHour(15)->setMinute(0),
            ],
            [
                'title' => 'Lomba Tahfidz Al-Quran Tingkat SD Se-Karawang',
                'description' => '<p>SDIT Al Irsyad akan menjadi tuan rumah perlombaan Musabaqoh Hifdzil Quran untuk kategori juz 30 dan 29.</p>',
                'location' => 'Masjid Raya SDIT Al Irsyad',
                'start_time' => Carbon::now()->addDays(12)->setHour(7)->setMinute(30),
                'end_time' => Carbon::now()->addDays(12)->setHour(14)->setMinute(0),
            ],
            [
                'title' => 'Parenting Seminar: Mendidik Anak di Era Digital',
                'description' => '<p>Undangan khusus bagi seluruh orang tua/wali murid untuk mengikuti seminar parenting dengan pembicara ahli psikologi anak dan pakar pendidikan Islam.</p>',
                'location' => 'Aula Utama SDIT Al Irsyad',
                'start_time' => Carbon::now()->addDays(20)->setHour(8)->setMinute(30),
                'end_time' => Carbon::now()->addDays(20)->setHour(11)->setMinute(30),
            ],
            [
                'title' => 'Pameran Karya Robotik Siswa',
                'description' => '<p>Saksikan hasil karya inovatif dari anak-anak klub Robotik SDIT Al Irsyad. Akan ada demonstrasi robot line follower, penerapan IoT sederhana, dan mini games edukatif hasil rakitan siswa.</p>',
                'location' => 'Laboratorium Komputer',
                'start_time' => Carbon::now()->addDays(28)->setHour(9)->setMinute(0),
                'end_time' => Carbon::now()->addDays(28)->setHour(12)->setMinute(0),
            ]
        ];

        foreach ($events as $eventData) {
            Event::create($eventData);
        }
    }
}
