<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'subtitle',
        'slug',
        'content',
        'description',
        'image',
        'published_at',
        'seo_title',
        'seo_description',
        'category_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Post author (user who wrote/owns this post).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * User alias for author relation.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Author display name accessor.
     */
    public function getAuthorNameAttribute(): string
    {
        return $this->author?->name ?? 'Administrator';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * All comments for this post.
     */
    public function comments()
    {
        return $this->hasMany(PostComment::class)->latest();
    }

    /**
     * Only approved comments for public display.
     */
    public function approvedComments()
    {
        return $this->hasMany(PostComment::class)->where('status', 'approved')->latest();
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (str_starts_with($this->image, 'storage/') || str_starts_with($this->image, '/storage/')) {
            return asset(ltrim($this->image, '/'));
        }

        if (file_exists(public_path($this->image))) {
            return asset($this->image);
        }

        return \Illuminate\Support\Facades\Storage::url($this->image);
    }
}
