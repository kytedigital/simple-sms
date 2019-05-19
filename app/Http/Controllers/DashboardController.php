<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Shop;
use App\Models\Token;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DashboardController extends AppController
{
    /**
     * @param Request $request
     * @return \Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request) : View
    {
        try {
            $shop = Shop::byNameOrFail($request->get('shop'));

            if(!$shop || !$shop->token) $this->startInstall($request);
        } catch(ModelNotFoundException $exception) {
            return view('error', ['message' => __('errors.installation')]);
        }

        $freshApiToken = $this->cleanTokens()->generateAndSaveNewApiToken($request->get('shop'));

        return view('index',
            [
                'token' => $freshApiToken,
                'shopName' => $request->get('shop')
            ]);
    }

    /**
     * Generate and save a random for verifying requests.
     *
     * @param $shopName
     * @return string
     * @throws \Exception
     */
    private function generateAndSaveNewApiToken($shopName) : String
    {
        $code = hash_hmac('sha256', time(), config('services.shopify.app_api_secret'), false);

        (new Token([
            'type' => 'app-api',
            'token' => $code,
            'shop' => $shopName,
            'expires_at' => Carbon::now()->addHours(2)->toDateTimeString()
        ]))->save();


        return $code;
    }

    /**
     * Clean all tokens out.
     *
     * @return $this
     */
    private function cleanTokens() : DashboardController
    {
        Token::where('expires_at', '<', Carbon::now()->toDateTimeString())->delete();

        return $this;
    }
}
