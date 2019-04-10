<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageDispatchStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $shop;

    public $channel;

    public $notice;

    public $message;

    /**
     * Create a new event instance.
     *
     * @param $shop
     * @param string $channel
     * @param Message $message
     */
    public function __construct($shop, string $channel, Message $message)
    {
        $this->shop = $shop;
        $this->channel = $channel;
        $this->message = $message;
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
