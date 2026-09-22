<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $fillable = [
        'source_url',
        'target_url',
        'match_type',
        'status_code',
        'hits',
        'last_accessed_at',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'hits' => 'integer',
        'status_code' => 'integer',
        'is_active' => 'boolean',
        'last_accessed_at' => 'datetime',
    ];

    /**
     * Scope only active redirects.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Normalize URL path to standard format (e.g. /my-path)
     */
    public static function normalizePath(string $url): string
    {
        $url = trim($url);
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            $parsed = parse_url($url, PHP_URL_PATH);
            $url = $parsed ?: '/';
        }
        
        $path = '/' . ltrim($url, '/');
        if (strlen($path) > 1) {
            $path = rtrim($path, '/');
        }
        return $path;
    }

    /**
     * Check if this redirect rule matches the incoming path.
     */
    public function matchesPath(string $path): bool
    {
        $normalizedPath = self::normalizePath($path);
        $source = self::normalizePath($this->source_url);

        switch ($this->match_type) {
            case 'exact':
                return strtolower($normalizedPath) === strtolower($source);

            case 'prefix':
                return str_starts_with(strtolower($normalizedPath), strtolower($source));

            case 'regex':
                $pattern = '#' . str_replace('#', '\#', $this->source_url) . '#i';
                return (bool) @preg_match($pattern, $path);

            default:
                return strtolower($normalizedPath) === strtolower($source);
        }
    }

    /**
     * Resolve final destination URL for the incoming path.
     */
    public function resolveDestination(string $currentUri): string
    {
        if ($this->match_type === 'regex') {
            $pattern = '#' . str_replace('#', '\#', $this->source_url) . '#i';
            $replaced = @preg_replace($pattern, $this->target_url, $currentUri);
            if ($replaced) {
                return $replaced;
            }
        }

        if ($this->match_type === 'prefix') {
            $normalizedSource = self::normalizePath($this->source_url);
            $normalizedPath = self::normalizePath($currentUri);
            $remaining = substr($normalizedPath, strlen($normalizedSource));
            return rtrim($this->target_url, '/') . '/' . ltrim($remaining, '/');
        }

        return $this->target_url;
    }
}
