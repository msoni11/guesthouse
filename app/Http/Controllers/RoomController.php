<?php

namespace GuestHouse\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use GuestHouse\Http\Requests;
use GuestHouse\Http\Controllers\Controller;

class RoomController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function index()
   {
       $rooms = DB::table('rooms')
               ->join('guest_houses', 'rooms.guest_house_id', '=', 'guest_houses.id')
               ->select(DB::raw('guest_houses.name as guest_house_name, guest_houses.id as guest_house_id, rooms.*'))
               ->paginate(10);
       return view('room.index',compact('rooms'));
   }
   /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
   public function create()
   {
      $guesthouses = \GuestHouse\GuestHouse::lists('name', 'id');  
      return view('room.create', compact('guesthouses'));
   }
   /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
   public function store(Request $request)
   {
       $this->validate($request, [
            'room_no' => 'required|unique:rooms|max:100',
            'guest_house_id' => 'required',
        ]);
        $room = $request->all();
        \GuestHouse\Room::create($room);
        return redirect('room');
   }
   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function show($id)
   {
      $rooms =  \GuestHouse\Room::find($id); 
      $guesthouse = \GuestHouse\Room::find($id)->guesthouse->first();
      return view('room.show',compact('rooms'), compact('guesthouse'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function edit($id)
   {
      $guesthouse = \GuestHouse\GuestHouse::lists('name', 'id');  
      $rooms = \GuestHouse\Room::find($id);
      return view('room.edit',compact('rooms'), compact('guesthouse'));
   }
   /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function update(Request $request, $id)
   {
      $update_room = $request->all();
      $room = \GuestHouse\Room::find($id);
      $room->update($update_room);
      return redirect('room');
   }
   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function destroy($id)
   {
       \GuestHouse\Room::find($id)->delete();
       return redirect('room');
   }
}
