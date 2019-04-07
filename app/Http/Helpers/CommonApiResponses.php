<?php

namespace App\Http\Helpers;

class CommonApiResponses
{
    /**
     * @param $shop
     * @return array
     */
    public static function missingSubscription($shop)
    {
        return [
            'status'  => 405,
            'message' => "No subscription for shop {$shop} found. App needs to be subscribed",
        ];
    }

    /**
     * @param int $requested
     * @param $remaining
     * @return array
     */
    public static function notEnoughCredits(int $requested, int $remaining)
    {
        return [
            'status'  => 405,
            'message' => "Not enough credits remaining to send $requested messages",
            'credits_remaining' => $remaining
        ];
    }
}