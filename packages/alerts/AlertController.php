<?php
namespace MyLibrary\Alerts;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AlertController extends Controller
{

    public function index($timezone)
    {
        echo Carbon::now($timezone)->toDateTimeString();
    }

}