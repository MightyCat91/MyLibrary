<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 09.11.2017
 * Time: 16:03
 */

namespace MyLibrary\customServiceProviders;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('isAdmin', function () {
            return \Auth::user()->isAdmin();
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}