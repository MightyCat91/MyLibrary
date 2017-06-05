<?php

namespace MyLibrary\Breadcrumbs;


use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use MyLibrary\Breadcrumbs\Exceptions\AlreadyExistsException;
use MyLibrary\Breadcrumbs\Exceptions\NotFoundException;

class Breadcrumbs
{
    protected $breadcrumbs;
    protected $breadcrumbsCollections;
    protected $currentRoute;

    public function __construct() {
        $this->currentRoute = url()->current();
        $this->breadcrumbsCollections = new Collection();
        $this->breadcrumbs = new Collection();
    }

    public function add($name, $route, $parameters = [], $parent = null) {
        if (!empty($parameters)) {
            foreach ($parameters as $name => $param) {
                if (preg_match('/\{'. $name .'\}/', $route)) {
                    throw UrlGenerationException::forMissingParameters($route);
                }
                $id = $page->pluck('id');
            }
        }
        $url = route($route);
        if ($this->hasBreadcrumbs('name', $name)) {
            throw new AlreadyExistsException("Breadcrumbs have already been defined for route [{$name}].");
        }
        if ($this->hasBreadcrumbs('url', $url)) {
            throw new AlreadyExistsException("Breadcrumbs have already been defined for route [{$url}].");
        }
        $this->breadcrumbsCollections->push([
            'name' => $name,
            'url' => $url,
            'parent' => $parent
        ]);
    }

    public function render() {
        dd($this->breadcrumbsCollections);
        if ($breadcrumbs = $this->getBreadcrumbs()->toArray()) {
            \Session::forget('title');
            return new HtmlString(
                view('breadcrumbs::breadcrumbs')->with('breadcrumbs', $breadcrumbs)->render()
            );
        }
    }

    protected function getBreadcrumbs() {
        if ($this->currentRoute != route('home')) {
            if (!$this->hasBreadcrumbs('url', $this->currentRoute)) {
                throw new NotFoundException("No breadcrumbs defined for route [{$this->currentRoute}].");
            }
        }
        $key = $this->breadcrumbsCollections->search(function ($item) {
            return  $item['url'] == $this->currentRoute;
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

    protected function call($name) {
        if (!$name) {
            return null;
        }
        else {
            $key = $this->breadcrumbsCollections->search(function ($item) use ($name) {
                return  $item['name'] == $name;
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

    protected function hasBreadcrumbs($key, $value) {
        return $this->breadcrumbsCollections->contains(function ($item) use ($key, $value) {
            return $item[$key] == $value;
        });
    }

    protected function getPageTitle($url) {
        $curl_handle=curl_init();
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