<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table) {
            $table->string('alt_text')->nullable()->after('disk');
            $table->string('title')->nullable()->after('alt_text');
            $table->text('caption')->nullable()->after('title');
            $table->text('description')->nullable()->after('caption');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn(['alt_text', 'title', 'caption', 'description']);
        });
    }
};
