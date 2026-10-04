<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\IpRule;
use App\Models\SecurityThreatLog;
use App\Models\Setting;
use App\Services\SecurityService;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    /**
     * Display the Security Center tabs
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'overview');

        // Common settings
        $settings = Setting::pluck('value', 'key')->toArray();

        // ─── TAB 1: OVERVIEW ───
        $healthScore = SecurityService::calculateHealthScore();

        $todaySuccessfulLogins = AuditLog::where('action', 'login')
            ->whereDate('created_at', today())
            ->count();

        $todayFailedLogins = AuditLog::where('action', 'failed_login')
            ->whereDate('created_at', today())
            ->count();

        $todayThreatsBlocked = SecurityThreatLog::whereDate('created_at', today())
            ->count();

        $totalBlockedIps = IpRule::where('rule_type', 'blacklist')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->count();

        $recentAudits = AuditLog::latest('created_at')->limit(6)->get();
        $recentThreats = SecurityThreatLog::latest('created_at')->limit(6)->get();

        // ─── TAB 2: AUDIT LOGS ───
        $auditQuery = AuditLog::with('user')->latest('created_at');

        if ($search = $request->query('search')) {
            $auditQuery->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        if ($module = $request->query('module')) {
            $auditQuery->where('module', $module);
        }

        if ($action = $request->query('action_type')) {
            $auditQuery->where('action', $action);
        }

        $auditLogs = $auditQuery->paginate(20, ['*'], 'audit_page')->withQueryString();

        // ─── TAB 3: THREAT LOGS & IP RULES ───
        $threatQuery = SecurityThreatLog::latest('created_at');

        if ($threatType = $request->query('threat_type')) {
            $threatQuery->where('threat_type', $threatType);
        }

        $threatLogs = $threatQuery->paginate(20, ['*'], 'threat_page')->withQueryString();
        $ipRules = IpRule::with('creator')->latest()->get();

        return view('admin.security.index', compact(
            'tab',
            'settings',
            'healthScore',
            'todaySuccessfulLogins',
            'todayFailedLogins',
            'todayThreatsBlocked',
            'totalBlockedIps',
            'recentAudits',
            'recentThreats',
            'auditLogs',
            'threatLogs',
            'ipRules'
        ));
    }

    /**
     * Add manual IP rule (Blacklist or Whitelist)
     */
    public function blockIp(Request $request)
    {
        $validated = $request->validate([
            'ip_address'       => 'required|ip',
            'rule_type'        => 'required|in:blacklist,whitelist',
            'reason'           => 'nullable|string|max:255',
            'duration_minutes' => 'nullable|integer|min:1',
        ]);

        $expiresAt = !empty($validated['duration_minutes'])
            ? now()->addMinutes((int)$validated['duration_minutes'])
            : null;

        IpRule::updateOrCreate(
            ['ip_address' => $validated['ip_address']],
            [
                'rule_type'  => $validated['rule_type'],
                'reason'     => $validated['reason'] ?? ($validated['rule_type'] === 'blacklist' ? 'Diblokir manual oleh admin' : 'Whitelist manual'),
                'expires_at' => $expiresAt,
                'created_by' => auth()->id(),
            ]
        );

        $actionDesc = $validated['rule_type'] === 'blacklist' ? 'Memblokir IP' : 'Menambahkan ke Whitelist';
        SecurityService::logAudit('created', 'security', "{$actionDesc}: {$validated['ip_address']}");

        return redirect()->route('admin.security.index', ['tab' => 'threats'])
            ->with('success', "Aturan IP untuk {$validated['ip_address']} berhasil disimpan!");
    }

    /**
     * Unblock an IP rule
     */
    public function unblockIp($id)
    {
        SecurityService::unblockIp((int)$id);

        return redirect()->route('admin.security.index', ['tab' => 'threats'])
            ->with('success', 'Aturan IP berhasil dihapus.');
    }

    /**
     * Clear old threat logs
     */
    public function clearThreatLogs()
    {
        SecurityThreatLog::truncate();
        SecurityService::logAudit('deleted', 'security', 'Membersihkan semua riwayat log ancaman');

        return redirect()->route('admin.security.index', ['tab' => 'threats'])
            ->with('success', 'Seluruh riwayat log ancaman berhasil dibersihkan.');
    }

    /**
     * Update security configuration settings
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'security_captcha_enabled'        => 'nullable|boolean',
            'security_captcha_provider'       => 'required|in:builtin,turnstile,recaptcha',
            'security_captcha_login'          => 'nullable|boolean',
            'security_captcha_guestbook'      => 'nullable|boolean',
            'security_captcha_comments'       => 'nullable|boolean',
            'security_captcha_forms'          => 'nullable|boolean',
            'security_turnstile_site_key'     => 'nullable|string|max:255',
            'security_turnstile_secret_key'   => 'nullable|string|max:255',
            'security_recaptcha_site_key'     => 'nullable|string|max:255',
            'security_recaptcha_secret_key'   => 'nullable|string|max:255',
            'security_login_lockout_enabled'  => 'nullable|boolean',
            'security_login_max_attempts'     => 'required|integer|min:3|max:20',
            'security_login_lockout_duration' => 'required|integer|min:5|max:1440',
            'security_waf_enabled'            => 'nullable|boolean',
            'security_auto_ban_enabled'       => 'nullable|boolean',
            'security_auto_ban_threshold'     => 'required|integer|min:3|max:50',
            'security_auto_ban_duration'      => 'required|integer|min:5|max:10080',
            'security_headers_enabled'        => 'nullable|boolean',
        ]);

        $booleanKeys = [
            'security_captcha_enabled',
            'security_captcha_login',
            'security_captcha_guestbook',
            'security_captcha_comments',
            'security_captcha_forms',
            'security_login_lockout_enabled',
            'security_waf_enabled',
            'security_auto_ban_enabled',
            'security_headers_enabled',
        ];

        foreach ($booleanKeys as $bKey) {
            Setting::set($bKey, $request->boolean($bKey) ? '1' : '0');
        }

        $textKeys = [
            'security_captcha_provider',
            'security_turnstile_site_key',
            'security_turnstile_secret_key',
            'security_recaptcha_site_key',
            'security_recaptcha_secret_key',
            'security_login_max_attempts',
            'security_login_lockout_duration',
            'security_auto_ban_threshold',
            'security_auto_ban_duration',
        ];

        foreach ($textKeys as $tKey) {
            if ($request->has($tKey)) {
                Setting::set($tKey, (string)$request->input($tKey, ''));
            }
        }

        SecurityService::logAudit('updated', 'security', 'Memperbarui konfigurasi sistem keamanan & CAPTCHA');

        return redirect()->route('admin.security.index', ['tab' => 'settings'])
            ->with('success', 'Konfigurasi keamanan berhasil disimpan!');
    }
}
