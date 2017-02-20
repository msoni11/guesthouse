<?php
use GuestHouse\Task;
use GuestHouse\User;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/




/**
 * Add A New tasks
 */
/*Route::get('/', function (Request $request) {
    $tasks = Task::orderBy('created_at', 'asc')->get();

    return view('tasks', [
        'tasks' => $tasks
    ]);
});

Route::post('/task', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|min:5',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    $task = new Task;
    $task->name = $request->name;
    $task->save();

    return redirect('/');
});

Route::delete('/task/{task}', function (Task $task) {
    $task->delete();

    return redirect('/');
});  */

Route::resource('task', 'TaskController');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::auth();    
    
       
    Route::get('/guest_info/updatecheckin','GuestInfoController@updatecheckin')->name('updatecheckin');

    Route::get('/guest_info/pending','GuestInfoController@Pending')->name('pending');
    
    Route::get('/guest_info/guest_house_bookings','GuestInfoController@GuestHouseBookings')->name('guest_house_bookings');
    
    Route::get('/guest_info/pendingcheckin','GuestInfoController@PendingCheckIn')->name('pendingcheckin');

    Route::get('/guest_info/pendingcheckin','GuestInfoController@PendingCheckIn')->name('pendingcheckin');

    Route::get('/guest_info/updatebypasscheckout', 'GuestInfoController@UpdateBypassCheckout')->name('updatebypasscheckout');

    Route::resource('guest_info','GuestInfoController');
        
    Route::resource('guesthouse','GuestHouseController');
    
    Route::resource('room','RoomController');

    Route::get('/extend_booking/approveextenddays','ExtendController@ApproveExtendDays')->name('approveextenddays');

    Route::get('/extend_booking/cancelextenddays','ExtendController@CancelExtendDays')->name('cancelextenddays');

    Route::resource('extend_booking','ExtendController');
    
    Route::get('/guestroomallotment/checkout', 'GuestRoomAllotmentController@ShowCheckOut')->name('checkout');

    Route::get('/guestroomallotment/updatecheckout','GuestRoomAllotmentController@UpdateCheckOut')->name('updatecheckout');

    Route::get('/guestroomallotment/approvebyemail', 'GuestRoomAllotmentController@ApproveByEmail')->name('approvebyemail');

    Route::get('/guestroomallotment/show/{id}', 'GuestRoomAllotmentController@Show')->name('show');

    Route::resource('guestroomallotment','GuestRoomAllotmentController');

    Route::resource('food','FoodController');
    
    Route::get('/foodserved/served', 'FoodServedController@Served')->name('served');

    Route::resource('foodserved','FoodServedController');
    
    Route::resource('user','UsersController');
    
    Route::get('/', 'UsersController@Home')->name('Home');
    
});

Route::group(['middleware' => ['web']], function () {
    Route::auth();

    Route::get('/booking_request/updatestatus/{booking_request}', 'BookingRequestController@UpdateStatusByHOD')->name('UpdateStatusByHOD');
    
    Route::get('/booking_request/updatebyowner/{booking_request}', 'BookingRequestController@UpdateStatusByOwner')->name('UpdateStatusByOwner');

    Route::get('/food_bookings/updatestatus/{food_bookings}', 'FoodBookingController@UpdateStatusByHOD')->name('UpdateStatusByHOD');

    Route::get('/food_bookings/updatebyowner/{food_bookings}', 'FoodBookingController@UpdateStatusByOwner')->name('UpdateStatusByOwner');

    Route::get('/booking_request/requests','BookingRequestController@Requests')->name('requests');

    Route::get('/food_booking/requests','FoodBookingController@Requests')->name('requests');

    Route::get('/food_booking/foodpending','FoodBookingController@FoodPending')->name('foodpending');

    Route::get('/food_booking/food_bookings_report','FoodBookingController@FoodBookingsReport')->name('food_bookings_report');

    Route::resource('booking_request','BookingRequestController');

    Route::resource('report','ReportController');


    //Route::get('/', function () {return view('auth.login'); });
   
    Route::post('/user/check_ldap', 'UsersController@CheckLdap')->name('check_ldap');

    Route::resource('food_booking','FoodBookingController');
    
    Route::get('/', 'UsersController@Home')->name('Home');
});
 