<?php

namespace App\Http\Middleware;

use Closure;

class AuthUserMiddleware
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
        $is_allow = false;

        $user_id = session()->get('user_id');

        if(!is_null($user_id)){
            $is_allow = true;
        }

        if(!$is_allow){
            return redirect()->to('/user/auth/sign-in');
        }

        return $next($request);
    }
}
