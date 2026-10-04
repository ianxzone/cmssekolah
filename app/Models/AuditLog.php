<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'module',
        'target_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function log(string $action, string $module, string $description, ?string $targetId = null, ?array $oldValues = null, ?array $newValues = null): self
    {
        $user = auth()->user();

        return self::create([
            'user_id'     => $user?->id,
            'user_name'   => $user?->name ?? 'Guest/System',
            'action'      => $action,
            'module'      => $module,
            'target_id'   => $targetId,
            'description' => $description,
            'old_values'  => $oldValues,
            'new_values'  => $newValues,
            'ip_address'  => request()->ip(),
            'user_agent'  => substr(request()->userAgent() ?? '', 0, 500),
            'created_at'  => now(),
        ]);
    }
}
