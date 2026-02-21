<?php

namespace App\Http\Middleware;

use App\Support\ApiResponse;
use Closure;

class RequireHealthToken
{
    public function handle($request, Closure $next)
    {
        $expectedToken = (string) config('health.auth.token', '');

        if ($expectedToken === '') {
            return $next($request);
        }

        $providedToken = (string) $request->header('X-Health-Token', '');

        if (!hash_equals($expectedToken, $providedToken)) {
            return ApiResponse::error('Unauthorized.', 401, 'UNAUTHORIZED');
        }

        return $next($request);
    }
}
