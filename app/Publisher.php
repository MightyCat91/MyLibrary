<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    /**
     * Книги, принадлежащие издательству
     */
    public function books()
    {
        return $this->belongsToMany('App\Book');
    }

    /**
     * Авторы, принадлежащие издательству
     */
    public function authors()
    {
        return $this->hasManyThrough('App\Author', 'App\Book');
    }
}