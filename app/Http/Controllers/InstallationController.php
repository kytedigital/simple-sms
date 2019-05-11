<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Http\Helpers\Shopify;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests\ReceiveAccessCodeRequest;

class InstallationController extends Controller
{
    /**
     * @param ReceiveAccessCodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(ReceiveAccessCodeRequest $request)
    {
        try {
            $result = (new Guzzle())->post("https://{$request->query('shop')}/admin/oauth/access_token", [
                'form_params' => [
                    "code" => $request->query('code'),
                    'client_id' => config('services.shopify.app_api_key'),
                    'client_secret' => config('services.shopify.app_api_secret'),
                ]
            ]);

            $response = json_decode($result->getBody()->getContents());

            $shop = Shop::byName(Shopify::stemName($request->input('shop')))
                         ->saveShopifyToken($response->access_token);

            if(!$shop->getAttribute('burst_sms_client_id') && !$shop->setUpClientAccount()) {
                return view('error')->with(
                    [
                        'message' => 'Count not set up your SMS account. Please contact support for assistance.'
                    ]);
            }

            return response()->redirectTo('https://'.$request->input('shop') . '/admin/apps/'.config('app.name'));
        } catch(ClientException $exception) {
            Log::debug($exception->getMessage());
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
