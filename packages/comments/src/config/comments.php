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
    'route' => 'addComment',
    // имен таблиц, сущности которых могут иметь комментарии
    'commentable' => ['books', 'reviews']
];