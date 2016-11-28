<?php

namespace GuestHouse;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    /**
     * The users that belong to the role.
     */
//    public function users()
//    {
//        return $this->belongsToMany('App\User');
//    }
    protected $fillable = [
        'name', 'display_name', 'description',
    ];
}
