<?php

namespace MyLibrary\Alerts;

use \Illuminate\Session\Store;

class Alert
{
    /**
     * сессия ларавель
     *
     * @var \Illuminate\Session\Store
     */
    protected $session;
    /**
     * настройки репозитория
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }


    /**
     * @param string|string $message
     * @param string $type
     * @param $lifetime
     * @return $this
     */
    public function flash($message, $type = 'info', $lifetime)
    {
        $icons = config('alert.icons');
        $lifetime = $lifetime ?? config('alert.lifetime');
        $alert = [
            'icon'     => $icons[$type] ?? null,
            'type'     => $type,
            'message' => $message,
            'lifetime' => $lifetime,
        ];
        $this->session->flash('alert', $alert);
        return $this;
    }

    /**
     * Flash an error alert.
     *
     * @param string|string $message
     * @param null $lifetime
     * @return $this
     */
    public function error($message, $lifetime = null)
    {
        return $this->flash($message, 'danger', $lifetime);
    }

    /**
     * Flash a info alert.
     *
     * @param string|string $message
     * @param null $lifetime
     * @return $this
     */
    public function info($message, $lifetime = null)
    {
        return $this->flash($message, 'info', $lifetime);
    }

    /**
     * Flash a success alert.
     *
     * @param string|string $message
     * @param null $lifetime
     * @return $this
     */
    public function success($message, $lifetime = null)
    {
        return $this->flash($message, 'success', $lifetime);
    }

    /**
     * Flash a warning alert.
     *
     * @param string|string $message
     * @param null $lifetime
     * @return $this
     */
    public function warning($message, $lifetime = null)
    {
        return $this->flash($message, 'warning', $lifetime);
    }
}