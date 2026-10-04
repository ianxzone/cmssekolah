<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'fields', 'is_active', 'use_captcha'];

    protected $casts = [
        'fields' => 'array',
        'is_active' => 'boolean',
        'use_captcha' => 'boolean',
    ];

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }
}
