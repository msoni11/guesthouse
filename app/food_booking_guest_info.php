<?php

namespace GuestHouse;

use Illuminate\Database\Eloquent\Model;

class food_booking_guest_info extends Model
{
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'food_booking_id', 'guest_info_id',
    ];
}
