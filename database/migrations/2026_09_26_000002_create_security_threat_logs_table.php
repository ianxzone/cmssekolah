<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_threat_logs', function (Blueprint $table) {
            $table->id();
            $table->string('threat_type', 50); // brute_force, sqli, xss, probing, spam_bot, rate_limit, blacklisted_ip
            $table->string('severity', 20)->default('medium'); // low, medium, high, critical
            $table->string('ip_address', 45);
            $table->string('method', 10)->default('GET');
            $table->string('url', 1000);
            $table->text('payload')->nullable();
            $table->text('user_agent')->nullable();
            $table->boolean('is_blocked')->default(true);
            $table->timestamp('created_at')->useCurrent();

            $table->index(['threat_type', 'severity']);
            $table->index('ip_address');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_threat_logs');
    }
};
