<?php declare(strict_types=1);

namespace App\Services\SendGrid;

use GuzzleHttp\Client as GuzzleClient;

class Client
{
    /**
     * SendGrid ApiService Base URL
     */
    const API_BASE_URL = 'https://api.sendgrid.com/v3/';

    /**
     * SendGrid Guzzle Client.
     *
     * @var GuzzleClient
     */
    private $client;

    /**
     * ApiService key.
     *
     * @var string
     */
    protected $key;

    /**
     * Client constructor.
     *
     * @param string $key - SendGrid ApiService Key for client.
     */
    public function __construct(string $key)
    {
        if(empty($key)) {
            throw new \InvalidArgumentException('SendGrid client requires an ApiService key and 
            store strings to initialise on line');
        }

        $this->key = $key;
        $this->client = $this->getClient();
    }

    /**
     * Initialise the Guzzle Client for SendGrid.
     *
     * @return GuzzleClient.
     */
    public function getClient() : GuzzleClient
    {
        return new GuzzleClient(array_merge([
            'base_uri' => self::API_BASE_URL,
            'headers' => $this->getDefaultHeaders()
        ]));
    }

    /**
     * Return the default auth and content-type headers.
     *
     * @return array
     */
    private function getDefaultHeaders()
    {
        $headers = [
            'Authorization' => 'Bearer '. $this->key,
            'Content-Type' => 'application/json'
        ];

        return $headers;
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
