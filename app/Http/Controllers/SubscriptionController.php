<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Helpers\Shopify;
use GuzzleHttp\Client as Guzzle;
use App\Services\Shopify\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;

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

    private $shop;

    /**
     * @var Guzzle
     */
    private $client;

    /**
     * InstallationController constructor.
     */
    public function __construct()
    {
        $this->clientId = config('services.shopify.app_api_key');
        $this->clientSecret = config('services.shopify.app_api_secret');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        $subscription = Shop::where('name', session('shop'))->first()->subscription();
        $plan = Plan::where('code', $subscription->name)->first();

        return view('subscription', ['subscription' => $subscription, 'plan' => $plan]);
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
            'return_url' => 'https://' . Shopify::nameToUrl(session('shop')) . "/admin/apps/shopify-sms/activate-subscription",
            'trial_days' => $subscription->getAttribute('trial_days'),
            'test' => true,

        ];
    }

    /**
     * @param Request $request
     * @return void
     */
    public function createSubscription(Request $request, Client $client)
    {
        $shop = Shop::where('name', session('shop'))->first();

        $this->client = $client->oauth($shop->getAttribute('token'))
                                ->setStore(Shopify::nameToUrl($shop->getAttribute('name')))->getClient();

        try {

            $result = $this->client->post("/admin/recurring_application_charges.json", [
                'form_params' => [
                    'recurring_application_charge' => $this->subscriptionDetails($request->input('code'))
                ]
            ]);

        } catch( GuzzleException $e ) {

            Log::debug($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);

        }

        $charge = json_decode($result->getBody())->recurring_application_charge;

        // TODO: What the hell?

        return "<script>window.top.location.href = \"{$charge->confirmation_url}\";</script>";

//        return redirect($charge->confirmation_url);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function activateSubscription(Request $request, Client $client)
    {
        $shop = Shop::where('name', session('shop'))->first();

        $this->client = $client->oauth($shop->getAttribute('token'))
                                ->setStore(Shopify::nameToUrl($shop->getAttribute('name')))->getClient();

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

        return response()->redirectTo(route('dashboard'))
            ->with('message', 'Thank you for updating your subscription to '. $result->name);
    }
}
