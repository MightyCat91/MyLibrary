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