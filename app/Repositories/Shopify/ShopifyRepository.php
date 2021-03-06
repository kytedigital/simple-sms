<?php

namespace App\Repositories\Shopify;

use InvalidArgumentException;
use App\Services\Shopify\Client;
use Illuminate\Support\Collection;
use App\Repositories\RepositoryInterface;

abstract class ShopifyRepository implements RepositoryInterface
{
    protected $token;

    protected $shop;

    /**
     * CustomersRepository constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $token
     * @return ShopifyRepository
     */
    public function token($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return $this
     */
    public function shop($shop)
    {
        $this->shop = $shop;

        return $this;
    }

    /**
     * Standard request function
     *
     * @param string $path
     * @param string|null $resource
     * @return Collection
     */
    public function get(string $path, string $resource = null) : Collection
    {
        if(!$this->shop) {
            throw new InvalidArgumentException('Can\'t access ApiService without shop details. Run setShop first.');
        }

        $this->client
             ->oauth($this->token)
             ->setStore($this->shop)
             ->getClient();

        $resource = is_null($resource) ? preg_split('/[\.\/]/', $path)[0] : $resource;

        return collect(json_decode($this->client->get($path)->getBody())->$resource);
    }
}
