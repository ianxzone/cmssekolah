<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUniqueSlug;

class Event extends Model
{
    use HasUniqueSlug;

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return \App\Services\PermalinkService::getEventUrl($this);
    }
    protected $fillable = [
        'title',
        'slug',
        'type',
        'meeting_link',
        'description',
        'start_time',
        'end_time',
        'location',
        'map_link',
        'capacity',
        'image',
        'organizer_name',
        'sponsors'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'sponsors' => 'array',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
