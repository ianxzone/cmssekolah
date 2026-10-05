<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class PartnershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            [
                'name' => 'GSE',
                'logo' => 'images/partners/gse.png',
                'url'  => 'https://lama.alirsyad.sch.id/partnership/global-school-of-english-gse',
                'desc' => 'Global Scale of English'
            ],
            [
                'name' => 'PEARSON EDEXCEL',
                'logo' => 'images/partners/pearson.png',
                'url'  => '/pearson-icp',
                'desc' => 'Kurikulum Internasional Pearson Edexcel'
            ],
            [
                'name' => 'MUSTAQILI',
                'logo' => 'images/partners/mustaqili.png',
                'url'  => 'https://lama.alirsyad.sch.id/mustaqili',
                'desc' => 'Metode Belajar Bahasa Arab Mustaqili'
            ],
            [
                'name' => 'KOMITE',
                'logo' => 'images/partners/komite.png',
                'url'  => 'https://lama.alirsyad.sch.id/komite',
                'desc' => 'Komite Sekolah Al Irsyad'
            ],
            [
                'name' => 'CODE ORG',
                'logo' => 'images/partners/codeorg.jpg',
                'url'  => 'https://lama.alirsyad.sch.id/code-org',
                'desc' => 'Kurikulum Ilmu Komputer & Pemrograman'
            ],
            [
                'name' => 'PERPUNAS',
                'logo' => 'images/partners/perpusnas.png',
                'url'  => 'https://lama.alirsyad.sch.id/partnership/perpunas',
                'desc' => 'Perpustakaan Nasional RI'
            ],
        ];

        Setting::set('home_show_partnership', '1', 'boolean');
        Setting::set('partnership_title', 'PARTNERSHIP', 'text');
        Setting::set('partnership_subtitle', 'Jaringan Kemitraan Strategis', 'text');
        Setting::set('partners_list', json_encode($partners), 'json');
    }
}
