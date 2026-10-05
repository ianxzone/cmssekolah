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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(false); // Apakah slider ini yang aktif di beranda
            $table->boolean('auto_play')->default(true);
            $table->integer('delay')->default(6000); // dalam milidetik
            $table->timestamps();
        });

        Schema::create('slider_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slider_id')->constrained('sliders')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('badge')->nullable(); // e.g. OFFICIAL PEARSON EDEXCEL PARTNER
            $table->string('image')->nullable(); // path storage atau URL
            $table->string('side_image')->nullable(); // gambar siswa / visual samping jika ada
            $table->string('btn_text')->nullable();
            $table->string('btn_link')->nullable();
            $table->string('btn2_text')->nullable();
            $table->string('btn2_link')->nullable();
            $table->json('pills')->nullable(); // array poin keunggulan
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider_items');
        Schema::dropIfExists('sliders');
    }
};
