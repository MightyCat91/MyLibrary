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
     * Обзоры, принадлежащие данной книге
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
//    public function reviews()
//    {
//        return $this->hasMany('App\Review');
//    }

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
    public function inFavoriteCountWithInstance()
    {
        return $this->getInFavorite($this->id);
    }

    /**
     * Количество пользователей добавивших книгу в избранное
     *
     * @param $id int|string идентификатор автора
     * @return mixed
     */
    public static function inFavoriteCount($id)
    {
        return (new self())->getInFavorite($id);

    }

    /**
     * Количество пользователей читающих книгу
     *
     * @return mixed
     */
    public function nowReadingCountWithInstance()
    {
        return $this->getNowReading($this->id);
    }

    /**
     * Количество пользователей читающих книгу
     *
     * @param $id int|string идентификатор автора
     * @return mixed
     */
    public static function nowReadingCount($id)
    {
        return (new self())->getNowReading($id);
    }

    /**
     * Количество пользователей прочитавших книгу
     *
     * @return mixed
     */
    public function completedCountWithInstance()
    {
        return $this->getCompleted($this->id);
    }

    /**
     * Количество пользователей прочитавших книгу
     *
     * @param $id int|string идентификатор автора
     * @return mixed
     */
    public static function completedCount($id)
    {
        return (new self())->getCompleted($id);
    }

    /**
     * Количество пользователей планирующих прочитать книгу
     *
     * @return mixed
     */
    public function inPlansCountWithInstance()
    {
        return $this->getInPlans($this->id);
    }

    /**
     * Количество пользователей планирующих прочитать книгу
     *
     * @param $id int|string идентификатор автора
     * @return mixed
     */
    public static function inPlansCount($id)
    {
        return (new self())->getInPlans($id);
    }

    /**
     * Получить рецензии на эту книгу
     */
    public function reviews()
    {
        return DB::table('reviews_view')->where('book_id', '=', $this->id)->get();
    }



    protected function getNowReading($id)
    {
        return array_first(
            DB::select('SELECT COUNT(statistic) FROM users WHERE statistic @> \'{"reading": ["' . $id . '"]}\''))->count;
    }

    protected function getCompleted($id)
    {
        return array_first(
            DB::select('SELECT COUNT(statistic) FROM users WHERE statistic @> \'{"completed": ["' . $id . '"]}\''))->count;
    }

    protected function getInPlans($id)
    {
        return array_first(
            DB::select('SELECT COUNT(statistic) FROM users WHERE statistic @> \'{"inPlans": ["' . $id . '"]}\''))
            ->count;
    }

    protected function getInFavorite($id)
    {
        return array_first(
            DB::select('SELECT COUNT(favorite) FROM users WHERE favorite @> \'{"book": ["' . $id . '"]}\''))->count;
    }
}
