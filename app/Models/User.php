<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Get the role assigned to this user
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($role): bool
    {
        if (is_string($role)) {
            return $this->role && $this->role->name === $role;
        }

        return $this->role && $this->role->id === $role->id;
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole($roles): bool
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
            return false;
        }

        return $this->hasRole($roles);
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission($permission): bool
    {
        // Super admin has all permissions
        if ($this->hasRole('super_admin')) {
            return true;
        }

        return $this->role && $this->role->hasPermission($permission);
    }

    /**
     * Assign role to user
     */
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::firstWhere('name', $role);
        }

        if ($role) {
            $this->role()->associate($role);
            $this->save();
        }

        return $this;
    }

    /**
     * Log activity for this user
     */
    public function logActivity(string $logName, string $description, string $event = 'created', $subjectType = null, $subjectId = null, $properties = null)
    {
        return ActivityLog::create([
            'user_id' => $this->id,
            'log_name' => $logName,
            'description' => $description,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'event' => $event,
            'properties' => $properties ? json_encode($properties) : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
