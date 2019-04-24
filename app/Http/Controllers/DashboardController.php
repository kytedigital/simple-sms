<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Shop;
use App\Models\Token;
use App\Traits\UsesNames;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DashboardController extends AppController
{
    use UsesNames;

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        try {
            $shop = Shop::byNameOrFail($this->shopName());

            if(!$shop->token) $this->startInstall($request);
        } catch(ModelNotFoundException $exception) {
            return view('error', ['message' => __('errors.installation')]);
        }

        $freshApiToken = $this->cleanTokens()->generateAndSaveNewApiToken();

        if(!$shop->hasSubscription())
            return view('subscription',
                ['subscription' => null, 'token' => $freshApiToken, 'shop' => $this->shopName()]);

        return view('dashboard',
            ['subscription' => $shop->subscription(), 'token' => $freshApiToken, 'shop' => $this->shopName()]);
    }

    /**
     * Generate and save a random for verifying requests.
     *
     * @return string
     * @throws \Exception
     */
    private function generateAndSaveNewApiToken()
    {
        $code = hash_hmac('sha256', time(), config('services.shopify.app_api_secret'), false);

        $token = (new Token([
            'type' => 'app-api',
            'token' => $code,
            'shop' => $this->shopName(),
            'expires_at' => (new Carbon('+5 hours'))->toDateTimeString()
        ]));

        $token->save();

        return $code;
    }

    /**
     * Clean all tokens out.
     *
     * @return $this
     */
    private function cleanTokens()
    {
        Token::where('expires_at', '<', Carbon::now()->toDateTimeString())->delete();

        return $this;
    }
}
