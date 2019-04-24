<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class CheckNounce
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(($request->session()->get('nounce') !== $request->query('state'))) {
            Log::alert('An nounce verification failed');
            Log::alert('The request was:'. json_encode($request->all()));
            Log::alert('The client IP was:'. json_encode($_SERVER['REMOTE_ADDR']));
            Log::alert('The entire server object was:'. json_encode($_SERVER));

            return redirect()->route('security');
        }

        return $next($request);
    }
}
