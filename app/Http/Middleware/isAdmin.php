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
    public function handle($request, Closure $next)
    {
        if (Auth::user()->hasRole('admin')) {
            abort(403);
        }
        return $next($request);
    }
}