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

        //dd($request);die;
        $extend_request = array('booking_requests_id' => $request->booking_requests_id,
            'extend_days' => $request->extend_days,
            'status' => $request->status);
        $id = $request->booking_requests_id;
        $info = \GuestHouse\extend_booking::create($extend_request);
        if ($request->status == 1)
        {
            $this->SendConfirmationToOwner($request);

        }
        else
        {
            Flash::error('Error Occured');
            return redirect('booking_request');

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
        $id = $request->booking_requests_id;
        $booking_request = \GuestHouse\booking_request::find($id);
        //$user = \GuestHouse\User::findOrFail();
        $guest_info = \GuestHouse\booking_request::find($id)->guest_info()->get();
        $status = 'Rejected';
        if($booking_request->status == 1 || $booking_request->status == 2) {
            $status = 'Extend';
        }

        $emails = [$owner->email];
        $mail = Mail::send('emails.extend_booking',['request'=>$request], function ($m) use ($emails, $status) {
            $m->from('support@hzl.com', 'GHMS Team');
            $m->to($emails)->subject('Guesthouse Stay Room Booking '. $status);
        });
    }

    /*    public function show()
        {



        }

        public function edit()
        {




        }

        public function update()
        {





        }*/



}
