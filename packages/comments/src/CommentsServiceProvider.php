<?php

namespace MyLibrary\Comments;

use Illuminate\Support\ServiceProvider;


/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 06.06.2018
 * Time: 10:50
 */
class CommentsServiceProvider extends ServiceProvider
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
        $configPath = __DIR__ . '/config/comments.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('comments.php');
        } else {
            $publishPath = base_path('config/comments.php');
        }

        // Регистрация(загрузка) шаблона
        $this->loadViewsFrom(__DIR__ . '/view', 'comments');
        $this->loadRoutesFrom(__DIR__ . '/routes/comments.php');
        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        $this->publishes([
            // Публикация файла стилей
            __DIR__ . '/css' => public_path('css/custom'),
            // Публикация файла скриптов
            __DIR__ . '/js' => public_path('js/custom'),
            // Публикация файла конфига
            $configPath => $publishPath
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('comments', function () {
            return new Comments();
        });
    }
}