<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 28.05.2017
 * Time: 18:33
 */

namespace MyLibrary\Breadcrumbs;


class Breadcrumbs
{
    /**
     * Имя хлебной крошки.
     *
     * @var string
     */
    protected $title;
    /**
     * URL хлебной крошки.
     *
     * @var string
     */
    protected $url;

    /**
     * Конструктор экземпляра.
     *
     * @param  string $title
     * @param  string $url
     */
    public function __construct($title, $url = null)
    {
        $this->title = $title;
        $this->url = $url;
    }
    /**
     * Получение имени хлебной крошки
     *
     * @return string
     */
    public function title()
    {
        return $this->title;
    }
    /**
     * Получение url хлебной крошки
     *
     * @return string
     */
    public function url()
    {
        return $this->url;
    }
}