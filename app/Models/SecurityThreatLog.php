<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityThreatLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'threat_type',
        'severity',
        'ip_address',
        'method',
        'url',
        'payload',
        'user_agent',
        'is_blocked',
        'created_at',
    ];

    protected $casts = [
        'is_blocked' => 'boolean',
        'created_at' => 'datetime',
    ];

    public static function log(string $type, string $severity, ?string $payload = null, bool $isBlocked = true): self
    {
        return self::create([
            'threat_type' => $type,
            'severity'    => $severity,
            'ip_address'  => request()->ip(),
            'method'      => request()->method(),
            'url'         => substr(request()->fullUrl(), 0, 1000),
            'payload'     => $payload ? substr($payload, 0, 5000) : null,
            'user_agent'  => substr(request()->userAgent() ?? '', 0, 500),
            'is_blocked'  => $isBlocked,
            'created_at'  => now(),
        ]);
    }
}
