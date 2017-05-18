<?php
namespace MyLibrary\Alerts\Facades;
use \Illuminate\Support\Facades\Facade;
/**
 * Alert facade
 */
class Alert extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'alert';
    }
}