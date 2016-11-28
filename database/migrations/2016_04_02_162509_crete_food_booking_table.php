<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreteFoodBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('no_of_visitors');
            $table->integer('quantity');
            $table->string('food_type');
            $table->integer('request_by');
            $table->timestamp('date');
            $table->text('purpose');
            $table->tinyinteger('status');
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
        Schema::drop('food_bookings');
    }
}
