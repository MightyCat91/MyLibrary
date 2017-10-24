<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property mixed name
 * @property mixed email
 * @property string password
 * @property bool subscribed
 * @property static last_visit
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'name', 'email', 'password', 'last_visit', 'subscribed', 'gender', 'favorite', 'statistic', 'rating'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'favorite' => 'array',
        'statistic' => 'array',
        'rating' => 'array',
        'progress' =>'array'
    ];
}
