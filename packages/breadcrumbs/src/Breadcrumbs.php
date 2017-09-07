<?php

namespace MyLibrary\Breadcrumbs;


use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use MyLibrary\Breadcrumbs\Exceptions\AlreadyExistsException;
use MyLibrary\Breadcrumbs\Exceptions\NotArrayException;
use MyLibrary\Breadcrumbs\Exceptions\NotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Breadcrumbs
{
    /**
     * @var Collection Коллекция хлебных крошек для рендера
     */
    protected $breadcrumbs;
    /**
     * @var Collection Коллекция-хранилище всех хлебных крошек
     */
    protected $breadcrumbsCollections;
    /**
     * @var string урл текущей страницы
     */
    protected $currentRoute;

    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->currentRoute = url()->current();
        $this->breadcrumbsCollections = new Collection();
        $this->breadcrumbs = new Collection();
    }

    /**
     * Создание хлебной крошки
     *
     * @param $name string хлебной крошки
     * @param $route string урл соответствующий хлебной крошке
     * @param $title string|array массив вида ['имя параметра' => [массив необходимых строк]]
     * @param null $parent string идентификатор родительской хлебной крошки
     * @param null $parameters array массив динамических параметров для урла
     * @throws AlreadyExistsException
     * @throws NotArrayException
     */
    public function add($name, $route, $title, $parent = null, $parameters = [])
    {
        if ($this->hasBreadcrumbs('name', $name)) {
            throw new AlreadyExistsException("Breadcrumbs have already been defined for route [{$name}].");
        }
        if ($parent and !$this->hasBreadcrumbs('name', $parent)) {
            throw new AlreadyExistsException("No defined parent with name [{$parent}].");
        }
        if (!is_array($title) and !is_string($title)) {
            throw new NotArrayException("Parameter 'title'=[{$title}] is not array or string.");
        }
        if (!is_array($parameters)) {
            throw new NotArrayException("Parameter 'parameters'=[{$parameters}] is not array.");
        }


        if (empty($parameters)) {
            $this->createBreadcrumbs($name, route($route), $title, $parent);
        } else {
            list($keys, $values) = array_divide($parameters);
            $paramsForRoute = $this->getParams($values);

            if (is_array($title)) {
                $paramForTitle = key($title);
                $keysForTitlesArray = array_get($parameters, $paramForTitle)->toArray();
                $titlesArray = array_combine($keysForTitlesArray, array_get($title, $paramForTitle));
            }
            foreach ($paramsForRoute as $value) {
                $params = array_combine($keys, explode(',', $value));
                $title = is_array($title) ? array_get($titlesArray, head($params)) : $title;
                $this->createBreadcrumbs($name, route($route, $params), $title, $parent, $params);
            }
        }
    }


    /**
     * Рендер хлебных крошек
     *
     * @param null $parameters
     * @return HtmlString html-строка
     */
    public function render($parameters = null)
    {
        if ($breadcrumbs = $this->getBreadcrumbs($parameters)->toArray()) {
//            \Session::forget('title');
            return new HtmlString(
                view('breadcrumbs::breadcrumbs')->with('breadcrumbs', $breadcrumbs)->render()
            );
        }
    }


    /**
     * Формирование массива всех пересечений параметров для роутов
     *
     * @param $data
     * @return array
     */
    protected function getParams($data)
    {
        if (count($data) === 0) {
            return [];
        } elseif (count($data) === 1) {
            return $data[0];
        } else {
            $result = [];
            $allCasesOfRest = $this->getParams(array_slice($data, 1));
            foreach ($allCasesOfRest as $key => $case) {
                for ($i = 0; $i < count($data[0]); $i++) {
                    $val = $data[0][$i] . "," . $allCasesOfRest[$key];
                    array_push($result, $val);
                }
            }
            return $result;
        }
    }

    /**
     * Добавление хлебных крошек в коллекцию-хранилище
     *
     * @param $name string хлебной крошки
     * @param $url string урл соответствующий хлебной крошке
     * @param $title
     * @param $parent string идентификатор родительской хлебной крошки
     * @param array $parameters
     */
    protected function createBreadcrumbs($name, $url, $title, $parent, $parameters = [])
    {
        $this->breadcrumbsCollections->push([
            'name' => $name,
            'url' => $url,
            'title' => $title,
            'parent' => $parent,
            'parameters' => $parameters
        ]);
    }

    /**
     * Получение хлебной крошки из коллекции-хранилища
     *
     * @param $parameters
     * @return Collection
     */
    protected function getBreadcrumbs($parameters)
    {
        if ($this->currentRoute != route('home')) {
            if (!$this->hasBreadcrumbs('url', $this->currentRoute)) {
                throw new NotFoundHttpException("No breadcrumbs defined for route [{$this->currentRoute}].");
            }
        }

        $key = $this->breadcrumbsCollections->search(function ($item) use ($parameters) {
            return $item['url'] == $this->currentRoute;
        });

        $activeBreadcrumbCollection = collect($this->breadcrumbsCollections->get($key));
        $this->breadcrumbs->push([
            'title' => session('title'),
            'url' => $activeBreadcrumbCollection->get('url')
        ]);

        if ($parent = $activeBreadcrumbCollection->get('parent')) {
            $this->call($parent, $parameters);
        }

        return $this->breadcrumbs;
    }

    /**
     * Получение хлебных крошек предков текущей страницы
     *
     * @param $name string идентификатор предка хлебной крошки
     * @return null
     */
    protected function call($name, $parameters)
    {
        if (!$name) {
            return null;
        } else {
            $key = $this->breadcrumbsCollections->search(function ($item) use ($name, $parameters) {
                return $item['name'] == $name && (!empty($parameters) ? $item['parameters'] == $parameters : true);
            });
            $activeBreadcrumbCollection = collect($this->breadcrumbsCollections->get($key));

            $this->breadcrumbs->prepend([
                'title' => $activeBreadcrumbCollection->get('title'),
                'url' => $activeBreadcrumbCollection->get('url')
            ]);

            if ($parameters) {
                $parameters = array_slice($parameters, 1);
            }
            return $this->call($activeBreadcrumbCollection->get('parent'), $parameters);
        }
    }

    /**
     * Проверка наличия в коллекции-хранилище хлебных крошек указанного значения
     *
     * @param $key string тип проверяемого значения
     * @param $value string проверяемое значение
     * @return bool
     */
    protected function hasBreadcrumbs($key, $value)
    {
        return $this->breadcrumbsCollections->contains(function ($item) use ($key, $value) {
            return $item[$key] == $value;
        });
    }
}