<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Получение пользователей с данной ролью
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsers()
    {
        return $this->users()->get();
    }

    /**
     * Создание новой роли
     * @param $name
     * @param null $descr
     */
    public function createRole($name, $descr = null)
    {
        if (\Auth::user()->isAdmin() and is_null(Role::where('name', $name)->findOrFail())) {
            $newRole = new Role();
            $newRole->name = $name;
            $newRole->description = $descr;
            $newRole->save();
        }
    }

    /**
     * Удаление роли
     * @param $name
     */
    public function deleteRole($name)
    {
        $role = Role::where('name', $name)->findOrFail();
        if ($role) {
            $role->delete();
        }
    }
}
