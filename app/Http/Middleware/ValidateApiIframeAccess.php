<?php

namespace App\Http\Middleware;

use App\Models\ApiClient;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiIframeAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->query('access_token');

        // Extract origin from headers or request
        $originHeader = $request->header('Origin') ?? $request->headers->get('referer');
        $originHost = $originHeader ? parse_url($originHeader, PHP_URL_HOST) : null;

        // Fallback: if no origin/referer, use request host
        if (!$originHost) {
            $originHost = $request->getHost();
        }

        if (!$token) {
            abort(403, 'Missing access token');
        }

        $client = ApiClient::where('token', $token)
            ->where('is_deleted', 0)
            ->first();

        if (!$client) {
            abort(403, 'Invalid token');
        }

        // Allowed domains from DB (case-insensitive, trim spaces)
        $allowedDomains = array_map('trim', explode(',', strtolower($client->allowed_domains ?? '')));

        // Normalize originHost to lowercase
        $originHost = strtolower($originHost);

        $isAllowed = false;
        foreach ($allowedDomains as $domain) {
            // Allow if exact match OR if origin ends with allowed domain
            if ($originHost === $domain || str_ends_with($originHost, $domain)) {
                $isAllowed = true;
                break;
            }
        }

        if (!$isAllowed) {
            abort(403, 'Domain not allowed: ' . $originHost);
        }

        return $next($request);
    }
}
