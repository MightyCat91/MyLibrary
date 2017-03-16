<?php

namespace App\Providers;

use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // правило проверки максимального количества файлов
        Validator::extend('max_files_count', function ($attribute, $value, $parameters, $validator) {

            $validator->addReplacer('max_files_count', function ($message, $attribute, $rule, $parameters) {
                return str_replace(':maxFilesCount', $parameters[0], $message);
            });

            return (count($value) > $parameters[0]) ? false : true;
        });

        //инициализация атрибута имени валидируемого файла в правиле image
        Validator::replacer('image', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':fileName', Input::file($attribute)->getClientOriginalName(), $message);
        });

        /*
         * инициализация атрибута имени валидируемого файла и переопределение значений заданных параметров в правиле
         * mimes
         */
        Validator::replacer('mimes', function ($message, $attribute, $rule, $parameters) {
            return str_replace([':fileName', ':values'],
                [Input::file($attribute)->getClientOriginalName(), implode(', ', $parameters)],
                $message);
        });

        //инициализация атрибута имени валидируемого файла в правиле max
        Validator::replacer('max', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':fileName', Input::file($attribute)->getClientOriginalName(), $message);
        });

        //инициализация атрибута имени валидируемого файла в правиле dimensions
        Validator::replacer('dimensions', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':fileName', Input::file($attribute)->getClientOriginalName(), $message);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
