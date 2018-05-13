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
     * @param $id String|integer идентификатор автора
     * @return \Illuminate\Support\Collection
     */
    public static function series($id = null)
    {
        return DB::table('author_series')
            ->where('author_id', '=', $id)
            ->select('series_id as id', 'name')
            ->get();
    }

    /**
     * Категории, принадлежащие автору
     * @param $id String|integer идентификатор автора
     * @return \Illuminate\Support\Collection
     */
    public static function categories($id = null)
    {
        return DB::table('author_categories')
            ->where([
                ['author_id', '=', $id],
                ['category_id', '<>', null],
                ['category_name', '<>', null]
            ])
            ->select('category_id as id', 'category_name as name')
            ->get();
    }
}
