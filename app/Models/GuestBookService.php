<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestBookService extends Model
{
    use HasFactory;

    protected $table = 'guest_book_services';

    protected $fillable = [
        'title',
        'subtitle',
        'url',
        'icon',
        'icon_color',
        'icon_bg_color',
        'sort_order',
        'clicks_count',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'clicks_count' => 'integer',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc');
    }
}
