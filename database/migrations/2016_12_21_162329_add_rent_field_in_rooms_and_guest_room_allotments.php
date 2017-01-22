<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRentFieldInRoomsAndGuestRoomAllotments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rooms', function(Blueprint $table) {
            $table->float('rent');
        });

        Schema::table('guest_room_allotments', function(Blueprint $table) {
            $table->float('rent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rooms', function(Blueprint $table) {
            $table->dropColumn('rent');
        });

        Schema::table('guest_room_allotments', function(Blueprint $table) {
            $table->dropColumn('rent');
        });
    }
}
