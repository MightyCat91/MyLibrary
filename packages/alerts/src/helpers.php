<?php

if (!function_exists('alert')) {
    /**
     * @param string|null $message
     * @param string|null $type
     * @param $lifetime
     * @return
     */
    function alert($message = null, $type = 'info', $lifetime = null)
    {
        $alert = app('alert');
        if (is_null($message)) {
            return $alert;
        }
        return $alert->flash($message, $type, $lifetime);
    }
}