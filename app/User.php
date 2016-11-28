<?php

namespace GuestHouse;

use Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;


class User extends Authenticatable
{
    use EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password','contact_no', 'address', 'designation', 'reg_date', 'status', 'location'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
    
    /**
     * Get the phone record associated with the user.
     */
    public function guesthouse()
    {
        return $this->hasOne('GuestHouse\GuestHouse');
    }
    
    /**
     * Get the phone record associated with the user.
     */
    public function booking_request()
    {
        return $this->hasOne('GuestHouse\booking_request');
    }
    
     
    /**
     * 
     * @return type 
     */
    public function check_role(){
        $roles_arr = array();
        if(Auth::check()) {
            $roles = $this::find(Auth::user()->id)->roles()->orderBy('name')->get();
            foreach($roles as $role){
                $roles_arr[] =  $role->name;
            }
        }
         return $roles_arr;
        
    }
}
