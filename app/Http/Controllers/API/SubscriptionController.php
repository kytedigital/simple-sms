<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\MessageLog;
use App\Models\Shop;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Shopify\Client;
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
            (array) $subscription,
            (array) Plan::where('code', $subscription->name)->first()->getAttributes()
        );

        $usage = [
            'period_usage' => $this->getPeriodUsage($shop, $info['billing_on']),
            'period_remaining' => $info['message_limit'] - $this->getPeriodUsage($shop, $info['billing_on']),
            'total_usage' => $this->getTotalUsageByShop($shop),
        ];

        return array_merge($info, ['usage' => $usage]);
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

    /**
     * @param $shop
     * @return mixed
     */
    private function getTotalUsageByShop($shop)
    {
        return MessageLog::where('shop', $shop)->count();
    }
}
