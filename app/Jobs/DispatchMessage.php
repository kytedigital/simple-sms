<?php

namespace App\Jobs;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use App\Services\BurstSms\Client;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
    protected $recipients;

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
     * @param array $recipients
     * @param Message $message
     * @param string $shop
     */
    public function __construct(string $channel, array $recipients, string $text, string $shop)
    {
        $this->channel = $channel;
        $this->recipients = $recipients;
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
        foreach($this->recipients as $recipient) {

            $message = (new Message($recipient, $this->message))->__toArray($this->channel);

            $response = $client->request('POST', 'send-sms.json', [
                'form_params' => $message
            ]);

            $this->dispatchEvent($message, $response);
        }
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
