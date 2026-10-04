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
        // Primary Check: .env variable APP_INSTALLED or storage/installed file
        $isInstalled = env('APP_INSTALLED', false) || File::exists(storage_path('installed'));

        // Secondary check: verify database if not explicitly installed.
        // If DB throws exception, we MUST assume it might be installed but DB is down (FAIL-CLOSED)
        if (!$isInstalled) {
            try {
                if (\Illuminate\Support\Facades\DB::connection()->getPdo() && \Illuminate\Support\Facades\Schema::hasTable('users') && \App\Models\User::where('role', 'admin')->exists()) {
                    File::put(storage_path('installed'), now()->toDateTimeString());
                    $isInstalled = true;
                }
            } catch (\Throwable $e) {
                // Database connection failed, DO NOT open the installer!
                // We assume it's installed but broken. Opening installer allows malicious overwrite.
                if (!env('APP_DEBUG', false)) {
                    abort(503, 'Database connection is down. System locked for security.');
                }
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
