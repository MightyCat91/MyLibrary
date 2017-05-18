<?php

declare(strict_types=1);
use MyLibrary\Alerts\Alert;

if (!function_exists('alert')) {
    /**
     * @param string|null $message
     * @param string|null $style
     *
     * @return \
     */
    function alert(string $message = null, string $style = 'info'): Alert
    {
        $alert = app('alert');
        if (is_null($message)) {
            return $alert;
        }
        return $alert->flash($message, $style);
    }
}