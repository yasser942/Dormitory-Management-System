<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckJobTitle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next ,string $role  , string $job_title): Response
    {
        if ($role =='employee'&& auth()->user()->role_id != 3) {

            abort(403,  'You are not authorized to access this page');
        }

        if ($role =='employee'&&$job_title=='librarian'&& auth()->user()->profileable->job_title!='librarian') {
            abort(403, 'You are not authorized to access this page');
        }
        if ($role =='employee'&&$job_title=='trainer'&& auth()->user()->profileable->job_title!='trainer') {
            abort(403, 'You are not authorized to access this page');
        }
        if ($role =='employee'&&$job_title=='chief'&& auth()->user()->profileable->job_title!='chief') {
            abort(403, 'You are not authorized to access this page');
        }
        return $next($request);
    }
}
