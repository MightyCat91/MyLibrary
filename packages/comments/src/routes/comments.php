<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 06.06.2018
 * Time: 13:42
 */

Route::post(config('comments.route'), [
    'as' => config('comments.route'), 'uses' => 'MyLibrary\Comments\Comments@addComment'
]);

//Route::post(config('comments.route'), function (\Illuminate\Http\Request $request) {
//    Comments::addComment($request);
//})->name(config('comments.route'));