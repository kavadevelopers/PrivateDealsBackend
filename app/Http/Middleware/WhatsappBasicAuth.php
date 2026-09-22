<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WhatsappBasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $username = 'd066eeed2d080c8e';
        $password = 'MUu1S1pskJYkGJ7yqFD4KQ';
        $authorization = $request->header('Authorization');
        if ($authorization && preg_match('/Basic\s(\S+)/', $authorization, $matches)) {
            $credentials = base64_decode($matches[1]);
            list($providedUsername, $providedPassword) = explode(':', $credentials, 2);

            if ($providedUsername === $username && $providedPassword === $password) {
                return $next($request);
            }
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
