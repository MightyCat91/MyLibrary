<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        return $this->belongsToMany('App\Book', 'book_categories', 'category_id', 'book_id');
    }

    /**
     * Авторы принадлежащие категории
     */
    public function scopeAuthors()
    {
        return DB::table('author_categories')
            ->where('category_id','=',$this->id)
            ->select('author_id as id','author_name as name')
            ->get();
    }
}
