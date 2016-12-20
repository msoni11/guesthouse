<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHodFieldInFoodBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('food_bookings', function(Blueprint $table) {
            $table->integer('hod_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('food_bookings', function(Blueprint $table) {
            $table->dropColumn('hod_id');
        });
    }
}
