<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 30.05.2017
 * Time: 16:15
 */

namespace MyLibrary\Breadcrumbs;


use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use MyLibrary\Breadcrumbs\Exceptions\AlreadyExistsException;
use MyLibrary\Breadcrumbs\Exceptions\NotFoundException;
use Illuminate\Contracts\Routing\Registrar;

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
     *
     * @var \Illuminate\Routing\Route
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
     * @internal param $route
     * @param Registrar $route
     */
    public function __construct(Registrar $route)
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
            ??проблема с рендерингом
            dd(view('breadcrumbs::breadcrumbs')->render());
            return new HtmlString(
                view('breadcrumbs::breadcrumbs')->with('breadcrumbs', compact($breadcrumbs))->render()
            );
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
     * @param  string $title
     * @param  string $url
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
    public function generate(): Collection
    {
        $currentRoute = $this->route->current();
        if (!is_null($this->route) && $this->hasBreadcrumbs($currentRoute->getName())) {
            $this->call($currentRoute->getName(), $currentRoute->parameters());
        }
        return $this->breadcrumbs;
    }

    /**
     * Получение хлебной крошки привязанной к данному роуту
     *
     * @param  string $name
     * @return \Closure
     * @throws \MyLibrary\Breadcrumbs\Exceptions\NotFoundException
     */
    public function getBreadcrumbs($name)
    {
        if (!$this->hasBreadcrumbs($name)) {
            throw new NotFoundException("No breadcrumbs defined for route [{$name}].");
        }
        return $this->definitions[$name];
    }

    /**
     * Привязка хлебной крошки
     *
     * @param string $name
     * @param \Closure $definition
     * @throws \MyLibrary\Breadcrumbs\Exceptions\AlreadyExistsException
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
     * Register a definition with the registrar.
     *
     * @param  string $name
     * @param  \Closure $definition
     * @return void
     * @throws AlreadyExistsException
     */
    public function register($name, Closure $definition)
    {
        $this->setBreadcrumbs($name, $definition);
    }

    /**
     * Call the breadcrumb definition with the given parameters.
     *
     * @param  string  $name
     * @param  array  $parameters
     * @return void
     * @throws \MyLibrary\Breadcrumbs\Exceptions\NotFoundException
     */
    protected function call($name, array $parameters)
    {
        $parameters = array_prepend(array_values($parameters), $this);
        call_user_func_array($this->getBreadcrumbs($name), $parameters);
    }
}