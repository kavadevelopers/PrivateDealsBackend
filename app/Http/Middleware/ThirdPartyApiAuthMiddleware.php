<?php

namespace App\Http\Middleware;

use App\Models\ApiClient;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThirdPartyApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $token = $request->header('X-AUTH-TOKEN');
        $origin = $request->header('Origin') ?? $request->header('Referer');

        if (!$token) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $client = ApiClient::where('token', $token)
            ->where(function ($q) {
                $q->where('is_deleted', 0)->orWhereNull('is_deleted');
            })
            ->first();

        if (!$client) {
            return response()->json(['error' => 'Invalid Token Provided'], 403);
        }

        $allowedDomains = array_map('trim', explode(',', $client->allowed_domains ?? ''));

        // If '*' is allowed or origin is missing, allow the request
        if (!in_array('*', $allowedDomains)) {
            if (!$origin) {
                return response()->json(['error' => 'Origin Header Missing'], 401);
            }

            $parsedDomain = parse_url($origin, PHP_URL_HOST);

            $authorized = false;

            foreach ($allowedDomains as $allowed) {
                $allowed = trim($allowed);

                // Wildcard domain like *.shuruup.com
                if (str_starts_with($allowed, '*')) {
                    $baseDomain = ltrim($allowed, '*.');
                    if (
                        $parsedDomain === $baseDomain ||
                        str_ends_with($parsedDomain, '.' . $baseDomain)
                    ) {
                        $authorized = true;
                        break;
                    }
                } elseif ($parsedDomain === $allowed) {
                    $authorized = true;
                    break;
                }
            }

            if (!$authorized) {
                return response()->json(['error' => 'Unauthorized Domain'], 403);
            }
        }

        // Inject the client object into the request for downstream use
        $request->attributes->set('client', $client);
        $request->merge(['client' => $client]);

        return $next($request);
    }
}
