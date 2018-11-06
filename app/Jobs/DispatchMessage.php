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
    protected $channel = '';

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var string
     */
    protected $shop;

    /**
     * Create a new job instance.
     *
     * @param string $channel
     * @param Message $message
     * @param string $shop
     */
    public function __construct(string $channel, Message $message, string $shop)
    {
        $this->channel = $channel;
        $this->message = $message;
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

        // TODO: for sms only
        // TODO: Change client depending on channel
        $to = array_pluck($this->message->getAttribute('recipients'), 'phone');

        $message = $this->message->toArray($this->channel);

//        dd( array_only($message, ['to', 'message']) );

        $response = $client->request('POST', 'send-sms.json', [
            'form_params' => array_only($message, ['to', 'message'])
        ]);

        $message['status'] = $response->getStatusCode();
        $message['responseMessage'] = $response->getBody();
        $message['sendCount'] = count(array_unique($to));

        event('message.sent', [
            'channel' => $this->channel,
            'message' => $message,
            'shop' => $this->shop
        ]);

    }
}
