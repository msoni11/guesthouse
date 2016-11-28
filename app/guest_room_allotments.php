<?php

namespace GuestHouse;

use Illuminate\Database\Eloquent\Model;

class guest_room_allotments extends Model
{
    //
    protected  $fillable = ['guest_info_id', 'room_id', 'checked_in', 'check_in_date', 'check_out_date'];
}
