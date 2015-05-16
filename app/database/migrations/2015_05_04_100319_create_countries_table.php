<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country_code', 3)->unique();
            $table->string('country_name');
            $table->integer('message_count');
            $table->string('top_currency_pair', 7);
            $table->integer('top_pair_msg_cnt');
            $table->double('top_pair_avg_rate', 15, 9);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('countries');
    }
}
