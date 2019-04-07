<?php

namespace App\Services\BurstSms\Responses;

use BurstSmsResponseInterface;
use GuzzleHttp\Exception\ClientException;

class BurstSmsGuzzleExceptionResponse implements BurstSmsResponseInterface
{
    public $guzzleException;

    public $status;

    public $message;

    public $sentAt;

    public $phoneNumber;

    /**
     * BurstSmsGuzzleResponse constructor.
     * @param ClientException $guzzleException
     */
    public function __construct(ClientException $guzzleException)
    {
        $this->guzzleException = $guzzleException;

        $this->breakDown($guzzleException);
    }

    /**
     * @param ClientException $guzzleException
     * @return $this
     */
    private function breakDown(ClientException $guzzleException)
    {
        dd($guzzleException->getResponse()->getBody(true));
        $body = json_decode($guzzleException->getMessage());

        dd($body);

        $this->status = $guzzleException->getCode();
        $this->message = $body->reason;
        $this->phoneNumber = $body->fails[0];

        return $this;
    }
}