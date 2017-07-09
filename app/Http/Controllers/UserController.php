<?php
namespace App\Http\Controllers;



use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function addToFavorite($id, Request $request) {
        if ($request->ajax()) {
            $type = $request->get('type');
            $user = User::findOrFail(\Auth::id());
            $favorite = $user->favorite;
            $arrayOfType = array_get($favorite, $type, []);
            if ($request->get('delete')=='true') {
                array_forget($arrayOfType, array_search($id, $arrayOfType));
            } else {
                array_push($arrayOfType, $id);
            }
            array_set($favorite, $type, $arrayOfType);
            $user->favorite = $favorite;
            $user->save();
            return alert()->success(($type == 'book') ? 'Книга' : 'Автор' . ' добавлен в избранное', '5000', true);
        }
    }
}