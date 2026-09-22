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
        Schema::create('biolink_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->default('default')->unique();
            $table->string('title')->default('Al Irsyad Al Islamiyyah');
            $table->string('subtitle')->nullable()->default('Karawang Branch');
            $table->string('badge_text')->nullable()->default('Islamic Tech Generation');
            $table->string('badge_icon')->nullable()->default('fa-solid fa-microchip');
            $table->text('bio')->nullable();
            $table->string('avatar_path')->nullable();
            $table->string('banner_path')->nullable();
            $table->boolean('show_verified_badge')->default(true);
            
            // Theme settings
            $table->string('theme_bg_color')->default('#022c19');
            $table->string('theme_primary_color')->default('#006837');
            $table->string('theme_accent_color')->default('#FBB03B');
            $table->boolean('show_pattern')->default(true);
            $table->boolean('show_scanline')->default(true);
            
            // Video profile
            $table->string('youtube_url')->nullable();
            $table->boolean('show_youtube')->default(true);
            
            // Social links
            $table->json('social_links')->nullable();
            
            // Footer
            $table->string('footer_text')->nullable()->default('© 2026 Al Irsyad Al Islamiyyah Karawang.');
            $table->string('footer_subtext')->nullable()->default('Building The Islamic Tech Generation');
            
            // SEO Meta
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('og_image')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('biolink_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('biolink_profiles')->onDelete('cascade');
            $table->string('title');
            $table->string('icon')->nullable();
            $table->string('layout_type')->default('list'); // 'list' or 'grid_2'
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('biolink_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('biolink_sections')->onDelete('cascade');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('url');
            $table->string('icon')->nullable();
            $table->string('icon_color')->nullable();
            $table->string('icon_bg_color')->nullable();
            $table->string('badge_text')->nullable();
            $table->string('badge_color')->nullable();
            $table->string('style_type')->default('standard'); // 'standard' or 'highlighted'
            $table->boolean('open_new_tab')->default(true);
            $table->unsignedBigInteger('clicks_count')->default(0);
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
        Schema::dropIfExists('biolink_links');
        Schema::dropIfExists('biolink_sections');
        Schema::dropIfExists('biolink_profiles');
    }
};
