<?php
namespace App\Http\Controllers;



use App\User;

class UserController extends Controller
{

    public function addToFavorite($id) {
        $user = User::findOrFail(\Auth::id());
        $favorite = $user->favorite;
        //TODO: передавать в аяксе тип сущности для диференциации в текущем методе
        array_push($favorite, );
    }
}