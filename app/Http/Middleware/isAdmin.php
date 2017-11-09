<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 08.11.2017
 * Time: 16:03
 */

namespace App\Http\Middleware;


use Auth;
use Closure;

class isAdmin
{
    public function handle($request, Closure $next, $guard = null)
    {
        \Debugbar::info($request);
        if (Auth::guard($guard)->check()) {
            \Debugbar::info('2'.Auth::user()->isAdmin());
            if (Auth::user()->isAdmin()) {
                return $next($request);
            }
//            return redirect('/');
        }
//            return redirect()->back();
        return $next($request);
    }
}