<?php
/**
 * Получение массива публичных изображений из указанной папки
 *
 * @var string $imgFolder имя папки соответствующее определенного типа изображений(авторы, книги, жанры)
 * @var string $id имя папки соответствующее id необходимого автора, книги, жанра, юзера
 * @return array
 */
function getAllStorageFiles($imgFolder, $id) {
    return glob(sprintf('storage/%s/%s/*.{jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF}', $imgFolder, $id), GLOB_BRACE);
}

/**
 * Получение публичного изображения из указанной папки
 *
 * @var string $imgFolder имя папки соответствующее определенного типа изображений(авторы, книги, жанры)
 * @var string $id имя папки соответствующее id необходимого автора, книги, жанра, юзера
 * @return array
 */
function getStorageFile($imgFolder, $id) {
    $files = getAllStorageFiles($imgFolder, $id);
    return $files ? $files[0] : null;
}

/**
 * Формирование алерта на серверной стороне
 *
 * @param string $type тип алерта(success, info, warning, danger)
 * @param null $text текст сообщения
 * @param int $delay время отображения(если алерт не должен скрываться автоматически необходимо указать 0)
 */
function alert($type = 'success', $text = null, $delay = 3000)
{
    session()->push('alert', ['type' => $type, 'message' => $text, 'delay' => $delay]);
}

function queryToArray($query)
{
    return array_map(function ($value) {
        return (array) $value;
    }, $query->toArray());
}