<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $fillable = ['name', 'isPublisher'];

    protected $guarded = ['id'];


    /**
     * Книги, принадлежащие серии
     */
    public function books()
    {
        return $this->belongsToMany('App\Book');
    }

    /**
     * Добавление в таблицу серий новых данных
     * @param $query
     * @param $name
     * @return
     */
    public function scopeAddSeries($query, $name)
    {
        return $query->insert([
                'name' => $name,
                'isPublisher' => false
            ]);
    }
}
