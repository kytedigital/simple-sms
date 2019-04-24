<?php

namespace App\Http\Helpers;

use App\Models\Shop;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\ClientException;
use App\Services\BurstSms\Client as BurstClient;
use App\Services\BurstSms\Responses\BurstSmsGuzzleResponse;

class BurstSubAccountHelper
{
    /**
     * @param Shop $shop
     * @return bool
     */
    public static function findOrSetupSmsClientAccount(Shop $shop)
    {
        $shopDetails = $shop->shopDetails();

        $clientAccountCredentials = self::createSmsClientAccount(
            $shop->getAttribute('name'),
            $shopDetails->phone,
            $shopDetails->email
        );

        if(!$clientAccountCredentials) {
            $clientAccountCredentials = self::findPreviousClientAccount(
                $shop->getAttribute('name')
            );
        }

        if(!$clientAccountCredentials) return false;

        $shop->burst_sms_client_id = $clientAccountCredentials['id'];
        $shop->burst_sms_client_api_key = $clientAccountCredentials['api_key'];
        $shop->burst_sms_client_api_secret = $clientAccountCredentials['api_secret'];

        $shop->save();

        return true;
    }

    /**
     * @param $shopName
     * @param $shopPhoneNumber
     * @param $shopEmailAddress
     * @return array|null
     */
    private static function createSmsClientAccount($shopName, $shopPhoneNumber, $shopEmailAddress)
    {
        $shopPhoneNumber = empty($shopPhoneNumber) ? config('services.burstsms.backup_msisdn') : $shopPhoneNumber;

        $createParameters = [
            'name' => $shopName,
            'email' => "$shopName+$shopEmailAddress",
            'password' => '@'.$shopName.'1',
            'msisdn' => $shopPhoneNumber,
            'client_pays' => false,
        ];

        try {
            $response = new BurstSmsGuzzleResponse(app(BurstClient::class)->request('POST', 'add-client.json', [
                'form_params' => $createParameters
            ]));

            return [
                'id' => $response->body->id,
                'api_key' => $response->body->apikey,
                'api_secret' => $response->body->apisecret,
                'createParams' => $createParameters
            ];
        } catch(ClientException $exception) {
            $response = new BurstSmsGuzzleResponse($exception->getResponse());
            Log::debug(json_encode($response->message));
            return null;
        }
    }

    /**
     * @param $shopName
     * @return array|null
     */
    private static function findPreviousClientAccount($shopName)
    {
        try {
            $response = new BurstSmsGuzzleResponse(app(BurstClient::class)->request('GET', 'get-clients.json'));
        } catch(ClientException $exception) {
            $response = new BurstSmsGuzzleResponse($exception->getResponse());
            Log::debug(json_encode($response->message));
            return null;
        }

        if(!$account = collect($response->body->clients)->filter(function($client) use ($shopName) {
            return $client->name === $shopName;
        })->first()) {
            return null;
        }

        return [
            'id' => $account->id,
            'api_key' => $account->apikey,
            'api_secret' => $account->apisecret
        ];
    }
}
