<?php

namespace App\Http\Controllers\Api;

use App\Models\Shop;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShowSubscriptionRequest;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    /**
     * Get subscription.
     *
     * @param ShowSubscriptionRequest $request
     * @return array
     */
    public function show(ShowSubscriptionRequest $request) : array
    {
        $subscription = Shop::where('name', $request->input('shop'))->first()->subscription();

        if(!$subscription) {
            return response()->json(['message' => 'Subscription not found'], Response::HTTP_NOT_FOUND);
        }

        return [
            'subscription' => (array) $subscription->getAttributes(),
            'plan' => (array) $subscription->plan->getAttributes(),
            'usage' => $subscription->getUsage($request->input('shop'))
        ];
    }
}
