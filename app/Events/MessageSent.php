<?php

namespace SMS\Events;

use SMS\Message\Message;

class MessageSent
{
    public $sms;

    /**
     * Create a new event instance.
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }
}