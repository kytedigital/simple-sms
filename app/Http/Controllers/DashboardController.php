<?php

namespace App\Http\Controllers;

use JavaScript;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Traits\StartsInstalls;
use App\Traits\ManagesApiTokens;

class DashboardController extends AppController
{
    use ManagesApiTokens, StartsInstalls;

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $shop = Shop::where('name', $request->get('shop'))->first();

        if(!$shop || !$shop->token) return $this->startInstall($request);

        JavaScript::put([
            'apiBase' => config('services.simple.api_base'),
            'appKey' => config('services.shopify.app_api_key'),
            'token' => $this->cleanTokens()->generateAndSaveNewApiToken($request->get('shop')),
            'shopName' => $request->get('shop'),
            'shopUrl' => $request->get('shop'),
        ]);

        return view('index');
    }
}
