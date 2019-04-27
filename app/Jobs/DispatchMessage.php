<?php

namespace App\Jobs;

use App\Models\Shop;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use App\Services\BurstSms\Client;
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
class DispatchMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * @var string
     */
    protected $channel;

    /**
     * @var string
     */
    protected $recipient;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $shopName;

    /**
     * Create a new job instance.
     *
     * @param string $channel
     * @param Collection $recipient
     * @param string $text
     * @param string $shopName
     */
    public function __construct(string $channel, Collection $recipient, string $text, string $shopName)
    {
        $this->channel = $channel;
        $this->recipient = $recipient;
        $this->message = $text;
        $this->shopName = $shopName;
    }

    /**
     * Execute the job.
     *
     * @param Client $client
     * @return void
     */
    public function handle()
    {
        Log::debug('Starting DispatchMessage JOB');

        $shop = Shop::byName($this->shopName);
        $client = $this->getBurstClientForStore($shop);

        $message = (new Message($this->recipient, $this->message));

        $this->dispatchStartedEvent($message);

        try {
            $response = new BurstSmsGuzzleResponse($client->request('POST', 'send-sms.json', [
                'form_params' => $message->__toArray($this->channel)
            ]));
        } catch(ClientException $exception) {
            $response = new BurstSmsGuzzleResponse($exception->getResponse());
            Log::debug(json_encode($response->message));
        }


        // Cheap mode!
      //  $response = new FakeBurstSmsGuzzleResponse();
     //   $response = new FakeBurstSmsGuzzleResponse(500, 'The customer has opted out!');

        $this->dispatchCompletedEvent($message, $response);
    }

    /**
     * @param $message
     */
    private function dispatchStartedEvent($message) : void
    {
        MessageDispatchStarted::dispatch($this->shopName, $this->channel, $message);
    }

    /**
     * @param $message
     * @param $response
     */
    private function dispatchCompletedEvent($message, $response) : void
    {
        MessageDispatchCompleted::dispatch($this->shopName, $this->channel, $message, $response);
    }

    /**
     * @param $shop
     * @return Client
     */
    private function getBurstClientForStore($shop)
    {
        return new Client(
            $shop->getAttribute('burst_sms_client_api_key'),
            $shop->getAttribute('burst_sms_client_api_secret'),
            config('services.burstsms.api_base')
        );
    }
}
