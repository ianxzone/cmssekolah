<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Ensure2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // If user is logged in, has 2FA enabled, and hasn't verified this session
        if ($user && $user->google2fa_enabled && !$request->session()->has('2fa_verified')) {
            // Check if they are currently on the 2FA verification routes to prevent redirect loop
            if (!$request->routeIs('admin.2fa.*')) {
                return redirect()->route('admin.2fa.verify');
            }
        }

        return $next($request);
    }
}
