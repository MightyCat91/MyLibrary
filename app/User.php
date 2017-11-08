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

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     *
     * @param string|array $roles
     * @return bool
     */
    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles);
        }
        return $this->hasRole($roles) || alert('Недостаточно прав для данного действия', 'danger');
    }

    /**
     * Проверка наличия хотя бы одной из ролей из списка у пользователя
     * @param array $roles
     * @return bool
     */
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            return null !== $this->roles()->whereIn('name', $roles)->first();
        }
        return abort(401);
    }

    /**
     * Проверка наличия роли у пользователя
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }

    public function addRoles($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if (Role::where('name', $role)->firstOrFail()) {
                    $this->roles()->attach($role);
                }
            }

        }

        if (is_string($roles)) {
            
        }
    }
}
