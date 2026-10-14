<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('ppdb_events')) {
            Schema::create('ppdb_events', function (Blueprint $table) {
                $table->id();
                $table->string('event_name', 50)->index(); // click_wa_ppdb, click_spmb_portal, download_brosur, dll
                $table->string('category', 50)->nullable();  // Contact, PPDB, Brochure
                $table->string('label', 255)->nullable();   // Judul artikel / tombol yang diklik
                $table->string('url', 255)->nullable();     // Halaman tempat aksi dilakukan
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_events');
    }
};
