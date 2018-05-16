<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed id
 */
class Book extends Model
{
    use Notifiable;

    protected $fillable = ['name', 'description', 'year', 'page_counts', 'isbn', 'moderate', 'rating'];

    protected $guarded = ['id'];

    protected $casts = [
        'rating' => 'array'
    ];

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

    /**
     * Серии, принадлежащие книге
     */
    public function series()
    {
        return $this->belongsToMany('App\Series');
    }

    /**
     * Книги этой же серии, принадлежащей автору
     */
    public function scopeAuthorSeriesBooks()
    {
        return queryToArray(
            DB::table('series')->where('isPublisher', '=', false)
                ->join(DB::raw("(SELECT series_id FROM book_series WHERE book_id = $this->id) as t1"),
                    'series.id', '=', 't1.series_id')
                ->join('book_series', 'book_series.series_id', '=', 't1.series_id')
                ->join('books', function ($join) {
                    $join->on('book_series.book_id', '=', 'books.id')
                        ->where('books.id', '<>', $this->id);
                })
                ->select('books.id', 'books.name')
                ->distinct()
                ->get()
        );
    }

    /**
     * Книги этой же серии, принадлежащей издательству
     */
    public function scopePublisherSeriesBooks()
    {
        return queryToArray(
            DB::table(DB::raw("(SELECT series_id FROM book_series WHERE book_id = $this->id) as t1"))
                ->join('book_series', 'book_series.series_id', '=', 't1.series_id')
                ->join('books', function ($join) {
                    $join->on('book_series.book_id', '=', 'books.id')
                        ->where('books.id', '<>', $this->id);
                })
                ->select('books.id', 'books.name')
                ->distinct()
                ->get()
        );
    }

    /**
     * Книги этого же автора
     */
    public function scopeAuthorBooks()
    {
        return queryToArray(
            DB::table(DB::raw("(SELECT author_id FROM author_book WHERE book_id = $this->id) as t1"))
                ->join('author_book', 'author_book.author_id', '=', 't1.author_id')
                ->join('books', function ($join) {
                    $join->on('author_book.book_id', '=', 'books.id')
                        ->where('books.id', '<>', $this->id);
                })
                ->select('books.id', 'books.name')
                ->distinct()
                ->get()
        );
    }

    /**
     * Количество пользователей добавивших книгу в избранное
     *
     * @return mixed
     */
    public function inFavoriteCount()
    {
        return array_first(
            DB::select('SELECT COUNT(favorite) FROM users WHERE favorite @> \'{"book": ["' . $this->id . '"]}\''))
            ->count;
    }

    /**
     * Количество пользователей добавивших книгу в избранное
     *
     * @return mixed
     */
    public function completedCount()
    {
        return array_first(
            DB::select('SELECT COUNT(statistic) FROM users WHERE statistic @> \'{"completed": ["' . $this->id . '"]}\''))
            ->count;
    }
}
