<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_videos', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->text('deskripsi')->nullable();
            $table->string('youtube_url', 500);
            $table->string('youtube_embed_id', 30);
            $table->integer('tahun')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_videos');
    }
};
