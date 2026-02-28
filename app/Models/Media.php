<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_name',
        'mime_type',
        'path',
        'disk',
        'size',
        'alt_text',
        'caption',
    ];

    public function getUrlAttribute()
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function getIsImageAttribute()
    {
        return str_starts_with($this->mime_type, 'image/');
    }
}
