<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IpRule extends Model
{
    protected $fillable = [
        'ip_address',
        'rule_type',
        'reason',
        'expires_at',
        'created_by',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public static function isBlacklisted(string $ip): bool
    {
        $rule = self::where('ip_address', $ip)
            ->where('rule_type', 'blacklist')
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->first();

        return $rule !== null;
    }

    public static function isWhitelisted(string $ip): bool
    {
        return self::where('ip_address', $ip)
            ->where('rule_type', 'whitelist')
            ->exists();
    }
}
