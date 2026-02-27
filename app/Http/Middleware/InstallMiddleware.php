<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Config;

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
        $isInstallPath = $request->is('install*');

        if (!$isInstalled && $isInstallPath) {
            Config::set('session.driver', 'file');
        }

        if (!$isInstalled && !$isInstallPath) {
            return redirect()->route('install.index');
        }

        if ($isInstalled && $isInstallPath) {
            return redirect('/');
        }

        return $next($request);
    }
}
