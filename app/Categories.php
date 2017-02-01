<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    /**
     * Таблица, с которой ассоциируется модель
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * Книги, принадлежащие категории
     */
    public function books()
    {
        return $this->belongsToMany('App\Book', 'book_categories', 'book_id', 'category_id');
    }

    /**
     * Авторы принадлежащие категории
     */
    public function authors()
    {
        return $this->belongsToMany('App\Author', 'author_categories', 'author_id', 'category_id');
    }
}
