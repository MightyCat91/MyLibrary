<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 */
class Book extends Model
{
    protected $fillable = ['name', 'description', 'year', 'page_counts', 'isbn', 'moderate'];

    protected $guarded = ['id'];

    /**
     * Авторы, принадлежащие книге
     */
    public function authors()
    {
        return $this->belongsToMany('App\Author');
    }

    /**
     * Категории, принадлежащие книге
     */
    public function categories()
    {
        return $this->belongsToMany('App\Categories', 'book_categories', 'book_id', 'category_id');
    }

    /**
     * Издатели, принадлежащие книге
     */
    public function publishers()
    {
        return $this->belongsToMany('App\Publisher');
    }
}
