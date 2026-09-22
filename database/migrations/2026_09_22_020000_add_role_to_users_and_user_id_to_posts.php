<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add role column to users table if not exists
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 30)->default('author')->after('email');
            });
        }

        // Set existing user (id 1 or first user) as admin
        $firstUser = DB::table('users')->first();
        if ($firstUser) {
            DB::table('users')->where('id', $firstUser->id)->update(['role' => 'admin']);
        }

        // 2. Add user_id to posts table if not exists
        if (!Schema::hasColumn('posts', 'user_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            });
        }

        // Associate existing posts with the first user
        if ($firstUser) {
            DB::table('posts')->whereNull('user_id')->update(['user_id' => $firstUser->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('posts', 'user_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }

        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};
