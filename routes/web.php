<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', [
    'as' => 'home', 'uses' => 'Controller@index'
]);

Route::get('year/{year}/books', [
    'as' => 'year-books', 'uses' => 'BookController@showBooksForYear'
]);

Route::group(['prefix' => 'publisher'], function () {
    Route::group(['prefix' => '{id}', 'where' => ['id' => '[0-9]+']], function (){
        Route::get('', [
            'as' => 'publisher-books', 'uses' => 'PublisherController@show'
        ]);
        Route::get('filterLetter', [
            'uses' => 'Controller@showFiltered'
        ]);
    });
    Route::group(['prefix' => 'all'], function (){
        Route::get('', [
            'as' => 'publishers', 'uses' => 'PublisherController@show'
        ]);
        Route::get('filterLetter', [
            'uses' => 'Controller@showFiltered'
        ]);
    });
});

Route::group(['prefix' => 'book'], function () {
    Route::group(['prefix' => 'all'], function () {
        Route::get('', [
            'as' => 'books', 'uses' => 'BookController@show'
        ]);
        Route::get('filterLetter', [
            'uses' => 'BookController@showFiltered'
        ]);
    });
    Route::group(['prefix' => 'add'], function () {
        Route::get('', [
            'as' => 'book-add-get', 'uses' => 'BookController@create'
        ])->middleware('auth');
        Route::post('', [
            'as' => 'book-add-post', 'uses' => 'BookController@store'
        ])->middleware('auth');
        Route::post('ajaxImg', [
            'uses' => 'BookController@addImgAJAX'
        ])->middleware('auth');
    });
    Route::get('{id}', [
        'as' => 'book', 'uses' => 'BookController@show'
    ]);
});

Route::group(['prefix' => 'author'], function () {
    Route::group(['prefix' => '{id}', 'where' => ['id' => '[0-9]+']], function () {
        Route::get('books', [
            'as' => 'author-books', 'uses' => 'BookController@showBooksForAuthor'
        ]);
        Route::get('', [
            'as' => 'author', 'uses' => 'AuthorController@show'
        ]);
    });
    Route::group(['prefix' => 'add'], function () {
        Route::get('', [
            'as' => 'author-add-get', 'uses' => 'AuthorController@create'
        ])->middleware('auth');
        Route::post('', [
            'as' => 'author-add-post', 'uses' => 'AuthorController@store'
        ])->middleware('auth');
        Route::post('ajaxImg', [
            'uses' => 'AuthorController@addImgAJAX'
        ])->middleware('auth');
    });
    Route::group(['prefix' => 'all'], function () {
        Route::get('', [
            'as' => 'authors', 'uses' => 'AuthorController@show'
        ]);
        Route::get('filterLetter', [
            'uses' => 'Controller@showFiltered'
        ]);
    });
});

Route::group(['prefix' => 'category'], function () {
    Route::group(['prefix' => '{id}', 'where' => ['id' => '[0-9]+']], function () {
        Route::group(['prefix' => 'books'], function () {
            Route::get('', [
                'as' => 'category-books', 'uses' => 'CategoriesController@showBooks'
            ]);
            Route::get('filterLetter', [
                'uses' => 'Controller@showFiltered'
            ]);
        });
        Route::group(['prefix' => 'authors'], function () {
            Route::get('', [
                'as' => 'category-authors', 'uses' => 'CategoriesController@showAuthors'
            ]);
            Route::get('filterLetter', [
                'uses' => 'Controller@showFiltered'
            ]);
        });
    });
    Route::group(['prefix' => 'all'], function () {
        Route::get('', [
            'as' => 'categories', 'uses' => 'CategoriesController@show'
        ]);
        Route::get('filterLetter', [
            'uses' => 'Controller@showFiltered'
        ]);
    });
});

Route::group(['prefix' => 'series'], function () {
    Route::group(['prefix' => '{id}', 'where' => ['id' => '[0-9]+']], function () {
        Route::get('', [
            'as' => 'series-books', 'uses' => 'SeriesController@showBooks'
        ]);
        Route::get('filterLetter', [
            'uses' => 'Controller@showFiltered'
        ]);
    });
});

//TODO: реализовать вьюху и контроллер страницы разработчиков
Route::get('developers', ['as' => 'developers', 'uses' => 'MainController@test']);
//TODO: реализовать вьюху и контроллер личного кабинета
Route::get('user/profile', ['as' => 'userProfile', 'uses' => 'MainController@test']);

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@login')->name('loginPost');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
