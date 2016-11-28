<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBookingRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('no_of_visitors');
            $table->integer('required_room');
            $table->string('type_of_guest');
            $table->timestamp('check_in_date');
            $table->timestamp('check_out_date');
            $table->string('food_order');
            $table->text('purpose');
            $table->text('remark');
            $table->integer('request_by');
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
        Schema::drop('booking_requests');
    }
}
