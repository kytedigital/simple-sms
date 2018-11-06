<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequest;
use App\MessageLog;
use App\Models\Shop;
use App\Models\Plan;
use App\Services\Shopify\Client;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
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
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get subscription.
     *
     * @param ApiRequest $request
     * @return JsonResponse
     */
    public function getSubscription(ApiRequest $request) : JsonResponse
    {
        $info = $this->getSubscriptionInfo($request->input('shop'));

        return response()->json(['item' => $info]);
    }

    /**
     * @param ApiRequest $request
     * @return JsonResponse
     */
    public function getSubscriptionStatistics(ApiRequest $request) : JsonResponse
    {
        $info = [
            'period_usage' => $this->getPeriodUsageByShop($request->input('shop')),
            'period_remaining' => $this->getRemainingUsageByShop($request->input('shop')),
            'total_usage' => $this->getTotalUsageByShop($request->input('shop')),
            'usage_by_channel' => [
                'sms' => $this->getPeriodUsageByShop($request->input('shop'))
            ]
        ];

        return response()->json(['item' => $info]);
    }

    /**
     *
     */
    private function getPeriodUsageByShop($shop)
    {
        $subscription = $this->getSubscriptionInfo($shop);

        $periodStart = Carbon::parse($subscription['billing_on'])->toDateTimeString();
        $periodEnd = Carbon::parse($subscription['billing_on'])->addMonth()->toDateTimeString();

        return MessageLog::where('shop', $shop)
                         ->where('created_at', '>', $periodStart)
                         ->where('created_at', '<', $periodEnd)
                         ->count();
    }

    /**
     *
     */
    private function getTotalUsageByShop($shop)
    {
        return MessageLog::where('shop', $shop)->count();
    }

    /**
     * @param $shop
     * @return int|void
     */
    private function getRemainingUsageByShop($shop)
    {
        // TODO: Put message limit in plan and subtract from plan limit.
        return 100 - $this->getPeriodUsageByShop($shop);
    }

    /**
     * @param $shop
     * @return array
     */
    private function getSubscriptionInfo($shop) : array
    {
        $subscription = Shop::where('name', $shop)->first()->subscription();

        $plan = Plan::where('code', $subscription->name)->first();

        return array_merge((array) $subscription, (array) $plan);
    }
}
