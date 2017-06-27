<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 21.06.2017
 * Time: 22:59
 */

namespace App\Http\Controllers;


use App\Http\Requests\EditUserProfile;
use App\User;

class UserController extends Controller
{

    public function showUserProfile($id)
    {
        $user = User::find($id);
//        dd($user);
        if ($array = $user->favorite) {
            $favorite = unserialize($array);
            $favoriteBooks = $favorite['books'];
            $favoriteAuthors = $favorite['authors'];
            $favoriteCategories = $favorite['categories'];
        } else {
            $favoriteBooks = $favoriteAuthors = $favoriteCategories = null;
        }
        if ($array = $user->statistics) {
            $statistics = unserialize($array);
            $statisticsBooks = $statistics['books']->lenght;
            $statisticsAuthors = $statistics['authors']->lenght;
            $statisticsCategories = $statistics['categories']->lenght;
        } else {
            $statisticsBooks = $statisticsAuthors = $statisticsCategories = null;
        }
        return view('user.profile', [
            'name' => $user->name,
            'login' => $user->login,
            'email' => $user->email,
            'gender' => $user->gender,
            'created_at' => $user->created_at,
            'last_visit' => $user->last_visit,
            'favoriteBooks' => $favoriteBooks,
            'favoriteAuthors' => $favoriteAuthors,
            'favoriteCategories' => $favoriteCategories,
            'statisticsBooks' => $statisticsBooks,
            'statisticsAuthors' => $statisticsAuthors,
            'statisticsCategories' => $statisticsCategories
        ]);
    }

    public function editUserProfile($id) {
        $user = User::find($id);
        return view('user.editProfile', [
            'login' => $user->login,
            'email' => $user->email,
            'name' => $user->name,
            'gender' => $user->gender
        ]);
    }

    public function storeEmailPass($id, EditUserProfile $request) {
        \Debugbar::info($id);
        if ($request->ajax()) {

        }
    }
}