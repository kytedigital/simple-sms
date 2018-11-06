<?php

namespace App\Services\BurstSms;

use GuzzleHttp\Client as GuzzleClient;

class Client
{
    /**
     * SendGrid Guzzle Client.
     *
     * @var GuzzleClient
     */
    private $client;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * API key.
     *
     * @var string
     */
    protected $key;

    /**
     * API key.
     *
     * @var string
     */
    protected $secret;

    /**
     * Client constructor.
     *
     * @param string $key
     * @param string $secret
     * @param string $baseUrl
     */
    public function __construct(string $key, string $secret, string $baseUrl)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->baseUrl = $baseUrl;

        $this->client = $this->getClient();
    }

    /**
     * Initialise the Guzzle Client for SendGrid.
     *
     * @return GuzzleClient.
     */
    public function getClient() : GuzzleClient
    {
        return new GuzzleClient([
            'auth' => [$this->key, $this->secret],
            'base_uri' => $this->baseUrl
        ]);
    }

    /**
     * Pass unknown methods off to the underlying Guzzle client.
     *
     * @param  string $name
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->client, $name], $arguments);
    }
}
