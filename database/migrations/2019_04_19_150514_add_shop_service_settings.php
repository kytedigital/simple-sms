<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddShopServiceSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_service_settings', function($table) {
            $table->string('shop');
            $table->integer('shop_id')->default(null)->nullable();
            $table->string('service', 20);
            $table->string('client_id', 50)->nullable();
            $table->string('client_api_key', 50)->nullable();
            $table->string('api_token', 50)->nullable();
            $table->string('api_secret', 50)->nullable();
            $table->text('options')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_service_settings', function($table) {
            Schema::dropIfExists('shop_service_settings');
        });
    }
}
