<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckRole
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
        if ($request->user() === null) {
         return response("Insufficient permissions", 401);
        }

     $actions = $request->route()->getAction();
     $roles = isset($actions['roles']) ? $actions['roles'] : null;

     if ($request->user()->hasAnyRole($roles) || !$roles) {
         return $next($request);
     }
     
     return $next($request);
	 /* 
	 if(Auth::user()->hasRole('Knitter')){
			$role = 'Knitter';
		}else if(Auth::user()->hasRole('Admin')){
			$role = 'Admin';
		}else if(Auth::user()->hasRole('Designer')){
			$role = 'Designer';
		}
		
		$allowed_roles = array_slice(func_get_args(),2);
		
		if(in_array($role, $allowed_roles)){
			return $next($request);
		}
     
		return response("Insufficient permissions", 401);
		*/
    }
}
