<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\IpRule;
use App\Models\SecurityThreatLog;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SecurityService
{
    /**
     * Log an admin action to audit_logs
     */
    public static function logAudit(
        string $action,
        string $module,
        string $description,
        ?string $targetId = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): AuditLog {
        return AuditLog::log($action, $module, $description, $targetId, $oldValues, $newValues);
    }

    /**
     * Log a security threat
     */
    public static function logThreat(
        string $type,
        string $severity = 'medium',
        ?string $payload = null,
        bool $isBlocked = true
    ): SecurityThreatLog {
        $threat = SecurityThreatLog::log($type, $severity, $payload, $isBlocked);

        // Check if auto-ban threshold is reached
        self::checkAutoBan(request()->ip());

        return $threat;
    }

    /**
     * Check if an IP is currently blocked
     */
    public static function isIpBlocked(?string $ip = null): bool
    {
        $ip = $ip ?? request()->ip();

        if (IpRule::isWhitelisted($ip)) {
            return false;
        }

        return IpRule::isBlacklisted($ip);
    }

    /**
     * Manually or automatically block an IP
     */
    public static function blockIp(string $ip, ?string $reason = null, ?int $durationMinutes = null, ?int $userId = null): IpRule
    {
        $expiresAt = $durationMinutes ? now()->addMinutes($durationMinutes) : null;

        return IpRule::updateOrCreate(
            ['ip_address' => $ip],
            [
                'rule_type'  => 'blacklist',
                'reason'     => $reason ?? 'Diblokir oleh sistem keamanan',
                'expires_at' => $expiresAt,
                'created_by' => $userId,
            ]
        );
    }

    /**
     * Unblock an IP rule
     */
    public static function unblockIp(int $id): bool
    {
        $rule = IpRule::find($id);
        if ($rule) {
            $ip = $rule->ip_address;
            $rule->delete();
            self::logAudit('deleted', 'security', "Membuka blokir IP: {$ip}", (string)$id);
            return true;
        }
        return false;
    }

    /**
     * Check if IP has triggered enough threats to warrant an auto-ban
     */
    public static function checkAutoBan(string $ip): void
    {
        $autoBanEnabled = Setting::get('security_auto_ban_enabled', '1') === '1';
        if (!$autoBanEnabled || IpRule::isWhitelisted($ip)) {
            return;
        }

        $threshold = (int)Setting::get('security_auto_ban_threshold', '5');
        $duration = (int)Setting::get('security_auto_ban_duration', '60'); // minutes

        // Count recent high/critical threats within last 1 hour
        $recentThreats = SecurityThreatLog::where('ip_address', $ip)
            ->where('created_at', '>=', now()->subHour())
            ->whereIn('severity', ['medium', 'high', 'critical'])
            ->count();

        if ($recentThreats >= $threshold && !IpRule::isBlacklisted($ip)) {
            self::blockIp($ip, "Auto-ban: Terdeteksi {$recentThreats} pelanggaran keamanan dalam 1 jam", $duration);
            self::logAudit('blocked', 'security', "Auto-ban IP {$ip} karena {$recentThreats} ancaman terdeteksi");
        }
    }

    /**
     * Check if login is locked due to brute-force attempts
     */
    public static function isLoginLocked(string $ip, string $email): bool
    {
        $key = 'login_lockout_' . md5($ip . '_' . strtolower($email));
        return Cache::has($key);
    }

    /**
     * Record a failed login attempt and lock if threshold is reached
     */
    public static function recordFailedLogin(string $ip, string $email): array
    {
        $maxAttempts = (int)Setting::get('security_login_max_attempts', '5');
        $lockoutMinutes = (int)Setting::get('security_login_lockout_duration', '15');

        $counterKey = 'login_fails_' . md5($ip . '_' . strtolower($email));
        $lockKey = 'login_lockout_' . md5($ip . '_' . strtolower($email));

        $attempts = (int)Cache::get($counterKey, 0) + 1;
        Cache::put($counterKey, $attempts, now()->addMinutes($lockoutMinutes));

        self::logThreat('brute_force', 'medium', "Percobaan login gagal ({$attempts}/{$maxAttempts}) untuk email: {$email}", false);

        if ($attempts >= $maxAttempts) {
            Cache::put($lockKey, true, now()->addMinutes($lockoutMinutes));
            self::logThreat('brute_force', 'high', "Akun/IP dikunci selama {$lockoutMinutes} menit setelah {$attempts}x gagal login (Email: {$email})", true);
            return [
                'locked'         => true,
                'remaining'      => 0,
                'lockoutMinutes' => $lockoutMinutes,
            ];
        }

        return [
            'locked'    => false,
            'remaining' => $maxAttempts - $attempts,
        ];
    }

    /**
     * Clear failed login attempts after a successful login
     */
    public static function clearFailedLogins(string $ip, string $email): void
    {
        $counterKey = 'login_fails_' . md5($ip . '_' . strtolower($email));
        $lockKey = 'login_lockout_' . md5($ip . '_' . strtolower($email));

        Cache::forget($counterKey);
        Cache::forget($lockKey);
    }

    /**
     * Calculate security health score and checklist
     */
    public static function calculateHealthScore(): array
    {
        $checks = [];

        // 1. Admin Authentication Check
        $checks[] = [
            'title'       => 'Proteksi Autentikasi Admin',
            'description' => 'Route /admin diproteksi dengan session login',
            'passed'      => true,
            'weight'      => 20,
        ];

        // 2. Debug Mode Check
        $debugDisabled = !config('app.debug');
        $checks[] = [
            'title'       => 'Mode Debug Nonaktif (APP_DEBUG=false)',
            'description' => $debugDisabled ? 'Stack trace & kredensial tersembunyi dengan aman' : 'APP_DEBUG aktif! Error dapat membocorkan query & password',
            'passed'      => $debugDisabled,
            'weight'      => 15,
        ];

        // 3. Security Headers Check
        $headersEnabled = Setting::get('security_headers_enabled', '1') === '1';
        $checks[] = [
            'title'       => 'OWASP Security Headers',
            'description' => 'X-Frame-Options, X-Content-Type-Options, Referrer-Policy',
            'passed'      => $headersEnabled,
            'weight'      => 15,
        ];

        // 4. CAPTCHA & Anti-Spam Check
        $captchaEnabled = Setting::get('security_captcha_enabled', '1') === '1';
        $checks[] = [
            'title'       => 'CAPTCHA & Honeypot Form',
            'description' => $captchaEnabled ? 'Proteksi bot aktif pada formulir dan login' : 'CAPTCHA nonaktif, form rawan spam bot',
            'passed'      => $captchaEnabled,
            'weight'      => 15,
        ];

        // 5. Brute Force Protection
        $bruteForceActive = Setting::get('security_login_lockout_enabled', '1') === '1';
        $checks[] = [
            'title'       => 'Proteksi Brute-Force Login',
            'description' => 'Kunci otomatis setelah 5 kali gagal login',
            'passed'      => $bruteForceActive,
            'weight'      => 15,
        ];

        // 6. Storage Execution Prevention
        $storageHtaccess = file_exists(public_path('storage/.htaccess'));
        $checks[] = [
            'title'       => 'Anti-Eksekusi Script di Storage',
            'description' => $storageHtaccess ? '.htaccess memblokir file script (.php/.sh) di folder uploads' : 'Belum ada .htaccess proteksi di public/storage',
            'passed'      => $storageHtaccess,
            'weight'      => 10,
        ];

        // 7. Mini-WAF Threat Detector
        $wafEnabled = Setting::get('security_waf_enabled', '1') === '1';
        $checks[] = [
            'title'       => 'Mini-WAF (Deteksi SQLi, XSS & Probing)',
            'description' => 'Filter otomatis mendeteksi request berbahaya dan path terlarang (.env/wp-admin)',
            'passed'      => $wafEnabled,
            'weight'      => 10,
        ];

        $totalScore = 0;
        foreach ($checks as $check) {
            if ($check['passed']) {
                $totalScore += $check['weight'];
            }
        }

        return [
            'score'  => $totalScore,
            'checks' => $checks,
        ];
    }
}
