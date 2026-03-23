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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // super_admin, admin, editor, author
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // create_posts, edit_posts, delete_posts, etc.
            $table->string('description')->nullable();
            $table->string('group')->default('general'); // posts, pages, media, users, settings
            $table->timestamps();
        });

        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->primary(['role_id', 'permission_id']);
        });

        // Add role_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->after('email')->constrained()->onDelete('set null');
        });

        // Create activity_logs table
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('log_name')->index(); // posts, users, settings, etc.
            $table->string('description');
            $table->string('subject_type')->nullable(); // Model class name
            $table->unsignedBigInteger('subject_id')->nullable(); // Model ID
            $table->string('event')->default('created'); // created, updated, deleted, logged_in, etc.
            $table->text('properties')->nullable(); // JSON data
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->index(['log_name', 'created_at']);
            $table->index(['subject_type', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
        
        Schema::dropIfExists('activity_logs');
    }
};
