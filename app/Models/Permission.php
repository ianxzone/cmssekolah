<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'group'];

    /**
     * Get roles that have this permission
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions');
    }

    /**
     * Get users that have this permission (through roles)
     */
    public function users()
    {
        return $this->hasManyThrough(User::class, Role::class);
    }
}
