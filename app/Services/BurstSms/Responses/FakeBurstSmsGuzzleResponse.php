<?php

namespace App\Services\BurstSms\Responses;

class FakeBurstSmsGuzzleResponse implements BurstSmsResponseInterface
{
    public $status = 201;

    public $message = 'Sent';

    public function __construct($status = 201, $message = "Sent")
    {
        $this->status = $status;
        $this->message = $message;
    }
}