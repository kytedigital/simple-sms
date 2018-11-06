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
                    'code' => 'beacon-trial',
                    'product' => 'Beacon',
                    'name' => 'Beacon Trial',
                    'description' => '1 Week trial including p to 60 trial messages. Will automatically roll on to 
                     Beacon SM plan after 7 days unless uninstalled.
                     All plans covers all third party send fees (70%), Shopify transaction fees (20%) and our 
                     infrastructure costs.',
                    'price' => '15.00',
                    'trial_days' => 7,
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
                [
                    'code' => 'beacon-sm',
                    'product' => 'Beacon',
                    'name' => 'Beacon Small',
                    'description' => 'Up to 100 messages across all channels / month. 
                     All plans covers all third party send fees (70%), Shopify transaction fees (20%) and our 
                     infrastructure costs.',
                    'price' => '15.00',
                    'trial_days' => 0,
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
                [
                    'code' => 'beacon-md',
                    'product' => 'Beacon',
                    'name' => 'Beacon Medium',
                    'description' => 'Up to 500 messages across all channels / month. 
                     All plans covers all third party send fees (70%), Shopify transaction fees (20%) and our 
                     infrastructure costs.',
                    'price' => '60.00',
                    'trial_days' => 0,
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
                [
                    'code' => 'beacon-lg',
                    'product' => 'Beacon',
                    'name' => 'Beacon Large',
                    'description' => 'Up to 1000 messages across all channels / month. 
                     All plans covers all third party send fees (70%), Shopify transaction fees (20%) and our 
                     infrastructure costs.',
                    'price' => '120.00',
                    'trial_days' => 0,
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
                [
                    'code' => 'beacon-xl',
                    'product' => 'Beacon',
                    'name' => 'Beacon XL',
                    'description' => 'Up to 5000 messages across all channels / month. 
                     Covers all third party send fees (70%), Shopify transaction fees (20%) and our infrastructure 
                     costs.',
                    'price' => '590.00',
                    'trial_days' => 0,
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ]
            ]
        );
    }
}
