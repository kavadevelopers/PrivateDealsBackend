<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiBasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $username = '9473829104758392017465';
        $password = 'Pq7!Xk#92Lm@Vp4&QzYtGh5$Bn8*WrAo';

        if ($request->getUser() !== $username || $request->getPassword() !== $password) {
            return response()->json(['message' => 'Unauthorized'], 401, ['WWW-Authenticate' => 'Basic']);
        }

        return $next($request);
    }
}
