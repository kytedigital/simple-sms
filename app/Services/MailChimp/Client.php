<?php declare(strict_types=1);

namespace App\Services\MailChimp;

use GuzzleHttp\Client as GuzzleClient;

class Client
{
    /**
     * MailChimp Guzzle Client.
     *
     * @var GuzzleClient
     */
    private $client;

    /**
     * MailChimp Account Handle.
     *
     * @var string
     */
    protected $account_handle;

    /**
     * API Datacenter.
     *
     * @var string
     */
    protected $data_center;

    /**
     * API Access Username.
     *
     * @var string
     */
    protected $api_user;

    /**
     * API Access Key.
     *
     * @var string
     */
    protected $api_key;

    /**
     * The store URL
     *
     * @var string
     */
    protected $store_url;

    /**
     * Initialise the Guzzle Client for SendGrid.
     *
     * @return GuzzleClient.
     */
    public function getClient() : GuzzleClient
    {
        return $this->client = new GuzzleClient([
            'base_uri' => 'https://'.$this->data_center.'api.mailchimp.com/3.0',
            'auth'     => [$this->api_user, $this->api_key]
        ]);
    }

    /**
     * Client constructor.
     *
     * @param string $data_center - MailChimp Data Center
     * @param string $api_user - MailChimp Admin API access password
     * @param string $api_key - MailChimp API access key
     */
    public function __construct(string $data_center, string $api_user, string $api_key)
    {
        $this->data_center = $data_center;
        $this->api_user = $api_user;
        $this->api_key = $api_key;

        $this->client = $this->getClient();
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
