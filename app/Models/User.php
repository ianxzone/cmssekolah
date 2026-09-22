<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * User Roles Constants
     */
    public const ROLE_ADMIN = 'admin';
    public const ROLE_EDITOR = 'editor';
    public const ROLE_AUTHOR = 'author';
    public const ROLE_CONTRIBUTOR = 'contributor';

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
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
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

    /**
     * Available roles list with human readable labels and descriptions.
     */
    public static function getRolesList(): array
    {
        return [
            self::ROLE_ADMIN => [
                'name' => 'Administrator',
                'description' => 'Akses penuh ke semua menu, pengaturan sistem, dan dapat mengganti author artikel apapun.',
                'badge_color' => '#dc2626',
            ],
            self::ROLE_EDITOR => [
                'name' => 'Editor',
                'description' => 'Dapat mengelola, mengedit, mempublikasikan postingan dari semua penulis serta mengganti author.',
                'badge_color' => '#2563eb',
            ],
            self::ROLE_AUTHOR => [
                'name' => 'Penulis (Author)',
                'description' => 'Dapat membuat, mengedit, dan mempublikasikan postingan miliknya sendiri. Tidak dapat mengganti author.',
                'badge_color' => '#059669',
            ],
            self::ROLE_CONTRIBUTOR => [
                'name' => 'Kontributor',
                'description' => 'Dapat membuat draft artikel miliknya sendiri, membutuhkan persetujuan editor/admin untuk publikasi.',
                'badge_color' => '#d97706',
            ],
        ];
    }

    /**
     * Check if user is an Administrator.
     */
    public function isAdmin(): bool
    {
        return ($this->role ?? self::ROLE_ADMIN) === self::ROLE_ADMIN;
    }

    /**
     * Check if user has Editor level (Admin or Editor).
     */
    public function isEditor(): bool
    {
        return in_array($this->role ?? self::ROLE_ADMIN, [self::ROLE_ADMIN, self::ROLE_EDITOR]);
    }

    /**
     * Check if user can create/manage posts as author.
     */
    public function isAuthor(): bool
    {
        return in_array($this->role ?? self::ROLE_ADMIN, [
            self::ROLE_ADMIN,
            self::ROLE_EDITOR,
            self::ROLE_AUTHOR,
            self::ROLE_CONTRIBUTOR
        ]);
    }

    /**
     * Check if user can change the author of posts (Admin & Editor only).
     */
    public function canChangeAuthor(): bool
    {
        return $this->isEditor();
    }

    /**
     * Human readable role label.
     */
    public function getRoleLabelAttribute(): string
    {
        $roles = self::getRolesList();
        return $roles[$this->role]['name'] ?? ucfirst($this->role ?? 'Author');
    }

    /**
     * Posts written by this user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }
}
