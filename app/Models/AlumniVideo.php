<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniVideo extends Model
{
    protected $table = 'alumni_videos';

    protected $fillable = [
        'judul',
        'deskripsi',
        'youtube_url',
        'youtube_embed_id',
        'tahun',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope: only active videos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: ordered
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('tahun', 'desc');
    }

    /**
     * Extract YouTube embed ID from various YouTube URL formats
     */
    public static function extractYoutubeId($url)
    {
        $patterns = [
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * Get YouTube embed URL
     */
    public function getEmbedUrlAttribute()
    {
        return 'https://www.youtube.com/embed/' . $this->youtube_embed_id;
    }
}
