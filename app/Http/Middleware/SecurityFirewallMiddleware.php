<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use App\Services\SecurityService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityFirewallMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        // 1. IP Blacklist Check
        if (SecurityService::isIpBlocked($ip)) {
            SecurityService::logThreat('blacklisted_ip', 'medium', "Akses ditolak untuk IP terblokir: {$ip}", true);
            return response()->view('errors.blocked', [
                'ip'     => $ip,
                'reason' => 'Alamat IP Anda sementara waktu dibatasi demi alasan keamanan.',
            ], 403);
        }

        // 2. Mini-WAF (Check if enabled in settings, default enabled)
        $wafEnabled = Setting::get('security_waf_enabled', '1') === '1';

        if ($wafEnabled && !$this->isWhitelistedRoute($request)) {
            $threat = $this->inspectRequest($request);
            if ($threat !== null) {
                SecurityService::logThreat($threat['type'], $threat['severity'], $threat['payload'], true);
                return response()->view('errors.blocked', [
                    'ip'     => $ip,
                    'reason' => 'Permintaan Anda diblokir oleh Firewall Keamanan karena terdeteksi pola berbahaya.',
                ], 403);
            }
        }

        return $next($request);
    }

    /**
     * Inspect incoming request for SQLi, XSS, and Sensitive File Probing
     */
    protected function inspectRequest(Request $request): ?array
    {
        $uri = urldecode($request->getRequestUri());
        $allInputs = json_encode($request->all());

        // A. Sensitive File / Directory Probing
        $probingPatterns = [
            '/\.env/i',
            '/wp-config\.php/i',
            '/phpmyadmin/i',
            '/wp-login\.php/i',
            '/\.git\//i',
            '/\.aws\//i',
            '/\.\.\//',                 // Path traversal (../)
            '/\.\.\\\\/',               // Windows path traversal (..\)
            '/eval\s*\(/i',
            '/base64_decode\s*\(/i',
        ];

        foreach ($probingPatterns as $pattern) {
            if (preg_match($pattern, $uri)) {
                return [
                    'type'     => 'probing',
                    'severity' => 'high',
                    'payload'  => "Path Probing: {$uri}",
                ];
            }
        }

        // B. SQL Injection Patterns in Query String & Inputs
        $sqliPatterns = [
            '/\bunion\s+all\s+select\b/i',
            '/\bunion\s+select\b/i',
            '/\bselect\s+.*\s+from\s+information_schema/i',
            '/\bbenchmark\s*\(\s*\d+\s*,\s*.*\)/i',
            '/\bsleep\s*\(\s*\d+\s*\)/i',
            '/;\s*drop\s+table\b/i',
            '/;\s*shutdown\b/i',
        ];

        foreach ($sqliPatterns as $pattern) {
            if (preg_match($pattern, $uri) || preg_match($pattern, $allInputs)) {
                return [
                    'type'     => 'sqli',
                    'severity' => 'critical',
                    'payload'  => "SQLi Pattern detected in URI/Input: " . substr($allInputs, 0, 500),
                ];
            }
        }

        // C. Obvious XSS Script Tag Injection in Non-Admin Inputs
        if (!$request->is('admin/*') && !$request->is('admin')) {
            $xssPatterns = [
                '/<script\b[^>]*>(.*?)<\/script>/is',
                '/javascript\s*:\s*[^\s]+/i',
                '/<iframe\b[^>]*>(.*?)<\/iframe>/is',
                '/onerror\s*=\s*[\'"][^\'"]*[\'"]/i',
                '/onload\s*=\s*[\'"][^\'"]*[\'"]/i',
            ];

            foreach ($xssPatterns as $pattern) {
                if (preg_match($pattern, $allInputs)) {
                    return [
                        'type'     => 'xss',
                        'severity' => 'high',
                        'payload'  => "XSS Pattern detected: " . substr($allInputs, 0, 500),
                    ];
                }
            }
        }

        return null;
    }

    /**
     * Routes exempt from aggressive inspection
     */
    protected function isWhitelistedRoute(Request $request): bool
    {
        return $request->is('admin/settings*') || $request->is('admin/media*');
    }
}
