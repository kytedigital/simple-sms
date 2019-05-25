<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiTestBase extends TestCase
{
    const SHOP_NAME = 'sms-dervelopment-2';

    const LONG_TERM_TOKEN = 'hcd3c510c0c076a23ef4b9b4507976f4ab9061feb46df17485347409776e9552';

    /**
     * @return ApiTestBase
     */
    protected function getClient()
    {
        return $this->withHeader('Authorization', 'Bearer '.self::LONG_TERM_TOKEN);
    }
}
