<?php
declare(strict_types=1);

namespace MyLibrary\Alerts;

use \Illuminate\Session\Store;
use \Illuminate\Config\Repository;
use \Illuminate\View\Factory;

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

    public function __construct(Store $session, Repository $config, Factory $view, array $messages = array())
    {
        $this->session = $session;
        $this->config  = $config;
    }


    /**
     * @param string|string $message
     * @param string $type
     * @param $lifetime
     * @return $this
     */
    public function flash(string $message, $type = 'info', $lifetime): self
    {
        $icons = $this->config->get('alert.icons');
        $lifetime = $lifetime ?? $this->config->get('alert.lifetime');
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
     * Flash a danger alert.
     *
     * @param string|string $message
     * @param null $lifetime
     * @return Alert
     */
    public function danger(string $message, $lifetime = null): Alert
    {
        return $this->flash($message, 'danger', $lifetime);
    }

    /**
     * Flash an error alert.
     *
     * @param string|string $message
     * @param null $lifetime
     * @return $this
     */
    public function error(string $message, $lifetime = null): Alert
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
    public function info(string $message, $lifetime = null): Alert
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
    public function success(string $message, $lifetime = null): Alert
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
    public function warning(string $message, $lifetime = null): Alert
    {
        return $this->flash($message, 'warning', $lifetime);
    }
}