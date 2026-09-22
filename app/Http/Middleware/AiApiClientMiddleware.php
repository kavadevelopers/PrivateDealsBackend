<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AiApiClientMiddleware
{
    /**
     * Allow only API clients marked as AI (is_ai = 1) to hit /api/sandbox/ai/* routes.
     * Expects ThirdPartyApiAuthMiddleware to have set request attribute `client`.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $client = $request->attributes->get('client');

        if (!$client) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        if (!method_exists($client, 'isAi') || !$client->isAi()) {
            return response()->json(['error' => 'Forbidden: AI client required'], 403);
        }

        return $next($request);
    }
}
