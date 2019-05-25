<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanFeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plan_features')->insert(
            [
                [
                    'plan_id' => 1,
                    'title' => 'Feature 1',
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
                [
                    'plan_id' => 1,
                    'title' => 'Feature 2',
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
                [
                    'plan_id' => 1,
                    'title' => 'Feature 3',
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
                [
                    'plan_id' => 1,
                    'title' => 'Feature 4',
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
                [
                    'plan_id' => 2,
                    'title' => 'Feature 1',
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
                [
                    'plan_id' => 2,
                    'title' => 'Feature 2',
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
                [
                    'plan_id' => 2,
                    'title' => 'Feature 3',
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
                [
                    'plan_id' => 2,
                    'title' => 'Feature 4',
                    'created_at' => Carbon\Carbon::now(),
                    'updated_at' => Carbon\Carbon::now()
                ],
            ]
        );
    }
}
