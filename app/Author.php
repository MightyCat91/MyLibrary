<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed id
 */
class Author extends Model
{
    protected $fillable = ['name', 'biography', 'moderate'];

    protected $guarded = ['id'];

    protected $casts = [
        'rating' => 'array'
    ];

    /**
     * Книги, принадлежащие автору
     */
    public function books()
    {
        return $this->belongsToMany('App\Book');
    }


    /**
     * Серии, принадлежащие автору
     * @return \Illuminate\Support\Collection
     * @internal param int|String $id идентификатор автора
     */
    public function seriesWithInstance()
    {
        return DB::table('author_series')
            ->where('author_id', '=', $this->id)
            ->select('series_id as id', 'name')
            ->get();
    }

    /**
     * Серии, принадлежащие автору
     * @param $id String|integer идентификатор автора
     * @return array
     */
    public static function series($id)
    {
        return DB::table('author_series')
            ->where('author_id', '=', $id)
            ->select('series_id as id', 'name')
            ->get()->transform(function ($item, $key) {
                return ['id' => $item->id, 'name' => $item->name];
            })->all();
    }

    /**
     * Категории, принадлежащие автору
     * @return \Illuminate\Support\Collection
     * @internal param int|String $id идентификатор автора
     */
    public function categoriesWithInstance()
    {
        return DB::table('author_categories')
            ->where([
                ['author_id', '=', $this->id],
                ['category_id', '<>', null],
                ['category_name', '<>', null]
            ])
            ->select('category_id as id', 'category_name as name')
            ->get();
    }

    /**
     * Категории, принадлежащие автору
     * @param $id String|integer идентификатор автора
     * @return array
     */
    public static function categories($id)
    {
        return DB::table('author_categories')
            ->where([
                ['author_id', '=', $id],
                ['category_id', '<>', null],
                ['category_name', '<>', null]
            ])
            ->select('category_id as id', 'category_name as name')
            ->get()->transform(function ($item, $key) {
                return ['id' => $item->id, 'name' => $item->name];
            })->all();
    }

    /**
     * Количество пользователей добавивших автора в избранное
     *
     * @return mixed
     */
    public function inFavoriteCountWithInstance()
    {
        return $this->getInFavorite($this->id);
    }

    /**
     * Количество пользователей добавивших автора в избранное
     *
     * @param $id int|string идентификатор автора
     * @return mixed
     */
    public static function inFavoriteCount($id)
    {
        return (new self())->getInFavorite($id);

    }

    /**
     * Количество пользователей добавивших автора в избранное
     *
     * @return mixed
     */
    public function nowReadingCountWithInstance()
    {
        return $this->getNowReading($this->id);
    }

    /**
     * Количество пользователей добавивших автора в избранное
     *
     * @param $id int|string идентификатор автора
     * @return mixed
     */
    public static function nowReadingCount($id)
    {
        return (new self())->getNowReading($id);
    }



    protected function getNowReading($id)
    {
        $book_id =  DB::table('author_book')->where('author_id','=', $id)->get(['book_id'])
            ->transform(function($item, $key) {
                return $item->book_id;
            })
            ->all();
        $result = [];
        foreach ($book_id as $id) {
            $count = array_first(
                DB::select('SELECT id FROM users WHERE statistic @> \'{"reading": ["' . $id . '"]}\''));
            if (!empty($count)) {
                $result[] = $count;
            }
        }
        return count($result);
    }

    protected function getInFavorite($id)
    {
        return array_first(
            DB::select('SELECT COUNT(favorite) FROM users WHERE favorite @> \'{"author": ["' . $id . '"]}\''))->count;
    }
}
