<?php

namespace App\Http\Middleware;

use App\Models\UserAdminModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminPermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        $user = UserAdminModel::find(Auth::guard('admin')->id());
        if ($user->role != 'admin') {
            if (!$user->hasAnyPermission($permissions)) {
                abort(403, 'Unauthorized');
            }
        }
        return $next($request);
    }
}
