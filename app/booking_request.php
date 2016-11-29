<?php

namespace GuestHouse;

use Illuminate\Database\Eloquent\Model;

class booking_request extends Model
{
    //
    protected $fillable = [
        'no_of_visitors', 'required_room', 'type_of_guest', 'check_in_date', 'check_out_date', 'food_order', 'org_name_address', 'purpose', 'remark', 'request_by', 'status', 'email_key', 'hod_id'];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'food_order' => 'array',
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
        return $this->belongsToMany('GuestHouse\guest_info', 'booking_request_guest_infos', 'booking_request_id', 'guest_info_id');
    }
}
