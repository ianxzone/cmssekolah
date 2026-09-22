<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Teacher::count() > 0) {
            return;
        }

        Teacher::create([
            'name' => 'Ketua LPP Al Irsyad',
            'role' => 'Ketua LPP Al Irsyad',
            'unit' => 'LPP',
            'order' => 1,
            'is_active' => true,
            'bio' => 'Memimpin arah kebijakan strategis dan mutu pendidikan seluruh unit LPP Al Irsyad Karawang.',
        ]);

        Teacher::create([
            'name' => 'Ustadz Budi, M.Pd.',
            'role' => 'Kabid Pendidikan & Pengajaran',
            'unit' => 'LPP',
            'order' => 2,
            'is_active' => true,
            'bio' => 'Mengawal implementasi kurikulum khas Al Irsyad dan keterpaduan kurikulum nasional.',
        ]);

        Teacher::create([
            'name' => 'Ustadzah Siti, S.Pd.I.',
            'role' => 'Koordinator Tahfidz Al-Qur\'an',
            'unit' => 'LPP',
            'order' => 3,
            'is_active' => true,
            'bio' => 'Membina program tahsin dan tahfidz bersanad untuk seluruh peserta didik.',
        ]);

        Teacher::create([
            'name' => 'Ustadzah Sarah, M.A.',
            'role' => 'Koordinator Kurikulum & Bahasa',
            'unit' => 'LPP',
            'order' => 4,
            'is_active' => true,
            'bio' => 'Pengembangan kompetensi dwibahasa (Arab & Inggris) santri dan tenaga pendidik.',
        ]);
    }
}
