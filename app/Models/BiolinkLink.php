<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiolinkLink extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'open_new_tab' => 'boolean',
        'is_active' => 'boolean',
        'clicks_count' => 'integer',
        'sort_order' => 'integer',
    ];

    public function section()
    {
        return $this->belongsTo(BiolinkSection::class, 'section_id');
    }
}
