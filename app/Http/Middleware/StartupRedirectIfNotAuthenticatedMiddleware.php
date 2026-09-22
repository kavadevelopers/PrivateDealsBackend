<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class StartupRedirectIfNotAuthenticatedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('partner')->check()) {
            return Redirect::route('front.business.dashboard');
        }
        if (Auth::guard('admin')->check()) {
            return Redirect::route('admin.dashboard');
        }
        if (Auth::guard('investor')->check()) {
            return Redirect::route('front.investor.dashboard');
        }
        if (!Auth::guard('startup')->check()) {
            return Redirect::route('front.raise.auth.login');
        }
        return $next($request);
    }
}
