<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    const SHOP_NAME = 'sms-dervelopment-2';

    const LONG_TERM_TOKEN = 'hcd3c510c0c076a23ef4b9b4507976f4ab9061feb46df17485347409776e9552';

    /*
     * Set up DB
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->seed();
    }

    protected function getClient()
    {
        return $this->withHeader('Authorization', 'Bearer '.self::LONG_TERM_TOKEN);
    }
}
