<?php

namespace MyLibrary\Alerts;

use \Illuminate\Session\Store;
use Illuminate\Support\HtmlString;

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
     * @param bool $ajax
     * @return $this
     */
    public function flash($message, $type = 'info', $lifetime, $ajax)
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
        return $ajax ? new HtmlString(view('Alert::alert')->renderSections()['alert']) : $this;
    }

    /**
     * Flash an error alert.
     *
     * @param string|string $message
     * @param null $lifetime
     * @param bool $ajax
     * @return $this
     */
    public function error($message, $lifetime = null, $ajax = false)
    {
        return $this->flash($message, 'danger', $lifetime, $ajax);
    }

    /**
     * Flash a info alert.
     *
     * @param string|string $message
     * @param null $lifetime
     * @param bool $ajax
     * @return $this
     */
    public function info($message, $lifetime = null, $ajax = false)
    {
        return $this->flash($message, 'info', $lifetime, $ajax);
    }

    /**
     * Flash a success alert.
     *
     * @param string|string $message
     * @param null $lifetime
     * @param bool $ajax
     * @return $this
     */
    public function success($message, $lifetime = null, $ajax = false)
    {
        return $this->flash($message, 'success', $lifetime, $ajax);
    }

    /**
     * Flash a warning alert.
     *
     * @param string|string $message
     * @param null $lifetime
     * @param bool $ajax
     * @return $this
     */
    public function warning($message, $lifetime = null, $ajax = false)
    {
        return $this->flash($message, 'warning', $lifetime, $ajax);
    }
}