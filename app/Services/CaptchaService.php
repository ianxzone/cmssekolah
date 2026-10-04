<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CaptchaService
{
    /**
     * Check if CAPTCHA is enabled for a specific form.
     * Forms: 'login', 'guestbook', 'comments', 'forms'
     */
    public static function isEnabledFor(string $form): bool
    {
        $globalEnabled = Setting::get('security_captcha_enabled', '1') === '1';
        if (!$globalEnabled) {
            return false;
        }

        return Setting::get("security_captcha_{$form}", '1') === '1';
    }

    /**
     * Get active CAPTCHA provider: 'builtin', 'turnstile', or 'recaptcha'
     */
    public static function getProvider(): string
    {
        return Setting::get('security_captcha_provider', 'builtin');
    }

    /**
     * Generate or retrieve current Math CAPTCHA for session
     */
    public static function generateMathCaptcha(): array
    {
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        $operators = ['+', '-'];
        $op = $operators[array_rand($operators)];

        if ($op === '-' && $num1 < $num2) {
            // Swap to prevent negative results for ease of use
            [$num1, $num2] = [$num2, $num1];
        }

        $answer = $op === '+' ? ($num1 + $num2) : ($num1 - $num2);

        $question = "{$num1} {$op} {$num2} = ?";
        session(['_security_captcha_answer' => $answer]);

        return [
            'question' => $question,
            'answer'   => $answer,
        ];
    }

    /**
     * Verify submitted CAPTCHA based on active provider
     */
    public static function verify(array $requestData, string $form = 'general'): array
    {
        if (!self::isEnabledFor($form)) {
            return ['success' => true, 'message' => null];
        }

        // 1. Honeypot check
        if (!empty($requestData['_hp_name'] ?? '')) {
            return ['success' => false, 'message' => 'Spam bot terdeteksi (Honeypot).'];
        }

        // 2. Time-trap check (submitted in less than 1.5 seconds)
        if (isset($requestData['_hp_time'])) {
            $diff = time() - (int)$requestData['_hp_time'];
            if ($diff < 1.5) {
                return ['success' => false, 'message' => 'Form terkirim terlalu cepat. Silakan coba lagi.'];
            }
        }

        $provider = self::getProvider();

        // 3. Provider Verification
        switch ($provider) {
            case 'turnstile':
                $token = $requestData['cf-turnstile-response'] ?? '';
                if (empty($token)) {
                    return ['success' => false, 'message' => 'Harap selesaikan verifikasi Cloudflare Turnstile.'];
                }
                return self::verifyCloudflareTurnstile($token);

            case 'recaptcha':
                $token = $requestData['g-recaptcha-response'] ?? '';
                if (empty($token)) {
                    return ['success' => false, 'message' => 'Harap selesaikan verifikasi Google reCAPTCHA.'];
                }
                return self::verifyGoogleRecaptcha($token);

            case 'builtin':
            default:
                $userAnswer = trim($requestData['captcha_answer'] ?? '');
                $expected = session('_security_captcha_answer');
                
                // Unconditionally clear to prevent replay and brute-force
                session()->forget('_security_captcha_answer');

                if ($userAnswer === '' || $expected === null || (int)$userAnswer !== (int)$expected) {
                    return ['success' => false, 'message' => 'Jawaban kode keamanan (CAPTCHA) tidak tepat.'];
                }

                return ['success' => true, 'message' => null];
        }
    }

    /**
     * Verify Cloudflare Turnstile
     */
    private static function verifyCloudflareTurnstile(string $token): array
    {
        $secretKey = Setting::get('security_turnstile_secret_key', '');
        if (empty($secretKey)) {
            // If secret key is not configured, fall back to success with warning
            return ['success' => true, 'message' => null];
        }

        try {
            $response = Http::asForm()->timeout(5)->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret'   => $secretKey,
                'response' => $token,
                'remoteip' => request()->ip(),
            ]);

            $body = $response->json();
            if ($response->successful() && !empty($body['success'])) {
                return ['success' => true, 'message' => null];
            }

            return ['success' => false, 'message' => 'Verifikasi Turnstile gagal. Silakan ulangi.'];
        } catch (\Throwable $e) {
            Log::error('Turnstile verification error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal menghubungkan ke server verifikasi Turnstile.'];
        }
    }

    /**
     * Verify Google reCAPTCHA
     */
    private static function verifyGoogleRecaptcha(string $token): array
    {
        $secretKey = Setting::get('security_recaptcha_secret_key', '');
        if (empty($secretKey)) {
            return ['success' => true, 'message' => null];
        }

        try {
            $response = Http::asForm()->timeout(5)->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => $secretKey,
                'response' => $token,
                'remoteip' => request()->ip(),
            ]);

            $body = $response->json();
            if ($response->successful() && !empty($body['success'])) {
                return ['success' => true, 'message' => null];
            }

            return ['success' => false, 'message' => 'Verifikasi reCAPTCHA gagal. Silakan ulangi.'];
        } catch (\Throwable $e) {
            Log::error('reCAPTCHA verification error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal menghubungkan ke server verifikasi reCAPTCHA.'];
        }
    }
}
