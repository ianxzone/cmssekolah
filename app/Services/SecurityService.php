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

    /**
     * Get aggregated security analytics data
     */
    public static function getAnalyticsData(string $range = '30d'): array
    {
        $cacheKey = "security_analytics_{$range}";

        return Cache::remember($cacheKey, 300, function () use ($range) {
            $now = now();
            $endDate = $now->copy()->endOfDay();

            if ($range === '7d') {
                $startDate = $now->copy()->subDays(6)->startOfDay();
                $totalDays = 7;
                $periodLabel = '7 Hari Terakhir';
            } elseif ($range === 'this_month') {
                $startDate = $now->copy()->startOfMonth()->startOfDay();
                $totalDays = max(1, $now->day);
                $periodLabel = 'Bulan Ini (' . $now->translatedFormat('F Y') . ')';
            } elseif ($range === 'last_month') {
                $startDate = $now->copy()->subMonth()->startOfMonth()->startOfDay();
                $endDate = $now->copy()->subMonth()->endOfMonth()->endOfDay();
                $totalDays = $startDate->daysInMonth;
                $periodLabel = 'Bulan Lalu (' . $startDate->translatedFormat('F Y') . ')';
            } else { // default '30d'
                $startDate = $now->copy()->subDays(29)->startOfDay();
                $totalDays = 30;
                $periodLabel = '30 Hari Terakhir';
                $range = '30d';
            }

            // 1. Total Metrics
            $totalThreats = SecurityThreatLog::whereBetween('created_at', [$startDate, $endDate])->count();
            $blockedThreats = SecurityThreatLog::whereBetween('created_at', [$startDate, $endDate])
                ->where('is_blocked', true)
                ->count();

            $blockRate = $totalThreats > 0 ? round(($blockedThreats / $totalThreats) * 100, 1) : 100.0;
            $dailyAverage = $totalThreats > 0 ? round($totalThreats / $totalDays, 1) : 0;

            // 2. Daily Timeline
            $dailyDb = SecurityThreatLog::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->pluck('count', 'date')
                ->toArray();

            $timelineLabels = [];
            $timelineData = [];
            $peakDay = ['date' => '-', 'count' => 0];

            $cursor = $startDate->copy();
            while ($cursor->lte($endDate) && $cursor->lte($now)) {
                $dateKey = $cursor->format('Y-m-d');
                $count = $dailyDb[$dateKey] ?? 0;
                $label = $cursor->translatedFormat('d M');

                $timelineLabels[] = $label;
                $timelineData[] = $count;

                if ($count > $peakDay['count']) {
                    $peakDay = [
                        'date'  => $cursor->translatedFormat('d F Y'),
                        'count' => $count,
                    ];
                }

                $cursor->addDay();
            }

            // 3. Threat Types Breakdown
            $typeCounts = SecurityThreatLog::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('threat_type, COUNT(*) as count')
                ->groupBy('threat_type')
                ->orderByDesc('count')
                ->pluck('count', 'threat_type')
                ->toArray();

            $typeLabels = [];
            $typeData = [];
            $typeColors = [
                'probing'        => '#ef4444',
                'blacklisted_ip' => '#f97316',
                'sqli'           => '#dc2626',
                'xss'            => '#e11d48',
                'brute_force'    => '#eab308',
                'spam_bot'       => '#8b5cf6',
                'rate_limit'     => '#3b82f6',
            ];

            foreach ($typeCounts as $type => $count) {
                $formattedType = ucwords(str_replace('_', ' ', $type));
                $typeLabels[] = $formattedType;
                $typeData[] = $count;
            }

            // 4. Top Attacker IPs (Top 10)
            $topAttackerIps = SecurityThreatLog::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('ip_address, COUNT(*) as attack_count, MAX(threat_type) as sample_threat, MAX(created_at) as last_seen')
                ->groupBy('ip_address')
                ->orderByDesc('attack_count')
                ->limit(10)
                ->get();

            $blacklistedIps = IpRule::where('rule_type', 'blacklist')
                ->whereIn('ip_address', $topAttackerIps->pluck('ip_address'))
                ->pluck('ip_address')
                ->toArray();

            $topAttackers = $topAttackerIps->map(function ($row) use ($blacklistedIps) {
                return [
                    'ip_address'    => $row->ip_address,
                    'attack_count'  => $row->attack_count,
                    'sample_threat' => ucwords(str_replace('_', ' ', $row->sample_threat)),
                    'last_seen'     => \Carbon\Carbon::parse($row->last_seen)->diffForHumans(),
                    'is_blacklisted'=> in_array($row->ip_address, $blacklistedIps),
                ];
            });

            // 5. Top Target Endpoints
            $topEndpoints = SecurityThreatLog::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('url, method, COUNT(*) as hit_count')
                ->groupBy('url', 'method')
                ->orderByDesc('hit_count')
                ->limit(6)
                ->get()
                ->map(function ($row) use ($totalThreats) {
                    $percent = $totalThreats > 0 ? round(($row->hit_count / $totalThreats) * 100, 1) : 0;
                    return [
                        'method'    => $row->method,
                        'url'       => $row->url,
                        'hit_count' => $row->hit_count,
                        'percent'   => $percent,
                    ];
                });

            // 6. Hourly Attack Distribution (00 - 23)
            $hourlyDb = SecurityThreatLog::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
                ->groupBy('hour')
                ->pluck('count', 'hour')
                ->toArray();

            $hourlyLabels = [];
            $hourlyData = [];
            for ($h = 0; $h < 24; $h++) {
                $hourlyLabels[] = sprintf('%02d:00', $h);
                $hourlyData[] = $hourlyDb[$h] ?? 0;
            }

            return [
                'range'           => $range,
                'period_label'    => $periodLabel,
                'total_threats'   => $totalThreats,
                'blocked_threats' => $blockedThreats,
                'block_rate'      => $blockRate,
                'daily_average'   => $dailyAverage,
                'peak_day'        => $peakDay,
                'timeline'        => [
                    'labels' => $timelineLabels,
                    'data'   => $timelineData,
                ],
                'types'           => [
                    'labels' => $typeLabels,
                    'data'   => $typeData,
                    'raw'    => $typeCounts,
                ],
                'top_attackers'   => $topAttackers,
                'top_endpoints'   => $topEndpoints,
                'hourly'          => [
                    'labels' => $hourlyLabels,
                    'data'   => $hourlyData,
                ],
            ];
        });
    }

    /**
     * Generate Comprehensive Security Report Data for Monthly / Quarterly Periods
     */
    public static function getReportData(string $type = 'month', ?int $year = null, ?int $month = null, ?int $quarter = null): array
    {
        $year = $year ?? (int)date('Y');
        $month = $month ?? (int)date('n');
        $quarter = $quarter ?? (int)ceil($month / 3);

        if ($type === 'quarter') {
            $quarterMonths = [
                1 => ['start' => 1, 'end' => 3, 'label' => 'Kuartal I (Januari - Maret)'],
                2 => ['start' => 4, 'end' => 6, 'label' => 'Kuartal II (April - Juni)'],
                3 => ['start' => 7, 'end' => 9, 'label' => 'Kuartal III (Juli - September)'],
                4 => ['start' => 10, 'end' => 12, 'label' => 'Kuartal IV (Oktober - Desember)'],
            ];

            $qInfo = $quarterMonths[$quarter] ?? $quarterMonths[1];
            $startDate = \Carbon\Carbon::create($year, $qInfo['start'], 1)->startOfDay();
            $endDate = \Carbon\Carbon::create($year, $qInfo['end'], 1)->endOfMonth()->endOfDay();
            $title = "Laporan Keamanan Siber {$qInfo['label']} {$year}";
            $subtitle = "Periode " . $startDate->translatedFormat('d F Y') . " s/d " . $endDate->translatedFormat('d F Y');
        } elseif ($type === 'year') {
            $startDate = \Carbon\Carbon::create($year, 1, 1)->startOfDay();
            $endDate = \Carbon\Carbon::create($year, 12, 31)->endOfDay();
            $title = "Laporan Tahunan Keamanan Siber {$year}";
            $subtitle = "Periode 01 Januari {$year} s/d 31 Desember {$year}";
        } else { // default 'month'
            $type = 'month';
            $startDate = \Carbon\Carbon::create($year, $month, 1)->startOfDay();
            $endDate = $startDate->copy()->endOfMonth()->endOfDay();
            $title = "Laporan Keamanan Siber Bulanan - " . $startDate->translatedFormat('F Y');
            $subtitle = "Periode " . $startDate->translatedFormat('01 F Y') . " s/d " . $endDate->translatedFormat('d F Y');
        }

        // Clamp endDate to now if in current period
        $realEndDate = $endDate->isFuture() ? now() : $endDate;
        $totalDays = max(1, $startDate->diffInDays($realEndDate) + 1);

        // Core Aggregations
        $totalThreats = SecurityThreatLog::whereBetween('created_at', [$startDate, $endDate])->count();
        $blockedThreats = SecurityThreatLog::whereBetween('created_at', [$startDate, $endDate])
            ->where('is_blocked', true)
            ->count();
        $blockRate = $totalThreats > 0 ? round(($blockedThreats / $totalThreats) * 100, 1) : 100.0;
        $dailyAverage = $totalThreats > 0 ? round($totalThreats / $totalDays, 1) : 0;

        // Threat Categories
        $categories = SecurityThreatLog::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('threat_type, severity, COUNT(*) as count')
            ->groupBy('threat_type', 'severity')
            ->orderByDesc('count')
            ->get();

        // Top IPs
        $topIps = SecurityThreatLog::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('ip_address, COUNT(*) as attack_count, MAX(threat_type) as sample_threat')
            ->groupBy('ip_address')
            ->orderByDesc('attack_count')
            ->limit(10)
            ->get();

        // Active IP Rules at this moment
        $totalActiveBlacklist = IpRule::where('rule_type', 'blacklist')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })->count();

        $healthScore = self::calculateHealthScore();

        return [
            'type'            => $type,
            'year'            => $year,
            'month'           => $month,
            'quarter'         => $quarter,
            'title'           => $title,
            'subtitle'        => $subtitle,
            'start_date'      => $startDate,
            'end_date'        => $endDate,
            'total_days'      => $totalDays,
            'total_threats'   => $totalThreats,
            'blocked_threats' => $blockedThreats,
            'block_rate'      => $blockRate,
            'daily_average'   => $dailyAverage,
            'categories'      => $categories,
            'top_ips'         => $topIps,
            'active_blacklist'=> $totalActiveBlacklist,
            'health_score'    => $healthScore,
            'generated_at'    => now(),
            'generated_by'    => auth()->user()?->name ?? 'Administrator',
        ];
    }
}
