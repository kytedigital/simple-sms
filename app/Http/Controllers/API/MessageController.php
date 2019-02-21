<?php
namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Shop;
use App\Jobs\DispatchMessage;
use http\Env\Response;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageDispatchRequest;

class MessageController extends Controller
{
    /**
     *
     */
    const SHOP_PROPERTIES = [
        'name',
        'email',
        'domain',
        'province',
        'country',
        'city',
        'phone',
        'currency',
        'address1',
        'zip'
    ];

    /**
     * @param MessageDispatchRequest $request
     * @return array
     */
    public function send(MessageDispatchRequest $request)
    {
        $shop = $this->getShop($request->json('shop'));

        $subscription = $shop->subscription();

        $credits = $subscription->getRemainingCredits($request->json('shop'));

        $recipients = collect($request->json('recipients'));

        if(($credits < 1) || $credits < $recipients->count() && !$request->json('enable_partial', false)) {
            return [
                'status'  => 405,
                'message' => "Not enough credits remaining to send {$recipients->count()} messages",
                'credits_remaining' => $credits
            ];
        }

        // Default chunk size is the entire recipients.
        $chunk = $recipients->count();

        // If there isn't enough credits, but partial is allowed, send to as many as can be afforded.
        if(($credits < $recipients->count()) && $request->json('enable_partial', false)) {
            $chunk = $credits;
        }


        try {
            $channels = $this->cleanChannels($request->json('channels'));

            $shopData = $this->getShopData($request->json('shop'));

            $count = 0;

            foreach ($recipients->chunk($chunk)->first() as $recipient) {
                $recipient = collect($recipient)->merge(['shop' => $shopData]);

                // TODO: Check customer accepts marketing and channel is available.
                foreach ($channels as $channel) {
                    DispatchMessage::dispatch($channel,
                        $recipient,
                        $request->json('message'),
                        $request->input('shop')
                    );

                    $count++;
                }
            }

            return response()->json([
                'message' => 'OK',
                'count'   => $count,
              //  'recipients' => json_encode($recipients), // TODO - Wont work for other channels.
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage() .' in '.  $exception->getFile() .' line '. $exception->getLine(),
                'status' => $exception->getCode()
            ]);
        }

        return response()->json([
            'message' => 'OK',
            'recipients' => json_encode($recipients), // TODO - Wont work for other channels.
        ]);
    }

    /**
     * @param $shop
     * @return Collection
     */
    private function getShopData($shop) : Collection
    {
        return collect($this->getShop($shop)->shopDetails())->only(self::SHOP_PROPERTIES);
    }

    /**
     * @param $shopName
     * @return
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
