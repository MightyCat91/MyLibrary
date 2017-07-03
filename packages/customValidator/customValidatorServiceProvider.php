<?php

namespace MyLibrary\customValidator;

use Illuminate\Support\ServiceProvider;
use Validator;

class CustomValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('check_password', function ($attribute, $value, $parameters, $validator) {
            return \Hash::check($value, \Auth::getUser()->getAuthPassword());
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}