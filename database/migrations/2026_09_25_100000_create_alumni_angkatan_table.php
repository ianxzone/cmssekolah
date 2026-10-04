<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_angkatan', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun_lulus');
            $table->string('nama_angkatan', 100)->comment('Angkatan I, II, dst');
            $table->integer('nomor_angkatan')->default(1);
            $table->decimal('persen_ptn', 5, 2)->default(0);
            $table->decimal('persen_pts', 5, 2)->default(0);
            $table->decimal('persen_ptln', 5, 2)->default(0);
            $table->decimal('persen_kedinasan', 5, 2)->default(0);
            $table->string('flyer_image', 500)->nullable();
            $table->text('catatan')->nullable();
            $table->boolean('is_highlighted')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique('tahun_lulus');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_angkatan');
    }
};
