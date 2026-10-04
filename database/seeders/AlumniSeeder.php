<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AlumniAngkatan;
use App\Models\AlumniVideo;
use App\Models\Setting;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Angkatan Data (based on reference site) ───
        $angkatanData = [
            [
                'tahun_lulus'      => 2023,
                'nama_angkatan'    => 'Angkatan I',
                'nomor_angkatan'   => 1,
                'persen_ptn'       => 62.00,
                'persen_pts'       => 35.00,
                'persen_ptln'      => 0.00,
                'persen_kedinasan' => 0.00,
                'is_highlighted'   => false,
                'is_active'        => true,
                'sort_order'       => 4,
            ],
            [
                'tahun_lulus'      => 2024,
                'nama_angkatan'    => 'Angkatan II',
                'nomor_angkatan'   => 2,
                'persen_ptn'       => 82.00,
                'persen_pts'       => 32.00,
                'persen_ptln'      => 9.00,
                'persen_kedinasan' => 0.00,
                'is_highlighted'   => false,
                'is_active'        => true,
                'sort_order'       => 3,
            ],
            [
                'tahun_lulus'      => 2025,
                'nama_angkatan'    => 'Angkatan III',
                'nomor_angkatan'   => 3,
                'persen_ptn'       => 72.00,
                'persen_pts'       => 25.00,
                'persen_ptln'      => 3.00,
                'persen_kedinasan' => 3.00,
                'is_highlighted'   => false,
                'is_active'        => true,
                'sort_order'       => 2,
            ],
            [
                'tahun_lulus'      => 2026,
                'nama_angkatan'    => 'Angkatan IV',
                'nomor_angkatan'   => 4,
                'persen_ptn'       => 77.50,
                'persen_pts'       => 0.00,
                'persen_ptln'      => 0.00,
                'persen_kedinasan' => 0.00,
                'flyer_image'      => 'https://www.alirsyad.sch.id/wp-content/uploads/2026/09/alumni-sma-alirsyad-2026-lulusptn.jpeg',
                'is_highlighted'   => true,
                'is_active'        => true,
                'sort_order'       => 1,
            ],
        ];

        foreach ($angkatanData as $data) {
            AlumniAngkatan::updateOrCreate(
                ['tahun_lulus' => $data['tahun_lulus']],
                $data
            );
        }

        // ─── Video Data ───
        AlumniVideo::updateOrCreate(
            ['youtube_embed_id' => '3I2xjkIMt2U'],
            [
                'judul'            => 'Edu Expo 2026',
                'deskripsi'        => 'Cuplikan Talk Show Inspiratif bersama Alumni',
                'youtube_url'      => 'https://www.youtube.com/watch?v=3I2xjkIMt2U',
                'youtube_embed_id' => '3I2xjkIMt2U',
                'tahun'            => 2026,
                'is_active'        => true,
                'sort_order'       => 1,
            ]
        );

        // ─── Alumni Settings ───
        $settingsDefaults = [
            'alumni_hero_title'       => 'Jejak Prestasi Alumni',
            'alumni_hero_subtitle'    => 'Barakallah, Selamat & Sukses',
            'alumni_hero_description' => 'Keberhasilan lulusan yang tersebar di Perguruan Tinggi unggulan dalam dan luar negeri.',
            'alumni_stats_title'      => 'Statistik Keberhasilan',
            'alumni_flyer_title'      => 'Flyer Arsip Kelulusan',
            'alumni_is_active'        => '1',
        ];

        foreach ($settingsDefaults as $key => $value) {
            Setting::firstOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => 'text']
            );
        }

        $this->command->info('✅ Alumni data seeded successfully!');
    }
}
