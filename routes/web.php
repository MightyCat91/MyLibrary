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

Route::get('author/{id}/books', [
    'as' => 'author-books', 'uses' => 'BookController@showBooksForAuthor'
]);

Route::get('author/all', [
    'as' => 'authors', 'uses' => 'AuthorController@show'
]);

Route::get('author/{id}', [
    'as' => 'author', 'uses' => 'AuthorController@show'
]);

Route::get('category/{id}', [
    'as' => 'category-books', 'uses' => 'CategoriesController@show'
]);

Route::get('book/all', [
    'as' => 'books', 'uses' => 'BookController@show'
]);

Route::get('book/{id}', [
    'as' => 'book', 'uses' => 'BookController@show'
]);

Route::get('year/{year}/books', [
    'as' => 'year-books', 'uses' => 'BookController@showBooksForYear'
]);

Route::get('publisher/{id}', [
    'as' => 'publisher-books', 'uses' => 'PublisherController@show'
]);