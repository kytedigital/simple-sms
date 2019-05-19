<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('product');
            $table->string('name');
            $table->text('description');
            $table->float('price');
            $table->integer('trial_days', false, false);
            $table->integer('usage_limit', false, false);
            $table->integer('trial_usage_limit', false, false);
            $table->integer('test_mode', false, false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
