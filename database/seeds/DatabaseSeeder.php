<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ShopsTableSeeder::class);
        $this->call(PlansTableSeeder::class);
        $this->call(PlanFeaturesTableSeeder::class);
        $this->call(TokensSeeder::class);
        $this->call(TokensSeeder::class);
        $this->call(PurchasesTableSeeder::class);
        $this->call(UsagesTableSeeder::class);
    }
}
