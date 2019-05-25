<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class LifecycleWebhookController extends Controller
{
    /**
     * @param LifecycleShopDeleteRequest $request
     * @return array
     */
    public function shopDelete(LifecycleShopDeleteRequest $request) : array
    {
        if(!$request->has('shop_domain')) return;

        Shop::where('name', '=', Shopify::stemName($request->get('shop_domain')))->delete();

        return ['status' => 'Shop Deleted'];
    }

    /**
     * @param LifecycleCustomersDeleteRequest $request
     * @return array
     */
    public function customersRedact(LifecycleCustomersDeleteRequest $request) : array
    {
        if(!$request->has('shop_domain')) return;

        logger('Customer delete requested');
        logger($request->all());

        return ['status' => 'Customer data delete request received.'];
    }

    /**
     * @param LifecycleCustomersDeleteRequest $request
     * @return array
     */
    public function customersDelete(LifecycleCustomersDeleteRequest $request) : array
    {
        if(!$request->has('shop_domain')) return;

        logger('Customer delete requested');
        logger($request->all());

        return ['status' => 'Customer data delete request received.'];
    }
}
