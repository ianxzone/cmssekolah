<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent clickjacking attacks
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // XSS Protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Content Security Policy
        $cspPolicy = "default-src 'self'; " .
                    "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://unpkg.com; " .
                    "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
                    "font-src 'self' https://fonts.gstatic.com; " .
                    "img-src 'self' data: https: blob:; " .
                    "connect-src 'self' https://wa.me; " .
                    "frame-ancestors 'self'; " .
                    "base-uri 'self'; " .
                    "form-action 'self'";

        $response->headers->set('Content-Security-Policy', $cspPolicy);

        // Permissions Policy (formerly Feature Policy)
        $permissionsPolicy = "geolocation=(), microphone=(), camera=(), payment=()";
        $response->headers->set('Permissions-Policy', $permissionsPolicy);

        // Cross-Origin Embedder Policy
        $response->headers->set('Cross-Origin-Embedder-Policy', 'require-corp');

        // Cross-Origin Opener Policy
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');

        // Cross-Origin Resource Policy
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');

        return $response;
    }
}
