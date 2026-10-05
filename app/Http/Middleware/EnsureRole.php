<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();

        // If no roles specified, just allow authenticated users.
        if (empty($roles)) {
            return $next($request);
        }

        // Using the models method or direct check
        $userRole = $user->role ?? \App\Models\User::ROLE_ADMIN;

        // Superadmin bypasses all role checks
        if ($userRole !== \App\Models\User::ROLE_SUPERADMIN && !in_array($userRole, $roles)) {
            \App\Services\SecurityService::logAudit('unauthorized_access', 'security', "Akses ditolak ke {$request->path()} karena role {$userRole} tidak memiliki izin.", (string)$user->id);
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin (role) yang diperlukan untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
