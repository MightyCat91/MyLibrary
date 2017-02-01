<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
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
