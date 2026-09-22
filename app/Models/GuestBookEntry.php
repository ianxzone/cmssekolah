<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class GuestBookEntry extends Model
{
    use HasFactory;

    protected $table = 'guest_book_entries';

    protected $fillable = [
        'name',
        'category',
        'institution',
        'phone',
        'email',
        'purpose',
        'meet_with',
        'signature',
        'status', // pending, accepted, completed
        'admin_notes',
        'check_in_at',
    ];

    protected $casts = [
        'check_in_at' => 'datetime',
    ];

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'accepted' => '<span class="badge badge-success px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800"><i class="fas fa-check-circle mr-1"></i> Diterima</span>',
            'completed' => '<span class="badge badge-info px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800"><i class="fas fa-flag-checkered mr-1"></i> Selesai</span>',
            default => '<span class="badge badge-warning px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800"><i class="fas fa-clock mr-1"></i> Menunggu</span>',
        };
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }
}
