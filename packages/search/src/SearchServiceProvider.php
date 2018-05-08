<?php

namespace MyLibrary\Search;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Route;


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
        $this->loadViewsFrom(__DIR__ . '/view', 'search');

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

        Route::post($route, function (Request $request){
            $searchedText = $request->get('text');
            $a = new Search();
            return $a->search($searchedText);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->singleton('search', function ($app) {
//            return $app->make(Search::class);
//        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
//        return [Search::class];
    }

}
