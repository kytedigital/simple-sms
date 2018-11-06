<?php

namespace App\Http\Controllers\Api;

use App\Http\Helpers\Shopify;
use App\Http\State;
use App\Models\Shop;
use Illuminate\Http\Request;

abstract class ShopifyRestController extends RestController implements RestControllerInterface
{
    /**
     * Because we are using a crazy Shopify repository, we need to initialise
     * some stuff into the underlying client. Can't do it before now because
     * the request data isn't available in the constructor.
     *
     * @param Request $request
     * @return ShopifyRestController
     */
    protected function up(Request $request) : RestController
    {
        $this->state = new State($request);

        $shop = Shop::where('name', $request->input('shop'))->first();

        $this->repository = $this->repository->token($shop->token)->shop(Shopify::nameToUrl($shop->name));

        return $this;
    }
}
