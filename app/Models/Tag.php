<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name', 
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
