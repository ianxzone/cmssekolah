<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Check if security headers are enabled in settings (default enabled)
        if (Setting::get('security_headers_enabled', '1') !== '1') {
            return $response;
        }

        // 1. Anti-Clickjacking: Disallow embedding in iframes from other domains
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // 2. Prevent MIME-type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 3. Referrer Policy: Send referrer only on same origin or secure HTTPS
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 4. Permissions Policy: Restrict access to sensitive browser features
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // 5. Cross-Origin Opener Policy
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        // 6. HSTS (Strict-Transport-Security) if request is on HTTPS
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
