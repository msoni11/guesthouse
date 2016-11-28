<?php

namespace GuestHouse;

use Illuminate\Database\Eloquent\Model;

class food_served extends Model
{
    //
    protected $fillable = ['guest_info_id', 'food_id', 'quantity'];
}
