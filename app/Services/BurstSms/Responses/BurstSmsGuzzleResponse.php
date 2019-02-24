<?php

namespace App\Services\BurstSms\Responses;

use GuzzleHttp\Psr7\Response;

class BurstSmsGuzzleResponse
{
    public $guzzleResponse;

    public $status;

    public $message;

    public $sentAt;

    public $messageId;

    /**
     * BurstSmsGuzzleResponse constructor.
     * @param Response $guzzleResponse
     */
    public function __construct(Response $guzzleResponse)
    {
        $this->guzzleResponse = $guzzleResponse;

        $this->breakDown($guzzleResponse);
    }

    /**
     * @param Response $guzzleResponse
     * @return $this
     */
    private function breakDown(Response $guzzleResponse)
    {
        $body = json_decode($guzzleResponse->getBody());

        $this->status = $body->error->code === 'SUCCESS' ? 200 : 500;
        $this->message = $body->error->description === 'OK' ? 'Sent!' : $body->error->description;
        $this->sentAt = $body->send_at;
        $this->messageId = $body->message_id;

        return $this;
    }
}