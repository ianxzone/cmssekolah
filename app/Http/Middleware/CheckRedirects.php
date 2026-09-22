<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Redirect;

class CheckRedirects
{
    /**
     * Paths that should be completely excluded from redirection checks.
     */
    protected array $excludedPrefixes = [
        'admin',
        'api',
        'storage',
        'install',
        'css',
        'js',
        'images',
        'vendor',
        '_debugbar',
        'up',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only inspect GET and HEAD requests
        if (!$request->isMethodSafe()) {
            return $next($request);
        }

        $path = $request->path(); // e.g. "berita/post-1" or "/"

        // Check if path starts with excluded prefix
        foreach ($this->excludedPrefixes as $prefix) {
            if ($request->is($prefix) || $request->is($prefix . '/*')) {
                return $next($request);
            }
        }

        $normalizedPath = Redirect::normalizePath($path);

        try {
            // 1. Check exact match first (super fast indexed query)
            $redirect = Redirect::active()
                ->where('match_type', 'exact')
                ->where(function ($q) use ($normalizedPath, $path) {
                    $q->where('source_url', $normalizedPath)
                      ->orWhere('source_url', $path)
                      ->orWhere('source_url', '/' . ltrim($path, '/'))
                      ->orWhere('source_url', rtrim($normalizedPath, '/') . '/');
                })
                ->first();

            // 2. If not found, check prefix & regex rules
            if (!$redirect) {
                $dynamicRedirects = Redirect::active()
                    ->whereIn('match_type', ['prefix', 'regex'])
                    ->get();

                foreach ($dynamicRedirects as $candidate) {
                    if ($candidate->matchesPath($normalizedPath)) {
                        $redirect = $candidate;
                        break;
                    }
                }
            }

            if ($redirect) {
                // If 410 Content Deleted / Gone
                if ($redirect->status_code === 410) {
                    $redirect->increment('hits');
                    $redirect->update(['last_accessed_at' => now()]);
                    abort(410, 'Konten ini telah dihapus permanen.');
                }

                $target = $redirect->resolveDestination($request->getRequestUri());

                // Prevent infinite redirect loop
                $targetPath = Redirect::normalizePath($target);
                if (strtolower($targetPath) !== strtolower($normalizedPath)) {
                    $redirect->increment('hits');
                    $redirect->update(['last_accessed_at' => now()]);

                    $statusCode = in_array($redirect->status_code, [301, 302, 307, 308]) 
                        ? $redirect->status_code 
                        : 301;

                    return redirect($target, $statusCode);
                }
            }
        } catch (\Throwable $e) {
            // Silently fail if database error so site remains accessible
        }

        return $next($request);
    }
}
