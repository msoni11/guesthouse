<?php

namespace GuestHouse;

use Illuminate\Database\Eloquent\Model;

class GuestHouse extends Model
{
    //
    protected $fillable = [
        'name', 'description', 'user_id', 'status',
    ];
    
     /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo('GuestHouse\User');
    }
    
    /**
     * Get the user that owns the phone.
     */
    public function room()
    {
        return $this->hasMany('GuestHouse\Room');
    }
}
