<?php
/**
 * Created by PhpStorm.
 * User: muzhilkin
 * Date: 06.06.2018
 * Time: 11:31
 */

return [
    // таблица пользователей-авторов комментариев
    'users' => 'users',
    // адрес, по которому добавляются комменты
    'addCommentRoute' => 'addComment',
    // адрес, по которому добавляются оценки комментам
    'addVoteToCommentRoute' => 'addVoteToComment',
    // имен таблиц, сущности которых могут иметь комментарии
    'commentable' => ['books', 'reviews'],
    // количество отображаемых комментариев по дефолту
    'displayedCommentsCount' => 10
];