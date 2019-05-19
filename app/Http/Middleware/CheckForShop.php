<?php

namespace App\Http\Middleware;

use App\Http\Helpers\Shopify;
use Closure;

class CheckForShop
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
        if (!session('shop') && !$request->has('shop')) {
             return redirect(route('refresh'));
        }

        $request->merge([
            'shop' => Shopify::stemName($request->input('shop')),
            'shopUrl' => Shopify::nameToUrl($request->input('shop'))
        ]);

        return $next($request);
    }
}