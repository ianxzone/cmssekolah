<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guest_book_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Portal Buku Tamu');
            $table->string('subtitle')->nullable()->default('Ahlan wa Sahlan di Al Irsyad');
            $table->string('greeting_title')->default("Assalamu'alaikum");
            $table->text('greeting_text')->nullable();
            $table->string('banner_path')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('footer_text')->nullable()->default('© 2026 Al Irsyad. Jazakumullahu khairan.');
            $table->boolean('enable_direct_form')->default(true);
            $table->string('wa_notification_number')->nullable();
            $table->timestamps();
        });

        Schema::create('guest_book_services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('url')->nullable();
            $table->string('icon')->nullable()->default('money-bill');
            $table->string('icon_color')->nullable()->default('#059669');
            $table->string('icon_bg_color')->nullable()->default('#ecfdf5');
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('clicks_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('guest_book_entries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->default('Umum');
            $table->string('institution')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('purpose');
            $table->string('meet_with')->nullable();
            $table->longText('signature')->nullable();
            $table->string('status')->default('pending'); // pending, accepted, completed
            $table->text('admin_notes')->nullable();
            $table->timestamp('check_in_at')->nullable();
            $table->timestamps();
        });

        // Seed default settings
        DB::table('guest_book_settings')->insert([
            'title' => 'Portal Buku Tamu',
            'subtitle' => 'Ahlan wa Sahlan di Al Irsyad',
            'greeting_title' => "Assalamu'alaikum",
            'greeting_text' => 'Bismillah. Tafadhdhol, silakan pilih layanan yang Anda tuju atau isi buku tamu digital:',
            'footer_text' => '© 2026 Al Irsyad. Jazakumullahu khairan.',
            'enable_direct_form' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed default services matching https://www.alirsyad.sch.id/buku-tamu/
        DB::table('guest_book_services')->insert([
            [
                'title' => 'Layanan Keuangan',
                'subtitle' => 'Administrasi & Pembayaran',
                'url' => 'https://www.alirsyad.sch.id/formkeuangan',
                'icon' => 'money-bill-wave',
                'icon_color' => '#059669',
                'icon_bg_color' => '#ecfdf5',
                'sort_order' => 1,
                'clicks_count' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Layanan SMART SPMB',
                'subtitle' => 'Pendaftaran & Informasi Siswa Baru',
                'url' => 'https://www.alirsyad.sch.id/formsmart',
                'icon' => 'graduation-cap',
                'icon_color' => '#0284c7',
                'icon_bg_color' => '#f0f9ff',
                'sort_order' => 2,
                'clicks_count' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Layanan Tamu Instansi',
                'subtitle' => 'Kunjungan Dinas & Lembaga',
                'url' => 'https://www.alirsyad.sch.id/forminstantsi',
                'icon' => 'building-columns',
                'icon_color' => '#d97706',
                'icon_bg_color' => '#fffbeb',
                'sort_order' => 3,
                'clicks_count' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_book_entries');
        Schema::dropIfExists('guest_book_services');
        Schema::dropIfExists('guest_book_settings');
    }
};
