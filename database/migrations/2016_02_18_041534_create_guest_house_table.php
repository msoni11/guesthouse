<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestHouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_houses', function (Blueprint $table) {
            $table->increments('id');
             $table->string('name');
             $table->text('description');
             $table->bigInteger('user_id');
             $table->tinyInteger('status'); 
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
        Schema::drop('guest_house');
    }
}
