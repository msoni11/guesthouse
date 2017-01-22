<?php

namespace GuestHouse\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use GuestHouse\Http\Requests;
use GuestHouse\Http\Controllers\Controller;

class FoodServedController extends Controller
{
        /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function Index(Request $request)
   {
       $foodserved = DB::table('food_serveds')
               ->join('guest_infos', 'food_serveds.guest_info_id', '=', 'guest_infos.id')
               ->join('foods', 'food_serveds.food_id', '=', 'foods.id')
               ->select(DB::raw('food_serveds.*, guest_infos.name as name, foods.name as food_name, guest_infos.name as guest_name'))
               ->orderby('food_serveds.id', 'desc')
               ->paginate(15);
       return view('foodserved.index', compact('foodserved'));
   }//function
   //--------------------------------------------------------------------------------

   /**
    *  crate form
    */
   public function Create(Request $request){
       $users = DB::table('guest_infos')
                ->join('guest_room_allotments', 'guest_infos.id', '=', 'guest_room_allotments.guest_info_id')
                ->where('guest_room_allotments.checked_in', '=', 1)->lists('guest_infos.name', 'guest_infos.id');
       
       $foodserved = DB::table('food_serveds')
               ->join('guest_infos', 'food_serveds.guest_info_id', '=', 'guest_infos.id')
               ->join('foods', 'food_serveds.food_id', '=', 'foods.id')
               ->where('guest_infos.id', '=', $request->user_id)
               ->select(DB::raw('food_serveds.*, guest_infos.name as name, foods.name as food_name, guest_infos.name as guest_name'))
               ->paginate(15);
       //dd($users);
       //$users = \GuestHouse\guest_info::lists('name', 'id');
       $user_id = $request->user_id;
       $foods = \GuestHouse\food::lists('name', 'id');
       return view('foodserved.create', compact('users', 'foods', 'user_id', 'foodserved'));
   }//function
   
   /**
    *  crate form
    */
   public function Served(Request $request){
       $users = DB::table('guest_infos')
                ->join('food_booking_guest_infos', 'guest_infos.id', '=', 'food_booking_guest_infos.guest_info_id')->lists('guest_infos.name', 'guest_infos.id');
       
       $foodserved = DB::table('food_serveds')
               ->join('guest_infos', 'food_serveds.guest_info_id', '=', 'guest_infos.id')
               ->join('foods', 'food_serveds.food_id', '=', 'foods.id')
               ->where('guest_infos.id', '=', $request->user_id)
               ->select(DB::raw('food_serveds.*, guest_infos.name as name, foods.name as food_name, guest_infos.name as guest_name'))
               ->paginate(15);
       //dd($users);
       //$users = \GuestHouse\guest_info::lists('name', 'id');
       $user_id = $request->user_id;
       $foods = \GuestHouse\food::lists('name', 'id');
       return view('foodserved.create', compact('users', 'foods', 'user_id', 'foodserved'));
   }//function
   
   //--------------------------------------------------------------------------------
   /**
    * 
    * @param \Illuminate\Http\Request $request
    */
   public function Store(Request $request){
       $foodserveds = $request->all();
       $res = \GuestHouse\food_served::create($foodserveds);
       $food = \GuestHouse\food::find($res->food_id);
       $res->price = $food->price;
       $res->save();
       return redirect('/foodserved');
   }//function
   //-------------------------------------------------------------------------------------------
   
   /**
    * 
    * @return type
    */
    public function Edit($id, Request $request){
       $foodserved = \GuestHouse\food_served::find($id);
       $users = \GuestHouse\guest_info::lists('name', 'id');
       $foods = \GuestHouse\food::lists('name', 'id');
       return view('foodserved.edit', compact('foodserved','users', 'foods', 'request'));
    }//function
    //-----------------------------------------------------------------------------------------
    
    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @param type $id
     */
    public function update(Request $request, $id){
        $all_data = $request->all();
        $foodserved = \GuestHouse\food_served::find($id);
        $foodserved->update($all_data);
        $food = \GuestHouse\food::find($foodserved->food_id);
        $foodserved->price = $food->price;
        $foodserved->save();
        if ($request->guestroomallotmentid) {
            return redirect('/guestroomallotment/'. $request->guestroomallotmentid);
        }
        return redirect('foodserved');
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function Destroy($id, Request $request){
        \GuestHouse\food_served::find($id)->delete();
        if ($request->guestroomallotmentid) {
            return redirect('/guestroomallotment/'. $request->guestroomallotmentid);
        }
        return redirect('foodserved');
    }

}
