<?php
/**
 * Получение массива публичных изображений из указанной папки
 *
 * @var string $imgFolder имя папки соответствующее определенного типа изображений(авторы, книги, жанры)
 * @var string $id имя папки соответствующее id необходимого автора, книги, жанра
 * @return array
 */function getPublicFiles($imgFolder, $id) {
    return glob(sprintf('storage/%s/%s/*.{jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF}', $imgFolder, $id), GLOB_BRACE);
}