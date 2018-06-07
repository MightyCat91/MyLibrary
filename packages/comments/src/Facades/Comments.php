<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 06.06.2018
 * Time: 16:58
 */

namespace MyLibrary\Comments\Facades;
use Illuminate\Support\Facades\Facade;

class Comments extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'comments';
    }
}