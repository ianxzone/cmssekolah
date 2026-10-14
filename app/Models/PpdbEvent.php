<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpdbEvent extends Model
{
    protected $table = 'ppdb_events';

    protected $fillable = [
        'event_name',
        'category',
        'label',
        'url',
        'ip_address',
        'user_agent',
    ];
}
