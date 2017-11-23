<?php

if (!function_exists('alert')) {
    /**
     * @param string|null $message
     * @param string|null $type
     * @param $lifetime
     * @param bool $ajax
     * @return \Illuminate\Foundation\Application|mixed
     */
//    function alert($message = null, $type = 'info', $lifetime = null, $ajax = false)
//    {
//        $alert = app('alert');
//        if (is_null($message)) {
//            return $alert;
//        }
//        return $alert->flash($message, $type, $lifetime, $ajax);
//    }

    function alert($type = 'success', $text = null)
    {
        \Debugbar::info(123);
        session()->put('alert', ['type' => $type, 'message' => $text]);
//        View::share('alert', ['type' => $type, 'message' => $text]);
    }
}