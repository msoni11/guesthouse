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
        $from_date = date('Y/m/d 00:00:00', strtotime('-10 day'));
        $to_date = date('Y/m/d 23:59:59');

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

        if(isset($request->status) && $request->status != ''){
         $food_booking = DB::table('food_bookings')
             ->leftjoin('users', 'users.id', '=', 'food_bookings.request_by')
             ->leftjoin('users as huser', 'huser.id', '=', 'food_bookings.hod_id')
             ->where('food_bookings.request_by', '=', Auth::user()->id)
             ->Where('food_bookings.status', '=', $request->status)
             ->wherebetween('food_bookings.created_at', [$from_date, $to_date])
             ->select(DB::raw('food_bookings.*, users.name as user_name, huser.name as hod_name'))
             ->paginate(10);

        } else {
         $food_booking = DB::table('food_bookings')
             ->leftjoin('users', 'users.id', '=', 'food_bookings.request_by')
             ->leftjoin('users as huser', 'huser.id', '=', 'food_bookings.hod_id')
             ->where('food_bookings.request_by', '=', Auth::user()->id)
             ->wherebetween('food_bookings.created_at', [$from_date, $to_date])
             ->select(DB::raw('food_bookings.*, users.name as user_name, huser.name as hod_name'))
             ->paginate(10);
        }
    } else {
        return redirect('/login');
    }
    return view('food_booking.index',compact('food_booking'), compact('search_form_data_arr'));
   }
   
   /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
   public function create(){
       
       $users = \GuestHouse\User::lists('name', 'id');
       $hods = DB::table('users')
           ->join('role_users', 'role_users.user_id', '=', 'users.id')
           ->join('roles', 'role_users.role_id', '=', 'roles.id')
           ->where('users.location', Auth::user()->location)
           ->where('users.id', '!=', Auth::user()->id)
           ->where('roles.name', '=', 'hod')
           ->lists('users.name', 'users.id');
      return view('food_booking.create', compact('users'), compact('hods'));
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
           'purpose' => 'required',
           'food_type' => 'required',
           'contact_no' => 'digits_between:9,12',
       ]);
       $req = $request->all();
       $req['email_key'] = str_random(30);
       $food_request = $req;
       $res = \GuestHouse\food_bookings::create($food_request);
       $this->SendBookingEmail($res->hod_id, $res->id); // This email should go to HOD.
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

       if (isset($request->status)) {
           if($request->status == 1 || $request->status == 2) {
               Flash::message('Booking Accepted');
           } else if($request->status == 0){
               Flash::message('Booking Rejected');
           }

           if ($request->status == 2) {
               $this->SendConfirmationToOwner($id);
           } else {
               $this->SendConfirmationEmail($id);
           }
           return redirect('food_booking/requests');
       }

       if (isset($request->served)) {
           if ($request->served == 1) {
               Flash::message('Food Served');
           } else {
               Flash::message('Food Not Served');
           }
           return redirect('/food_booking/foodpending');
       }
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
   public function UpdateStatusByHOD(Request $request, $id)
   {   
      $update_food_booking_request = array('email_key'=>'', 'status'=>$request->status);
      $food_booking = \GuestHouse\food_bookings::find($id);
      
      
      if(isset($food_booking->email_key) && $food_booking->email_key == $request->val) {
        $food_booking->update($update_food_booking_request);
        Flash::message('Booking Rejected');
        if($request->status == 2) {
            Flash::message('Booking Accepted');
        }
      } else {
          Flash::error('Error Occured');
          return redirect('food_booking');
      }
      
      $this->SendConfirmationToOwner($id);
    
      return redirect('food_booking');
   }   
   //-----------------------------------------------------------------------------------------------------------------------------------

    /**
     * Update the accept/reject in the table.
     *
     * @param  int  $id
     * @return Response
     */
    public function UpdateStatusByOwner(Request $request, $id)
    {
        $update_food_booking_request = array('email_key'=>'', 'status'=>$request->status);
        $food_booking = \GuestHouse\food_bookings::find($id);

        if(isset($food_booking->email_key) && $food_booking->email_key == $request->val) {
            $food_booking->update($update_food_booking_request);
            Flash::message('Booking Rejected');
            if($request->status == 1) {
                Flash::message('Booking Accepted');
            }
        } else {
            Flash::error('Error Occured');
            return redirect('food_booking');
        }
        $this->SendConfirmationEmail($id);
        return redirect('food_booking');
    }   
    
    /**
     * Send an e-mail reminder to the user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function SendConfirmationToOwner($id)
    {
        $owner = DB::table('users')
            ->leftjoin('role_users', 'users.id', '=', 'role_users.user_id')
            ->leftjoin('roles', 'roles.id', '=', 'role_users.role_id')
            ->where('users.location', '=', Auth::user()->location)
            ->Where('roles.name', '=', 'owner')
            ->select(DB::raw('users.*'))->first();
        $users = \GuestHouse\food_bookings::find($id)->user->first();
        $food_bookings = \GuestHouse\food_bookings::find($id);
        $links = ['accept'=>url('/food_bookings/updatebyowner/'.$id.'?val='.$food_bookings->email_key.'&status=1'),'reject'=>url('/food_bookings/updatebyowner/'.$id.'?val='.$food_bookings->email_key.'&status=0')];

        $emails = [$owner->email];
        $mail = Mail::send('emails.food_bookings', ['users'=> $users, 'food_bookings'=> $food_bookings, 'links'=>$links], function ($m) use ($emails) {
            $m->from('support@hzl.com', 'GHMS Team');
            $m->to($emails)->subject('Guesthouse Food Booking Request');
        });
    }


   /**
     * Send an e-mail reminder to the user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function SendBookingEmail($user_id, $id)
    {
        $owner = \GuestHouse\User::findOrFail($user_id);
        $users = \GuestHouse\food_bookings::find($id)->user->first();
        $food_bookings = \GuestHouse\food_bookings::find($id);
        $links = ['accept'=>url('/food_bookings/updatestatus/'.$id.'?val='.$food_bookings->email_key.'&status=2'),'reject'=>url('/food_bookings/updatestatus/'.$id.'?val='.$food_bookings->email_key.'&status=0')];
        
        $emails = [$owner->email];
        $mail = Mail::send('emails.food_bookings', ['users'=> $users, 'food_bookings'=> $food_bookings, 'links'=>$links], function ($m) use ($emails) {
            $m->from('support@hzl.com', 'GHMS Team');
            $m->to($emails)->subject('Guesthouse Food Booking Request');
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
            $m->to($emails)->subject('Guesthouse Food Booking Request '. $status);
        });
    }//function
    //---------------------------------------------------------------------------------------------------------------------

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function requests(Request $request)
    {
        $from_date = date('Y/m/d 00:00:00', strtotime('-10 day'));
        $to_date = date('Y/m/d 23:59:59');

        if (isset($request->from_date) && $request->from_date==''){
            $from_date = $request->from_date .' 00:00:00';
        } else if(isset($request->from_date)) {
            $from_date = $request->from_date .' 00:00:00';
        }

        if (isset($request->to_date) && $request->to_date==''){
            $to_date = $request->to_date . ' 23:59:59';
        } elseif(isset($request->to_date)) {
            $to_date = $request->to_date . ' 23:59:59';
        }

        $search_form_data_arr = array('from_date'=>$from_date, 'to_date'=>$to_date, 'status'=>$request->status, 'check_role'=>0);

        $user = new \GuestHouse\User;
        $search_form_data_arr['check_role'] =  $user->check_role();

        if(in_array('admin',  $search_form_data_arr['check_role']) || in_array('owner', $search_form_data_arr['check_role'])) { // check role
            if(isset($request->status) && $request->status != ''){
                $food_booking = DB::table('food_bookings')
                    ->leftjoin('users', 'users.id', '=', 'food_bookings.request_by')
                    ->leftjoin('users as huser', 'huser.id', '=', 'food_bookings.hod_id')
                    ->Where('food_bookings.status', '=', $request->status)
                    ->wherebetween('food_bookings.created_at', [$from_date, $to_date])
                    ->select(DB::raw('food_bookings.*, users.name as user_name, huser.name as hod_name'))
                    ->paginate(10);
            } else {
                $food_booking = DB::table('food_bookings')
                    ->leftjoin('users', 'users.id', '=', 'food_bookings.request_by')
                    ->leftjoin('users as huser', 'huser.id', '=', 'food_bookings.hod_id')
                    ->wherebetween('food_bookings.created_at', [$from_date, $to_date])
                    ->select(DB::raw('food_bookings.*, users.name as user_name, huser.name as hod_name'))
                    ->paginate(10);
            }
        } elseif(in_array('hod', $search_form_data_arr['check_role'])) {
            if(isset($request->status) && $request->status != ''){
                $food_booking = DB::table('food_bookings')
                    ->leftjoin('users', 'users.id', '=', 'food_bookings.request_by')
                    ->leftjoin('users as huser', 'huser.id', '=', 'food_bookings.hod_id')
                    ->Where('food_bookings.status', '=', $request->status)
                    ->where('food_bookings.hod_id', '=', Auth::user()->id)
                    ->wherebetween('food_bookings.created_at', [$from_date, $to_date])
                    ->select(DB::raw('food_bookings.*, users.name as user_name, huser.name as hod_name'))
                    ->paginate(10);
            } else {
                $food_booking = DB::table('food_bookings')
                    ->leftjoin('users', 'users.id', '=', 'food_bookings.request_by')
                    ->leftjoin('users as huser', 'huser.id', '=', 'food_bookings.hod_id')
                    ->where('food_bookings.hod_id', '=', Auth::user()->id)
                    ->wherebetween('food_bookings.created_at', [$from_date, $to_date])
                    ->select(DB::raw('food_bookings.*, users.name as user_name, huser.name as hod_name'))
                    ->paginate(10);
            }
        } else {
            return  redirect('/login');
        }

        return view('food_booking.requests',compact('food_booking'), compact('search_form_data_arr'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function FoodPending(request $request) {
        $user = new \GuestHouse\User;
        $userRole = $user->check_role();
        if(Auth::check()) {
            if (in_array('admin',  $userRole) || in_array('owner',  $userRole) || in_array('receptionist',  $userRole)) {
                $status = 1;

                $from_date = date('Y/m/d 00:00:00', strtotime('-1 day'));
                $to_date = date('Y/m/d 23:59:59', strtotime('+1 day'));

                if (isset($request->from_date) && $request->from_date !== '') {
                    $from_date = $request->from_date . ' 00:00:00';
                }

                if (isset($request->to_date) && $request->to_date !== '') {
                    $to_date = $request->to_date . ' 23:59:59';
                }

                if (isset($request->reset)) {
                    $from_date = date('Y/m/d 00:00:00', strtotime('-1 day'));
                    $to_date = date('Y/m/d 23:59:59', strtotime('+1 day'));
                }

                $search_form_data_arr = array('from_date' => $from_date, 'to_date' => $to_date, 'status' => 1);

                $food_bookings = DB::table('food_bookings')
                    ->join('users', 'food_bookings.request_by', '=', 'users.id')
                    ->where('food_bookings.date', '>', $from_date)
                    ->where('food_bookings.date', '<', $to_date)
                    ->where('food_bookings.status', '=', $status)
                    ->select(DB::raw('food_bookings.*, users.name as request_by'))
                    ->orderby('food_bookings.id', 'desc')
                    ->paginate(20);

                return view('food_booking.foodpending', compact('food_bookings', 'search_form_data_arr'));
            } else {
                return redirect('food_booking');
            }
        } else {
            return  redirect('/login');
        }
    }
}
