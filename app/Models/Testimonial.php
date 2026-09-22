<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'role',
        'occupation',
        'content',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
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

    public function getRoleLabelAttribute()
    {
        return match ($this->role) {
            'parent' => 'Orang Tua Santri',
            'student' => 'Santri / Siswa',
            'alumni' => 'Alumni',
            default => $this->role ?? 'Sahabat Lembaga'
        };
    }
}
