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
    public function show(ShowSubscriptionRequest $request)
    {
        $subscription = Shop::where('name', $request->input('shop'))
                            ->first()
                            ->subscription();

        return [
            'subscription' => $subscription ? (array) $subscription->getAttributes() : null,
            'plan' => (array) $subscription ? $subscription->plan->getAttributes() : null,
            'usage' => $subscription ? $subscription->getUsage($request->input('shop')) : null
        ];
    }
}
