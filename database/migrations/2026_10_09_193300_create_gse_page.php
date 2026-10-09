<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Page;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Page::firstOrCreate(
            ['slug' => 'gse'],
            [
                'title' => 'Global Scale of English (GSE)',
                'content' => '<p><strong>Global Scale of English (GSE)</strong> adalah standar global pertama untuk mengukur kemampuan bahasa Inggris. Di Al Irsyad Al Islamiyyah, kami menggunakan standar GSE untuk memastikan bahwa perkembangan bahasa Inggris setiap siswa terukur secara presisi, komprehensif, dan bertaraf internasional.</p><br><ul><li>Mengukur 4 keterampilan utama: Speaking, Listening, Reading, dan Writing.</li><li>Memberikan target yang jelas di setiap tahap pembelajaran.</li><li>Menyelaraskan kurikulum sekolah dengan standar internasional (Pearson).</li></ul><br><p>Melalui kemitraan dengan GSE, siswa kami dibekali dengan kemampuan bahasa Inggris yang terjamin dan diakui secara global, mempersiapkan mereka untuk bersaing di dunia internasional.</p>',
                'status' => 'published',
                'published_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Page::where('slug', 'gse')->delete();
    }
};
