<?php

namespace App\Jobs;

use App\Http\Helpers\Shopify;
use App\Models\Shop;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use App\Services\Shopify\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Events\MessageDispatchStarted;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\MessageDispatchCompleted;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\BurstSms\Responses\BurstSmsGuzzleResponse;
use App\Services\BurstSms\Responses\FakeBurstSmsGuzzleResponse;

/**
 * @property array recipient
 */
class MarkCustomerOptOut implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * @var string
     */
    protected $customer;


    protected $shop;

    /**
     * Create a new job instance.
     *
     * @param $shop
     * @param Collection $customer
     */
    public function __construct($shopName, Collection $customer)
    {
        $this->shopName = $shopName;
        $this->customer = $customer;
    }

    /**
     * Execute the job.
     *
     * @param Client $client
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $customerId = $this->customer->first();

        Log::debug('Marking Customer Opt-out for '.$customerId);

        $shop = Shop::byName($this->shopName);

        $client = $this->getShopifyClient($shop);

        Log::debug(json_encode([
            'customer' => [
                'id' => $customerId,
                'accepts_marketing' => false,
                'accepts_marketing_updated_at' => Carbon::now()->toISOString(),
                'marketing_opt_in_level' => 'confirmed_opt_out'
            ]
        ]));

        try {
            $response = $client->request('PUT', "/admin/customers/{$customerId}.json", [
                'body' => json_encode([
                    'customer' => [
                        'id' => $customerId,
                        'accepts_marketing' => false,
                        'accepts_marketing_updated_at' => Carbon::now()->toISOString(),
                        'marketing_opt_in_level' => 'confirmed_opt_out'
                    ]
                ])
            ]);

            Log::debug('Opt Out Response');
            Log::debug(json_encode($response->getBody()));
        } catch(ClientException $exception) {
            Log::debug('Opt Out Exception');
            $message = $exception->getMessage();
            Log::debug($message);
        }
    }

    /**
     * @param $shop
     * @return \GuzzleHttp\Client
     */
    private function getShopifyClient($shop)
    {
        return (new Client())->oauth($shop->getAttribute('token'))
                            ->setStore(Shopify::nameToUrl($shop->getAttribute('name')))
                            ->getClient();
    }
}
