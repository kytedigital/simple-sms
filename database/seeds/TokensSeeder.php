<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TokensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
        $fuckingAgesAway = (new Carbon('+3 years'))->toDateTimeString();

        // Development only GOD tokens.
        DB::table('tokens')->insert([
            [
                'shop' => 'sms-dervelopment-2',
                'type' => 'app-api',
                'token' => 'hcd3c510c0c076a23ef4b9b4507976f4ab9061feb46df17485347409776e9552',
                'expires_at' => $fuckingAgesAway,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'shop' => 'sms-dervelopment-3',
                'type' => 'app-api',
                'token' => 'hcd3c510c0c076a23ef4b9b4507976f4ab9061feb46df17485347409776e9553',
                'expires_at' => $fuckingAgesAway,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'shop' => 'sms-dervelopment-4',
                'type' => 'app-api',
                'token' => 'hcd3c510c0c076a23ef4b9b4507976f4ab9061feb46df17485347409776e9554',
                'expires_at' => $fuckingAgesAway,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'shop' => 'sms-dervelopment-5',
                'type' => 'app-api',
                'token' => 'hcd3c510c0c076a23ef4b9b4507976f4ab9061feb46df17485347409776e9555',
                'expires_at' => $fuckingAgesAway,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'shop' => 'sms-dervelopment-6',
                'type' => 'app-api',
                'token' => 'hcd3c510c0c076a23ef4b9b4507976f4ab9061feb46df17485347409776e9556',
                'expires_at' => $fuckingAgesAway,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }
}
