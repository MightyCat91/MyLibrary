<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 06.06.2018
 * Time: 13:42
 */

Route::post(config('comments.addCommentRoute'), [
    'as' => config('comments.addCommentRoute'), 'uses' => 'MyLibrary\Comments\Comments@addComment'
]);

Route::post(config('comments.addVoteToCommentRoute'), [
    'as' => config('comments.addVoteToCommentRoute'), 'uses' => 'MyLibrary\Comments\Comments@addVoteToComment'
]);

Route::post(config('comments.filterCommentRoute'), [
    'as' => config('comments.filterCommentRoute'), 'uses' => 'MyLibrary\Comments\Comments@filterComments'
]);

Route::post(config('comments.deleteCommentRoute'), [
    'as' => config('comments.deleteCommentRoute'), 'uses' => 'MyLibrary\Comments\Comments@deleteComments'
]);