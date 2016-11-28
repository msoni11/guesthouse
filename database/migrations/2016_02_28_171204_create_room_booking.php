<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_booking', function (Blueprint $table) {
            $table->increments('id');
            $table->biginteger('room_id');
            $table->biginteger('guest_info_id');
            $table->timestamp('check_in_date');
            $table->timestamp('check_out_date');
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
        Schema::drop('room_booking');
    }
}
