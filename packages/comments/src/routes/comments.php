<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 06.06.2018
 * Time: 13:42
 */

Route::post(config('search.route'), 'CommentsController@addComment');