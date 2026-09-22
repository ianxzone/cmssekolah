<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiolinkSection extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function profile()
    {
        return $this->belongsTo(BiolinkProfile::class, 'profile_id');
    }

    public function links()
    {
        return $this->hasMany(BiolinkLink::class, 'section_id')->orderBy('sort_order', 'asc');
    }

    public function activeLinks()
    {
        return $this->hasMany(BiolinkLink::class, 'section_id')
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc');
    }
}
