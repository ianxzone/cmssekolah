<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'event_id',
        'user_name',
        'user_email',
        'status'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
