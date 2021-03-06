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

Route::post('/changeFavoriteStatus', [
    'as' => 'changeFavoriteStatus', 'uses' => 'UserController@changeFavoriteStatus'
])->middleware('auth');

Route::get('reviews', [
    'as' => 'reviews', 'uses' => 'Controller@getAllReviews'
]);

Route::group(['prefix' => 'year/{year}/books'], function () {
    Route::get('', [
        'as' => 'year-books', 'uses' => 'BookController@showBooksForYear'
    ]);
    Route::get('changeViewType', [
        'as' => 'changeViewType', 'uses' => 'BookController@changeBooksViewTypeForYear'
    ]);
});

Route::group(['prefix' => 'publisher'], function () {
    Route::group(['prefix' => '{id}', 'where' => ['id' => '[0-9]+']], function () {
        Route::get('', [
            'as' => 'publisher-books', 'uses' => 'PublisherController@show'
        ]);
    });
});

Route::group(['prefix' => 'book'], function () {
    Route::group(['prefix' => 'all'], function () {
        Route::get('', [
            'as' => 'books', 'uses' => 'BookController@show'
        ]);
        Route::get('changeViewType', [
            'as' => 'changeViewType', 'uses' => 'BookController@changeViewType'
        ]);
//        Route::post('', [
//            'as' => 'changeFavoriteStatus', 'uses' => 'UserController@changeFavoriteStatus'
//        ])->middleware('auth');
    });
    Route::group(['prefix' => 'add'], function () {
        Route::get('', [
            'as' => 'book-add-get', 'uses' => 'BookController@create'
        ])->middleware('auth');
        Route::post('', [
            'as' => 'book-add-post', 'uses' => 'BookController@store'
        ])->middleware('auth');
        Route::post('addImg', [
            'uses' => 'BookController@addImgAJAX'
        ])->middleware('auth');
        Route::post('deleteImg', [
            'uses' => 'BookController@deleteImgAJAX'
        ])->middleware('auth');
    });
    Route::group(['prefix' => '{id}'], function () {
        Route::get('', [
            'as' => 'book', 'uses' => 'BookController@show'
        ]);
        Route::post('changeStatus', [
            'as' => 'changeStatus', 'uses' => 'UserController@changeStatus'
        ])->middleware('auth');
        Route::post('changeRating', [
            'as' => 'changeRating', 'uses' => 'BookController@changeBookRating'
        ])->middleware('auth');
        Route::post('changeProgress', [
            'as' => 'changeProgress', 'uses' => 'UserController@changeProgress'
        ])->middleware('auth');
    });
    Route::post('addVoteForReview', [
        'as' => 'voteForReview', 'uses' => 'BookController@addVoteForReview'
    ]);
    Route::post('addReview', [
        'as' => 'addReview', 'uses' => 'BookController@addReview'
    ])->middleware('auth');
});

Route::group(['prefix' => 'author'], function () {
    Route::group(['prefix' => '{id}', 'where' => ['id' => '[0-9]+']], function () {
        Route::group(['prefix' => 'books'], function () {
            Route::get('', [
                'as' => 'author-books', 'uses' => 'BookController@showBooksForAuthor'
            ]);
            Route::get('changeViewType', [
                'as' => 'changeViewType', 'uses' => 'BookController@changeBooksViewTypeForAuthor'
            ]);
        });
        Route::get('', [
            'as' => 'author', 'uses' => 'AuthorController@show'
        ]);
        Route::post('changeRating', [
            'as' => 'changeRating', 'uses' => 'AuthorController@changeAuthorRating'
        ]);
    });
    Route::group(['prefix' => 'add'], function () {
        Route::get('', [
            'as' => 'author-add-get', 'uses' => 'AuthorController@create'
        ])->middleware('auth');
        Route::post('', [
            'as' => 'author-add-post', 'uses' => 'AuthorController@store'
        ])->middleware('auth');
        Route::post('addImg', [
            'uses' => 'AuthorController@addImgAJAX'
        ])->middleware('auth');
        Route::post('deleteImg', [
            'uses' => 'AuthorController@deleteImgAJAX'
        ])->middleware('auth');
    });
    Route::group(['prefix' => 'all'], function () {
        Route::get('', [
            'as' => 'authors', 'uses' => 'AuthorController@show'
        ]);
        Route::get('changeViewType', [
            'as' => 'changeViewType', 'uses' => 'AuthorController@changeViewType'
        ]);
//        Route::post('', [
//            'as' => 'changeFavoriteStatus', 'uses' => 'UserController@changeFavoriteStatus'
//        ])->middleware('auth');
    });

});

Route::group(['prefix' => 'category'], function () {
    Route::group(['prefix' => '{id}', 'where' => ['id' => '[0-9]+']], function () {
        Route::group(['prefix' => 'books'], function () {
            Route::get('', [
                'as' => 'category-books', 'uses' => 'CategoriesController@showBooks'
            ]);
            Route::get('changeViewType', [
                'as' => 'changeViewType', 'uses' => 'BookController@changeViewType'
            ]);
        });
        Route::get('authors', [
            'as' => 'category-authors', 'uses' => 'CategoriesController@showAuthors'
        ]);
        Route::group(['prefix' => 'authors'], function () {
            Route::get('', [
                'as' => 'category-authors', 'uses' => 'CategoriesController@showAuthors'
            ]);
            Route::get('changeViewType', [
                'as' => 'changeViewType', 'uses' => 'AuthorController@changeViewType'
            ]);
        });
    });
    Route::get('all', [
        'as' => 'categories', 'uses' => 'CategoriesController@show'
    ]);
});

Route::group(['prefix' => 'series'], function () {
    Route::group(['prefix' => '{id}', 'where' => ['id' => '[0-9]+']], function () {
        Route::get('', [
            'as' => 'series-books', 'uses' => 'BookController@showBooksForSeries'
        ]);
        Route::get('changeViewType', [
            'as' => 'changeViewType', 'uses' => 'BookController@changeBooksViewTypeForSeries'
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
        Route::group(['prefix' => 'library'], function () {
            Route::get('', [
                'as' => 'userLibrary', 'uses' => 'UserController@showUserLibrary'
            ])->middleware('auth');
            Route::post('changeRating', [
                'as' => 'changeRating', 'uses' => 'UserController@changeBookRating'
            ])->middleware('auth');
        });
        Route::get('reviews', [
            'as' => 'getAllReviewsForUser', 'uses' => 'UserController@getAllReviewsForUser'
        ]);
        Route::get('history', [
            'as' => 'userHistory', 'uses' => 'UserController@showUserHistoryPage'
        ])->middleware('auth');
        Route::get('edit', [
            'as' => 'userEditProfile', 'uses' => 'UserController@showEditUserProfilePage'
        ])->middleware(['auth']);
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
Route::post('register', 'Auth\RegisterController@register')->name('register')->middleware('guest');

// Password Reset Routes...
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset', [
    'as' => 'resetPassword', 'uses' => 'Auth\ResetPasswordController@showResetForm'
]);
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');