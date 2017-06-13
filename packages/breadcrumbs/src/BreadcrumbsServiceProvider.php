<?php

namespace MyLibrary\Breadcrumbs;

use Illuminate\Support\ServiceProvider;

class BreadcrumbsServiceProvider extends ServiceProvider
{
    /**
     * Задаём, отложена ли загрузка провайдера.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Загрузка сервисов после регистрации.
     *
     * @return void
     */
    public function boot()
    {
        // Регистрация(загрузка) шаблона
        $this->loadViewsFrom(__DIR__.'/views', 'breadcrumbs');
        // Выполнение после-регистрационной загрузки сервисов
        $this->publishes([
            // Публикация файла стилей
            __DIR__.'/css' => public_path('css/custom')
        ]);
        //подключение маршрутов для хлебных крошек
        if (file_exists($file = base_path('routes/breadcrumbs.php'))) {
            require $file;
        }
    }

    /**
     * Регистрация сервис-провайдера.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('breadcrumbs', function ($app) {
            return $app->make(Breadcrumbs::class);
        });
    }

    /**
     * Получить сервисы от провайдера.
     *
     * @return array
     */
    public function provides()
    {
        return ['breadcrumbs'];
    }
}