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
    Route::group(['prefix' => '{id}', 'where' => ['id' => '[0-9]+']], function () {
        Route::get('', [
            'as' => 'publisher-books', 'uses' => 'PublisherController@show'
        ]);
    });
    Route::get('all', [
        'as' => 'publishers', 'uses' => 'PublisherController@show'
    ]);
});

Route::group(['prefix' => 'book'], function () {
    Route::get('all', [
        'as' => 'books', 'uses' => 'BookController@show'
    ]);
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
    Route::group(['prefix' => '{id}'], function () {
        Route::get('', [
            'as' => 'book', 'uses' => 'BookController@show'
        ]);
        Route::post('', [
            'as' => 'addToFavorite', 'uses' => 'UserController@addToFavorite'
        ]);
        Route::post('changeStatus', [
            'as' => 'changeStatus', 'uses' => 'UserController@changeStatus'
        ]);
        Route::post('changeRating', [
            'as' => 'changeRating', 'uses' => 'UserController@changeRating'
        ]);
    });
});

Route::group(['prefix' => 'author'], function () {
    Route::group(['prefix' => '{id}', 'where' => ['id' => '[0-9]+']], function () {
        Route::get('books', [
            'as' => 'author-books', 'uses' => 'BookController@showBooksForAuthor'
        ]);
        Route::get('', [
            'as' => 'author', 'uses' => 'AuthorController@show'
        ]);
        Route::post('', [
            'as' => 'addToFavorite', 'uses' => 'UserController@addToFavorite'
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
    Route::get('all', [
        'as' => 'authors', 'uses' => 'AuthorController@show'
    ]);
});

Route::group(['prefix' => 'category'], function () {
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

Route::group(['prefix' => 'series'], function () {
    Route::group(['prefix' => '{id}', 'where' => ['id' => '[0-9]+']], function () {
        Route::get('', [
            'as' => 'series-books', 'uses' => 'SeriesController@showBooks'
        ]);
    });
});

Route::group(['prefix' => 'user'], function () {
    Route::group(['prefix' => '{id}', 'where' => ['id' => '[0-9]+']], function () {
        Route::get('profile', [
            'as' => 'userProfile', 'uses' => 'UserController@showUserProfilePage'
        ])->middleware('auth');
        Route::get('collections', [
            'as' => 'userCollections', 'uses' => 'UserController@showUserCollectionsPage'
        ])->middleware('auth');
        Route::get('library', [
            'as' => 'userLibrary', 'uses' => 'UserController@showUserLibrary'
        ])->middleware('auth');
        Route::get('history', [
            'as' => 'userHistory', 'uses' => 'UserController@showUserHistoryPage'
        ])->middleware('auth');
        Route::get('edit', [
            'as' => 'userEditProfile', 'uses' => 'UserController@showEditUserProfilePage'
        ])->middleware('auth');
        Route::get('userBooksStatistic', [
            'as' => 'userBooksStatistic', 'uses' => 'UserController@showBooksForUser'
        ])->middleware('auth');
        Route::get('userAuthorsStatistic', [
            'as' => 'userAuthorsStatistic', 'uses' => 'UserController@showAuthorsForUser'
        ])->middleware('auth');
        Route::get('userCategoriesStatistic', [
            'as' => 'userCategoriesStatistic', 'uses' => 'UserController@showCategoriesForUser'
        ])->middleware('auth');
        Route::get('{status}', [
            'as' => 'userStatusBooks', 'uses' => 'UserController@showStatusBooksForUser'
        ])->middleware('auth');
        Route::get('favorite/{type}', [
            'as' => 'userFavorite', 'uses' => 'UserController@showUserFavorite'
        ])->middleware('auth');
        Route::post('edit', [
            'as' => 'editProfile', 'uses' => 'UserController@editUserProfilePage'
        ])->middleware('auth');
        Route::post('updateProfileImg', [
            'as' => 'updateProfileImg', 'uses' => 'UserController@updateProfileImg'
        ])->middleware('auth');
        Route::post('deleteProfileImg', [
            'as' => 'deleteProfileImg', 'uses' => 'UserController@deleteProfileImg'
        ])->middleware('auth');
    });
    Route::post('saveEmailPass', [
        'as' => 'saveEmailPass', 'uses' => 'UserController@storeEmailPass'
    ])->middleware('auth');
});

//TODO: реализовать вьюху и контроллер страницы разработчиков
Route::get('developers', ['as' => 'developers', 'uses' => 'MainController@test']);
//TODO: реализовать вьюху и контроллер пользовательского соглашения
Route::get('privacyPolicy', ['as' => 'privacyPolicy', 'uses' => 'MainController@test']);

// Authentication Routes...
Route::post('/', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::post('register', 'Auth\RegisterController@register')->name('register');

// Password Reset Routes...
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');