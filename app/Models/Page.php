<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'type',
        'status',
        'published_at',
        'seo_title',
        'seo_description'
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return \Illuminate\Support\Facades\Storage::url($this->image);
    }

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where(function ($q) {
                         $q->whereNull('published_at')
                           ->orWhere('published_at', '<=', now());
                     });
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'pending' => 'Pending Review',
            'scheduled' => 'Scheduled',
            'published' => 'Published',
            default => ucfirst($this->status ?? 'Draft'),
        };
    }

    public function getIsPublishedAttribute()
    {
        return $this->status === 'published' && ($this->published_at === null || $this->published_at <= now());
    }

    public function getIsScheduledAttribute()
    {
        return $this->status === 'scheduled' || ($this->published_at && $this->published_at > now());
    }
}
