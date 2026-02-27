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
        Schema::table('events', function (Blueprint $table) {
            $table->string('type')->default('offline')->after('title'); // offline, online
            $table->string('meeting_link')->nullable()->after('type');
            $table->text('map_link')->nullable()->after('location');
            $table->string('organizer_name')->nullable()->after('image');
            $table->json('sponsors')->nullable()->after('organizer_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['type', 'meeting_link', 'map_link', 'organizer_name', 'sponsors']);
        });
    }
};
