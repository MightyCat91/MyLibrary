<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 10.09.2017
 * Time: 15:11
 */

namespace App\Http\Middleware;


use Closure;

class UserAction
{
    public function handle($request, Closure $next)
    {
        if (\Auth::check()) {
            // The user is logged in...
            $user = \Auth::user();
            $user->last_visit = date('Y-m-d H:i:s');
            $user->save();
        }
        return $next($request);
    }
}