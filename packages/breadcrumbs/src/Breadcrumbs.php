<?php

namespace MyLibrary\Breadcrumbs;


use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use MyLibrary\Breadcrumbs\Exceptions\AlreadyExistsException;
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
     * @param null $parent string идентификатор родительской хлебной крошки
     * @param null $parameters array массив динамических параметров для урла
     * @throws AlreadyExistsException
     */
    public function add($name, $route, $parent = null, $parameters = null)
    {
        if ($this->hasBreadcrumbs('name', $name)) {
            throw new AlreadyExistsException("Breadcrumbs have already been defined for route [{$name}].");
        }
        if ($parent and !$this->hasBreadcrumbs('name', $parent)) {
            throw new AlreadyExistsException("No defined parent with name [{$parent}].");
        }
        if (empty($parameters)) {
            $this->createBreadcrumbs($name, route($route), $parent);
        } else {
            list($keys, $values) = array_divide($parameters);
            $paramsForRoute = $this->getParams($values);
            foreach ($paramsForRoute as $value) {
                $params = array_combine($keys, explode( ',', $value ));
                $this->createBreadcrumbs($name, route($route, $params), $parent);
            }
        }
    }



    /**
     * Рендер хлебных крошек
     *
     * @return HtmlString html-строка
     * @throws NotFoundException
     */
    public function render()
    {
        if ($breadcrumbs = $this->getBreadcrumbs()->toArray()) {
            \Session::forget('title');
            return new HtmlString(
                view('breadcrumbs::breadcrumbs')->with('breadcrumbs', $breadcrumbs)->render()
            );
        }
    }


    /**
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
                    $val = $data[0][$i] .",". $allCasesOfRest[$key];
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
     * @param $parent string идентификатор родительской хлебной крошки
     */
    protected function createBreadcrumbs($name, $url, $parent)
    {
        $this->breadcrumbsCollections->push([
            'name' => $name,
            'url' => $url,
            'parent' => $parent
        ]);
    }

    /**
     * Получение хлебной крошки из коллекции-хранилища
     *
     * @return Collection
     * @throws NotFoundException
     */
    protected function getBreadcrumbs()
    {
        if ($this->currentRoute != route('home')) {
            if (!$this->hasBreadcrumbs('url', $this->currentRoute)) {
                throw new NotFoundHttpException("No breadcrumbs defined for route [{$this->currentRoute}].");
            }
        }
        $key = $this->breadcrumbsCollections->search(function ($item) {
            return $item['url'] == $this->currentRoute;
        });
        $activeBreadcrumbCollection = collect($this->breadcrumbsCollections->get($key));
        $this->breadcrumbs->push([
            'title' => session('title'),
            'url' => $activeBreadcrumbCollection->get('url')
        ]);
        if ($parent = $activeBreadcrumbCollection->get('parent')) {
            $this->call($parent);
        }
        return $this->breadcrumbs;
    }

    /**
     * Получение хлебных крошек предков текущей страницы
     *
     * @param $name string идентификатор предка хлебной крошки
     * @return null
     */
    protected function call($name)
    {
        if (!$name) {
            return null;
        } else {
            $key = $this->breadcrumbsCollections->search(function ($item) use ($name) {
                return $item['name'] == $name;
            });
            $activeBreadcrumbCollection = collect($this->breadcrumbsCollections->get($key));
            $url = $activeBreadcrumbCollection->get('url');

            if ($title = $this->getPageTitle($url)) {
                $this->breadcrumbs->prepend([
                    'title' => $title,
                    'url' => $url
                ]);
            }
            return $this->call($activeBreadcrumbCollection->get('parent'));
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

    /**
     * Получение заголовка страницы
     *
     * @param $url string урл страницы
     * @return mixed|null|string
     */
    protected function getPageTitle($url)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $curl_handle,
            CURLOPT_USERAGENT,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13'
        );
        $fp = curl_exec($curl_handle);
        curl_close($curl_handle);

        $res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
        if (!$res)
            return null;

        $title = preg_replace('/\s+/', ' ', $title_matches[1]);
        $title = trim($title);
        return $title;
    }
}