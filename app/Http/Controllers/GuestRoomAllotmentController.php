<?php
namespace GuestHouse\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use GuestHouse\guest_room_allotments;
use GuestHouse\Http\Requests;
use GuestHouse\Http\Controllers\Controller;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Mail;
use GuestHouse\guest_info;

class GuestRoomAllotmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function Index(Request $request)
    {
        $guestroomallotment = DB::table('guest_room_allotments')
            ->join('guest_infos', 'guest_room_allotments.guest_info_id', '=', 'guest_infos.id')
            ->join('rooms', 'guest_room_allotments.room_id', '=', 'rooms.id')
            ->where('guest_room_allotments.checked_in', '<>', 0)
            ->select(DB::raw('guest_room_allotments.*, guest_infos.name as name, rooms.room_no as room_no, rooms.room_type as room_type, guest_infos.id as user_id'))
            ->paginate(15);
        $title = 'All Checked In and Checked Out Guests';
        return view('guestroomallotment.index', compact('guestroomallotment', 'title'));
    }//function

    //--------------------------------------------------------------------------------
    /**
     *
     * @return type
     */
    public function ShowCheckOut()
    {
        $guestroomallotment = DB::table('guest_room_allotments')
            ->join('guest_infos', 'guest_room_allotments.guest_info_id', '=', 'guest_infos.id')
            ->join('rooms', 'guest_room_allotments.room_id', '=', 'rooms.id')
            ->where('guest_room_allotments.checked_in', '=', 2)
            ->select(DB::raw('guest_room_allotments.*, guest_infos.name as name, rooms.room_no as room_no, rooms.room_type as room_type'))
            ->paginate(15);
        $title = 'All Checked Out Guests';
        return view('guestroomallotment.checkout', compact('guestroomallotment', 'title'));

    }
    //--------------------------------------------------------------------------------

    /**
     *
     */
    public function Create(Request $request)
    {
        $booking_request = '';
        $guest_info = 0;
        if ($request->guest_info_id) {
            $booking_request = DB::table('booking_requests')
                ->join('booking_request_guest_infos', 'booking_requests.id', '=', 'booking_request_guest_infos.booking_request_id')
                ->join('guest_infos', 'booking_request_guest_infos.guest_info_id', '=', 'guest_infos.id')
                ->WHERE('booking_request_guest_infos.guest_info_id', '=', $request->guest_info_id)->first();
        }
        $users = \GuestHouse\guest_info::lists('name', 'id');
        $roomsall = \GuestHouse\Room::lists('room_no', 'id');
        $rooms = $roomsall->prepend('Select', '');
        $cnt_room = DB::table('guest_room_allotments')->join('rooms', 'guest_room_allotments.room_id', '=', 'rooms.id')
            ->where('guest_room_allotments.checked_in', '<', 2)
            ->groupBy('rooms.id')
            ->select(DB::raw('count(*) as cnt,rooms.id, rooms.room_no, rooms.capacity'))->get();
        $cntJson = json_encode($cnt_room);
        return view('guestroomallotment.create', compact('users', 'rooms', 'booking_request', 'cntJson'));
    }//function

    //--------------------------------------------------------------------------------
    /**
     *
     * @param \Illuminate\Http\Request $request
     */
    public function Store(Request $request)
    {
        $guestroomallotments = $request->all();
        $this->validate($request, [
            'room_id' => 'required',
        ]);
        $cnt_room = DB::table('guest_room_allotments')->join('rooms', 'guest_room_allotments.room_id', '=', 'rooms.id')
            ->where('guest_room_allotments.checked_in', '<', 2)
            ->where('rooms.id', '=', $request->room_id)
            ->select(DB::raw('count(*) as cnt,rooms.capacity, rooms.rent'))->get();
        if ($cnt_room) {
            if ($cnt_room[0]->cnt < $cnt_room[0]->capacity) {
                $guestroomallotments['rent'] = $cnt_room[0]->rent;
                \GuestHouse\guest_room_allotments::create($guestroomallotments);
                return redirect('/guest_info/pending');
            }
            Flash::error('Please  choose another room, Room Capacity Exceeded');
            return redirect('/guestroomallotment/create?guest_info_id=' . $request->guest_info_id);
        }

    }//function
    //-------------------------------------------------------------------------------------------

    /**
     *
     * @return type
     */
    public function Edit($id)
    {
        $guestroomallotment = \GuestHouse\guest_room_allotments::find($id);
        $users = \GuestHouse\guest_info::lists('name', 'id');
        $rooms = \GuestHouse\Room::lists('room_no', 'id');
        return view('guestroomallotment.edit', compact('guestroomallotment', 'users', 'rooms'));
    }//function
    //-----------------------------------------------------------------------------------------

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param type $id
     */
    public function update(Request $request, $id)
    {
        //dd($request);

        $update_guest_info = $request->all();
        $guestroomallotment = \GuestHouse\guest_room_allotments::find($id);
        if($request->get('guest_photo_checkout'))
        {
            $guest_info = \GuestHouse\guest_info::find($guestroomallotment->guest_info_id);
            $guest_info->update($update_guest_info);
        }
        if ($request->set_date) {
            $all_data = array('checked_in' => 2, 'check_out_date' => $request->check_out_date);


        } else {
            $all_data = $request->all();
        }

        $guestroomallotment->update($all_data);
        if ($request->set_date) {
            $this->SendCheckoutEmail($id);
            return redirect('guest_info/pending');
        } else {
            return redirect('guestroomallotment');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $guestroomallotment = DB::table('guest_room_allotments')
            ->join('guest_infos', 'guest_room_allotments.guest_info_id', '=', 'guest_infos.id')
            ->join('rooms', 'guest_room_allotments.room_id', '=', 'rooms.id')
            ->where('guest_room_allotments.id', '=', $id)
            ->select(DB::raw('guest_room_allotments.*, guest_infos.name, rooms.room_no, rooms.room_type'))
            ->paginate(1);

        //dd($guestroomallotment[0]->guest_info_id);
        if (isset($guestroomallotment[0])) {
            $foods = DB::table('food_serveds')
                ->join('foods', 'food_serveds.food_id', '=', 'foods.id')
                ->where('food_serveds.guest_info_id', '=', $guestroomallotment[0]->guest_info_id)
//                ->wherebetween('food_serveds.created_at', [$guestroomallotment[0]->check_in_date, $guestroomallotment[0]->check_out_date])
                ->select(DB::raw('food_serveds.*, foods.name as name'))
                ->get();
        }

        $guest_info = DB::table('guest_infos')
            ->join('guest_room_allotments', 'guest_room_allotments.guest_info_id', '=', 'guest_infos.id')
            ->where('guest_room_allotments.id', '=', $id)
            ->select(DB::raw('guest_infos.*,guest_room_allotments.id as r_id'))->first();
        //dd($guest_info);die;
        return view('guestroomallotment.show', compact('guestroomallotment', 'foods', 'guest_info'));
    }

    /**
     *
     * @param type $id
     * @return type
     */
    public function Destroy($id)
    {
        \GuestHouse\guest_room_allotments::find($id)->delete();
        return redirect('guestroomallotment');
    }

     /**
     * Send an e-mail reminder to the user after chechout.
     * @param  Request  $request
     * @param  int  $$guest_room_allotment_id
     * @return Response
     */
    public function SendCheckoutEmail($guest_room_allotment_id)
    {   
        $guest_room_allotment = \GuestHouse\guest_room_allotments::find($guest_room_allotment_id);
        //dd($guest_room_allotment->guest_info_id);
        $boking_request = DB::table('booking_request_guest_infos')->where('guest_info_id', '=', $guest_room_allotment->guest_info_id)->first();
        //dd($boking_request->booking_request_id);
        $owner = \GuestHouse\User::findOrFail(24);
        //dd($boking_request->booking_request_id);
        $users = \GuestHouse\booking_request::find($boking_request->booking_request_id)->user()->first();
        $booking_request = \GuestHouse\booking_request::find($boking_request->booking_request_id);
       
        $guestroomallotment = DB::table('guest_room_allotments')
               ->join('guest_infos', 'guest_room_allotments.guest_info_id', '=', 'guest_infos.id')
               ->join('rooms', 'guest_room_allotments.room_id', '=', 'rooms.id')
               ->where('guest_room_allotments.id', '=', $guest_room_allotment_id)
               ->paginate(1);
      
      //dd($guestroomallotment[0]->guest_info_id);        
      if(isset($guestroomallotment[0])){
          $foods = DB::table('food_serveds')
                  ->join('foods', 'food_serveds.food_id', '=', 'foods.id')
                  ->where('food_serveds.guest_info_id', '=', $guestroomallotment[0]->guest_info_id)
                  ->wherebetween('food_serveds.created_at', [$guestroomallotment[0]->check_in_date, $guestroomallotment[0]->check_out_date])
                  ->select(DB::raw('food_serveds.*, foods.name as name'))
                  ->get(); 
      }
       //dd($boking_request->id);
        $links = ['accept'=>url('/booking_request/updatestatus/'.$guest_room_allotment_id.'?val='.$booking_request->email_key.'&status=1'),'reject'=>url('/booking_request/updatestatus/'.$guest_room_allotment_id.'?val='.$booking_request->email_key.'&status=0')];
        
        $emails = [$users->email, $owner->email];
        $guestroomallotment = $guestroomallotment[0];
        $mail = Mail::send('emails.final_bill', ['users'=> $users, 'booking_request'=> $booking_request, 'foods'=> $foods, 'guestroomallotment'=>$guestroomallotment, 'links'=>$links], function ($m) use ($emails) {
            $m->from('support@hzl.com', 'GHMS Team');
            $m->to($emails)->subject('Guest Check Out Details');
        });
    }//function
    //---------------------------------------------------------------------------------------------------------------------

}
