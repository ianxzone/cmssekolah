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
        // ─── 1. Angkatan Alumni Data (Authentic Al Irsyad Karawang) ───
        $angkatanData = [
            [
                'tahun_lulus'      => 2026,
                'nama_angkatan'    => 'Angkatan IV',
                'nomor_angkatan'   => 4,
                'persen_ptn'       => 77.50,
                'persen_pts'       => 15.00,
                'persen_ptln'      => 5.00,
                'persen_kedinasan' => 2.50,
                'flyer_image'      => 'images/alumni/flyer-2026.png',
                'catatan'          => 'Terbaru - Angkatan IV Lulus 2026 (ITB, UGM, Unpad, UI, Polban, dll)',
                'is_highlighted'   => true,
                'is_active'        => true,
                'sort_order'       => 1,
            ],
            [
                'tahun_lulus'      => 2025,
                'nama_angkatan'    => 'Angkatan III',
                'nomor_angkatan'   => 3,
                'persen_ptn'       => 72.00,
                'persen_pts'       => 25.00,
                'persen_ptln'      => 3.00,
                'persen_kedinasan' => 3.00,
                'flyer_image'      => 'images/alumni/flyer-2025.png',
                'catatan'          => 'Angkatan III Lulus 2025 (Undip, Unpad, IPB, ITS)',
                'is_highlighted'   => false,
                'is_active'        => true,
                'sort_order'       => 2,
            ],
            [
                'tahun_lulus'      => 2024,
                'nama_angkatan'    => 'Angkatan II',
                'nomor_angkatan'   => 2,
                'persen_ptn'       => 82.00,
                'persen_pts'       => 32.00,
                'persen_ptln'      => 9.00,
                'persen_kedinasan' => 0.00,
                'flyer_image'      => 'images/alumni/flyer-2024.png',
                'catatan'          => 'Angkatan II Lulus 2024 (UI, ITB, UGM, Luar Negeri)',
                'is_highlighted'   => false,
                'is_active'        => true,
                'sort_order'       => 3,
            ],
            [
                'tahun_lulus'      => 2023,
                'nama_angkatan'    => 'Angkatan I',
                'nomor_angkatan'   => 1,
                'persen_ptn'       => 62.00,
                'persen_pts'       => 35.00,
                'persen_ptln'      => 0.00,
                'persen_kedinasan' => 0.00,
                'flyer_image'      => 'images/alumni/flyer-2023.png',
                'catatan'          => 'Angkatan I Perdana Lulus 2023',
                'is_highlighted'   => false,
                'is_active'        => true,
                'sort_order'       => 4,
            ],
        ];

        foreach ($angkatanData as $data) {
            AlumniAngkatan::updateOrCreate(
                ['tahun_lulus' => $data['tahun_lulus']],
                $data
            );
        }

        // ─── 2. Video Talkshow & Inspirasi Alumni ───
        $videos = [
            [
                'judul'            => 'Edu Expo 2026 | Talkshow Alumni SMA-IT: Dari Al Irsyad Menuju Panggung Dunia',
                'deskripsi'        => 'Cuplikan Talk Show Inspiratif bersama Alumni SMA Islam Teladan Al Irsyad Karawang yang menembus PTN dan kampus unggulan.',
                'youtube_url'      => 'https://www.youtube.com/watch?v=3I2xjkIMt2U',
                'youtube_embed_id' => '3I2xjkIMt2U',
                'tahun'            => 2026,
                'is_active'        => true,
                'sort_order'       => 1,
            ],
            [
                'judul'            => 'Kisah Sukses Masuk PTN Impian & Tips Menghadapi UTBK-SNBT',
                'deskripsi'        => 'Sharing session alumni inspiratif dalam menembus perguruan tinggi negeri favorit nasional.',
                'youtube_url'      => 'https://www.youtube.com/watch?v=kYJv6aN3V8E',
                'youtube_embed_id' => 'kYJv6aN3V8E',
                'tahun'            => 2025,
                'is_active'        => true,
                'sort_order'       => 2,
            ],
            [
                'judul'            => 'Jejak Langkah Alumni Al Irsyad Meraih Beasiswa Perguruan Tinggi Luar Negeri',
                'deskripsi'        => 'Kiat menembus seleksi beasiswa internasional dan pengalaman studi di perguruan tinggi mancanegara.',
                'youtube_url'      => 'https://www.youtube.com/watch?v=7W_zQ6eL9yI',
                'youtube_embed_id' => '7W_zQ6eL9yI',
                'tahun'            => 2024,
                'is_active'        => true,
                'sort_order'       => 3,
            ],
        ];

        foreach ($videos as $v) {
            AlumniVideo::updateOrCreate(
                ['youtube_embed_id' => $v['youtube_embed_id']],
                $v
            );
        }

        // ─── 3. Alumni Settings (Hero, Branding & CTA) ───
        $settingsDefaults = [
            'alumni_hero_title'       => 'Jejak Prestasi Alumni',
            'alumni_hero_subtitle'    => 'Barakallah, Selamat & Sukses',
            'alumni_hero_description' => 'Keberhasilan lulusan SMA Islam Teladan Al Irsyad Al Islamiyyah Karawang yang tersebar di Perguruan Tinggi unggulan dalam dan luar negeri.',
            'alumni_stats_title'      => 'Statistik Keberhasilan',
            'alumni_flyer_title'      => 'Flyer Arsip Kelulusan',
            'alumni_brand_title'      => 'LAJNAH PENDIDIKAN',
            'alumni_brand_subtitle'   => 'AL IRSYAD AL ISLAMIYYAH KARAWANG',
            'alumni_cta_text'         => 'PPDB Online',
            'alumni_cta_url'          => 'https://smart.alirsyad.sch.id/pendaftaran',
            'alumni_is_active'        => '1',
        ];

        foreach ($settingsDefaults as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => 'text']
            );
        }

        if ($this->command) {
            $this->command->info('✅ Alumni data seeded successfully with authentic Al Irsyad Karawang data & flyers!');
        }
    }
}
