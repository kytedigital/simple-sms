<?php

namespace App\Http\Controllers;

use App\Events\MessageDispatchCompleted;
use Carbon\Carbon;
use App\Models\Shop;
use App\Models\Token;
use App\Traits\UsesNames;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DashboardController extends Controller
{
    use UsesNames;

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
        if($this->looksLikeInstall($request)) $this->startInstall($request);

        try {
            $shop = $shop->where(['name' => $this->shopName()])->firstOrFail();

            if(!$shop->token) $this->startInstall($request);
        } catch(ModelNotFoundException $exception) {
            return view('error', ['message' => __('errors.installation')]);
        }

        $token = $this->generateApiToken();

        if(!$shop->hasSubscription()) return view('subscription', ['subscription' => null, 'token' => $token, 'shop' => $this->shopName()]);

        return view('dashboard', ['subscription' => $shop->subscription(), 'token' => $token, 'shop' => $this->shopName()]);
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

        $request->session()->put('nounce', md5($this->shopName() . time()));

        return response()->redirectTo(
            "https://{$this->shopName()}.myshopify.com/admin/oauth/authorize?client_id={$this->clientId}&scope=read_customers&redirect_uri=$redirectUrl&state=".session('nounce')
        );
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
            'shop' => $this->shopName(),
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

    /**
     * @param Request $request
     * @return bool
     */
    private function looksLikeInstall(Request $request)
    {
        return count($request->all()) == 3;
    }
}
