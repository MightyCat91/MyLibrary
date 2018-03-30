<?php

use App\User;

/**
 * Получение массива публичных изображений из указанной папки
 *
 * @var string $imgFolder имя папки соответствующее определенного типа изображений(авторы, книги, жанры)
 * @var string $id имя папки соответствующее id необходимого автора, книги, жанра, юзера
 * @return array
 */
function getAllStorageFiles($imgFolder, $id)
{
    return glob(sprintf('storage/%s/%s/*.{jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF}', $imgFolder, $id), GLOB_BRACE);
}

/**
 * Получение публичного изображения из указанной папки
 *
 * @var string $imgFolder имя папки соответствующее определенного типа изображений(авторы, книги, жанры)
 * @var string $id имя папки соответствующее id необходимого автора, книги, жанра, юзера
 * @return array
 */
function getStorageFile($imgFolder, $id)
{
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

/**
 * Преобразование результата запроса из коллекции в массив
 *
 * @param $query \Illuminate\Database\Eloquent\Collection результат запроса
 * @return array массив
 */
function queryToArray($query)
{
    return array_map(function ($value) {
        return (array)$value;
    }, $query->toArray());
}

/**
 * Получение списка элементов грида(книг, авторов) с рейтингом и статусом избранного
 *
 * @param $items \Illuminate\Database\Eloquent\Collection коллекция элементов
 * @param $favoriteItemType string тип элемента
 * @return mixed массив элементов
 */
function getGridItemsWithRatingAndFavoriteStatus($items, $favoriteItemType)
{
    $itemsId = $items->pluck('id');
    $itemsName = $items->pluck('name');
    $favoriteItemsId = User::where('id', auth()->id())->pluck('favorite')->pluck($favoriteItemType)->flatten();
    $itemsInFavorite = $itemsId->map(function ($id) use ($favoriteItemsId) {
        if ($favoriteItemsId) {
            $inFavorite = $favoriteItemsId->search($id) === false ? false : true;
        } else {
            $inFavorite = false;
        }
        return $inFavorite;
    });
    $authorsRating = $items->pluck('rating')->map(function ($item) {
        return empty($item) ? 0 : array_sum($item) / count($item);
    });

    return $itemsId->map(function ($id, $key) use ($itemsName, $itemsInFavorite, $authorsRating) {
        return [
            'id' => $id,
            'name' => $itemsName[$key],
            'inFavorite' => $itemsInFavorite[$key],
            'rating' => $authorsRating[$key]
        ];
    })->toArray();
}
