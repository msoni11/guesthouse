<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddServedFieldInFoodBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('food_bookings', function(Blueprint $table) {
            $table->integer('served');
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
            $table->dropColumn('served');
        });
    }
}
