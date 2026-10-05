<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SliderItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'pills'      => 'array',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Slider parent / master tema
     */
    public function slider()
    {
        return $this->belongsTo(Slider::class, 'slider_id');
    }

    /**
     * URL gambar background slide
     */
    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=1920';
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        if (Str::startsWith($this->image, ['images/', 'img/', 'assets/'])) {
            return asset($this->image);
        }

        return Storage::url($this->image);
    }

    /**
     * URL gambar visual samping jika ada
     */
    public function getSideImageUrlAttribute()
    {
        if (empty($this->side_image)) {
            return null;
        }

        if (Str::startsWith($this->side_image, ['http://', 'https://'])) {
            return $this->side_image;
        }

        if (Str::startsWith($this->side_image, ['images/', 'img/', 'assets/'])) {
            return asset($this->side_image);
        }

        return Storage::url($this->side_image);
    }
}
