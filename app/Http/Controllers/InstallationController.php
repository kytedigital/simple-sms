<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Http\Helpers\Shopify;
use App\Services\BurstSms\Responses\BurstSmsGuzzleResponse;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;
use App\Http\Requests\ReceiveAccessCodeRequest;
use App\Services\BurstSms\Client as BurstClient;

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

        $this->setupSmsContactListID(Shopify::stemName($request->input('shop')));

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

    /**
     *
     */
    private function setupSmsContactListID($name)
    {
        $shop = Shop::where(['name' => $name])->first();

        if($shop->getAttribute('burst_sms_list_id')) {
            return $shop->burst_sms_list_id;
        }

        $listId = $this->createSmsContactList($name);

        $shop->burst_sms_list_id = $listId;

        $shop->save();

        return $listId;
    }

    /**
     * @param $name
     * @return
     */
    private function createSmsContactList($name)
    {
        // TODO: Get existing lists and search them here for uninstall / reinstall cases.

        $client = app(BurstClient::class);

        try {
            $response = new BurstSmsGuzzleResponse($client->request('POST', 'add-list.json', [
                'form_params' => ['name' => $name]
            ]));
        } catch(ClientException $exception) {
            $response = new BurstSmsGuzzleResponse($exception->getResponse());

            if($response->body->error->code === "KEY_EXISTS") {
                $listId = $this->findPreviousListId($name);
            }

            Log::debug(json_encode($response->message));

            return $listId;
        }

        return $response->body->id;
    }

    private function findPreviousListId($name)
    {
        $client = app(BurstClient::class);

        try {
            $response = new BurstSmsGuzzleResponse($client->request('GET', 'get-lists.json'));
        } catch(ClientException $exception) {
            $response = new BurstSmsGuzzleResponse($exception->getResponse());
            Log::debug(json_encode($response->message));
        }

        if(!$list = collect($response->body->lists)->filter(function($item) use ($name) {
            return $item->name === $name;
        })->first()) {
            return null;
        }

        return $list->id;
    }
}
