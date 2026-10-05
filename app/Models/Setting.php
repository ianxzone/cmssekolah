<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type'];

    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value, $type = 'text')
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }

    /**
     * Resolve asset/storage/external URL for an image setting key
     */
    public static function urlFor(string $key, ?string $default = null): ?string
    {
        $val = trim(self::get($key, '') ?? '');
        if (empty($val)) {
            return $default;
        }

        if (\Illuminate\Support\Str::startsWith($val, ['http://', 'https://', '//'])) {
            return $val;
        }

        if (file_exists(public_path($val))) {
            return asset($val);
        }

        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($val)) {
            return \Illuminate\Support\Facades\Storage::url($val);
        }

        return asset($val);
    }

    public static function logoUrl(): string
    {
        return self::urlFor('site_logo', asset('images/logo-al-irsyad.png'));
    }

    public static function faviconUrl(): string
    {
        return self::urlFor('site_favicon', asset('images/favicon.png'));
    }

    public static function siteName(): string
    {
        return self::get('site_name', 'LPP AL IRSYAD');
    }

    public static function siteTagline(): string
    {
        return self::get('site_tagline', 'LAJNAH PENDIDIKAN & PENGAJARAN');
    }

    public static function siteIconText(): string
    {
        return self::get('site_icon_text', 'LPP');
    }

    /**
     * Preset catalog of extracurricular activities with rich metadata
     */
    public static function getExtracurricularCatalog(): array
    {
        return [
            [
                'title' => 'Tahfidz & Tahsin Bersanad',
                'category' => 'quran',
                'cat_label' => 'Qur\'ani & Keagamaan',
                'icon' => 'book-open',
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Bimbingan intensif hafalan Al-Qur\'an dengan metode talaqqi dan sanad tajwid oleh Asatidz bersanad, tasmi\' akbar rutin, serta mutaba\'ah harian.',
                'schedule' => 'Senin – Kamis Ba\'da Ashar',
                'coach' => 'Ustadz Bersanad Qira\'ah Al-Qur\'an',
                'achievement' => 'Juara 1 MHQ Tingkat Kabupaten & Provinsi'
            ],
            [
                'title' => 'Khitobah Tiga Bahasa',
                'category' => 'leadership',
                'cat_label' => 'Bahasa & Kepemimpinan',
                'icon' => 'mic',
                'image' => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Latihan retorika dakwah dan public speaking dalam tiga bahasa (Arab, Inggris, dan Indonesia) untuk mencetak calon da\'i dan pemimpin muda muslim.',
                'schedule' => 'Jumat Sore & Sabtu Pagi',
                'coach' => 'Tim Pembina Dakwah Santri LPP',
                'achievement' => 'Juara Pidato Bahasa Arab se-Jawa Barat'
            ],
            [
                'title' => 'Kajian Adab & Siroh Nabawiyah',
                'category' => 'quran',
                'cat_label' => 'Qur\'ani & Keagamaan',
                'icon' => 'heart',
                'image' => 'https://images.unsplash.com/photo-1584697964190-7bb9b1f23788?auto=format&fit=crop&q=80&w=600',
                'levels' => ['TK', 'SDIT', 'SMPIT'],
                'desc' => 'Penanaman keteladanan akhlak Rasulullah SAW dan para sahabat, fikih ibadah praktis, serta pembiasaan adab harian islami.',
                'schedule' => 'Sabtu Pagi (Dwi-Mingguan)',
                'coach' => 'Tim Asatidz Pendidikan Karakter',
                'achievement' => 'Pembentukan Karakter Teladan & Mandiri'
            ],
            [
                'title' => 'Robotik & IoT Innovation',
                'category' => 'stem',
                'cat_label' => 'Sains & Teknologi',
                'icon' => 'cpu',
                'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Eksplorasi perakitan mikrokontroler, pemrograman sensor arduino, robot line follower, hingga automasi cerdas berbasis Internet of Things.',
                'schedule' => 'Sabtu 08.00 – 10.30 WIB',
                'coach' => 'Instruktur Profesional Robotika',
                'achievement' => 'Gold Medal Lomba Robotik Tingkat Nasional'
            ],
            [
                'title' => 'Coding & Game Development',
                'category' => 'stem',
                'cat_label' => 'Sains & Teknologi',
                'icon' => 'code',
                'image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Pengenalan computational thinking, logika pemrograman Scratch untuk usia dini, serta Python & Web Development untuk jenjang lanjutan.',
                'schedule' => 'Sabtu 10.30 – 12.00 WIB',
                'coach' => 'Praktisi IT & Software Engineer',
                'achievement' => 'Finalis Edu-Game Creator Cup'
            ],
            [
                'title' => 'Kelompok Ilmiah Remaja (KIR)',
                'category' => 'stem',
                'cat_label' => 'Sains & Teknologi',
                'icon' => 'activity',
                'image' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SMPIT', 'SMAIT'],
                'desc' => 'Praktikum riset ilmiah di laboratorium modern, penelitian lingkungan hidup sekitar Karawang, dan penulisan karya tulis ilmiah terstruktur.',
                'schedule' => 'Rabu Ba\'da Ashar',
                'coach' => 'Guru Sains & Praktisi Riset',
                'achievement' => 'Juara Olimpiade Penelitian Siswa Daerah'
            ],
            [
                'title' => 'Desain Grafis & Multimedia',
                'category' => 'stem',
                'cat_label' => 'Sains & Teknologi',
                'icon' => 'image',
                'image' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SMPIT', 'SMAIT'],
                'desc' => 'Pembelajaran dasar tipografi, Canva, Adobe Illustrator, editing video kreatif, hingga pembuatan infografis edukasi dakwah santri.',
                'schedule' => 'Kamis Ba\'da Ashar',
                'coach' => 'Creative Designer & Video Editor',
                'achievement' => 'Kreator Konten Dakwah Digital Santri'
            ],
            [
                'title' => 'Panahan Sunnah (Archery)',
                'category' => 'sport',
                'cat_label' => 'Olahraga & Beladiri',
                'icon' => 'target',
                'image' => 'https://images.unsplash.com/photo-1511067007772-9da29974ce44?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Menghidupkan olahraga sunnah dengan melatih fokus mental, kestabilan pernapasan, postur tubuh, serta teknik bidik standar nasional (Perpani).',
                'schedule' => 'Sabtu Pagi 07.30 WIB',
                'coach' => 'Pelatih Berlisensi PERPANI',
                'achievement' => 'Medali Emas Kejurkab Panahan Pelajar'
            ],
            [
                'title' => 'Tapak Suci Putera Muhammadiyah',
                'category' => 'sport',
                'cat_label' => 'Olahraga & Beladiri',
                'icon' => 'shield',
                'image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Seni beladiri pencak silat berakidah tauhid, mengasah ketahanan fisik, jurus tanding, dan pertahanan diri santri berjiwa kesatria.',
                'schedule' => 'Selasa & Jumat Sore',
                'coach' => 'Pendekar & Wasit Juri Berlisensi',
                'achievement' => 'Juara Umum Pencak Silat Antar-Pelajar'
            ],
            [
                'title' => 'Taekwondo Teladan',
                'category' => 'sport',
                'cat_label' => 'Olahraga & Beladiri',
                'icon' => 'zap',
                'image' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Olahraga beladiri asal Korea yang melatih kekuatan tendangan, kecepatan reaksi fisik, dan kedisiplinan jenjang sabuk hingga kyorugi tanding.',
                'schedule' => 'Kamis Sore & Minggu Pagi',
                'coach' => 'Sabeum Nim Taekwondo Indonesia',
                'achievement' => 'Medali Perak Kejuaraan Terbuka Jawa Barat'
            ],
            [
                'title' => 'Futsal & Mini Soccer Club',
                'category' => 'sport',
                'cat_label' => 'Olahraga & Beladiri',
                'icon' => 'circle',
                'image' => 'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Pembinaan taktik dasar, kerjasama regu, stamina, dan sportivitas santri di lapangan representatif LPP Al Irsyad Karawang.',
                'schedule' => 'Senin & Kamis Sore',
                'coach' => 'Pelatih Futsal Berlisensi AFC/FFI',
                'achievement' => 'Juara 1 Turnamen Futsal Antar-Sekolah Islam'
            ],
            [
                'title' => 'Basket Ball Club',
                'category' => 'sport',
                'cat_label' => 'Olahraga & Beladiri',
                'icon' => 'disc',
                'image' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SMPIT', 'SMAIT'],
                'desc' => 'Latihan teknik dribble, passing, lay-up, dan strategi defense di Sporthall tertutup dengan ring dan lapangan standar kejuaraan.',
                'schedule' => 'Rabu Sore & Sabtu Pagi',
                'coach' => 'Pelatih Perbasi Karawang',
                'achievement' => 'Semifinalis Kejuaraan Basket Pelajar'
            ],
            [
                'title' => 'Renang (Irsyadin Water Pool)',
                'category' => 'sport',
                'cat_label' => 'Olahraga & Beladiri',
                'icon' => 'droplet',
                'image' => 'https://images.unsplash.com/photo-1530549387789-4c1017266635?auto=format&fit=crop&q=80&w=600',
                'levels' => ['TK', 'SDIT', 'SMPIT'],
                'desc' => 'Olahraga sunnah renang di kolam renang privat Irsyadin Water Pool dengan pelatih profesional, jadwal ikhwan dan akhwat terpisah.',
                'schedule' => 'Sesi Khusus Terjadwal per Kelas',
                'coach' => 'Instruktur Renang Bersertifikat',
                'achievement' => 'Kemampuan Akuatik & Ketahanan Fisik Prima'
            ],
            [
                'title' => 'Pramuka SIT (Sekolah Islam Terpadu)',
                'category' => 'leadership',
                'cat_label' => 'Bahasa & Kepemimpinan',
                'icon' => 'compass',
                'image' => 'https://images.unsplash.com/photo-1504851149312-7a075b496cc7?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Gerakan kepanduan khas SIT yang menggembleng kemandirian, kecakapan survival alam terbuka, tali-temali, dan kepedulian sosial kemanusiaan.',
                'schedule' => 'Jumat Siang (Wajib/Inti)',
                'coach' => 'Pembina Pramuka Kwarda Jabar',
                'achievement' => 'Kontingen Terbaik Jambore Daerah SIT'
            ],
            [
                'title' => 'English Conversation Club',
                'category' => 'leadership',
                'cat_label' => 'Bahasa & Kepemimpinan',
                'icon' => 'globe',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Pengasahan kelancaran bercakap bahasa Inggris melalui debat, drama edukasi, storytelling, dan persiapan sertifikasi Pearson Edexcel UK.',
                'schedule' => 'Kamis Ba\'da Ashar',
                'coach' => 'Native & Pearson Certified Teacher',
                'achievement' => 'Top 3 English Storytelling se-Karawang'
            ],
            [
                'title' => 'Nadi Al-Lughah (Arabic Club)',
                'category' => 'leadership',
                'cat_label' => 'Bahasa & Kepemimpinan',
                'icon' => 'message-square',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SDIT', 'SMPIT', 'SMAIT'],
                'desc' => 'Pembiasaan muhadatsah harian bahasa Arab fusha, pengenalan qawa\'id terapan, hafalan mufrodat tematik, dan lagu anak islami.',
                'schedule' => 'Selasa Ba\'da Ashar',
                'coach' => 'Alumni LIPIA & Timur Tengah',
                'achievement' => 'Apresiasi Lomba Muhadatsah Karawang'
            ],
            [
                'title' => 'Jurnalistik & Podcast Santri',
                'category' => 'leadership',
                'cat_label' => 'Bahasa & Kepemimpinan',
                'icon' => 'radio',
                'image' => 'https://images.unsplash.com/photo-1590602847861-f357a9332bbc?auto=format&fit=crop&q=80&w=600',
                'levels' => ['SMPIT', 'SMAIT'],
                'desc' => 'Pelatihan liputan berita sekolah, teknik wawancara narasumber, penulisan artikel buletin, serta produksi siaran podcast edukatif santri.',
                'schedule' => 'Sabtu 13.00 – 15.00 WIB',
                'coach' => 'Jurnalis & Produser Konten Media',
                'achievement' => 'Penerbitan Majalah Dinding & Podcast Santri'
            ],
            [
                'title' => 'Montessori Practical Life & Cooking',
                'category' => 'leadership',
                'cat_label' => 'Bahasa & Kepemimpinan',
                'icon' => 'smile',
                'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&q=80&w=600',
                'levels' => ['Daycare', 'TK Islam'],
                'desc' => 'Aktivitas motorik mandiri anak usia dini: menyajikan makanan sehat, merapikan perlengkapan sendiri, dan mengenal ragam tekstur bahan dapur halal.',
                'schedule' => 'Jumat Pagi Terjadwal',
                'coach' => 'Guru Montessori Bersertifikat',
                'achievement' => 'Kemandirian & Disiplin Diri Sejak Dini'
            ]
        ];
    }

    /**
     * Get synchronized extracurricular activities merging admin settings and catalog
     */
    public static function getExtracurriculars(): array
    {
        $baseCatalog = self::getExtracurricularCatalog();
        $rawSettings = self::get('extracurriculars_list');
        $configured = json_decode($rawSettings ?? '[]', true) ?: [];

        if (empty($configured)) {
            return array_map(function ($item) {
                $item['name'] = $item['title'];
                $item['cat'] = $item['cat_label'];
                $item['highlight'] = '0';
                return $item;
            }, $baseCatalog);
        }

        $finalList = [];
        $matchedKeys = [];

        $inferItem = function ($name, $highlight = '0') {
            $lower = strtolower($name);
            $category = 'leadership';
            $catLabel = 'Bahasa & Kepemimpinan';
            $icon = 'award';
            $image = 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=600';
            $levels = ['SDIT', 'SMPIT', 'SMAIT'];
            $desc = 'Program pembinaan minat, bakat, dan potensi santri ' . $name . ' untuk menumbuhkan karakter percaya diri, adab islami, dan berdaya saing unggul.';
            $schedule = 'Sabtu 08.00 – 10.30 WIB';
            $coach = 'Pembina & Pelatih Berpengalaman';
            $achievement = 'Pengembangan Minat & Prestasi Santri';

            if (str_contains($lower, 'tahfidz') || str_contains($lower, 'quran') || str_contains($lower, 'tajwid') || str_contains($lower, 'tilawah')) {
                $category = 'quran';
                $catLabel = 'Qur\'ani & Keagamaan';
                $icon = 'book-open';
                $image = 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=600';
                $desc = 'Bimbingan intensif hafalan dan tajwid Al-Qur\'an bersanad bersama asatidz pengampu.';
                $achievement = 'Juara MHQ & Tasmi\' Akbar Santri';
            } elseif (str_contains($lower, 'speaking') || str_contains($lower, 'pidato') || str_contains($lower, 'khitobah') || str_contains($lower, 'retorika') || str_contains($lower, 'orasi')) {
                $category = 'leadership';
                $catLabel = 'Bahasa & Kepemimpinan';
                $icon = 'mic';
                $image = 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&fit=crop&q=80&w=600';
                $desc = 'Pelatihan percaya diri berbicara di depan umum, teknik presentasi, retorika, dan kepemimpinan komunikasi santri.';
                $achievement = 'Juara Public Speaking & Orasi Santri';
            } elseif (str_contains($lower, 'robot') || str_contains($lower, 'coding') || str_contains($lower, 'iot') || str_contains($lower, 'program')) {
                $category = 'stem';
                $catLabel = 'Sains & Teknologi';
                $icon = 'cpu';
                $image = 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&q=80&w=600';
                $desc = 'Eksplorasi perakitan mikrokontroler, coding, dan inovasi teknologi digital masa depan.';
                $achievement = 'Medali Emas Lomba Robotik & IT';
            } elseif (str_contains($lower, 'panah') || str_contains($lower, 'archery')) {
                $category = 'sport';
                $catLabel = 'Olahraga & Beladiri';
                $icon = 'target';
                $image = 'https://images.unsplash.com/photo-1511067007772-9da29974ce44?auto=format&fit=crop&q=80&w=600';
                $desc = 'Menghidupkan olahraga sunnah dengan melatih fokus mental, kestabilan napas, dan teknik bidik standar PERPANI.';
                $achievement = 'Medali Kejuaraan Panahan Pelajar';
            } elseif (str_contains($lower, 'silat') || str_contains($lower, 'tapak suci') || str_contains($lower, 'taekwondo') || str_contains($lower, 'karate') || str_contains($lower, 'bela diri') || str_contains($lower, 'beladiri')) {
                $category = 'sport';
                $catLabel = 'Olahraga & Beladiri';
                $icon = 'shield';
                $image = 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&q=80&w=600';
                $desc = 'Seni beladiri berakidah tauhid, mengasah ketahanan fisik, jurus tanding, dan pertahanan diri santri berjiwa ksatria.';
                $achievement = 'Juara Pencak Silat Antar-Pelajar';
            } elseif (str_contains($lower, 'futsal') || str_contains($lower, 'soccer') || str_contains($lower, 'basket') || str_contains($lower, 'badminton') || str_contains($lower, 'voli')) {
                $category = 'sport';
                $catLabel = 'Olahraga & Beladiri';
                $icon = str_contains($lower, 'basket') ? 'disc' : 'circle';
                $image = 'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?auto=format&fit=crop&q=80&w=600';
                $desc = 'Pembinaan taktik dasar, kerjasama regu, stamina, dan sportivitas santri di lapangan standar kejuaraan.';
                $achievement = 'Juara Turnamen Antar-Sekolah';
            } elseif (str_contains($lower, 'renang') || str_contains($lower, 'swimming')) {
                $category = 'sport';
                $catLabel = 'Olahraga & Beladiri';
                $icon = 'droplet';
                $image = 'https://images.unsplash.com/photo-1530549387789-4c1017266635?auto=format&fit=crop&q=80&w=600';
                $desc = 'Olahraga sunnah renang di kolam renang representatif dengan pelatih profesional berlisensi.';
                $achievement = 'Kemampuan Akuatik & Ketahanan Fisik Prima';
            } elseif (str_contains($lower, 'pramuka') || str_contains($lower, 'scout') || str_contains($lower, 'pandu')) {
                $category = 'leadership';
                $catLabel = 'Bahasa & Kepemimpinan';
                $icon = 'compass';
                $image = 'https://images.unsplash.com/photo-1504851149312-7a075b496cc7?auto=format&fit=crop&q=80&w=600';
                $desc = 'Gerakan kepanduan SIT yang menggembleng kemandirian, survival alam bebas, dan kepedulian kemanusiaan.';
                $achievement = 'Regu Terbaik Jambore Daerah SIT';
            } elseif (str_contains($lower, 'english') || str_contains($lower, 'inggris')) {
                $category = 'leadership';
                $catLabel = 'Bahasa & Kepemimpinan';
                $icon = 'globe';
                $image = 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=600';
                $desc = 'Pengasahan kelancaran bercakap bahasa Inggris melalui storytelling, debat, dan persiapan sertifikasi internasional.';
                $achievement = 'Top English Storytelling & Speech';
            } elseif (str_contains($lower, 'arab') || str_contains($lower, 'lughah')) {
                $category = 'leadership';
                $catLabel = 'Bahasa & Kepemimpinan';
                $icon = 'message-square';
                $image = 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=600';
                $desc = 'Pembiasaan muhadatsah harian bahasa Arab fusha, mufrodat tematik, dan lagu islami santri.';
                $achievement = 'Apresiasi Lomba Muhadatsah Karawang';
            } elseif (str_contains($lower, 'desain') || str_contains($lower, 'multimedia') || str_contains($lower, 'grafis') || str_contains($lower, 'video')) {
                $category = 'stem';
                $catLabel = 'Sains & Teknologi';
                $icon = 'image';
                $image = 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&q=80&w=600';
                $desc = 'Pembelajaran dasar tipografi, Canva, Adobe, editing video kreatif, hingga pembuatan infografis edukasi dakwah santri.';
                $achievement = 'Kreator Konten Dakwah Digital Santri';
            }

            return [
                'title' => $name,
                'name' => $name,
                'category' => $category,
                'cat_label' => $catLabel,
                'cat' => $catLabel,
                'icon' => $icon,
                'image' => $image,
                'levels' => $levels,
                'desc' => $desc,
                'schedule' => $schedule,
                'coach' => $coach,
                'achievement' => $achievement,
                'highlight' => $highlight
            ];
        };

        // 1. Process items from Settings first (they take priority and maintain admin order)
        foreach ($configured as $cfg) {
            $name = trim($cfg['name'] ?? '');
            if (empty($name)) continue;
            $highlight = $cfg['highlight'] ?? '0';

            $foundKey = null;
            $lowerName = strtolower($name);
            foreach ($baseCatalog as $idx => $base) {
                $lowerTitle = strtolower($base['title']);
                if (
                    $lowerTitle === $lowerName ||
                    str_contains($lowerTitle, $lowerName) ||
                    str_contains($lowerName, $lowerTitle) ||
                    (str_contains($lowerName, 'panahan') && str_contains($lowerTitle, 'panahan')) ||
                    (str_contains($lowerName, 'robotik') && str_contains($lowerTitle, 'robotik')) ||
                    (str_contains($lowerName, 'tahfidz') && str_contains($lowerTitle, 'tahfidz')) ||
                    (str_contains($lowerName, 'english') && str_contains($lowerTitle, 'english')) ||
                    (str_contains($lowerName, 'silat') && str_contains($lowerTitle, 'silat')) ||
                    (str_contains($lowerName, 'futsal') && str_contains($lowerTitle, 'futsal')) ||
                    (str_contains($lowerName, 'pramuka') && str_contains($lowerTitle, 'pramuka'))
                ) {
                    $foundKey = $idx;
                    break;
                }
            }

            if ($foundKey !== null) {
                $matched = $baseCatalog[$foundKey];
                $matched['title'] = $name;
                $matched['name'] = $name;
                $matched['cat'] = $matched['cat_label'];
                $matched['highlight'] = $highlight;
                $finalList[] = $matched;
                $matchedKeys[] = $foundKey;
            } else {
                $finalList[] = $inferItem($name, $highlight);
            }
        }

        // 2. Append any unconfigured base items to keep the catalog comprehensive
        foreach ($baseCatalog as $idx => $base) {
            if (!in_array($idx, $matchedKeys)) {
                $base['name'] = $base['title'];
                $base['cat'] = $base['cat_label'];
                $base['highlight'] = '0';
                $finalList[] = $base;
            }
        }

        return $finalList;
    }

    /**
     * Get extracurricular items for the Homepage carousel
     */
    public static function getHomeExtracurriculars(): array
    {
        $rawSettings = self::get('extracurriculars_list');
        $configured = json_decode($rawSettings ?? '[]', true) ?: [];
        $all = self::getExtracurriculars();

        if (!empty($configured)) {
            $homeItems = [];
            foreach ($configured as $cfg) {
                $cfgName = trim($cfg['name'] ?? '');
                if (empty($cfgName)) continue;
                foreach ($all as $item) {
                    if (strcasecmp($item['title'], $cfgName) === 0 || strcasecmp($item['name'], $cfgName) === 0) {
                        $homeItems[] = $item;
                        break;
                    }
                }
            }
            if (!empty($homeItems)) {
                return $homeItems;
            }
        }

        return array_slice($all, 0, 12);
    }
}

