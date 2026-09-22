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
        $testimonials = [
            [
                'name' => 'Bapak Budi Santoso, S.T.',
                'role' => 'parent',
                'occupation' => 'Manager Engineering PT Astra Honda Motor',
                'content' => 'Alhamdulillah, semenjak anak saya bersekolah di SDIT Al Irsyad, perkembangan tahfidz dan akhlaknya sangat membanggakan. Guru-gurunya sangat perhatian dan selalu memberi kabar terbaru perkembangan anak.',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=200',
                'is_active' => true,
            ],
            [
                'name' => 'dr. Hj. Siti Aminah, Sp.A.',
                'role' => 'parent',
                'occupation' => 'Dokter Spesialis Anak RSUD Karawang',
                'content' => 'Sebagai dokter dan orang tua, saya sangat mengapresiasi lingkungan sekolah yang bersih, sehat, dan kondusif. Pembiasaan adab nabawiyah dipadukan dengan kurikulum sains modern membuat ananda tumbuh cerdas dan berkarakter.',
                'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=200',
                'is_active' => true,
            ],
            [
                'name' => 'Ahmad Raihan, S.Kom.',
                'role' => 'alumni',
                'occupation' => 'Software Engineer Tokopedia (Alumnus ITB)',
                'content' => 'Saya bangga menjadi alumni Al Irsyad Karawang. Fondasi hafalan Al-Qur\'an, kedisiplinan sholat, dan dasar logika komputasi yang diajarkan sejak dini sangat membantu saya hingga lulus dengan predikat cumlaude di ITB.',
                'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=200',
                'is_active' => true,
            ],
            [
                'name' => 'Aisyah Putri Azzahra',
                'role' => 'student',
                'occupation' => 'Siswi SDIT / Juara MHQ Tingkat Kabupaten',
                'content' => 'Aku betah sekali belajar di Al Irsyad. Asatidz-nya ramah, sabar, dan materi sains diajarkan lewat eksperimen seru di lab. Di sini juga dibimbing hafalan Al-Qur\'an dengan metode talaqqi yang mudah dipahami.',
                'image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=200',
                'is_active' => true,
            ],
            [
                'name' => 'Ir. Hendra Gunawan, M.M.',
                'role' => 'parent',
                'occupation' => 'Senior General Manager PT KIIC Karawang',
                'content' => 'Sebagai profesional di kawasan industri KIIC Karawang, saya mencari sekolah yang menanamkan tauhid kuat sekaligus wawasan internasional. SMAIT Al Irsyad membuktikan kualitasnya dengan bimbingan masuk PTN dan kedinasan yang luar biasa.',
                'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=200',
                'is_active' => true,
            ],
            [
                'name' => 'Fathimah Nurul Izzah',
                'role' => 'alumni',
                'occupation' => 'Mahasiswi Univ. Al-Azhar Kairo / Hafidzah 30 Juz',
                'content' => 'Program Bilingual Habit (Arab & Inggris) di SMPIT dan SMAIT Al Irsyad sangat terasa manfaatnya saat saya menempuh studi sarjana di Universitas Al-Azhar Kairo. Adab dan rasa percaya diri terasah sejak di bangku sekolah.',
                'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=200',
                'is_active' => true,
            ],
            [
                'name' => 'Bapak Dedi Kurniawan, S.Pd.',
                'role' => 'parent',
                'occupation' => 'Dosen & Praktisi Pendidikan Anak Usia Dini',
                'content' => 'Pendidikan usia dini di KB-TK Islam Al Irsyad luar biasa. Stimulasi sentra bermainnya sangat kreatif, anak saya pulang selalu ceria dan sudah hafal banyak doa harian serta surat-surat pendek juz 30.',
                'image' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&q=80&w=200',
                'is_active' => true,
            ],
            [
                'name' => 'Muhammad Thariq Al-Ghifari',
                'role' => 'student',
                'occupation' => 'Santri SMPIT / Juara 1 Robotik Regional Jabar',
                'content' => 'Ikut ekskul coding robotik dan tim panahan sekolah sangat menyenangkan. Di Al Irsyad kami diajarkan berprestasi di lomba-lomba tanpa meninggalkan sholat dhuha dan tilawah Al-Qur\'an.',
                'image' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&q=80&w=200',
                'is_active' => true,
            ],
            [
                'name' => 'Ibu Rina Marlina, S.E.',
                'role' => 'parent',
                'occupation' => 'Branch Manager Bank Syariah Indonesia (BSI)',
                'content' => 'Kedua anak saya bersekolah di SDIT Al Irsyad 01. Komunikasi guru ke orang tua sangat transparan, sistem pelaporan hafalan Al-Qur\'an rapi, dan anak-anak terbiasa bersikap santun kepada orang tua di rumah.',
                'image' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=200',
                'is_active' => true,
            ],
            [
                'name' => 'Farhan Maulana Akbar',
                'role' => 'alumni',
                'occupation' => 'Mahasiswa STEI ITB / Alumnus SMPIT Al Irsyad',
                'content' => 'Bimbingan Bina Pribadi Islami (BPI) selama di SMPIT menjadi kompas moral saya hingga kini. Lingkungan pertemanan yang positif dan hafalan Al-Qur\'an 5 juz menjadi bekal terbaik hidup saya.',
                'image' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=200',
                'is_active' => true,
            ],
            [
                'name' => 'H. Wahyu Pratama, M.B.A.',
                'role' => 'parent',
                'occupation' => 'Direktur Operasional PT Pupuk Kujang Cikampek',
                'content' => 'Fasilitas Smart AC classroom, sport center, dan masjid yang luas menjadikan anak-anak nyaman seharian belajar. Nilai tambah terbesarnya adalah pembentukan karakter adab sebelum ilmu.',
                'image' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&q=80&w=200',
                'is_active' => true,
            ],
            [
                'name' => 'Zahra Anindya Putri',
                'role' => 'student',
                'occupation' => 'Siswi SMAIT / Medalis Perak OSN Biologi Nasional',
                'content' => 'Alhamdulillah, berkat bimbingan intensif ustadzah di SMAIT Al Irsyad, saya berhasil menyelesaikan tasmi\' 10 juz Al-Qur\'an mutqin dan meraih medali perak olimpiade biologi.',
                'image' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&q=80&w=200',
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
