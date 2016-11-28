<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestInfoRoomAllotment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_room_allotments', function (Blueprint $table) {
            $table->increments('id');
            $table->biginteger('guest_info_id');
            $table->biginteger('room_id');
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
        Schema::drop('guest_room_allotments');
    }
}
