<?php

namespace App\Http\Controllers;


use App\Http\Requests\EditUserProfile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Storage;

class UserController extends Controller
{

    public function showUserProfilePage($id)
    {
        $user = User::find($id);
        $favorite = $user->favorite;
        $favoriteBooks = array_get($favorite, 'book');
        $favoriteAuthors = array_get($favorite, 'author');
        $favoriteCategories = array_get($favorite, 'categories');

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

    public function showEditUserProfilePage($id)
    {
        $user = User::find($id);
        return view('user.editProfile', [
            'login' => $user->login,
            'email' => $user->email,
            'name' => $user->name,
            'gender' => $user->gender
        ]);
    }

    public function editUserProfilePage($id, EditUserProfile $request)
    {
        $user = \Auth::getUser();
        $user->login = $request->input(['login']);
        $user->name = $request->input(['name']);
        $user->gender = $request->input(['man']) ? 'мужской' : 'женский';
        $user->save();

        alert()->success('Изменения сохранены.');
        return redirect()->back();
    }

    public function storeEmailPass(EditUserProfile $request)
    {
        if ($request->ajax()) {
            $user = \Auth::getUser();
            $inputs = array_where(array_except($request->input(), ['_token', 'oldPassword']),
                function ($value, $key) {
                    return !empty($value);
                });
            foreach ($inputs as $key => $value) {
                $user->$key = ($key == 'password') ? \Hash::make($value) : $value;
            }
            $user->save();

            return alert()->success('Изменения сохранены.', '5000', true);
        }
    }

    public function updateProfileImg($id, EditUserProfile $request)
    {
        if ($request->ajax() and $request->hasFile('imageInput')) {
            $this->deleteProfileImgFromStorage($id);
            $file = $request->file('imageInput');
            $filepath = sprintf('/%s/%s.%s', $id, $id, $file->getClientOriginalExtension());
            Storage::disk('users')->put($filepath, file_get_contents($file));
            $url = Storage::disk('users')->url($filepath);
            return $url;
        }
    }

    public function deleteProfileImg($id, Request $request)
    {
        if ($request->ajax()) {
            $this->deleteProfileImgFromStorage($id);
            return asset('images/no_avatar.jpg');
        }
    }

    public function addToFavorite($id, Request $request)
    {
        if ($request->ajax()) {
            $type = $request->get('type');
            $user = User::findOrFail(\Auth::id());
            $favorite = $user->favorite;
            $arrayOfType = array_get($favorite, $type, []);
            if ($request->get('delete') == 'true') {
                array_forget($arrayOfType, array_search($id, $arrayOfType));
            } else {
                array_push($arrayOfType, $id);
            }
            array_set($favorite, $type, $arrayOfType);
            $user->favorite = $favorite;
            $user->save();
            return alert()->success(($type == 'book') ? 'Книга добавлена' : 'Автор  добавлен' . ' в избранное', '5000', true);
        }
    }


    private function deleteProfileImgFromStorage($id)
    {
        $files = Storage::disk('users')->files($id);
        if ($files) {
            Storage::disk('users')->delete($files);
        }
    }
}