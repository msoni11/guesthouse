<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGuestInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('contact_no', 20);
            $table->string('email', 100);
            $table->string('doc');
            $table->string('finger_print');
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
        Schema::drop('guest_infos');
    }
}
