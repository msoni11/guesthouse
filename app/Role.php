<?php

namespace GuestHouse;

use Zizaco\Entrust\EntrustRole;
use Zizaco\Entrust\Traits\EntrustRoleTrait;

class Role extends EntrustRole
{
    use EntrustRoleTrait;
    /**
     * The users that belong to the role.
     */
//    public function users()
//    {
//        return $this->belongsToMany('GuestHouse\User');
//    }
    
     protected $fillable = [
        'name', 'display_name', 'description',
    ];
}
