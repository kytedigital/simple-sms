<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Shop;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Http\Helpers\Shopify;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * InstallationController constructor.
     */
    public function __construct()
    {
        $this->clientId = config('services.shopify.app_api_key');
        $this->clientSecret = config('services.shopify.app_api_secret');
    }

    /**
     * @param Request $request
     * @param Shop $shop
     * @return \Illuminate\Contracts\View\Factory|RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request, Shop $shop)
    {
        $this->saveShop($request);

        if(count($request->all()) == 3) {
            return $this->startInstall($request);
        }

        try {
            $shop = $shop->where(['name' => $this->shop()])->firstOrFail();
            if(!$shop->token) return $this->startInstall($request);
        } catch(ModelNotFoundException $exception) {
            return $this->installationError();
        }

        $token = $this->generateApiToken();

        if(!$shop->hasSubscription()) {
            return view('subscriptions');
        }

        return view('dashboard', ['subscription' => $shop->subscription(), 'token' => $token]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function installationError()
    {
        return view('error', ['message' => 'There seems to be a problem with your app installation. Please
                                                    try uninstalling and reinstalling the app.']);
    }

    /**
     * Start the oAuth installation process.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function startInstall(Request $request) : RedirectResponse
    {
        $redirectUrl = config('app.url') .'/token';

        $request->session()->put('nounce', md5($this->shop() . time()));

        return response()->redirectTo(
            "https://{$this->shop()}.myshopify.com/admin/oauth/authorize?client_id={$this->clientId}&scope=read_customers&redirect_uri=$redirectUrl&state=".session('nounce')
        );
    }

    /**
     * @param $request
     * @return mixed
     */
    private function saveShop($request)
    {
        if($request->has('shop')) {
            $request->session()->put('shop', Shopify::stemName($request->shop));
        }

        return $this;
    }

    /**
     * @param $request
     * @return DashboardController
     */
    private function forgetStore($request)
    {
        $request->session()->forget('shop');

        return $this;
    }

    /**
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    private function shop()
    {
        return session('shop');
    }

    /**
     * Generate and save a random for verifying requests.
     *
     * @return string
     */
    private function generateApiToken()
    {
        $this->cleanTokens();

        $code = hash_hmac('sha256', time(), $this->clientSecret, false);

        $token = (new Token([
            'type' => 'app-api',
            'token' => $code,
            'shop' => $this->shop(),
            'expires_at' => (new Carbon('+2 hours'))->toDateTimeString()
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
