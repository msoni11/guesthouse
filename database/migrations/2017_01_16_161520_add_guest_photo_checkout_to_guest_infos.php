<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGuestPhotoCheckoutToGuestInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('guest_infos', function(Blueprint $table) {
            $table->text('guest_photo_checkout');
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
        Schema::table('booking_requests', function(Blueprint $table) {
            $table->dropColumn('guest_photo_checkout');
        });
    }
}
