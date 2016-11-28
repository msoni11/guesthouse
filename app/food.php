<?php

namespace GuestHouse;

use Illuminate\Database\Eloquent\Model;

class food extends Model
{
    //
    protected $fillable = ['name', 'description', 'price', 'active'];
}
