<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Http\Helpers\Shopify;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;
use App\Http\Requests\ReceiveAccessCodeRequest;

class InstallationController extends Controller
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
     * @param ReceiveAccessCodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getToken(ReceiveAccessCodeRequest $request)
    {
        if($request->session()->get('nounce') !== $request->query('state')) {
            return redirect(route('security'));
        }

        try {
            $result = (new Guzzle())->post("https://{$request->query('shop')}/admin/oauth/access_token", [
                'form_params' => [
                    "code" => $request->query('code'),
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                ]
            ]);
        } catch(GuzzleException $e) {
            Log::debug($e->getMessage());

            return response()->json(['message' => $e->getMessage()], 500);
        }

        $response = json_decode($result->getBody()->getContents());

        $this->saveStoreToken(Shopify::stemName($request->input('shop')), $response->access_token);

        return response()->redirectTo('https://'.$request->input('shop') . '/admin/apps');
    }

    /**
     * @param string $shop
     * @param string $token
     * @return bool
     */
    private function saveStoreToken(string $shop, string $token) : bool
    {
        $store = Shop::firstOrCreate(['name' => $shop]);

        $store->token = $token;
        $store->save();

        return $shop instanceof Shop;
    }
}
