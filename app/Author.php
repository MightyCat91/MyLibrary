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
     */
    public function scopeSeries()
    {
        return DB::table('author_series')
            ->where('author_id', '=', $this->id)
            ->select('series_id as id', 'name')
            ->get();
    }

    /**
     * Категории, принадлежащие автору
     */
    public function scopeCategories()
    {
        return DB::table('author_categories')
            ->where('author_id', '=', $this->id)
            ->select('category_id as id', 'category_name as name')
            ->get();
    }
}
