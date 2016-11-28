<?php

namespace GuestHouse\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use DB;
use GuestHouse\Http\Requests;
use GuestHouse\Http\Controllers\Controller;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Session;
use Adldap;
class UsersController extends Controller
{
   public function CheckLdap(Request $request)
   {   
        $this->validate($request, [
           'username'=>'required',
           'password'=>'required'
        ]);
        if($request->role == 'emp') {
                 if(Adldap::authenticate($request->username, $request->password)==true){
                    $user = Adldap::users()->find($request->username);          
                    $name        = $user['cn'][0];
                    $email       = $user['mail'][0];
                    $designation = $user['title'][0];
                    $address    = $user['physicaldeliveryofficename'][0];
                    $location    = $user['physicaldeliveryofficename'][0];
                    $find_user = DB::table('users')->where('username', '=', $request->username)->get(['id']);
                    $attributes = array('name'=>$name, 'username'=>$request->username,  'email'=>$email, 'password'=>bcrypt($request->password), 'designation'=>$designation, 'address'=>$address, 'location' => $location);
                    //dd($find_user[0]->id);
                    if($find_user) {
                         $db_user = \GuestHouse\User::find($find_user[0]->id);
                         $db_user->update($attributes);
                     } else {                           
                          \GuestHouse\User::create($attributes);
                     }

                } else{                    
                    $error = 'Invalid user name or password';
                    return view('auth.login', compact('error'));
                }
        }  
      
        if(Auth::attempt(['username'=>$request->username, 'password'=>$request->password]))
        {
              Session::put('userData', $request->username); 
              return Redirect('/booking_request')->with('message', 'Login Success');
        }
        $error = 'Invalid user name or password';
        return view('auth.login', compact('error'));
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function index()
   {
       $users = DB::table('users')->select(DB::raw('users.*, (SELECT GROUP_CONCAT(roles.name SEPARATOR \',\') as role  FROM roles INNER JOIN role_users ON roles.id = role_users.role_id WHERE role_users.user_id = users.id) as role'))->paginate(10);
      
       return view('users.index',compact('users'));
   }
   /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
   public function create()
   {
      $roles = \GuestHouse\Role::lists('display_name','id'); 
      return view('users.create',compact('roles'));
   }
   /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
   public function store(Request $request)
   {
       $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $users = $request->all();
        $users['reg_date'] = date('Y-m-d H:i:s'); 
        $users['password'] = bcrypt($users['password']);
        $user_res = \GuestHouse\User::create($users);
        if($request->role_id) {
            foreach ($request->role_id as $role){
                \GuestHouse\role_user::create(array('role_id'=>$role, 'user_id'=>$user_res->id));
            }
        }
        return redirect('user');
   }
   
   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function show($id)
   {
      $user = \GuestHouse\User::find($id); 
      return view('users.show',compact('user'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function edit($id)
   {
      $users = \GuestHouse\User::find($id);
      $roles = \GuestHouse\Role::lists('display_name','id'); 
      return view('users.edit', compact('users', 'roles'));
   }
   /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function update(Request $request, $id)
   {
      $update_users = $request->all();
      $update_users['password'] = bcrypt($update_users['password']);
      $users = \GuestHouse\User::find($id);
      DB::table('role_users')->where('user_id', '=', $id)->delete();
      
      if($request->role_id) {
        foreach ($request->role_id as $role){
              \GuestHouse\role_user::create(array('role_id'=>$role, 'user_id'=>$id));
        }
      }
      $users->update($update_users);
      return redirect('user');
   }
   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function destroy($id)
   {
       \GuestHouse\User::find($id)->delete();
       return redirect('user');
   }
   
   /**
    * 
    */
   public function home()
   {    
            if(Auth::check()){
                return redirect('/booking_request'); 
            } else {            
                return redirect('/login'); 
            }
       
   }
}
