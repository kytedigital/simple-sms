<?php

namespace App\Services\BurstSms\Responses;

use GuzzleHttp\Psr7\Response;

class BurstSmsGuzzleResponse
{
    public $guzzleResponse;

    public $status;

    public $message;

    public function __construct(Response $guzzleResponse)
    {
        $this->guzzleResponse = $guzzleResponse;

        $this->breakDown($guzzleResponse);
    }

    private function breakDown(Response $guzzleResponse)
    {
        $this->status = $guzzleResponse->getStatusCode();

        $this->message = $guzzleResponse->getBody();
    }
}