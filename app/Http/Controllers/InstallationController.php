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
                $shop = new Shop;

                $shop->name = $request->input('shop');
                $shop->token = $response->access_token;

                $shop->save();
            }

            // Could be a reinstall
            $shop->restore();

            return response()->redirectTo('https://'.$request->input('shopUrl') . '/admin/apps/'.config('app.name'));
        } catch(ClientException $exception) {
            Log::debug($exception->getMessage());
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
