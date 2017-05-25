<?php

namespace MyLibrary\Alerts;

use Illuminate\Support\ServiceProvider;

class AlertServiceProvider extends ServiceProvider
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
        // Установка настроек по умолчанию
        $this->mergeConfigFrom(__DIR__ . "/config/Alert.php", 'alert');
        // Выполнение после-регистрационной загрузки сервисов
        $this->publishes([
            // Публикация файла настроек
            __DIR__.'/config/alert.php' => config_path('Alert.php'),
            // Публикация файла стилей
            __DIR__.'/css' => public_path('css/custom'),
            // Публикация js-файла
            __DIR__.'/js' => public_path('js/custom'),
            // Публикация изображения
            __DIR__.'/images' => public_path('images'),
        ]);
    }

    /**
     * Регистрация сервис-провайдера.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('alert', function ($app) {
            return new Alert($app['session.store']);
        });
        //настройки пакета по умолчанию
        $this->mergeConfigFrom(
            __DIR__ . '/config/alert.php', 'alert'
        );

        $this->app->alias('alert', Alert::class);
    }

    /**
     * Получить сервисы от провайдера.
     *
     * @return array
     */
    public function provides()
    {
        return ['alert'];
    }
}
