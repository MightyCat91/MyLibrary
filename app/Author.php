<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['name', 'biography'];

    protected $guarded = ['id'];
    /**
     * Книги, принадлежащие автору
     */
    public function books()
    {
        return $this->belongsToMany('App\Book');
    }

    /**
     * Категории, принадлежащие автору
     */
    public function categories()
    {
        return $this->belongsToMany('App\Categories', 'author_categories', 'author_id', 'category_id');
    }
}
