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
     */
    public function run()
    {

        $now = Carbon::now()->toDateTimeString();
        $fuckingAgesAway = (new Carbon('+3 years'))->toDateTimeString();

        // Development only GOD tokens.
        DB::table('tokens')->insert([
            [
                'shop' => 'penguinsms-app',
                'type' => 'app-api',
                'token' => 'fcd3c510c0c076a23ef4b9b4507976f4ab9061feb46df17485347409776e955d',
                'expires_at' => $fuckingAgesAway,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'shop' => 'penguinblanket',
                'type' => 'app-api',
                'token' => 'gcd3c510c0c076a23ef4b9b4507976f4ab9061feb46df17485347409776e955d',
                'expires_at' => $fuckingAgesAway,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'shop' => 'sms-dervelopment-2',
                'type' => 'app-api',
                'token' => 'hcd3c510c0c076a23ef4b9b4507976f4ab9061feb46df17485347409776e955d',
                'expires_at' => $fuckingAgesAway,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }
}
