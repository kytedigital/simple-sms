<?php

namespace App\Http\Helpers;

class Shopify
{
    /**
     * Stem the Shopify store name from full domain.
     *
     * @param $input
     * @return string
     */
    public static function stemName($input) : string
    {
        return str_replace('.myshopify.com', '', $input);
    }

    /**
     * Stem the Shopify store name from full domain.
     *
     * @param $name
     * @return string
     */
    public static function nameToUrl($name) : string
    {
        return self::stemName($name) . '.myshopify.com';
    }
}