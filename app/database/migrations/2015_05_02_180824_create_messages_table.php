<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id', 64);
            $table->string('currency_from', 3);
            $table->string('currency_to', 3);
            $table->decimal('amount_sell', 10, 4);
            $table->decimal('amount_buy', 10, 4);
            $table->double('rate', 15, 9);
            $table->timestamp('time_placed');
            $table->string('originating_country', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('messages');
    }
}
