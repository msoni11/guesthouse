<?php

namespace GuestHouse;

use Illuminate\Database\Eloquent\Model;

class food_bookings extends Model
{
      protected $fillable = [
        'no_of_visitors', 'quantity', 'food_type', 'request_by', 'date', 'purpose','email_key','status'];
      
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'food_type' => 'array',
    ];
    
    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo('GuestHouse\user', 'request_by');
    }
    
     /**
     * 
     */
    public function guest_info(){
        return $this->belongsToMany('GuestHouse\guest_info', 'food_booking_guest_infos', 'food_booking_id', 'guest_info_id');
    }
}
