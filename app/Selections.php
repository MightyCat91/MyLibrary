<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Selections
 *
 * @property array rating
 * @property integer book_id
 * @property integer user_id
 * @property mixed name
 * @property mixed description
 */

class Selections extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'rating' => 'array',
        'book_id' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'rating', 'book_id', 'user_id', 'description'
    ];

    /**
     *
     */
    public function books()
    {
        return $this->belongsToMany('App\Book');
    }
}
