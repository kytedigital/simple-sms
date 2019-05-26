<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('purchases')->insert(
            [
                [
                    'shop' => 'sms-dervelopment-2',
                    'type' => 'credits',
                    'title' => 'Message Credits',
                    'quantity' => 100,
                    'cost' => 5.00,
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
            ]
        );
    }
}
