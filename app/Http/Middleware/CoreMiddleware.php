<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CoreMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasCookie('_unique_device_id')) {
            $uniqueId = (string) Str::uuid() . '_' . microtime(true);
            // Set cookie for 5 years (60 minutes * 24 hours * 365 days * 5 years)
            Cookie::queue('_unique_device_id', $uniqueId, 60 * 24 * 365 * 5);
        }
        return $next($request);
    }
}
