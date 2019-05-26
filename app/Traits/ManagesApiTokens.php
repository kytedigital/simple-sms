<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Token;

trait ManagesApiTokens
{
    /**
     * Generate and save a random for verifying requests.
     *
     * @param $shopName
     * @return string
     * @throws \Exception
     */
    public function generateAndSaveNewApiToken($shopName) : String
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
     */
    public function cleanTokens()
    {
        Token::where('expires_at', '<', Carbon::now()->toDateTimeString())->delete();

        return $this;
    }
}