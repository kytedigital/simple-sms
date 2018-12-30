<?php

namespace App\Jobs;

use App\Models\Message;
use App\Models\Shop;
use Illuminate\Bus\Queueable;
use App\Services\BurstSms\Client;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;

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
     * @param array $recipient
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
        $message = (new Message($this->recipient, $this->message))
                                ->__toArray($this->channel);

        $response = $client->request('POST', 'send-sms.json', [
            'form_params' => $message
        ]);

        $this->dispatchEvent($message, $response);

        /**
         * To provide the best service to all our customers we limit the number of API calls
         * which can be made by each account to 2 calls per sec. For heavy users we can increase
         * your throttling speed, but please contact us to discuss your requirements. If you
         * exceed this limit we will return two indicators which you can use in your code
         * to detect that you have been throttled.
         * The first is the HTTP status code 429 "Too Many Requests", the second is the error
         * code "OVER_LIMIT" in the error block of the response body.
         */
        sleep(0.5);
    }

    /**
     * @param $event
     * @param $response
     */
    private function dispatchEvent($event, $response) : void
    {
        $event['status'] = $response->getStatusCode();
        $event['responseMessage'] = $response->getBody();
        $event['sendCount'] = 1;

        event('message.sent', [
            'channel' => $this->channel,
            'message' => $event,
            'shop' => $this->shop
        ]);
    }
}
