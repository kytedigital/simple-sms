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
                    'code' => 'Simple SMS Lite - Intro',
                    'product' => 'Simple SMS Lite',
                    'name' => 'Simple SMS Lite - Intro',
                    'description' => 'Up to 100 messages/month. For occasional comms and notifications.',
                    'price' => '25.00',
                    'trial_days' => 7,
                    'message_limit' => 100,
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
                [
                    'code' => 'Simple SMS Lite - Moderate',
                    'product' => 'Simple SMS Lite',
                    'name' => 'Simple SMS Lite - Moderate',
                    'description' => 'Up to 500 messages/month. For infrequent comms/one or two bulk promos.',
                    'price' => '50.00',
                    'trial_days' => 0,
                    'message_limit' => 500,
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
                [
                    'code' => 'Simple SMS Lite - Regular',
                    'product' => 'Simple SMS Lite',
                    'name' => 'Simple SMS Lite - Regular',
                    'description' => 'Up to 1000 messages/month. For moderate comms/one or two bulk promos.',
                    'price' => '80.00',
                    'trial_days' => 0,
                    'message_limit' => 1000,
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
                [
                    'code' => 'Simple SMS Lite - Frequent',
                    'product' => 'Simple SMS Lite',
                    'name' => 'Simple SMS Lite - Frequent',
                    'description' => 'Up to 2000 messages/month. For regular comms/promos.',
                    'price' => '150.00',
                    'trial_days' => 0,
                    'message_limit' => 2000,
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ]
            ]
        );
    }
}
