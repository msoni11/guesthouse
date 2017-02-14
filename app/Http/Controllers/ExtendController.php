<?php

namespace GuestHouse\Http\Controllers;

use Illuminate\Http\Request;

use GuestHouse\Http\Requests;
use GuestHouse\Http\Controllers\Controller;
use GuestHouse\extend_booking;
use Input;
use Mail;
use Auth;
use DB;
use Flash;
use User;
class ExtendController extends Controller
{
    //

    public function index(Request $request)
    {

        $id = $request->id;
        $id = \GuestHouse\booking_request::find($id);
        return view('extend_booking.index',compact('id'));


    }


    public function store(Request $request)
    {

       // dd($request);die;
        $extend_request = array('booking_requests_id' => $request->booking_requests_id,
            'extend_days' => $request->extend_days,
            'status' => $request->status);
        $id = $request->booking_requests_id;
        $info = \GuestHouse\extend_booking::create($extend_request);

        if ($request->status == 1 )
        {
            $this->SendConfirmationToOwner($request);
        }


            return redirect('booking_request');

    }


    public function SendConfirmationToOwner($request)
    {

        //$user = User::findOrFail($user_id);
       // dd($extend_request);die;
        $owner = DB::table('users')
            ->leftjoin('role_users', 'users.id', '=', 'role_users.user_id')
            ->leftjoin('roles', 'roles.id', '=', 'role_users.role_id')
            //->where('users.location', '=', Auth::user()->location)
            ->Where('roles.name', '=', 'owner')
            ->select(DB::raw('users.*'))->first();

        $reception = DB::table('users')
            ->leftjoin('role_users', 'role_users.user_id', '=', 'users.id')
            ->leftjoin('roles', 'role_users.role_id', '=', 'roles.id')
            ->where('users.location', '=', Auth::user()->location)
            ->where('roles.name', '=', 'receptionist')
            ->select(DB::raw('users.*'))->first();

        $user = DB::table('users')
            ->leftjoin('role_users', 'role_users.user_id', '=', 'users.id')
            ->leftjoin('roles', 'role_users.role_id', '=', 'roles.id')
            ->where('users.location', '=', Auth::user()->location)
            ->where('roles.name', '=', 'employee')
            ->select(DB::raw('users.*'))->first();

        $id = $request->booking_requests_id;
        $booking_request = \GuestHouse\booking_request::find($id);
        //$user = \GuestHouse\User::findOrFail();
        $guest_info = \GuestHouse\booking_request::find($id)->guest_info()->get();
        $status = 'Rejected';
        if($booking_request->status == 1 || $booking_request->status == 2)
        {
            $status = 'Extend';
        }
        $extend_request = DB::table('extend_bookings')
            ->where('extend_bookings.booking_requests_id','=',$id)
            ->select(DB::raw('extend_bookings.*'))->first();

        if($extend_request->status == 1)
        {
            $links = ['accept' => url('extend_booking/approveextenddays/?extend_person_id=' . $reception->id . '&booking_request_id=' . $request->booking_requests_id . '&extend_days=' . $request->extend_days . '&status=' . $request->status), 'reject' => url('extend_booking/cancelextenddays/?user_id=' . $user->id . '&booking_request_id=' . $request->booking_requests_id . '&status=' . $request->status)];
            //dd($links);die;
            $emails = [$owner->email];
            $mail = Mail::send('emails.extend_booking', ['request' => $request, 'links' => $links], function ($m) use ($emails, $status) {
                $m->from('support@hzl.com', 'GHMS Team');
                $m->to($emails)->subject('Guesthouse Stay Room Booking ' . $status);
            });
        }

       elseif($extend_request->status == 2 || $extend_request->status == 3)
       {
           return redirect('booking_request');
       }

    }


    public function ApproveExtendDays(Request $request)
    {
        $id = intval($request->booking_request_id);
        $extend_request = DB::table('extend_bookings')
            ->where('extend_bookings.booking_requests_id','=',$id)
            ->select(DB::raw('extend_bookings.*'))->first();

        if($extend_request->status == 2)
        {
            return redirect('booking_request');
        }

        else

            {
               $update_guest_status = array('status' => 2);
               $extend_info = \GuestHouse\extend_booking::find($extend_request->id);
               $res = $extend_info->update($update_guest_status);
               $extend_request_info = DB::table('extend_bookings')
                   ->where('extend_bookings.id', '=', $extend_request->id)
                   ->select(DB::raw('extend_bookings.*'))->first();
               $this->SendConfirmationToReception($extend_request_info);
            }

        return redirect('booking_request');
    }

    public function CancelExtendDays(Request $request)
    {
        //dd($request);die;

        $id = intval($request->booking_request_id);
        $extend_request = DB::table('extend_bookings')
            ->where('extend_bookings.booking_requests_id','=',$id)
            ->select(DB::raw('extend_bookings.*'))->first();

        if($extend_request->status == 2){

            return redirect('booking_request');
        }

        else {
            $update_guest_status = array('status' => 3);

            $extend_info = \GuestHouse\extend_booking::find($extend_request->id);

            $res = $extend_info->update($update_guest_status);

            $extend_request_info = DB::table('extend_bookings')
                ->where('extend_bookings.id', '=', $extend_request->id)
                ->select(DB::raw('extend_bookings.*'))->first();
            $this->SendCancemaillToUser($extend_request_info);
        }

        return redirect('booking_request');

    }


    Public function SendConfirmationToReception($extend_request_info)
    {

       if($extend_request_info->status==2)
       {
           $reception = DB::table('users')
               ->leftjoin('role_users', 'role_users.user_id', '=', 'users.id')
               ->leftjoin('roles', 'role_users.role_id', '=', 'roles.id')
               ->where('users.location', '=', Auth::user()->location)
               ->where('roles.name', '=', 'receptionist')
               ->select(DB::raw('users.*'))->first();

           $emails = [$reception->email];
           $mail = Mail::send('emails.extend_booking', ['request' => $extend_request_info], function ($m) use ($emails) {
               $m->from('support@hzl.com', 'GHMS Team');
               $m->to($emails)->subject('Guesthouse Stay Room Booking ');
           });
       }
    }

    public function SendCancemaillToUser($extend_request_info)
    {

        if($extend_request_info->status==3)
        {

            $user = DB::table('users')
                ->leftjoin('role_users', 'role_users.user_id', '=', 'users.id')
                ->leftjoin('roles', 'role_users.role_id', '=', 'roles.id')
                ->where('users.location', '=', Auth::user()->location)
                ->where('roles.name', '=', 'employee')
                ->select(DB::raw('users.*'))->first();

            $emails = [$user->email];
            $mail = Mail::send('emails.extend_booking', ['request' => $extend_request_info], function ($m) use ($emails) {
                $m->from('support@hzl.com', 'GHMS Team');
                $m->to($emails)->subject('Guesthouse Stay Room Booking ');
            });
        }
    }
}
