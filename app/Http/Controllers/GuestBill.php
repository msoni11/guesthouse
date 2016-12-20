<?php

namespace App\Http\Controllers;

use GuestHouse\food_served;
use GuestHouse\guest_info;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {

        $users = DB::table('food_serveds')
            ->join('foods', 'food_serveds.id', '=', 'foods.id')
            ->join('guest_info', 'guest_info.id', '=', 'food_serveds.id')
            ->select('food_serveds.*','food_id','id')
            ->get();

        print_r($users);die;
        }

       }
