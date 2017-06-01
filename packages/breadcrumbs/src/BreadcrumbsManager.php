<?php

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
     * Определения хлебных крошек
     *
     * @var array
     */
    protected $definitions = [];
    /**
     * Текущий роут
     *
     * @var \Illuminate\Routing\Route
     */
    protected $route;
    /**
     * Коллекция хлебных крошек
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
     * Создание хлебных крошек
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
     * Рендер хлебных крошек как HTML строки.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function render()
    {
        if ($breadcrumbs = $this->generate()) {
            return new HtmlString(
                view('breadcrumbs::breadcrumbs')->with('breadcrumbs', $breadcrumbs)->render()
            );
        }
    }

    /**
     * Получение хлебной крошки привязанной к родительскому роуту
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
     * Создание коллекции хлебных крошек для текущего роута
     *
     * @return \Illuminate\Support\Collection
     */
    protected function generate(): Collection
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
    protected function getBreadcrumbs($name)
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
    protected function setBreadcrumbs($name, $definition)
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
    protected function hasBreadcrumbs($name)
    {
        return array_key_exists($name, $this->definitions);
    }

    /**
     * Регистрация хлебной крошки
     *
     * @param  string $name
     * @param  \Closure $definition
     * @return void
     * @throws AlreadyExistsException
     */
    protected function register($name, Closure $definition)
    {
        $this->setBreadcrumbs($name, $definition);
    }

    /**
     * Вызов хлебной крошки с заданными параметрами
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