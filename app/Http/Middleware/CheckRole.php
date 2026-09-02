<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
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
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Support comma-separated role arguments, e.g. "master-admin,admin"
        $parsedRoles = [];
        foreach ($roles as $roleGroup) {
            foreach (explode(',', $roleGroup) as $role) {
                $parsedRoles[] = trim($role);
            }
        }

        if (empty($parsedRoles) || $user->hasAnyRole($parsedRoles)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Unauthorized. You do not have the required role to access this resource.',
            ], 403);
        }

        abort(403, 'Unauthorized. Access restricted by role permission.');
    }
}
