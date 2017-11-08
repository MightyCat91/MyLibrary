<?php

use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user  = Role::where('name', 'user')->first();
        $role_admin  = Role::where('name', 'admin')->first();

        $user = User::where('name', 'test')->first();
        $user->roles()->attach($role_user);

        $manager = new User();
        $manager->name = 'admin';
        $manager->email = 'admin@mylibrary.ru';
        $manager->password = bcrypt('admin');
        $manager->last_visit = Carbon::now();
        $manager->save();
        $manager->roles()->attach($role_admin);
    }
}
