<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OnboardingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only trigger if logged in as admin and not on the onboarding route itself
        if (Auth::check() && !$request->is('admin/onboarding*')) {
            $onboardingCompleted = Setting::get('onboarding_completed', '0');

            if ($onboardingCompleted === '0') {
                return redirect()->route('admin.onboarding.index');
            }
        }

        return $next($request);
    }
}
