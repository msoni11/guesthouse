<?php
namespace GuestHouse\Http\Controllers;
use GuestHouse\guest_info;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use GuestHouse\Http\Requests;
use GuestHouse\Http\Controllers\Controller;
use Flash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\GuestRoomAllotmentController;

class GuestInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        if (Auth::check()) {
            $guest_info = DB::table('guest_infos')
                ->leftjoin('guest_room_allotments', 'guest_infos.id', '=', 'guest_room_allotments.guest_info_id')
                ->orderby('guest_infos.id', 'desc')
                ->paginate(20);
            return view('guest_info.index', compact('guest_info'));
        } else {
            return redirect('/login');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function Pending(Request $request)
    {
        if (Auth::check()) {
            $status = '';
            $from_date = date('Y/m/d 00:00:00', strtotime('-10 day'));
            $to_date = date('Y/m/d 23:59:59', strtotime('+10 day'));

            if (isset($request->from_date) && $request->from_date !== '') {
                $from_date = $request->from_date . ' 00:00:00';
            }

            if (isset($request->to_date) && $request->to_date !== '') {
                $to_date = $request->to_date . ' 23:59:59';
            }
            if (isset($request->reset)) {
                $from_date = date('Y/m/d 00:00:00', strtotime('-10 day'));
                $to_date = date('Y/m/d 23:59:59', strtotime('+10 day'));
            }
            $search_form_data_arr = array('from_date' => $from_date, 'to_date' => $to_date, 'status' => $request->status);
            //$search_form_data_arr = $request->all();
            if ((isset($request->to_date)) || (isset($request->from_date)) || (isset($request->status))) {
                $guest_info = DB::table('guest_infos')
                    ->join('booking_request_guest_infos', 'guest_infos.id', '=', 'booking_request_guest_infos.guest_info_id')
                    ->join('booking_requests', 'booking_requests.id', '=', 'booking_request_guest_infos.booking_request_id')
                    ->leftjoin('guest_room_allotments', 'guest_room_allotments.guest_info_id', '=', 'guest_infos.id')
                    ->leftjoin('rooms', 'guest_room_allotments.room_id', '=', 'rooms.id')
                    ->where('guest_room_allotments.check_in_date', '>', $from_date)
                    ->where('guest_room_allotments.check_in_date', '<', $to_date)
                    ->where('guest_room_allotments.checked_in', '=', $request->status)
                    ->where('booking_requests.status', '=', '1')
                    ->select(DB::raw('guest_infos.*,guest_room_allotments.checked_in, guest_room_allotments.check_in_date, guest_room_allotments.check_out_date, guest_room_allotments.id as guest_room_allotment_id, guest_room_allotments.checked_in, rooms.room_no, rooms.id as room_id,  booking_requests.type_of_guest'))
                    ->orderby('guest_room_allotments.id', 'desc')
                    ->paginate(20);
            } else {
                $guest_info = DB::table('guest_infos')
                    ->join('booking_request_guest_infos', 'guest_infos.id', '=', 'booking_request_guest_infos.guest_info_id')
                    ->join('booking_requests', 'booking_requests.id', '=', 'booking_request_guest_infos.booking_request_id')
                    ->leftjoin('guest_room_allotments', 'guest_room_allotments.guest_info_id', '=', 'guest_infos.id')
                    ->leftjoin('rooms', 'guest_room_allotments.room_id', '=', 'rooms.id')
                    ->where('booking_requests.status', '=', '1')
                    ->select(DB::raw('guest_infos.*,guest_room_allotments.checked_in, guest_room_allotments.check_in_date, guest_room_allotments.check_out_date, guest_room_allotments.id as guest_room_allotment_id, guest_room_allotments.checked_in, rooms.room_no, rooms.id as room_id, booking_requests.type_of_guest'))
                    ->orderby('guest_room_allotments.id', 'desc')
                    ->paginate(20);
            }
            return view('guest_info.pending', compact('guest_info', 'search_form_data_arr'));
        } else {
            return redirect('/login');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function GuestHouseBookings(request $request)
    {
        if (Auth::check()) {
            $status = '';
            $from_date = date('Y/m/d 00:00:00', strtotime('-10 day'));
            $to_date = date('Y/m/d 23:59:59', strtotime('+10 day'));

            if (isset($request->from_date) && $request->from_date !== '') {
                $from_date = $request->from_date . ' 00:00:00';
            }

            if (isset($request->to_date) && $request->to_date !== '') {
                $to_date = $request->to_date . ' 23:59:59';
            }
            if (isset($request->reset)) {
                $from_date = date('Y/m/d 00:00:00', strtotime('-10 day'));
                $to_date = date('Y/m/d 23:59:59', strtotime('+10 day'));
            }
            $search_form_data_arr = array('from_date' => $from_date, 'to_date' => $to_date, 'status' => $request->status);
            //$search_form_data_arr = $request->all();
            if (isset($request->status) && $request->status != '') {
                $guest_info = DB::table('guest_infos')
                    ->join('booking_request_guest_infos', 'guest_infos.id', '=', 'booking_request_guest_infos.guest_info_id')
                    ->join('booking_requests', 'booking_request_guest_infos.booking_request_id', '=', 'booking_requests.id')
                    ->join('users', 'booking_requests.request_by', '=', 'users.id')
                    ->join('guest_room_allotments', 'guest_room_allotments.guest_info_id', '=', 'guest_infos.id')
                    ->join('rooms', 'guest_room_allotments.room_id', '=', 'rooms.id')
                    ->where('guest_room_allotments.check_in_date', '>', $from_date)
                    ->where('guest_room_allotments.check_in_date', '<', $to_date)
                    ->where('guest_room_allotments.checked_in', '=', $request->status)
                    ->select(DB::raw('guest_infos.*,guest_room_allotments.checked_in, guest_room_allotments.check_in_date, guest_room_allotments.check_out_date, guest_room_allotments.id as guest_room_allotment_id, guest_room_allotments.checked_in, rooms.room_no, rooms.id as room_id, users.name as request_by'))
                    ->orderby('guest_room_allotments.id', 'desc')
                    ->paginate(20);
            } else {
                $guest_info = DB::table('guest_infos')
                    ->join('booking_request_guest_infos', 'guest_infos.id', '=', 'booking_request_guest_infos.guest_info_id')
                    ->join('booking_requests', 'booking_request_guest_infos.booking_request_id', '=', 'booking_requests.id')
                    ->join('users', 'booking_requests.request_by', '=', 'users.id')
                    ->join('guest_room_allotments', 'guest_room_allotments.guest_info_id', '=', 'guest_infos.id')
                    ->join('rooms', 'guest_room_allotments.room_id', '=', 'rooms.id')
                    ->where('guest_room_allotments.check_in_date', '>', $from_date)
                    ->where('guest_room_allotments.check_in_date', '<', $to_date)
                    ->where('guest_room_allotments.checked_in', '=', 2)
                    ->select(DB::raw('guest_infos.*,guest_room_allotments.checked_in, guest_room_allotments.check_in_date, guest_room_allotments.check_out_date, guest_room_allotments.id as guest_room_allotment_id, guest_room_allotments.checked_in, rooms.room_no, rooms.id as room_id, users.name as request_by'))
                    ->orderby('guest_room_allotments.id', 'desc')
                    ->paginate(20);
            }
            return view('guest_info.guest_house_bookings', compact('guest_info', 'search_form_data_arr'));
        } else {
            return redirect('/login');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function FoodPending(request $request)
    {
        if (Auth::check()) {
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
            //$search_form_data_arr = $request->all();


            $guest_info = DB::table('guest_infos')
                ->join('food_booking_guest_infos', 'guest_infos.id', '=', 'food_booking_guest_infos.guest_info_id')
                ->join('food_bookings', 'food_booking_guest_infos.food_booking_id', '=', 'food_bookings.id')
                ->join('users', 'food_bookings.request_by', '=', 'users.id')
                ->where('food_bookings.date', '>', $from_date)
                ->where('food_bookings.date', '<', $to_date)
                ->where('food_bookings.status', '=', $status)
                ->select(DB::raw('guest_infos.*, food_bookings.date as date, food_bookings.food_type as food_type, food_bookings.id as food_id, users.name as request_by'))
                ->orderby('food_bookings.id', 'desc')
                ->paginate(20);

            return view('guest_info.foodpending', compact('guest_info', 'search_form_data_arr'));
        } else {
            return redirect('/login');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function FoodBookings(request $request)
    {
        if (Auth::check()) {
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
            //$search_form_data_arr = $request->all();


            $guest_info = DB::table('guest_infos')
                ->join('food_booking_guest_infos', 'guest_infos.id', '=', 'food_booking_guest_infos.guest_info_id')
                ->join('food_bookings', 'food_booking_guest_infos.food_booking_id', '=', 'food_bookings.id')
                ->join('users', 'food_bookings.request_by', '=', 'users.id')
                ->where('food_bookings.date', '>', $from_date)
                ->where('food_bookings.date', '<', $to_date)
                ->where('food_bookings.status', '=', $status)
                ->select(DB::raw('guest_infos.*, food_bookings.date as date, food_bookings.food_type as food_type, food_bookings.id as food_id, users.name as request_by'))
                ->orderby('food_bookings.id', 'desc')
                ->paginate(20);

            return view('guest_info.food_bookings', compact('guest_info', 'search_form_data_arr'));
        } else {
            return redirect('/login');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function PendingCheckIn()
    {
        $guest_info = DB::table('guest_infos')
            ->join('guest_room_allotments', 'guest_infos.id', '=', 'guest_room_allotments.guest_info_id')
            ->where('guest_room_allotments.checked_in', '=', 0)
            ->orderby('guest_infos.id', 'desc')
            ->select(DB::raw('guest_infos.*, guest_room_allotments.check_in_date, guest_room_allotments.check_out_date, guest_room_allotments.id as guest_room_allotment_id'))
            ->orderby('guest_room_allotments.check_in_date', 'desc')
            ->paginate(20);
        return view('guest_info.pendingcheckin', compact('guest_info'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        return view('guest_info.create', compact('guest_info'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $guest_info = $request->all();

        if ($request->file('doc')) {
            $doc = $this->upload($request->file('doc')); // upload document
            $guest_info['doc'] = $doc;
        }

        \GuestHouse\guest_info::create($guest_info);
        return redirect('guest_info');
    }

    /**
     * upload file on specific location
     * @param string $file file object
     * @return string file name
     */
    public function upload($file)
    {
        $destination = base_path() . '/public/uploads/';
        $file->move($destination, $file->getClientOriginalName());
        return $file->getClientOriginalName();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //dd($id);die;
        $guest_info = \GuestHouse\guest_info::find($id);
        return view('guest_info.show', compact('guest_info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $check_book_table = DB::table('booking_request_guest_infos')
            ->where('booking_request_guest_infos.guest_info_id', '=', $id)->get();

        $users = \GuestHouse\User::lists('name', 'id');
        $guest_info = \GuestHouse\guest_info::find($id);
        if ($check_book_table) {
            return view('guest_info.edit', compact('guest_info'), compact('users'));
        } else {
            return view('guest_info.edit_guest', compact('guest_info'), compact('users'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        /* if(!isset($request->served))
         {
  //      $this->validate($request, [
  //            'finger_print' => 'required|unique:guest_infos|max:255',
  //        ]);
         }*/

        $update_guest_info = $request->all();
        if ($request->file('doc')) {
            $doc = $this->upload($request->file('doc'));
            $update_guest_info['doc'] = $doc;
        }


        $guest_info = \GuestHouse\guest_info::find($id);
        $guest_info->update($update_guest_info);
        if ($request->served == 1) {
            Flash::message('Food Served');
            return redirect('/guest_info/foodpending');
        } else {
            return redirect('/guest_info/pending');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function updatecheckin(Request $request)
    {
        $update_guest_check_in = array('checked_in' => 1, 'check_in_date' => date('Y-m-d H:i:s'));
        $guest_room_allotment = \GuestHouse\guest_room_allotments::find($request->guest_room_allotment_id);
        $res = $guest_room_allotment->update($update_guest_check_in);
        flash::Message('Checked In successfully!');
        return redirect('/guest_info/pending');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function updatecheckout(Request $request)
    {

        $update_guest_check_in = array('checked_in' => 2, 'check_in_date' => date('Y-m-d H:i:s'));
        $guest_room_allotment = \GuestHouse\guest_room_allotments::find($request->guest_room_allotment_id);
        $res = $guest_room_allotment->update($update_guest_check_in);
        flash::Message('Checked out successfully!');
        return redirect('/guest_info/pending');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        \GuestHouse\guest_info::find($id)->delete();
        return redirect('guest_info');
    }

    public function UpdateBypassCheckout(Request $request)

    {

            if (Auth::check())
            {

                if ($request->status == 1)
                {
                    $update_guest_check_in = array('checked_in' => 2, 'check_out_date' => date('Y-m-d H:i:s'));
                    $guest_room_allotment = \GuestHouse\guest_room_allotments::find($request->id);
                    $res = $guest_room_allotment->update($update_guest_check_in);
                    $this->checkoutbypassmail($request);
                }
                else if($request->status == 0)
                {
                    $this->checkoutcancelbypassmail($request);
                }

            }

    return redirect ('/login');
    }

    public function checkoutbypassmail($request)

    {

        $guest_room_allotment = \GuestHouse\guest_room_allotments::find($request->id);


        $boking_request = DB::table('booking_request_guest_infos')->where('guest_info_id', '=', $guest_room_allotment->guest_info_id)->first();


        $users = \GuestHouse\booking_request::find($boking_request->booking_request_id)->user()->first();

        $reception = DB::table('users')
            ->leftjoin('role_users', 'role_users.user_id', '=', 'users.id')
            ->leftjoin('roles', 'role_users.role_id', '=', 'roles.id')
            ->where('users.location', '=', Auth::user()->location)
            ->where('roles.name', '=', 'receptionist')
            ->select(DB::raw('users.*'))->first();

        $emails = [$reception->email];
        $mail = Mail::send('emails.reception_final_email', ['receptionist' => $reception , 'status'=>$request->status], function ($m) use ($emails)
        {
            $m->from('support@hzl.com', 'GHMS Team');
            $m->to($emails)->subject('Guest Check Out Details');
        });

    }


    public function checkoutcancelbypassmail($request)

    {
        //dd($request->status);die;
        $reception = DB::table('users')
            ->leftjoin('role_users', 'role_users.user_id', '=', 'users.id')
            ->leftjoin('roles', 'role_users.role_id', '=', 'roles.id')
            ->where('users.location', '=', Auth::user()->location)
            ->where('roles.name', '=', 'receptionist')
            ->select(DB::raw('users.*'))->first();

        $emails = [$reception->email];
        $mail = Mail::send('emails.reception_final_email', ['receptionist' => $reception , 'status'=>$request->status], function ($m) use ($emails)
        {
            $m->from('support@hzl.com', 'GHMS Team');
            $m->to($emails)->subject('Guest Check Out Details');

        });

    }

}