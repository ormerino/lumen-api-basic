<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Carbon\Carbon;

class CustomAuth
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
        $key = $request->header('tk');
        $user = User::where('api_key',$key)->where('expiration_key','>=',Carbon::now())->first();
        if(!$user)
            return response('Unauthorized.', 401);
        
        if(isset($request->route()[1]['permissions']))
        	$permissions = $request->route()[1]['permissions'];
        else
        	$permissions = [];

        if($user->hasAnyPermission($permissions))
            return $next($request);
        
        return response('Unauthorized.', 401);
    }
}
