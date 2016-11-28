<?php
namespace App\Http\Middleware;
use Closure;

class Administrator {

    public function handle($request, Closure $next) {
      if(Auth::user()) {  
        //if (!$request->user()->hasRole('admin')) {
        //    abort(403);
        //}
        
      }

        return $next($request);
    }

}