<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 28.05.2017
 * Time: 18:25
 */

namespace MyLibrary\Breadcrumbs;

use Illuminate\Support\Manager;
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
        $this->loadViewsFrom(__DIR__.'/views', 'alert');
        // Выполнение после-регистрационной загрузки сервисов
        $this->publishes([
            // Публикация файла стилей
            __DIR__.'/css' => public_path('css/custom')
        ]);
        //подключение маршрутов для хлебных крошек
        if (file_exists(app_path('/routes/breadcrumbs.php'))) {
            require $this;
        }
    }

    /**
     * Регистрация сервис-провайдера.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Breadcrumbs::class, function ($app) {
            return $app->make(BreadcrumbsManager::class);
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