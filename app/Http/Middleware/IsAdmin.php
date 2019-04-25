<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class IsAdmin
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
        /*
         |---------------------------------------------------------
         | If an unauthenticated user tries to access any route 
         | protected via "admin" middleware, the following
         | code makes sure that the user is redirected 
         | to /admin/login url rather than ordinary
         | /login url.
         |---------------------------------------------------------
        */
        if (! Auth::check()) {
            return redirect()->route('admin.login');
        }


        /*
         |---------------------------------------------------------
         | If an authenticated user tries to access any route 
         | protected via "admin" middleware, make sure that
         | the user type is "admin". Otherwise deny access.
         |---------------------------------------------------------
        */
        if (Auth::user()->type === 'admin') {
            return $next($request);
        }
        return abort(403, "Restricted Access");
    }
}
