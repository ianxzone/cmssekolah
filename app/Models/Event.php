<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
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
