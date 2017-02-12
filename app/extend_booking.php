<?php

namespace GuestHouse;

use Illuminate\Database\Eloquent\Model;

class extend_booking extends Model
{
    //
    protected $fillable = ['extend_days','booking_requests_id','status'];

}
