<?php

namespace App\Repositories\Shopify;

use App\Http\State;
use Illuminate\Support\Collection;

class CustomersRepository extends ShopifyRepository
{
    /**
     * Browse Shopify customers.
     *
     * @param State $state
     * @return Collection $customers
     */
    public function browse(State $state) : Collection
    {
        return $this->get('customers.json?'.$state);
    }

    /**
     * Search Shopify customers.
     *
     * @param State $state
     * @return Collection $customers
     */
    public function search(State $state) : Collection
    {
        return $this->get('customers/search.json?'.$state);
    }

    /**
     * Retrieve a single Shopify customer.
     *
     * @param string $id
     * @return Collection $customers
     */
    public function read(string $id) : Collection
    {
        return $this->get("customers/$id.json", 'customer');
    }
}
