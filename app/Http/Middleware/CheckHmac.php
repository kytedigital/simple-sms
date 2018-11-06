<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckHmac
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
        if($request->has('hmac') && !$this->verifyRequest($request, config('services.shopify.app_api_secret'))) {

            Log::alert('An HMAC verification failed');
            Log::alert('The request was:'. json_encode($request->all()));
            Log::alert('The client IP was:'. json_encode($_SERVER['REMOTE_ADDR']));
            Log::alert('The entire server object was:'. json_encode($_SERVER));

            return redirect(route('security'));
        }

        return $next($request);
    }

    /**
     * @param Request $request
     *
     * @param $secret
     * @return bool
     */
    public function verifyRequest(Request $request, $secret) {

        $signature = $request->except(['hmac', 'signature']);

        $parts = [];

        foreach ($signature as $key => $value) {

            $key = str_replace('%', '%25', $key);
            $key = str_replace('&', '%26', $key);
            $key = str_replace('=', '%3D', $key);
            $value = str_replace('%', '%25', $value);
            $value = str_replace('&', '%26', $value);

            $parts[] = $key."=".$value;

        }

        return $request->input('hmac') === hash_hmac('sha256', join('&', $parts), $secret, false);
    }
}
