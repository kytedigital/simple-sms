<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usages')->insert(
            [
                [
                    'shop' => 'sms-dervelopment-2',
                    'purchase_id' => 1,
                    'quantity' => 30,
                    'type' => 'credits',
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
                [
                    'shop' => 'sms-dervelopment-2',
                    'purchase_id' => 1,
                    'quantity' => 10,
                    'type' => 'credits',
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
                [
                    'shop' => 'sms-dervelopment-2',
                    'purchase_id' => 5,
                    'quantity' => 10,
                    'type' => 'addon',
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
            ]
        );
    }
}
