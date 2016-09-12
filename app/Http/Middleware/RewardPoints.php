<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class RewardPoints
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
        /*$request_uri = $request->getRequestUri();
        $call_type = [
            '/api/event/lists',
            '/api/event/eventLikeUnlike',
            '/user/login'
        ];
        $user_id = $request->input('user_id');
        if(in_array($request_uri, $call_type) && !empty($user_id)) {

        }*/
        return $next($request);
    }
}
