<?php

namespace App\Http\Controllers;

use App\Models\Shop;
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
            $result = (new Guzzle())->post("https://{$request->query('shopUrl')}/admin/oauth/access_token", [
                'form_params' => [
                    "code" => $request->query('code'),
                    'client_id' => config('services.shopify.app_api_key'),
                    'client_secret' => config('services.shopify.app_api_secret'),
                ]
            ]);

            $response = json_decode($result->getBody()->getContents());

            $shop = Shop::withTrashed()->where('name', $request->input('shop'))->first();

            if(!$shop) {
                // New Install
                $shop = new Shop;
                $shop->name = $request->input('shop');
                $shop->token = $response->access_token;
                $shop->shop_id = $shop->fullDetails()->id;
                $shop->save();
            } elseif($shop->fullDetails()->id === $shop->shop_id) {
                // Reinstall
                $shop->restore();
            }

            return response()->redirectTo('https://'.$request->input('shopUrl') . '/admin/apps/'.config('app.name'));
        } catch(ClientException $exception) {
            Log::debug($exception->getMessage());
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
