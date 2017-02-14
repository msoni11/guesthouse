<?php

namespace GuestHouse\Http\Controllers;

use Auth;
use Zizaco\Entrust\Entrust;
use Illuminate\Http\Request;
use DB;
use GuestHouse\Http\Requests;
use GuestHouse\Http\Controllers\Controller;
use GuestHouse\User;
use \GuestHouse\guest_info;
use \GuestHouse\booking_request_guest_info;
use Input;
use Mail;
use Laracasts\Flash\Flash;

class BookingRequestController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function index(Request $request)
   {    //dd($request);die;
       $status = '';
       $booking_request = array();
       $from_date = date('Y/m/d 00:00:00', strtotime('-10 day'));
       $to_date = date('Y/m/d 23:59:59');

       if (isset($request->from_date) && $request->from_date == '') {
           $from_date = $request->from_date . ' 00:00:00';
       } else if (isset($request->from_date)) {
           $from_date = $request->from_date . ' 00:00:00';
       }

       if (isset($request->to_date) && $request->to_date == '') {
           $to_date = $request->to_date . ' 23:59:59';
       } elseif (isset($request->to_date)) {
           $to_date = $request->to_date . ' 23:59:59';
       }

       $search_form_data_arr = array('from_date' => $from_date, 'to_date' => $to_date, 'status' => $request->status, 'check_role' => 0);
       //$search_form_data_arr = $request->all();

       $user = new \GuestHouse\User;
       $search_form_data_arr['check_role'] = $user->check_role();

       if (Auth::check()) {
           if (isset($request->status) && $request->status != '') {
               $booking_request = DB::table('booking_requests')
                   ->leftjoin('users', 'users.id', '=', 'booking_requests.request_by')
                   ->leftjoin('users as huser', 'huser.id', '=', 'booking_requests.hod_id')
                   ->where('booking_requests.request_by', '=', Auth::user()->id)
                   ->Where('booking_requests.status', '=', $request->status)
                   ->wherebetween('booking_requests.created_at', [$from_date, $to_date])
                   ->select(DB::raw('booking_requests.*, users.name as user_name, huser.name as hod_name'))
                   ->paginate(10);
               //dd($booking_request);

           } else {

                $booking_request = DB::table('booking_requests')
                   ->leftjoin('users', 'users.id', '=', 'booking_requests.request_by')
                   ->leftjoin('users as huser', 'huser.id', '=', 'booking_requests.hod_id')
                   ->leftjoin('booking_request_guest_infos','booking_request_guest_infos.booking_request_id','=','booking_requests.id')
                    ->leftjoin('guest_room_allotments','guest_room_allotments.guest_info_id','=','booking_request_guest_infos.guest_info_id')
                    ->leftjoin('guest_infos','guest_infos.id','=','guest_room_allotments.guest_info_id')
                    ->where('booking_requests.request_by', '=', Auth::user()->id)
                   ->wherebetween('booking_requests.created_at', [$from_date, $to_date])
                   ->select(DB::raw('booking_requests.*, users.name as user_name, huser.name as hod_name,guest_room_allotments.checked_in'))
                   ->paginate(10);
            //  dd($booking_request);
           }
       }


   else {
          return  redirect('/login');
       }

       return view('booking_request.index',compact('booking_request'), compact('search_form_data_arr'));
       
   }
   /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
   public function create(Request $request)
   {
       $old_data = $request->old();
       $no_of_visitors = false;
       $type_of_guest = false;

       if ($old_data) {
           if(isset($old_data['no_of_visitors'])) {
               $no_of_visitors = $old_data['no_of_visitors'];
           }
           if(isset($old_data['type_of_guest'])) {
               $type_of_guest = $old_data['type_of_guest'];
           }
       }
      $users = \GuestHouse\User::lists('name', 'id');
      $user = new \GuestHouse\User;
      $curruser = Auth::user();
      $hods = DB::table('users')
        ->join('role_users', 'role_users.user_id', '=', 'users.id')
        ->join('roles', 'role_users.role_id', '=', 'roles.id')
        ->where('users.location', Auth::user()->location)
        ->where('users.id', '!=', Auth::user()->id)
        ->where('roles.name', '=', 'hod')
        ->lists('users.name', 'users.id');
       //dd($request);die;
      return view('booking_request.create', compact('curruser', 'hods', 'old_data', 'no_of_visitors', 'type_of_guest'));
   }
   /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
   public function store(Request $request)
   {
       if ($request->get('type_of_guest') !== 'guestof') {
           $valids = [
               'no_of_visitors' => 'required',
               'check_in_date' => 'required|after:today',
               'check_out_date' => 'required|after:check_in_date',
               'name.*' => 'required',
               'contact_no.*' => 'required|digits_between:9,12',
               'required_room' => 'required',
               'type_of_guest' => 'required',
               'org_name_address'  => 'required',
               'purpose'       =>  'required|string',
               'remark'        =>  'required|string',
               'document_type.*' => 'required',
               'doc.*' => 'required',
               'address.*'       => 'required'
           ];
       } else {
           $valids = [
               'no_of_visitors' => 'required',
               'check_in_date' => 'required|after:today',
               'check_out_date' => 'required|after:check_in_date',
               'required_room' => 'required',
               'type_of_guest' => 'required',
               'org_name_address'  => 'required',
               'purpose'       =>  'required|string',
               'remark'        =>  'required|string'
           ];
       }
       $this->validate($request, $valids);
        $req = $request->all();
        $req['email_key'] = str_random(30);
        $booking_request =  $req;
        $res = \GuestHouse\booking_request::create($booking_request);        
        if(isset($request->name)) {
            for($i=1; $i<count($request->name)+1; $i++){
                $file_name = '';
                if($request->file('doc')) {
                    $files = $request->file('doc');
                    $destination = base_path().'/public/uploads/';
                    if($files[$i]) {
                        $files[$i]->move($destination, $files[$i]->getClientOriginalName());
                        $file_name = $files[$i]->getClientOriginalName();
                    }
                }
                $guest_info = array('name'=>$request->name[$i], 
                                    'contact_no'=>$request->contact_no[$i],
                                    'email'=>$request->email[$i],
                                    'address'=>$request->address[$i],
                                    'document_type'=>$request->document_type[$i],
                                    'doc'=>$file_name,
                                    'status'=>1    
                                );
                $guest_res = \GuestHouse\guest_info::create($guest_info);
                $booking_req_guest_info = array('booking_request_id'=>$res->id, 'guest_info_id'=>$guest_res->id); 
                \GuestHouse\booking_request_guest_info::create($booking_req_guest_info);
            }
        }
       $this->SendBookingEmail($res->hod_id, $res->id, 2); // This email should go to HOD.
       Flash::message('Booking Submited successfully!');
       return redirect('booking_request');
   }
   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function show($id)
   {
      $booking_request=  \GuestHouse\booking_request::find($id);
      $guest_info =  \GuestHouse\booking_request::find($id)->guest_info()->get();
      //dd($booking_request);
//      exit;
      $users = \GuestHouse\booking_request::find($id)->user->first();
      return view('booking_request.show',compact('booking_request', 'users', 'guest_info'));
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
      $booking_request = \GuestHouse\booking_request::find($id);
      $guest_info =  \GuestHouse\booking_request::find($id)->guest_info()->get();

      return view('booking_request.edit',compact('booking_request','users', 'guest_info'));
   }
   /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function update(Request $request, $id)
   {        
      $update_booking_request = $request->all();
      //$update_booking_request['email_key'] = str_random(30);
      $booking_request = \GuestHouse\booking_request::find($id);
      $booking_request->update($update_booking_request);
      if(isset($request->name)) {
        for($i=0; $i<count($request->name); $i++){
            $file_name = '';
            if($request->file('doc')) {
                $files = $request->file('doc');
                $destination = base_path().'/public/uploads/';
                if($files[$i]) {
                    $files[$i]->move($destination, $files[$i]->getClientOriginalName());
                    $file_name = $files[$i]->getClientOriginalName();
                }
            }
            if(isset($request->guest_id[$i])) {
              $guest_info_req = array('name'=>$request->name[$i], 
                                    'contact_no'=>$request->contact_no[$i],
                                    'email'=>$request->email[$i],
                                    'address'=>$request->address[$i],
                                    'document_type'=>$request->document_type[$i],
                                    'doc'=>$file_name,
                                    'status'=>1      
                                );
              $guest_info = \GuestHouse\guest_info::find($request->guest_id[$i]);
              $guest_info->update($guest_info_req);
            } else {
               $guest_info_req = array('name'=>$request->name[$i], 
                                    'contact_no'=>$request->contact_no[$i],
                                    'email'=>$request->email[$i],
                                    'address'=>$request->address[$i],
                                    'document_type'=>$request->document_type[$i],
                                    'doc'=>$file_name,
                                    'status'=>1        
                                );
              $guest_res = \GuestHouse\guest_info::create($guest_info_req); 
              $booking_req_guest_info = array('booking_request_id'=>$id, 'guest_info_id'=>$guest_res->id); 
              \GuestHouse\booking_request_guest_info::create($booking_req_guest_info);
            }

        }      
      }
      Flash::message('Booking Rejected');
        if($request->status == 1 || $request->status == 2) {
            Flash::message('Booking Accepted');
        }

       if ($request->status == 2) {
           $this->SendConfirmationToOwner($id);
       } else {
           $this->SendConfirmationEmail($id);

       }

      return redirect('booking_request/requests');
   }//function
   //-------------------------------------------------------------------------------------------------------------------------------
   
    /**
    * Update the accept/reject in the table.
    *
    * @param  int  $id
    * @return Response
    */
   public function UpdateStatusByHOD(Request $request, $id)
   {   
      $update_booking_request = array('email_key'=>'', 'status'=>$request->status);
      $booking_request = \GuestHouse\booking_request::find($id);
      if(isset($booking_request->email_key) && $booking_request->email_key == $request->val) {
        $booking_request->update($update_booking_request);
        Flash::message('Booking Rejected');
        if($request->status == 2) {
            Flash::message('Booking Accepted');
        }
      }
      else {
          Flash::error('Error Occured');
          return redirect('booking_request');
      }
      $this->SendConfirmationToOwner($id);
      return redirect('booking_request');
   }

    /**
    * Update the accept/reject in the table.
    *
    * @param  int  $id
    * @return Response
    */
   public function UpdateStatusByOwner(Request $request, $id)
   {

      $update_booking_request = array('email_key'=>'', 'status'=>$request->status);
      $booking_request = \GuestHouse\booking_request::find($id);
      
      if(isset($booking_request->email_key) && $booking_request->email_key == $request->val) {
        $booking_request->update($update_booking_request);
        Flash::message('Booking Rejected');
        if($request->status == 1) {
            Flash::message('Booking Accepted');
        }
      } else {
          Flash::error('Error Occured');
          return redirect('booking_request');
      }
      $this->SendConfirmationEmail($id);
      return redirect('booking_request');
   }//function   
   //-----------------------------------------------------------------------------------------------------------------------------------
   
   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function destroy($id)
   {
       \GuestHouse\booking_request::find($id)->delete();
       return redirect('booking_request');
   }//function
   //-------------------------------------------------------------------------------------------------------------------
   
    /**
     * Send an e-mail reminder to the user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function SendConfirmationToOwner($id)
    {
        //$user = User::findOrFail($user_id);
        $owner = DB::table('users')
              ->leftjoin('role_users', 'users.id', '=', 'role_users.user_id')
              ->leftjoin('roles', 'roles.id', '=', 'role_users.role_id')
              ->where('users.location', '=', Auth::user()->location)     
              ->Where('roles.name', '=', 'owner')
              ->select(DB::raw('users.*'))->first();
        $users = \GuestHouse\booking_request::find($id)->user->first();
        $booking_request = \GuestHouse\booking_request::find($id);
        $guest_info =  \GuestHouse\booking_request::find($id)->guest_info()->get();
        $links = ['accept'=>url('/booking_request/updatebyowner/'.$id.'?val='.$booking_request->email_key.'&status=1'),'reject'=>url('/booking_request/updatebyowner/'.$id.'?val='.$booking_request->email_key.'&status=0')];
        
        $emails = [$owner->email];
        $mail = Mail::send('emails.booking_request', ['users'=> $users, 'booking_request'=> $booking_request, 'guest_info'=>$guest_info, 'links'=>$links], function ($m) use ($emails) {
            $m->from('support@hzl.com', 'GHMS Team');
            $m->to($emails)->subject('Guesthouse Stay Room Booking');
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
        //$user = User::findOrFail($user_id);
        $owner = User::findOrFail($user_id);
        $users = \GuestHouse\booking_request::find($id)->user->first();
        $booking_request = \GuestHouse\booking_request::find($id);
        $guest_info =  \GuestHouse\booking_request::find($id)->guest_info()->get();
        $links = ['accept'=>url('/booking_request/updatestatus/'.$id.'?val='.$booking_request->email_key.'&status=2'),'reject'=>url('/booking_request/updatestatus/'.$id.'?val='.$booking_request->email_key.'&status=0')];
        
        $emails = [$owner->email];
        $mail = Mail::send('emails.booking_request', ['users'=> $users, 'booking_request'=> $booking_request, 'guest_info'=>$guest_info, 'links'=>$links], function ($m) use ($emails) {
            $m->from('support@hzl.com', 'GHMS Team');
            $m->to($emails)->subject('Guesthouse Stay Room Booking');
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
        $users = \GuestHouse\booking_request::find($id)->user->first();
        $booking_request = \GuestHouse\booking_request::find($id);
        $user = \GuestHouse\User::findOrFail($booking_request->request_by);
        $guest_info = \GuestHouse\booking_request::find($id)->guest_info()->get();
        $status = 'Rejected'; 
        if($booking_request->status == 1 || $booking_request->status == 2) { 
          $status = 'Accepted';
        }
        
        $emails = [$user->email];
        $mail = Mail::send('emails.booking_request_confirm', ['users'=> $users, 'booking_request'=> $booking_request, 'guest_info'=>$guest_info], function ($m) use ($emails, $status) {
            $m->from('support@hzl.com', 'GHMS Team');
            $m->to($emails)->subject('Guesthouse Stay Room Booking '. $status);
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
        $status = '';
        $booking_request = array();
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

        if(in_array('admin',  $search_form_data_arr['check_role']) || in_array('owner', $search_form_data_arr['check_role'])) { // check role
            if(isset($request->status) && $request->status != ''){
                $booking_request = DB::table('booking_requests')
                    ->leftjoin('users', 'users.id', '=', 'booking_requests.request_by')
                    ->leftjoin('users as huser', 'huser.id', '=', 'booking_requests.hod_id')
                    ->Where('booking_requests.status', '=', $request->status)
                    ->wherebetween('booking_requests.created_at', [$from_date, $to_date])
//                    ->orwherebetween('booking_requests.check_out_date', [$from_date, $to_date])
                    ->select(DB::raw('booking_requests.*, users.name as user_name, huser.name as hod_name'))
                    ->paginate(10);
            } else {
                $booking_request = DB::table('booking_requests')
                    ->leftjoin('users', 'users.id', '=', 'booking_requests.request_by')
                    ->leftjoin('users as huser', 'huser.id', '=', 'booking_requests.hod_id')
                    ->wherebetween('booking_requests.created_at', [$from_date, $to_date])
//                    ->orWherebetween('booking_requests.check_out_date', [$from_date, $to_date])
                    ->select(DB::raw('booking_requests.*, users.name as user_name, huser.name as hod_name'))
                    ->paginate(10);
            }
        } elseif(in_array('hod', $search_form_data_arr['check_role'])) {
            if(isset($request->status) && $request->status != ''){
                $booking_request = DB::table('booking_requests')
                    ->leftjoin('users', 'users.id', '=', 'booking_requests.request_by')
                    ->leftjoin('users as huser', 'huser.id', '=', 'booking_requests.hod_id')
                    ->Where('booking_requests.status', '=', $request->status)
                    ->where('booking_requests.hod_id', '=', Auth::user()->id)
                    ->wherebetween('booking_requests.created_at', [$from_date, $to_date])
//                    ->orwherebetween('booking_requests.check_out_date', [$from_date, $to_date])
                    ->select(DB::raw('booking_requests.*, users.name as user_name, huser.name as hod_name'))
                    ->paginate(10);
            } else {
                $booking_request = DB::table('booking_requests')
                    ->leftjoin('users', 'users.id', '=', 'booking_requests.request_by')
                    ->leftjoin('users as huser', 'huser.id', '=', 'booking_requests.hod_id')
                    ->where('booking_requests.hod_id', '=', Auth::user()->id)
                    ->wherebetween('booking_requests.created_at', [$from_date, $to_date])
//                    ->orWherebetween('booking_requests.check_out_date', [$from_date, $to_date])
                    ->select(DB::raw('booking_requests.*, users.name as user_name, huser.name as hod_name'))
                    ->paginate(10);
            }
        } else {
            return  redirect('/login');
        }

        return view('booking_request.requests',compact('booking_request'), compact('search_form_data_arr'));

    }
    
}//class
