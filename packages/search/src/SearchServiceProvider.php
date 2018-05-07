<?php

namespace MyLibrary\Search;

use Illuminate\Support\ServiceProvider;


class SearchServiceProvider extends ServiceProvider
{
    /**
     * Задаём, отложена ли загрузка провайдера.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //регистрируем конфиг
        $configPath = __DIR__ . '/config/search.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('search.php');
        } else {
            $publishPath = base_path('config/search.php');
        }

        // Регистрация(загрузка) шаблона
        $this->loadViewsFrom(__DIR__.'/view', 'search');

        $this->publishes([
            // Публикация файла стилей
            __DIR__ . '/css' => public_path('css/custom'),
            // Публикация файла скриптов
            __DIR__ . '/js' => public_path('js/custom'),
            // Публикация файла конфига
            $configPath => $publishPath,
            __DIR__ . '/view' => base_path('resources/views/layouts')
        ]);

        $route = $this->app['config']->get('search.route');

        $routeConfig = [
            'namespace' => 'MyLibrary\Search\Controllers',
            'prefix' => $this->app['config']->get('debugbar.route_prefix'),
            'domain' => $this->app['config']->get('debugbar.route_domain'),
        ];
        $this->app['router']->group($routeConfig, function($router) use$route {
            $router->post($route, [
                'uses' =>  __DIR__ .'/Controllers/SearchController@search'
            ]);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('search', function ($app) {
            return $app->make(Search::class);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Search::class];
    }

}
