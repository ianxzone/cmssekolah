<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * Get all permissions for this role
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }

    /**
     * Get users with this role
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if role has a specific permission
     */
    public function hasPermission($permission): bool
    {
        if (is_string($permission)) {
            return $this->permissions->contains('name', $permission);
        }

        return $this->permissions->contains($permission);
    }

    /**
     * Grant permission to role
     */
    public function grantPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::firstWhere('name', $permission);
        }

        if ($permission && !$this->hasPermission($permission)) {
            $this->permissions()->attach($permission);
        }

        return $this;
    }

    /**
     * Revoke permission from role
     */
    public function revokePermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::firstWhere('name', $permission);
        }

        if ($permission) {
            $this->permissions()->detach($permission);
        }

        return $this;
    }

    /**
     * Sync permissions
     */
    public function syncPermissions($permissions)
    {
        $this->permissions()->sync($permissions);
        return $this;
    }
}
