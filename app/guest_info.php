<?php

namespace GuestHouse;

use Illuminate\Database\Eloquent\Model;

class guest_info extends Model
{
    //
    protected $fillable = [
        'name', 'contact_no', 'email', 'address', 'document_type', 'doc', 'finger_print', 'status','guest_photo','served'
    ];
    
     /**
     * 
     */
    public function booking_request(){
        return $this->belongsTo('GuestHouse\booking_request');
    }
}
