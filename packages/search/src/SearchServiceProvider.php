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
    protected $defer = false;

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

        $this->loadRoutesFrom(__DIR__.'/routes/search.php');

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
}
