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
    protected $shop;

    /**
     * Create a new job instance.
     *
     * @param string $channel
     * @param Collection $recipient
     * @param string $text
     * @param string $shop
     */
    public function __construct(string $channel, Collection $recipient, string $text, string $shop)
    {
        $this->channel = $channel;
        $this->recipient = $recipient;
        $this->message = $text;
        $this->shop = $shop;
    }

    /**
     * Execute the job.
     *
     * @param Client $client
     * @return void
     */
    public function handle(Client $client)
    {
        Log::debug('Starting DispatchMessage JOB');

        $listId = $this->getShopListId($this->shop);

       // $message = (new Message($this->recipient, $this->message, $this->getShopListId($this->shop)));
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

        Log::debug('Response');

        $this->dispatchCompletedEvent($message, $response);
    }

    /**
     * @param $message
     */
    private function dispatchStartedEvent($message) : void
    {
        MessageDispatchStarted::dispatch($this->shop, $this->channel, $message);
    }

    /**
     * @param $message
     * @param $response
     */
    private function dispatchCompletedEvent($message, $response) : void
    {
        MessageDispatchCompleted::dispatch($this->shop, $this->channel, $message, $response);
    }

    /**
     * @param $shopName
     * @return mixed
     */
    private function getShopListId($shopName)
    {
        return Shop::where('name', '=', $shopName)->first()->getAttribute('burst_sms_list_id');
    }
}
