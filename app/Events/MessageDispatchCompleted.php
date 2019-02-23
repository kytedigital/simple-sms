<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageDispatchCompleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channel;

    public $message;

    public $shop;

    /**
     * Create a new event instance.
     *
     * @param string $channel
     * @param Message $message
     * @param $shop
     */
    public function __construct(string $channel, Message $message, $shop)
    {
        $this->channel = $channel;
        $this->message = $message;
        $this->shop = $shop;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('messages');
       // return new PrivateChannel('channel-name');
    }
}
