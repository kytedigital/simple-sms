<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Helpers\Shopify;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;

class RedirectIfShopifyAppInstallRequest
{
    /**
     * Use this middleware in-front of only the Shopify WEB request
     * to determine if Shopify is trying to install the app.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(count($request->all()) == 3) {
            Log::alert('Shopify Install Requested');
            Log::alert('The request was:'. json_encode($request->all()));

            return $this->startInstall($request);
        }

        return $next($request);
    }

    /**
     * Start the oAuth installation process.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function startInstall(Request $request)
    {
        list($redirectUrl, $clientId, $shopName) = [
            config('app.url') .'/token',
            config('services.shopify.app_api_key'),
            Shopify::stemName($request->get('shop'))
        ];

        $request->session()->put('nounce', md5($shopName . time()));

        return response()->redirectTo(
            "https://$shopName.myshopify.com/admin/oauth/authorize?client_id=$clientId&scope=read_customers,write_customers&redirect_uri=$redirectUrl&state=".session('nounce')
        );
    }
}
