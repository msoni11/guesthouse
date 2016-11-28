<?php

namespace GuestHouse\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use GuestHouse\Http\Requests;
use GuestHouse\GuestHouse;
use GuestHouse\Http\Controllers\Controller;
use Auth;

class GuestHouseController extends Controller
{
    public function __construct() {
        if(!Auth::check()){
            redirect('/login');
        }
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function index()
   {
       if(!Auth::check()){
            redirect('/login');
        }
       $guesthouse = DB::table('guest_houses')
               ->join('users', 'users.id', '=', 'guest_houses.user_id')
               ->select(DB::raw('guest_houses.*, users.name as user_name'))
               ->paginate(10);
       return view('guesthouse.index',compact('guesthouse'));
   }
   /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
   public function create()
   {
      $users = \GuestHouse\User::lists('name', 'id');  
      return view('guesthouse.create', compact('users'));
   }
   /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
   public function store(Request $request)
   {
       $this->validate($request, [
            'name' => 'required|unique:guest_houses|max:255',
            'description' => 'required',
        ]);
        $guesthouse = $request->all();
        GuestHouse::create($guesthouse);
        return redirect('guesthouse');
   }
   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function show($id)
   {
      $guesthouse=  GuestHouse::find($id); 
      $users = GuestHouse::find($id)->user->first();
      return view('guesthouse.show',compact('guesthouse'), compact('users'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function edit($id)
   {
      $users = \GuestHouse\User::lists('name', 'id');   
      $guesthouse = GuestHouse::find($id);
      return view('guesthouse.edit',compact('guesthouse'), compact('users'));
   }
   /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function update(Request $request, $id)
   {
      $update_guesthouse = $request->all();
      $guesthouse = GuestHouse::find($id);
      $guesthouse->update($update_guesthouse);
      return redirect('guesthouse');
   }
   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function destroy($id)
   {
       GuestHouse::find($id)->delete();
       return redirect('guesthouse');
   }
}
