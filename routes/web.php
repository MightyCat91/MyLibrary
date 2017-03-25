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
    'as' => 'home', 'uses' => 'AuthorController@index'
]);

Route::get('year/{year}/books', [
    'as' => 'year-books', 'uses' => 'BookController@showBooksForYear'
]);

Route::get('publisher/{id}', [
    'as' => 'publisher-books', 'uses' => 'PublisherController@show'
]);

Route::group(['prefix' => 'book'], function(){
    Route::get('all', [
        'as' => 'books', 'uses' => 'BookController@show'
    ]);
    Route::get('add', [
        'as' => 'book-add-get', 'uses' => 'BookController@create'
    ]);
    Route::post('add', [
        'as' => 'book-add-post', 'uses' => 'BookController@store'
    ]);
    Route::post('add/ajaxImg', [
        'uses' => 'BookController@addImgAJAX'
    ]);
    Route::get('{id}', [
        'as' => 'book', 'uses' => 'BookController@show'
    ]);
});

Route::group(['prefix' => 'author'], function(){
    Route::group(['prefix' => '{id}', 'where' => ['id' => '[0-9]+']], function(){
        Route::get('books', [
            'as' => 'author-books', 'uses' => 'BookController@showBooksForAuthor'
        ]);
        Route::get('', [
            'as' => 'author', 'uses' => 'AuthorController@show'
        ]);
    });
    Route::get('all', [
        'as' => 'authors', 'uses' => 'AuthorController@show'
    ]);
    Route::get('add', [
        'as' => 'author-add-get', 'uses' => 'AuthorController@create'
    ]);
    Route::post('add', [
        'as' => 'author-add-post', 'uses' => 'AuthorController@store'
    ]);
    Route::post('add/ajaxImg', [
        'uses' => 'AuthorController@addImgAJAX'
    ]);
});

Route::group(['prefix' => 'category'], function() {
    Route::group(['prefix' => '{id}', 'where' => ['id' => '[0-9]+']], function () {
        Route::get('books', [
            'as' => 'category-books', 'uses' => 'CategoriesController@showBooks'
        ]);
        Route::get('authors', [
            'as' => 'category-authors', 'uses' => 'CategoriesController@showAuthors'
        ]);
    });
    Route::get('all', [
        'as' => 'categories', 'uses' => 'CategoriesController@show'
    ]);
});

//TODO: реализовать вьюху и контроллер страницы разработчиков
Route::get('developers', ['as' => 'developers', 'uses' => 'MainController@test']);