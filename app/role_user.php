<?php

namespace GuestHouse;

use Illuminate\Database\Eloquent\Model;

class role_user extends Model
{
    //
     protected $fillable = [
        'role_id', 'user_id'
    ];
}
