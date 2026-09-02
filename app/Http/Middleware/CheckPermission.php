<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$permissions
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Support comma-separated permission arguments
        $parsedPermissions = [];
        foreach ($permissions as $permissionGroup) {
            foreach (explode(',', $permissionGroup) as $perm) {
                $parsedPermissions[] = trim($perm);
            }
        }

        if ($user->hasAnyPermission($parsedPermissions)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Unauthorized. Required permission is missing.',
            ], 403);
        }

        abort(403, 'Unauthorized action. You lack the permission required for this module.');
    }
}
