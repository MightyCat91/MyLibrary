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
}
