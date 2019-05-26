<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Http\Helpers\Shopify;

trait StartsInstalls
{
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