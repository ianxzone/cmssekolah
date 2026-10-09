<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$page = \App\Models\Page::firstOrCreate(
    ['slug' => 'gse'],
    [
        'title' => 'Global Scale of English (GSE)',
        'content' => '<p><strong>Global Scale of English (GSE)</strong> adalah standar global pertama untuk mengukur kemampuan bahasa Inggris. Di Al Irsyad Al Islamiyyah, kami menggunakan standar GSE untuk memastikan bahwa perkembangan bahasa Inggris setiap siswa terukur secara presisi, komprehensif, dan bertaraf internasional.</p><br><ul><li>Mengukur 4 keterampilan utama: Speaking, Listening, Reading, dan Writing.</li><li>Memberikan target yang jelas di setiap tahap pembelajaran.</li><li>Menyelaraskan kurikulum sekolah dengan standar internasional (Pearson).</li></ul><br><p>Melalui kemitraan dengan GSE, siswa kami dibekali dengan kemampuan bahasa Inggris yang terjamin dan diakui secara global, mempersiapkan mereka untuk bersaing di dunia internasional.</p>',
        'status' => 'published',
        'published_at' => now(),
    ]
);
echo "Created/Found Page: " . $page->slug;
