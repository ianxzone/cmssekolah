<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class InstallMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isInstalled = File::exists(storage_path('installed'));

        // Secondary check: if users table already has an admin user, lock install permanently
        if (!$isInstalled) {
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('users') && \App\Models\User::where('role', 'admin')->exists()) {
                    File::put(storage_path('installed'), now()->toDateTimeString());
                    $isInstalled = true;
                }
            } catch (\Throwable $e) {
                // Database not ready yet
            }
        }

        $isInstallPath = $request->is('install*');

        if (!$isInstalled && !$isInstallPath) {
            return redirect()->route('install.index');
        }

        if ($isInstalled && $isInstallPath) {
            return redirect('/');
        }

        return $next($request);
    }
}
