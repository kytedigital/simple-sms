<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Shop;
use App\Traits\UsesNames;
use Illuminate\Http\Request;
use GuzzleHttp\Client as Guzzle;
use App\Services\Shopify\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;

class SubscriptionController extends AppController
{
    use UsesNames;

    /**
     * @var
     */
    private $shop;

    /**
     * @var Guzzle
     */
    private $client;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        $shop = Shop::byName($this->shopName());
        $subscription = $shop->subscription();

        $usage = $subscription->getPeriodUsage($this->shopName());

        return view('subscription', [
            'shop' => $this->shopName(),
            'subscription' => $subscription,
            'usedMessages' => $usage,
        ]);
    }

    /**
     * @param string $code
     * @return array
     */
    private function subscriptionDetails(string $code) : array
    {
        $subscription = Plan::where('code', $code)->first();

        return [
            'name' => $subscription->getAttribute('code'),
            'price' => $subscription->getAttribute('price'),
            'return_url' => "https://{$this->shopName(true)}/admin/apps/{$this->appName()}/activate-subscription?shop={$this->shopName()}",
            'trial_days' => $subscription->getAttribute('trial_days'),
            'test' => null,
        ];
    }

    /**
     * @param Request $request
     * @param Client $client
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|string
     */
    public function createSubscription(Request $request, Client $client)
    {
        $shop = Shop::where('name', $this->shopName())->first();

        $this->client = $client->oauth($shop->getAttribute('token'))->setStore($this->shopName(true))->getClient();

        try {
            $result = $this->client->post("/admin/recurring_application_charges.json", [
                'form_params' => [
                    'recurring_application_charge' => $this->subscriptionDetails($request->input('code'))
                ]
            ]);
        } catch(GuzzleException $e) {
            Log::debug($e->getMessage());

            // The token is now invalid. Reinstall.
            if($e->getCode()) {
                return $this->startInstall($request);
            }

            return response()->json(['message' => $e->getMessage()], 500);
        }

        $charge = json_decode($result->getBody())->recurring_application_charge;

        return "<script>window.top.location.href = \"{$charge->confirmation_url}\";</script>";
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function activateSubscription(Request $request, Client $client)
    {
        $shop = Shop::where('name', $this->shopName())->first();

        $this->client = $client->oauth($shop->getAttribute('token'))
                                ->setStore($this->shopName(true))->getClient();

        try {
            $result = $this->client->post(
                "/admin/recurring_application_charges/{$request->input('charge_id')}/activate.json"
            );
        } catch( GuzzleException $e ) {
            Log::debug($e->getMessage());

            return response()->json(['message' => $e->getMessage()], 500);
        }

        $result = json_decode($result->getBody())->recurring_application_charge;

        Log::info(json_encode($result));

        return response()->redirectTo(route('dashboard', ['shop' => $this->shopName()]))
                         ->with('message', 'Thank you for updating your subscription to '. $result->name);
    }
}
