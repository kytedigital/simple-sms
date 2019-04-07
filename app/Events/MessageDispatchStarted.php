<?php

namespace App\Events;

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

    /**
     * Create a new event instance.
     *
     * @param $shop
     * @param string $channel
     * @param $notice
     */
    public function __construct($shop, string $channel, $notice)
    {
        $this->shop = $shop;
        $this->channel = $channel;
        $this->notice = $notice;
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
