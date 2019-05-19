<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMessageLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->default(null)->nullable();
            $table->string('shop');
            $table->text('recipients');
            $table->text('message');
            $table->string('channel');
            $table->integer('status');
            $table->integer('sendCount');
            $table->text('responseMessage');
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
        Schema::dropIfExists('message_logs');
    }
}
