<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 29.05.2017
 * Time: 20:15
 */

namespace MyLibrary\Breadcrumbs\Facades;
use Illuminate\Support\Facades\Facade;

class Breadcrumbs extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'breadcrumbs';
    }
}