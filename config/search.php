<?php
/**
 * Created by PhpStorm.
 * User: MUZHILKIN
 * Date: 04.05.2018
 * Time: 11:14
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Active class
    |--------------------------------------------------------------------------
    |
    | Here you may set the class string to be returned when the provided routes
    | or paths were identified as applicable for the current route.
    |
    */

    'options' => [
        'auth' => [
            'show_name' => true,   // Also show the users name/email in the debugbar
        ],
        'db' => [
            'with_params'       => true,   // Render SQL with the parameters substituted
            'backtrace'         => true,   // Use a backtrace to find the origin of the query in your files.
            'timeline'          => false,  // Add the queries to the timeline
            'explain' => [                 // Show EXPLAIN output on queries
                'enabled' => false,
                'types' => ['SELECT'],     // ['SELECT', 'INSERT', 'UPDATE', 'DELETE']; for MySQL 5.6.3+
            ],
            'hints'             => true,    // Show hints for common mistakes
        ],
        'mail' => [
            'full_log' => false
        ],
        'views' => [
            'data' => false,    //Note: Can slow down the application, because the data can be quite large..
        ],
        'route' => [
            'label' => true  // show complete route on bar
        ],
        'logs' => [
            'file' => null
        ],
    ],

];