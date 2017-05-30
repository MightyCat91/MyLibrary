<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 30.05.2017
 * Time: 16:15
 */

namespace MyLibrary\Breadcrumbs;


use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use MyLibrary\Breadcrumbs\Exceptions\AlreadyExistsException;
use MyLibrary\Breadcrumbs\Exceptions\NotFoundException;
use Route;

class BreadcrumbsManager
{
    /**
     * Breadcrumb definitions.
     *
     * @var array
     */
    protected $definitions = [];
    /**
     * The current route.
     */
    protected $route;
    /**
     * The breadcrumb trail.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $breadcrumbs;

    /**
     * Создание экземпляра менеджера
     *
     * @param $route
     */
    public function __construct($route)
    {
        $this->route = $route;
        $this->breadcrumbs = new Collection;
    }

    /**
     * создание хлебных крошек
     *
     * @param  string $route
     * @param  \Closure $definition
     * @return void
     */
    public function create($route, $definition)
    {
        $this->setBreadcrumbs($route, $definition);
    }

    /**
     * Рендер хлебных крошек как HTML строка.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function render()
    {
        if ($breadcrumbs = $this->generate()) {
            return new HtmlString(View::make(config('breadcrumbs.view'), compact($breadcrumbs))->render());
        }
    }

    /**
     * Вызов родительского маршрута
     *
     * @param  string $name
     * @throws NotFoundException
     * @internal param mixed $parameters
     */
    public function parent($name)
    {
        $this->getBreadcrumbs($name);
    }
    /**
     * Добавление хлебной крошки в коллекцию
     *
     * @param  string  $title
     * @param  string  $url
     * @return void
     */
    public function add($title, $url)
    {
        $this->breadcrumbs->push(new Breadcrumbs($title, $url));
    }

    /**
     * Generate the collection of breadcrumbs from the given route.
     *
     * @return \Illuminate\Support\Collection
     */
    public function generate()
    {
        if (!is_null(current($this->route)) && $this->hasBreadcrumbs($this->route->getName())) {
            $this->getBreadcrumbs($this->route->getName());
        }
        return $this->breadcrumbs;
    }

    /**
     * Получение хлебной крошки привязанной к данному роуту
     *
     * @param  string $name
     * @return \Closure
     * @throws NotFoundException
     */
    public function getBreadcrumbs($name)
    {
        if (!$this->hasBreadcrumbs($name)) {
            throw new NotFoundException("No breadcrumbs defined for route [{$name}].");
        }
        return $this->definitions[$name];
    }

    /**
     * Проверка существования хлебной крошки
     *
     * @param  string $name
     * @return bool
     */
    public function hasBreadcrumbs($name)
    {
        return array_key_exists($name, $this->definitions);
    }


    /**
     * Привязка хлебной крошки
     *
     * @param string $name
     * @param \Closure $definition
     * @throws AlreadyExistsException
     */
    public function setBreadcrumbs($name, $definition)
    {
        if ($this->hasBreadcrumbs($name)) {
            throw new AlreadyExistsException(
                "Breadcrumbs have already been defined for route [{$name}]."
            );
        }
        $this->definitions[$name] = $definition;
    }

    /**
     * Register a definition with the registrar.
     *
     * @param  string  $name
     * @param  \Closure  $definition
     * @return void
     * @throws AlreadyExistsException
     */
    public function register($name, $definition)
    {
        $this->setBreadcrumbs($name, $definition);
    }
}