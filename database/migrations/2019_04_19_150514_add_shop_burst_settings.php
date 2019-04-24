<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShopBurstSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shops', function($table) {
            $table->string('burst_sms_client_id', 50)->nullable();
            $table->string('burst_sms_client_api_key', 50)->nullable();
            $table->string('burst_sms_client_api_secret', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shops', function($table) {
            $table->dropColumn('burst_sms_client_id');
            $table->dropColumn('burst_sms_client_api_key');
            $table->dropColumn('burst_sms_client_api_secret');
        });
    }
}
