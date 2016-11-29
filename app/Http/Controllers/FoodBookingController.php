<?php

namespace GuestHouse\Http\Controllers;

use Illuminate\Http\Request;

use GuestHouse\Http\Requests;

use Flash;

use DB;

Use Mail;

use Auth;

class FoodBookingController extends Controller
{
     /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function index(Request $request)
   {
     if(Auth::check()){  
       
       $status = '';
       $from_date = date('Y/m/d 00:00:00');
       $to_date = date('Y/m/d 23:59:59', strtotime('+10 day'));
       
       if(isset($request->from_date) && $request->from_date==''){
           $from_date = $request->from_date .' 00:00:00';
       } else if(isset($request->from_date)) {
           $from_date = $request->from_date .' 00:00:00';
       }
       
       if(isset($request->to_date) && $request->to_date==''){
           $to_date = $request->to_date . ' 23:59:59';
       } elseif(isset($request->to_date)) {
           $to_date = $request->to_date . ' 23:59:59';
       }
       $search_form_data_arr = array('from_date'=>$from_date, 'to_date'=>$to_date, 'status'=>$request->status, 'check_role'=>0);
       //$search_form_data_arr = $request->all();
       $user = new \GuestHouse\User;
       $search_form_data_arr['check_role'] =  $user->check_role();   
       
       if(in_array('admin',  $search_form_data_arr['check_role']) || in_array('owner', $search_form_data_arr['check_role'])) { // check role
            if(isset($request->status) && $request->status != ''){
                 $food_booking = DB::table('food_bookings')
                    ->join('users', 'users.id', '=', 'food_bookings.request_by')
                    ->Where('food_bookings.status', '=', $request->status)  
                    ->wherebetween('food_bookings.date', [$from_date, $to_date])
                    ->select(DB::raw('food_bookings.*, users.name as user_name'))
                    ->paginate(10);

            } else {
                     $food_booking = DB::table('food_bookings')   
                   ->join('users', 'users.id', '=', 'food_bookings.request_by')          
                    ->wherebetween('food_bookings.date', [$from_date, $to_date])
                    ->select(DB::raw('food_bookings.*, users.name as user_name'))
                    ->paginate(10);
            } 
       } else {
             if(isset($request->status) && $request->status != ''){
                 $food_booking = DB::table('food_bookings')
                    ->join('users', 'users.id', '=', 'food_bookings.request_by')
                    ->where('food_bookings.request_by', '=', Auth::user()->id)     
                    ->Where('food_bookings.status', '=', $request->status)  
                    ->wherebetween('food_bookings.date', [$from_date, $to_date])   
                    ->select(DB::raw('food_bookings.*, users.name as user_name'))
                    ->paginate(10);
                // dd($food_booking);

            } else { 
                     $food_booking = DB::table('food_bookings')
                    ->join('users', 'users.id', '=', 'food_bookings.request_by')      
                    ->where('food_bookings.request_by', '=', Auth::user()->id)          
                    ->wherebetween('food_bookings.date', [$from_date, $to_date])
                    ->select(DB::raw('food_bookings.*, users.name as user_name'))
                    ->paginate(10);
                    // dd($food_booking);
            }
       }
       
       return view('food_booking.index',compact('food_booking'), compact('search_form_data_arr'));
     } else {
         return redirect('/login');
     }
   }
   
   /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
   public function create(){
       
       $users = \GuestHouse\User::lists('name', 'id');  
      return view('food_booking.create', compact('users'));
   }
   
    /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
   public function store(Request $request)
   {
       $this->validate($request, [
            'no_of_visitors' => 'required',
            'date' => 'required',
            'name.*' => 'string',
            'email.*' => 'email',
            'contact_no.*' => 'digits_between:9,12',
        ]);
        $req = $request->all();
        $req['email_key'] = str_random(30);
        $food_request =  $req;
        $res = \GuestHouse\food_bookings::create($food_request); 
        if(isset($request->name)) {
            for($i=1; $i<count($request->name)+1; $i++){
                $guest_info = array('name'=>$request->name[$i], 
                                    'contact_no'=>$request->contact_no[$i],
                                    'email'=>$request->email[$i],
                                    'address'=>$request->address[$i],
                                    'status'=>1    
                                );
                $guest_res = \GuestHouse\guest_info::create($guest_info);
                $food_booking_req_guest_info = array('food_booking_id'=>$res->id, 'guest_info_id'=>$guest_res->id); 
                \GuestHouse\food_booking_guest_info::create($food_booking_req_guest_info);
            }
        }
       //$this->SendBookingEmail(1, $res->id);
       Flash::message('Booking Submited successfully!');
       return redirect('food_booking');
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
      $food_booking = \GuestHouse\food_bookings::find($id);
      $guest_info =  \GuestHouse\food_bookings::find($id)->guest_info()->get();

      return view('food_booking.edit',compact('food_booking','users', 'guest_info'));
   }
   
    /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function update(Request $request, $id)
   {        
      $update_food_booking = $request->all();
      //$update_food_booking['email_key'] = str_random(30);
      $food_booking = \GuestHouse\food_bookings::find($id);
      $food_booking->update($update_food_booking);
      if(isset($request->name)) {
        for($i=0; $i<count($request->name); $i++){
            if(isset($request->guest_id[$i])) {
              $guest_info_req = array('name'=>$request->name[$i], 
                                    'contact_no'=>$request->contact_no[$i],
                                    'email'=>$request->email[$i],
                                    'address'=>$request->address[$i],
                                    'status'=>1      
                                );
              $guest_info = \GuestHouse\guest_info::find($request->guest_id[$i]);
              $guest_info->update($guest_info_req);
            } else {
               $guest_info_req = array('name'=>$request->name[$i], 
                                    'contact_no'=>$request->contact_no[$i],
                                    'email'=>$request->email[$i],
                                    'address'=>$request->address[$i],
                                    'status'=>1        
                                );
              $guest_res = \GuestHouse\guest_info::create($guest_info_req); 
              $food_booking_guest_info = array('food_booking_id'=>$id, 'guest_info_id'=>$guest_res->id); 
              \GuestHouse\food_booking_guest_info::create($food_booking_guest_info);
            }

        }      
      }
      
      //Flash::message('Booking Rejected');
      if($request->status == 1) {
         Flash::message('Booking Acceped');
       }else if($request->status == 0){
         Flash::message('Booking Rejected');
       }
       
       $this->SendConfirmationEmail($id);
      return redirect('food_booking');
      
   }//function
   //-------------------------------------------------------------------------------------------------------------------------------
   
      
   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function destroy($id)
   {
       \GuestHouse\food_bookings::find($id)->delete();
       return redirect('food_booking');
   }//function
   //-------------------------------------------------------------------------------------------------------------------
   
      /**
    * Update the accept/reject in the table.
    *
    * @param  int  $id
    * @return Response
    */
   public function UpdateStatus(Request $request, $id)
   {   
       
      $update_food_booking_request = array('email_key'=>'', 'status'=>$request->status);
      $food_booking = \GuestHouse\food_bookings::find($id);
      
      
      if(isset($food_booking->email_key) && $food_booking->email_key == $request->val) {
        $food_booking->update($update_food_booking_request);
        Flash::message('Booking Rejected');
        if($request->status == 1) {
            Flash::message('Booking Acceped');
        }
      } else {
          Flash::error('Error Occured');
          return redirect('food_booking');
      }
      
      $this->SendConfirmationEmail($id);
    
      return redirect('food_booking');
   }//function   
   //-----------------------------------------------------------------------------------------------------------------------------------
   
   /**
     * Send an e-mail reminder to the user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function SendBookingEmail($user_id, $id)
    {
        $user = \GuestHouse\User::findOrFail($user_id);
        $owner = \GuestHouse\User::findOrFail(2);
        $users = \GuestHouse\food_bookings::find($id)->user->first();
        $food_bookings = \GuestHouse\food_bookings::find($id);
        $guest_info = \GuestHouse\food_bookings::find($id)->guest_info()->get();
        $links = ['accept'=>url('/food_bookings/updatestatus/'.$id.'?val='.$food_bookings->email_key.'&status=1'),'reject'=>url('/food_bookings/updatestatus/'.$id.'?val='.$food_bookings->email_key.'&status=0')];
        
        $emails = [$user->email, $owner->email, 'test1@gmail.com', 'test2@gmail.com'];
        $mail = Mail::send('emails.food_bookings', ['users'=> $users, 'food_bookings'=> $food_bookings, 'guest_info'=>$guest_info, 'links'=>$links], function ($m) use ($emails) {
            $m->from('support@hzl.com', 'GHMS Team');
            $m->to($emails)->subject('New Food Booking Request');
        });
    }//function
    //---------------------------------------------------------------------------------------------------------------------
    
    /**
     * Send an e-mail reminder to the user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function SendConfirmationEmail($id)
    {
        $users = \GuestHouse\food_bookings::find($id)->user->first();
        $food_bookings = \GuestHouse\food_bookings::find($id);
        $user = \GuestHouse\User::findOrFail($food_bookings->request_by);
        $guest_info = \GuestHouse\food_bookings::find($id)->guest_info()->get();
        $status = 'Rejected'; 
        if($food_bookings->status == 1) { 
          $status = 'Accepted';
        }
        
        $emails = [$user->email];
        $mail = Mail::send('emails.food_bookings_confirm', ['users'=> $users, 'food_bookings'=> $food_bookings, 'guest_info'=>$guest_info], function ($m) use ($emails, $status) {
            $m->from('support@hzl.com', 'GHMS Team');
            $m->to($emails)->subject('Food Booking Request '. $status);
        });
    }//function
    //---------------------------------------------------------------------------------------------------------------------
}
