<?php

namespace GuestHouse\Http\Middleware;
use Zizaco\Entrust\Entrust;
use Illuminate\Contracts\Auth\Guard;
use Closure;
use Auth;
use \GuestHouse\User;
class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd(Auth::guest('own')) ;
       if(Auth::check()) {
           //dd(Auth::user()->hasRole('admin'));
//            if(!Auth::user()->hasRole('admin')) {
//               abort(403);
//           } 
           
          
       }
         return $next($request);
    }
}
