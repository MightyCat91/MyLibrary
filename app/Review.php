<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['text', 'positive', 'negative'];

    protected $guarded = ['id'];

    protected $casts = [
        'positive' =>'array',
        'negative' =>'array'
    ];
}
