<?php

namespace GuestHouse;

use Illuminate\Database\Eloquent\Model;

class booking_request_guest_info extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'booking_request_id', 'guest_info_id',
    ];
    
   

}
