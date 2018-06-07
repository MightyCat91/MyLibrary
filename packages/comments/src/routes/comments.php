<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 06.06.2018
 * Time: 13:42
 */
$comment = new \MyLibrary\Comments\CommentsController();

Route::post(config('search.route'), $comment->addComment());