<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;

class AuthenticateWithBasicAuth extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!$request->bearerToken() || !$this->checkBearerToken($request->bearerToken())) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        return $next($request);
    }

    /**
     * Check the provided token matches our credentials from ENV.
     *
     * @param string $token
     * @return bool
     */
    private function checkBearerToken(string $token)
    {
        $parts = explode(':', $token);

        return $parts[0] === config('services.api.token')
            && $parts[1] === config('services.api.secret');
    }
}