<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CkeckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,string $role  ): Response
    {
        if ( auth()->user() &&auth()->user()->status !='active'){
            abort(403, 'You are not authorized to access this page');
        }
        if ($role =='admin'&& auth()->user()->role_id != 1  ) {

            abort(403, 'You are not authorized to access this page');

        }
        if ($role =='student'&& auth()->user()->role_id != 2) {

            abort(403, 'You are not authorized to access this page');
        }
        if ($role =='employee'&& auth()->user()->role_id != 3) {

            abort(403,  'You are not authorized to access this page');
        }




        return $next($request);
    }
}
