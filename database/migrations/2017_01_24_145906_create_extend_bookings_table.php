<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtendBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('extend_bookings',function(Blueprint $table)
        {
            $table->increments('id');
            $table->biginteger('booking_requests_id');
            $table->string('extend_days');
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
        //

        Schema::drop('extend_bookings');

    }
}
