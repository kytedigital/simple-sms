<?php

namespace App\Traits;

use App\Http\Helpers\Shopify;

trait UsesNames
{
    public function shopName($expand = false)
    {
        if($expand) return Shopify::nameToUrl(Shopify::stemName(request()->get('shop')));

        return Shopify::stemName(request()->get('shop'));
    }

    public function appName()
    {
        return config('app.name');
    }
}