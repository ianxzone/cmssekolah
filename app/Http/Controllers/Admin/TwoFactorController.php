<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Support\Authenticator;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TwoFactorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.security.profile.index', compact('user'));
    }

    public function enable(Request $request)
    {
        $user = Auth::user();
        
        if ($user->google2fa_enabled) {
            return redirect()->back()->with('error', '2FA sudah diaktifkan.');
        }

        $google2fa = app('pragmarx.google2fa');
        $secret = $google2fa->generateSecretKey();
        
        $user->google2fa_secret = $secret;
        $user->save();

        // Generate QR code
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        $renderer = new ImageRenderer(
            new RendererStyle(250),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeSvg = $writer->writeString($qrCodeUrl);

        return view('admin.security.profile.confirm', compact('qrCodeSvg', 'secret'));
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->otp);

        if ($valid) {
            $user->google2fa_enabled = true;
            $user->save();
            
            $request->session()->put('2fa_verified', true);
            
            return redirect()->route('admin.security.profile')->with('success', '2FA berhasil diaktifkan!');
        }

        return redirect()->back()->withErrors(['otp' => 'Kode OTP tidak valid. Silakan coba lagi.']);
    }

    public function disable(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->otp);

        if ($valid) {
            $user->google2fa_enabled = false;
            $user->google2fa_secret = null;
            $user->save();
            
            $request->session()->forget('2fa_verified');
            
            return redirect()->route('admin.security.profile')->with('success', '2FA berhasil dinonaktifkan.');
        }

        return redirect()->back()->withErrors(['otp' => 'Kode OTP tidak valid. Gagal menonaktifkan 2FA.']);
    }

    public function verifyForm()
    {
        $user = Auth::user();
        
        if (!$user || !$user->google2fa_enabled) {
            return redirect()->route('admin.dashboard');
        }

        if (session('2fa_verified')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.security.profile.verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->otp);

        if ($valid) {
            $request->session()->put('2fa_verified', true);
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
    }
}
