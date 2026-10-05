<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\CaptchaService;
use App\Services\SecurityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the admin login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        $captchaEnabled = CaptchaService::isEnabledFor('login');
        $captchaProvider = CaptchaService::getProvider();
        $mathCaptcha = null;

        if ($captchaEnabled && $captchaProvider === 'builtin') {
            $mathCaptcha = CaptchaService::generateMathCaptcha();
        }

        $turnstileSiteKey = Setting::get('security_turnstile_site_key', '');
        $recaptchaSiteKey = Setting::get('security_recaptcha_site_key', '');

        return view('admin.auth.login', compact(
            'captchaEnabled',
            'captchaProvider',
            'mathCaptcha',
            'turnstileSiteKey',
            'recaptchaSiteKey'
        ));
    }

    /**
     * Handle the admin login submission
     */
    public function login(Request $request)
    {
        $ip = $request->ip();
        $email = trim($request->input('email', ''));

        // 1. Check Brute-Force Lockout
        if (SecurityService::isLoginLocked($ip, $email)) {
            $lockoutDuration = Setting::get('security_login_lockout_duration', '15');
            SecurityService::logThreat('brute_force', 'high', "Percobaan login ditolak karena status terkunci (Email: {$email})", true);
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => "Akun/IP Anda terkunci sementara waktu ({$lockoutDuration} menit) karena terlalu banyak percobaan gagal. Silakan coba lagi nanti."]);
        }

        // 2. Validate input fields
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 3. Verify CAPTCHA & Honeypot
        $captchaResult = CaptchaService::verify($request->all(), 'login');
        if (!$captchaResult['success']) {
            SecurityService::logThreat('spam_bot', 'medium', "Gagal verifikasi CAPTCHA login: {$captchaResult['message']}", false);
            return back()->withInput($request->only('email'))
                ->withErrors(['captcha' => $captchaResult['message']]);
        }

        // 4. Attempt Authentication
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withInput($request->only('email'))
                    ->withErrors(['email' => "Akun Anda telah dinonaktifkan. Silakan hubungi Administrator."]);
            }

            // Clear brute force counters
            SecurityService::clearFailedLogins($ip, $email);

            // Regenerate session to prevent session fixation attacks
            $request->session()->regenerate();

            // Update user's last login timestamp and IP
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $ip,
            ]);

            // Record audit log
            SecurityService::logAudit('login', 'auth', "Login berhasil sebagai {$user->name} ({$user->role})", (string)$user->id);

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', "Selamat datang kembali, {$user->name}!");
        }

        // 5. Handle Failed Login
        $failStatus = SecurityService::recordFailedLogin($ip, $email);
        SecurityService::logAudit('failed_login', 'auth', "Percobaan login gagal untuk email: {$email}");

        if ($failStatus['locked']) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => "Batas maksimal percobaan login terlampaui. Akun/IP Anda dikunci selama {$failStatus['lockoutMinutes']} menit."]);
        }

        $remainingMsg = $failStatus['remaining'] > 0
            ? " (Sisa kesempatan: {$failStatus['remaining']} kali)"
            : '';

        return back()->withInput($request->only('email'))
            ->withErrors(['email' => "Email atau password yang Anda masukkan salah.{$remainingMsg}"]);
    }

    /**
     * Handle the admin logout
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            SecurityService::logAudit('logout', 'auth', "Logout oleh {$user->name}", (string)$user->id);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Anda telah berhasil keluar dari sistem admin.');
    }
}
