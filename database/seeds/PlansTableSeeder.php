<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->insert(
            [
                [
                    'code' => 'PlanCode',
                    'product' => config('app.title'),
                    'name' => '',
                    'description' => '',
                    'price' => '9.99',
                    'trial_days' => 14,
                    'usage_limit' => 100,
                    'trial_usage_limit' => 50,
                    'test_mode' => true,
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
            ]
        );
    }
}
