<?php

namespace App\Http\Middleware;

use App\Models\ApiLogModel;
use App\Models\ApiTokenForHeaderAuthModel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class ApiHeaderAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $request->headers->set('Content-Type', 'application/json');
        // $request->headers->set('Accept', 'application/json');
        $token = $request->header('headtoken');
        if (!$token || !$this->isValidToken($token)) {
            return response()->json(['message' => 'Unauthorized Request'], 500);
        }
        // Log::info('Request Headers:', $request->headers->all());
        self::logRequest($request);
        return $next($request);
    }

    public function isValidToken($token): bool
    {
        return ApiTokenForHeaderAuthModel::where('token', $token)->where('is_deleted', '0')->exists();
    }

    private function logRequest($request): void
    {
        $isDebug = (bool) $request->header('isdebug');

        if (!$isDebug) {
            ApiLogModel::create([
                'url'                   => $request->url(),
                'headtoken'             => $request->header('headtoken'),
                'deviceid'              => $request->header('deviceid'),
                'devicetype'            => $request->header('devicetype'),
                'usertype'              => $request->header('usertype'),
                'userid'                => $request->header('userid'),
                'authorization'         => $request->header('authorization'),
                'useragent'             => $request->header('user-agent'),
                'version_code'          => $request->header('app-version-code') ?? '',
                'params'                => json_encode($request->query())
            ]);
        }
    }
}
