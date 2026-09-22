<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BiolinkProfile;
use App\Models\BiolinkSection;
use App\Models\BiolinkLink;

class BiolinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profile = BiolinkProfile::updateOrCreate(
            ['slug' => 'default'],
            [
                'title' => 'Al Irsyad Al Islamiyyah',
                'subtitle' => 'Karawang Branch',
                'badge_text' => 'Islamic Tech Generation',
                'badge_icon' => 'fa-solid fa-microchip',
                'bio' => 'Menyiapkan Generasi Rabbani yang Berprestasi, Jujur, dan Berakhlakul Karimah.',
                'avatar_path' => 'https://www.alirsyad.sch.id/wp-content/uploads/2025/03/cropped-logo-al-irsyad.png?lossy=2&strip=1&webp=1',
                'banner_path' => 'https://www.alirsyad.sch.id/wp-content/uploads/2026/07/header-link-sekolah-alirsyad.jpeg',
                'show_verified_badge' => true,
                'theme_bg_color' => '#022c19',
                'theme_primary_color' => '#006837',
                'theme_accent_color' => '#FBB03B',
                'show_pattern' => true,
                'show_scanline' => true,
                'youtube_url' => 'https://www.youtube.com/embed/f_iiLyE48Eo',
                'show_youtube' => true,
                'social_links' => [
                    [
                        'platform' => 'Instagram',
                        'icon' => 'fa-brands fa-instagram',
                        'url' => 'https://www.instagram.com/alirsyad_karawang/',
                        'color_hover' => 'hover:text-pink-600',
                        'is_active' => true
                    ],
                    [
                        'platform' => 'WhatsApp',
                        'icon' => 'fa-brands fa-whatsapp',
                        'url' => 'https://wa.me/62895708351313',
                        'color_hover' => 'hover:text-green-600',
                        'is_active' => true
                    ],
                    [
                        'platform' => 'YouTube',
                        'icon' => 'fa-brands fa-youtube',
                        'url' => 'https://www.youtube.com/@AlIrsyadAlIslamiyyahKarawang',
                        'color_hover' => 'hover:text-red-600',
                        'is_active' => true
                    ],
                    [
                        'platform' => 'Website',
                        'icon' => 'fa-solid fa-globe',
                        'url' => 'https://www.alirsyad.sch.id/',
                        'color_hover' => 'hover:text-blue-600',
                        'is_active' => true
                    ],
                    [
                        'platform' => 'Lokasi',
                        'icon' => 'fa-solid fa-location-dot',
                        'url' => 'https://maps.app.goo.gl/2Hovo5wumHvbrj7e6',
                        'color_hover' => 'hover:text-red-600',
                        'is_active' => true
                    ],
                ],
                'footer_text' => '© 2026 Al Irsyad Al Islamiyyah Karawang.',
                'footer_subtext' => 'Building The Islamic Tech Generation',
                'meta_title' => 'Official Link Al Irsyad Al Islamiyyah Karawang | PPDB & Informasi',
                'meta_description' => 'Pusat informasi resmi Al Irsyad Al Islamiyyah Karawang. Akses cepat link Pendaftaran PPDB Online, Indent Siswa Baru, Berita Terkini, dan Kontak Unit TKIT, SDIT, SMPIT, hingga SMAIT.',
                'meta_keywords' => 'Al Irsyad Karawang, PPDB Al Irsyad, Sekolah Islam Karawang, TKIT Al Irsyad, SDIT Al Irsyad, SMPIT Al Irsyad, SMAIT Al Irsyad, Link Bio Al Irsyad',
                'og_image' => 'https://www.alirsyad.sch.id/wp-content/uploads/2025/11/Fasilitas-View-Aula-min-1.jpeg',
                'is_active' => true,
            ]
        );

        // Clear existing sections & links for clean seeding
        BiolinkSection::where('profile_id', $profile->id)->delete();

        // 1. Seksi Pendaftaran (PPDB)
        $section1 = BiolinkSection::create([
            'profile_id' => $profile->id,
            'title' => 'Pendaftaran (PPDB)',
            'icon' => 'fa-solid fa-rocket',
            'layout_type' => 'list',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        BiolinkLink::create([
            'section_id' => $section1->id,
            'title' => 'Daftar PPDB Online',
            'subtitle' => 'Klik di sini untuk mendaftar',
            'url' => 'https://www.alirsyad.sch.id/smart',
            'icon' => 'fa-solid fa-user-plus',
            'style_type' => 'highlighted',
            'badge_text' => 'OPEN',
            'badge_color' => '#FBB03B',
            'open_new_tab' => true,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // 2. Seksi Informasi Publik
        $section2 = BiolinkSection::create([
            'profile_id' => $profile->id,
            'title' => 'Informasi Publik',
            'icon' => 'fa-solid fa-bullhorn',
            'layout_type' => 'list',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $links2 = [
            [
                'title' => 'Official Website',
                'subtitle' => null,
                'url' => 'https://www.alirsyad.sch.id/',
                'icon' => 'fa-solid fa-globe',
                'icon_color' => 'text-blue-600',
                'icon_bg_color' => 'bg-blue-50',
                'style_type' => 'standard',
                'sort_order' => 1,
            ],
            [
                'title' => 'Booklet Informasi Sekolah',
                'subtitle' => null,
                'url' => 'https://www.alirsyad.sch.id/booklet-informasi-al-irsyad-al-islamiyyah-karawang',
                'icon' => 'fa-solid fa-book-open',
                'icon_color' => 'text-orange-600',
                'icon_bg_color' => 'bg-orange-50',
                'style_type' => 'standard',
                'sort_order' => 2,
            ],
            [
                'title' => 'Pendaftaran School Tour',
                'subtitle' => null,
                'url' => 'https://www.alirsyad.sch.id/schooltour',
                'icon' => 'fa-solid fa-school',
                'icon_color' => 'text-purple-600',
                'icon_bg_color' => 'bg-purple-50',
                'style_type' => 'standard',
                'sort_order' => 3,
            ],
            [
                'title' => 'Berita & Artikel Terkini',
                'subtitle' => null,
                'url' => 'https://www.alirsyad.sch.id/blog',
                'icon' => 'fa-solid fa-newspaper',
                'icon_color' => 'text-red-600',
                'icon_bg_color' => 'bg-red-50',
                'style_type' => 'standard',
                'sort_order' => 4,
            ],
        ];

        foreach ($links2 as $l) {
            BiolinkLink::create(array_merge($l, ['section_id' => $section2->id, 'open_new_tab' => true, 'is_active' => true]));
        }

        // 3. Seksi Instagram Unit (Grid 2 Kolom)
        $section3 = BiolinkSection::create([
            'profile_id' => $profile->id,
            'title' => 'Instagram Unit',
            'icon' => 'fa-brands fa-instagram',
            'layout_type' => 'grid_2',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        $links3 = [
            [
                'title' => 'TKIT Aliska',
                'url' => 'https://www.instagram.com/tkit_aliska/',
                'icon' => 'fa-solid fa-shapes',
                'icon_color' => 'text-pink-600',
                'icon_bg_color' => 'bg-pink-100',
                'style_type' => 'standard',
                'sort_order' => 1,
            ],
            [
                'title' => 'SDIT Al Irsyad',
                'url' => 'https://www.instagram.com/sdit_alirsyad_krw/',
                'icon' => 'fa-solid fa-book',
                'icon_color' => 'text-red-600',
                'icon_bg_color' => 'bg-red-100',
                'style_type' => 'standard',
                'sort_order' => 2,
            ],
            [
                'title' => 'SMPIT Al Irsyad',
                'url' => 'https://www.instagram.com/smpitalirsyad_karawang/',
                'icon' => 'fa-solid fa-book-open',
                'icon_color' => 'text-blue-600',
                'icon_bg_color' => 'bg-blue-100',
                'style_type' => 'standard',
                'sort_order' => 3,
            ],
            [
                'title' => 'SMA IT Al Irsyad',
                'url' => 'https://www.instagram.com/smaitalirsyadkrw/',
                'icon' => 'fa-solid fa-graduation-cap',
                'icon_color' => 'text-gray-600',
                'icon_bg_color' => 'bg-gray-200',
                'style_type' => 'standard',
                'sort_order' => 4,
            ],
        ];

        foreach ($links3 as $l) {
            BiolinkLink::create(array_merge($l, ['section_id' => $section3->id, 'open_new_tab' => true, 'is_active' => true]));
        }

        // 4. Seksi Hubungi Kami
        $section4 = BiolinkSection::create([
            'profile_id' => $profile->id,
            'title' => 'Hubungi Kami',
            'icon' => 'fa-solid fa-headset',
            'layout_type' => 'list',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        $links4 = [
            [
                'title' => 'Call Center (WA)',
                'subtitle' => '0895-7083-51313',
                'url' => 'https://wa.me/62895708351313',
                'icon' => 'fa-brands fa-whatsapp',
                'icon_color' => 'text-brand-green',
                'icon_bg_color' => 'bg-green-50',
                'style_type' => 'standard',
                'sort_order' => 1,
            ],
            [
                'title' => 'Lokasi Sekolah',
                'subtitle' => null,
                'url' => 'https://maps.app.goo.gl/2Hovo5wumHvbrj7e6',
                'icon' => 'fa-solid fa-map-location-dot',
                'icon_color' => 'text-red-500',
                'icon_bg_color' => 'bg-red-50',
                'style_type' => 'standard',
                'sort_order' => 2,
            ],
        ];

        foreach ($links4 as $l) {
            BiolinkLink::create(array_merge($l, ['section_id' => $section4->id, 'open_new_tab' => true, 'is_active' => true]));
        }
    }
}
