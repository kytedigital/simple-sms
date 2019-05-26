<?php

namespace Tests\Feature;

use Tests\TestCase;

class PlansApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_plans_api_endpoint()
    {
        $response = $this->getClient()->json('GET', '/api/plans');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            [
                'id',
                'code',
                'product',
                'name',
                'description',
                'price',
                'trial_days',
                'usage_limit',
                'trial_usage_limit',
                'test_mode',
                'created_at',
                'updated_at',
                'features'
            ]
        ]);
    }
}
