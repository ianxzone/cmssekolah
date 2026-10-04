<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ip_rules', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->unique();
            $table->enum('rule_type', ['blacklist', 'whitelist'])->default('blacklist');
            $table->string('reason')->nullable();
            $table->timestamp('expires_at')->nullable(); // null = permanent
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['rule_type', 'expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ip_rules');
    }
};
