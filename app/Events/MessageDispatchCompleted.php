<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Services\BurstSms\Responses\BurstSmsResponseInterface;

class MessageDispatchCompleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $shop;

    public $channel;

    public $message;

    public $response;

    /**
     * Create a new event instance.
     *
     * @param $shop
     * @param string $channel
     * @param Message $message
     * @param $response
     */
    public function __construct($shop, string $channel, Message $message, BurstSmsResponseInterface $response)
    {
        $this->shop = $shop;
        $this->channel = $channel;
        $this->message = $message;
        $this->response = $response;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("shop.{$this->shop}");
    }
}
