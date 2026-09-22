<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $fillable = [
        'post_id',
        'name',
        'email',
        'phone',
        'content',
        'status',
        'ip_address',
        'user_agent',
    ];

    /**
     * Associated post.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Scope for approved comments.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for pending comments.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Status label and badge color.
     */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'approved' => ['label' => 'Approved', 'bg' => '#dcfce7', 'color' => '#15803d'],
            'pending'  => ['label' => 'Pending Review', 'bg' => '#fef3c7', 'color' => '#b45309'],
            'spam'     => ['label' => 'Spam', 'bg' => '#fee2e2', 'color' => '#b91c1c'],
            'rejected' => ['label' => 'Rejected', 'bg' => '#f1f5f9', 'color' => '#64748b'],
            default    => ['label' => ucfirst($this->status), 'bg' => '#f1f5f9', 'color' => '#64748b'],
        };
    }
}
