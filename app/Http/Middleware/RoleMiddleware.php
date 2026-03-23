<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('admin.login');
        }

        // Super admin has access to everything
        if ($request->user()->hasRole('super_admin')) {
            return $next($request);
        }

        // Check if user has any of the required roles
        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }

        // User doesn't have required role
        abort(403, 'Unauthorized action. You do not have permission to access this resource.');
    }
}
