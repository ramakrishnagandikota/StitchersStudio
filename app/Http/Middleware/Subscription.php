<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Subscription
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

     $subscription = isset($actions['subscription']) ? $actions['subscription'] : null;

     if ($request->user()->hasAnySubscription($subscription) || !$subscription) {
         return $next($request);
     }

     if(Auth::check()){
        return response("You dont have any subscription, Please contact admin.", 401);
     }else{
        return redirect('/login');
     }
    }
}
