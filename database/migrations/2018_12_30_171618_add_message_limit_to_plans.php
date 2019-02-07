<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddMessageLimitToPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function($table) {
        $table->integer('message_limit');
    });

        $this->seed();
    }

    private function seed()
    {
        DB::table('plans')->where('code', 'beacon-trial')->update(['message_limit' => 60]);
        DB::table('plans')->where('code', 'beacon-sm')->update(['message_limit' => 100]);
        DB::table('plans')->where('code', 'beacon-md')->update(['message_limit' => 500]);
        DB::table('plans')->where('code', 'beacon-lg')->update(['message_limit' => 1000]);
        DB::table('plans')->where('code', 'beacon-xl')->update(['message_limit' => 5000]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function($table) {
            $table->dropColumn('message_limit');
        });
    }
}
