<?php

namespace App\Http\Middleware;

use Closure;

class AllowCors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->header('Access-Control-Allow-Origin', '*');
        $request->header('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');

        return $next($request);
    }
}
