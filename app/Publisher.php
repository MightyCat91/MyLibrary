<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Publisher extends Model
{
    protected $fillable = ['name'];

    protected $guarded = ['id'];

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

    /**
     * Серии, принадлежащие издательству
     */
    public function scopeSeries()
    {
        return DB::table('publisher_book')
            ->where('publisher_book.publisher_id','=',$this->id)
            ->join('book_series','book_series.book_id','=','publisher_book.book_id')
            ->join('series','series.id','=','book_series.series_id')
            ->distinct()
            ->select('series.id','series.name')
            ->where('isPublisher','=','true')
            ->get();
    }
}