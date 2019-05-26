<?php

namespace Tests\Feature;

use Tests\TestCase;

class SubscriptionsApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_subscriptions_api_endpoint()
    {
        $response = $this->getClient()->json('GET', '/api/subscription/me');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'subscription',
            'plan',
            'usage',
        ]);
    }
}
