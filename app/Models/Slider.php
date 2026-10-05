<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'auto_play' => 'boolean',
        'delay'     => 'integer',
    ];

    /**
     * Relasi ke semua item slide di dalam slider ini
     */
    public function items()
    {
        return $this->hasMany(SliderItem::class, 'slider_id')->orderBy('sort_order', 'asc');
    }

    /**
     * Relasi ke item slide yang aktif saja
     */
    public function activeItems()
    {
        return $this->hasMany(SliderItem::class, 'slider_id')
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc');
    }

    /**
     * Dapatkan Slider yang sedang aktif untuk beranda
     */
    public static function getActive()
    {
        return self::where('is_active', true)->with(['items' => function ($q) {
            $q->where('is_active', true)->orderBy('sort_order', 'asc');
        }])->first();
    }
}
