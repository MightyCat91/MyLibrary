<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['text', 'rating'];

    protected $guarded = ['id'];

    protected $casts = [
        'rating' => 'array'
    ];

    /**
     * Получение всех рецензий
     *
     * @return mixed
     */
    public static function getAllReviews()
    {
        return DB::table('reviews_view')->orderBy('date', 'desc')->get();
    }
}
