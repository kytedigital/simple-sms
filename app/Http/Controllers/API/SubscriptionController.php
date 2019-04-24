<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Shop;
use App\Models\MessageLog;
use Illuminate\Http\Request;
use App\Services\Shopify\Client;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    /**
     * InstallationController constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get subscription.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getSubscription(Request $request) : JsonResponse
    {
        $info = $this->getSubscriptionInfo($request->input('shop'));

        return response()->json(['item' => $info]);
    }

    /**
     * @param $shop
     * @return array
     */
    private function getSubscriptionInfo($shop) : array
    {
        $subscription = Shop::where('name', $shop)->first()->subscription();

        $info = array_merge(
            (array) $subscription->getAttributes(),
            (array) $subscription->plan->getAttributes()
        );

        // TODO: Message log should tie to subscription ID not shop, it's weird passing shop trough.
        return array_merge($info, ['usage' => $subscription->getUsage($shop)]);
    }

    /**
     * @param $shop
     * @param $start
     * @return int
     */
    protected function getPeriodUsage($shop, $start) : int
    {
        $periodStart = Carbon::parse($start)->toDateTimeString();
        $periodEnd = Carbon::parse($start)->addMonth()->toDateTimeString();

        return MessageLog::where('shop', $shop)
                            ->where('created_at', '>', $periodStart)
                            ->where('created_at', '<', $periodEnd)
                            ->count();
    }
}
