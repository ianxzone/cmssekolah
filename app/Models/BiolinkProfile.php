<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BiolinkProfile extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'social_links' => 'array',
        'show_verified_badge' => 'boolean',
        'show_pattern' => 'boolean',
        'show_scanline' => 'boolean',
        'show_youtube' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function sections()
    {
        return $this->hasMany(BiolinkSection::class, 'profile_id')->orderBy('sort_order', 'asc');
    }

    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar_path) {
            return 'https://www.alirsyad.sch.id/wp-content/uploads/2025/03/cropped-logo-al-irsyad.png';
        }
        if (filter_var($this->avatar_path, FILTER_VALIDATE_URL)) {
            return $this->avatar_path;
        }
        return Storage::url($this->avatar_path);
    }

    public function getBannerUrlAttribute()
    {
        if (!$this->banner_path) {
            return 'https://www.alirsyad.sch.id/wp-content/uploads/2026/07/header-link-sekolah-alirsyad.jpeg';
        }
        if (filter_var($this->banner_path, FILTER_VALIDATE_URL)) {
            return $this->banner_path;
        }
        return Storage::url($this->banner_path);
    }
}
