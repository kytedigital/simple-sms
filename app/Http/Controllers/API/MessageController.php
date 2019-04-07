<?php

namespace App\Http\Controllers\Api;

use App\Models\Shop;
use App\Jobs\DispatchMessage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Helpers\CommonApiResponses;
use App\Http\Requests\MessageDispatchRequest;

class MessageController extends Controller
{
    /**
     * @param MessageDispatchRequest $request
     * @return array
     */
    public function send(MessageDispatchRequest $request)
    {
        Log::debug('Received Message Dispatch Request');
        Log::debug($request);


        if($shop = $this->getShop($request->get('shop'))) {
            CommonApiResponses::missingSubscription($request->get('shop'));
        }

        if(!$subscription = $shop->subscription()) {
            CommonApiResponses::missingSubscription($request->get('shop'));
        }

        $credits = $subscription->getRemainingCredits($request->json('shop'));
        $recipients = collect($request->json('recipients'));

        if(($credits < 1) || $credits < $recipients->count() && !$request->json('enable_partial', false)) {
            CommonApiResponses::notEnoughCredits($recipients->count(), $credits);
        }

        // Default chunk size is the entire recipients.
        $chunk = $recipients->count();

        // If there isn't enough credits, but partial is allowed, send to as many as can be afforded.
        if(($credits < $recipients->count()) && $request->json('enable_partial', false)) {
            $chunk = $credits;
        }

        $shopProperties = $shop->messageProperties();

        foreach ($recipients->chunk($chunk)->first() as $count => $recipient) {
            $recipient = collect($recipient)->merge(['shop' => $shopProperties]);

            DispatchMessage::dispatch('sms', $recipient, $request->json('message'), $request->input('shop'));
        }

        return response()->json(['status' => 201, 'message' => 'Messages are queued.', 'count' => ++$count]);
    }

    /**
     * @param $shopName
     * @return Shop
     */
    private function getShop($shopName)
    {
        return Shop::where('name', $shopName)->first();
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function availableChannels()
    {
        return config('services.messaging.channels');
    }

    /**
     * @param $channels
     * @return array
     */
    private function cleanChannels($channels)
    {
        $availableChannels = $this->availableChannels();
        return array_filter($channels, function($channels) use ($availableChannels) {
            return in_array($channels, $availableChannels);
        });
    }
}
