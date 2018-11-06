<?php

namespace App\Http\Controllers\Api;

use App\Models\Shop;
use App\Http\Helpers\Shopify;
use Illuminate\Http\Request;
use App\Repositories\Shopify\CustomersRepository;

class CustomersController extends ShopifyRestController
{
    /**
     * CustomersController constructor.
     *
     * @param Request $request
     * @param CustomersRepository $repository
     */
    public function __construct(Request $request, CustomersRepository $repository)
    {
         $this->repository = $repository;
    }
}
