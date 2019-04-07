<?php

namespace App\Services\BurstSms\Responses;

use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;

class BurstSmsGuzzleResponse implements BurstSmsResponseInterface
{
    public $guzzleResponse;

    public $body;

    public $status;

    public $message;

    public $sentAt;

    public $messageId;

    public $failures;

    public $optouts;

    public $reason;

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
        $this->body = json_decode($guzzleResponse->getBody());
        $this->status = $this->body->error->code === 'SUCCESS' ? 200 : 500;
        $this->message = $this->body->error->description === 'OK' ? 'Sent!' : $this->body->error->description;
        $this->sentAt = isset($this->body->send_at) ? $this->body->send_at : Carbon::now()->toDateTimeString();
        $this->messageId = isset($this->body->send_at) ? $this->body->send_at : null;
        $this->failures = isset($this->body->fails) ? $this->body->fails : [];
        $this->optouts = isset($this->body->optouts) ? $this->body->optouts : [];
        $this->reason = isset($this->body->reason) ? $this->body->reason : [];

        return $this;
    }
}