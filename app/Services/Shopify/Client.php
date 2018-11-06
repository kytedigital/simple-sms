<?php declare(strict_types=1);

namespace App\Services\Shopify;

use Shopify\ShopifyClient;
use GuzzleHttp\Client as GuzzleClient;

class Client
{
    /**
     *
     */
    const AUTH_METHOD_BEARER = 'bearer';

    /**
     *
     */
    const AUTH_METHOD_OAUTH  = 'oauth';

    /**
     * SendGrid Guzzle Client.
     *
     * @var ShopifyClient
     */
    private $client;

    /**
     * API Access Key.
     *
     * @var string
     */
    protected $api_key;

    /**
     * API Access Token.
     *
     * @var string
     */
    protected $api_token;

    /**
     * API Access Password.
     *
     * @var string
     */
    protected $api_password;

    /**
     * The store URL
     *
     * @var string
     */
    protected $store_url;

    /**
     * @var string
     */
    protected $auth_method = self::AUTH_METHOD_BEARER;

    /**
     * @param string $store_url
     * @return Client
     */
    public function setStore(string $store_url)
    {
        $this->store_url = 'https://'. $store_url;

        return $this;
    }

    /**
     * Client constructor.
     *
     * @param string $api_key - Shopify Admin API access key
     * @param string $api_password - Shopify Admin API access password
     * @return Client
     */
    public function bearer(string $api_key, string $api_password)
    {
        $this->auth_method = self::AUTH_METHOD_BEARER;

        $this->api_key = $api_key;
        $this->api_password = $api_password;

        return $this;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function oauth(string $token)
    {
        $this->auth_method = self::AUTH_METHOD_OAUTH;
        $this->api_token = $token;

        return $this;
    }

    /**
     * Initialise the Guzzle Client for SendGrid.
     *
     * @return GuzzleClient.
     */
    public function getClient() : GuzzleClient
    {
        if($this->auth_method === self::AUTH_METHOD_BEARER) {

            return $this->client = new GuzzleClient([
                'base_uri' => $this->store_url .'/admin/',
                'auth'     => [$this->api_key, $this->api_password]
            ]);

        }

        $this->client = new GuzzleClient(
            array_merge(
                ['base_uri' => $this->store_url .'/admin/'],
                $this->buildAuthArray()
            )
        );

        return $this->client;
    }

    /**
     * @return array
     */
    private function buildAuthArray() : array
    {
        if($this->auth_method === self::AUTH_METHOD_OAUTH) {
            return ['headers' => ['X-Shopify-Access-Token' => $this->api_token]];
        }

        return ['auth' => [$this->api_key, $this->api_password]];
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
