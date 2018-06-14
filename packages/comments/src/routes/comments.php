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