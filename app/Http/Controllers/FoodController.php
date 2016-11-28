<?php

namespace GuestHouse\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use GuestHouse\Http\Requests;
use GuestHouse\Http\Controllers\Controller;
use Auth;

class FoodController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function index()
   {
       if(Auth::check()) {
            $foods = DB::table('foods')
                    ->paginate(15);
            return view('foods.index',compact('foods'));
       }else{
          return  redirect('/login');
       }
   }
   /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
   public function create()
   {
      if(Auth::check()) {
            return view('foods.create');
      }else{
          return  redirect('/login');
       }
   }
   /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
   public function store(Request $request)
   {
       $this->validate($request, [
            'name' => 'required|unique:foods|max:255',
            'description' => 'max:255',
            'price' => 'required',
        ]);
        
        $foods = $request->all();
        \GuestHouse\food::create($foods);
        return redirect('food');
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function show($id)
   {
      $foods = \GuestHouse\food::find($id); 
      return view('foods.show',compact('foods'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function edit($id)
   {
      $foods = \GuestHouse\food::find($id);
      return view('foods.edit',compact('foods'));
   }
   /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function update(Request $request, $id)
   {
      $update_foods = $request->all();
      $foods = \GuestHouse\food::find($id);
      $foods->update($update_foods);
      return redirect('food');
   }
   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function destroy($id)
   {
       \GuestHouse\food::find($id)->delete();
       return redirect('food');   }
}
