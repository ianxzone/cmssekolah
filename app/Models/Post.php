<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUniqueSlug;

class Post extends Model
{
    use HasUniqueSlug;

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return \App\Services\PermalinkService::getPostUrl($this);
    }
    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'content',
        'description',
        'image',
        'published_at',
        'seo_title',
        'seo_description',
        'category_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
