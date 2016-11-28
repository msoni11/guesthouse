<?php

namespace GuestHouse;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    protected $fillable = [
        'room_no', 'room_type', 'description', 'guest_house_id', 'status','capacity'
    ];
    
     /**
     * Get the user that owns the phone.
     */
    public function guesthouse()
    {
        return $this->belongsTo('GuestHouse\GuestHouse', 'guest_house_id');
    }
}
