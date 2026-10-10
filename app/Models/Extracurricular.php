<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'title',
        'category',
        'badge',
        'icon',
        'image',
        'desc',
        'order',
        'is_active',
    ];
}
