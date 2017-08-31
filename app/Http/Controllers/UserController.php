<?php

namespace App\Http\Controllers;


use App\Author;
use App\Book;
use App\Categories;
use App\Http\Requests\EditUserProfile;
use App\User;
use Illuminate\Http\Request;
use Storage;

class UserController extends Controller
{

    public function showUserProfilePage($id)
    {
        $books = $authors = $collections = [];
        $user = User::find($id);
        $favorite = $user->favorite;
        $favoriteBooks = array_get($favorite, 'book');
        if(!empty($favoriteBooks)) {
            foreach ($favoriteBooks as $bookId) {
                $books = array_add($books, $bookId, Book::findOrFail($bookId)->name);
            }
        }
        $favoriteAuthors = array_get($favorite, 'author');
        if(!empty($favoriteAuthors)) {
            foreach ($favoriteAuthors as $authorId) {
                $authors = array_add($authors, $authorId, Author::findOrFail($authorId)->name);
            }
        }
        $favoriteCategories = array_get($favorite, 'categories');
        if(!empty($favoriteCategories)) {
            foreach ($favoriteCategories as $categoryId) {
                $collections = array_add($collections, $categoryId, Categories::findOrFail($categoryId)->name);
            }
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
            'favoriteBooks' => $books,
            'favoriteAuthors' => $authors,
            'favoriteCategories' => $collections,
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

    public function changeStatus($id, Request $request)
    {
        if ($request->ajax()) {
            $newStatus = $request->get('newStatus');
            $oldStatus = $request->get('oldStatus');
            $user = User::findOrFail(\Auth::id());
            $statistic = $user->statistic;
            if (!empty($oldStatus)) {
                $arrayOfStatus = array_get($statistic, $oldStatus, []);
                array_forget($arrayOfStatus, array_search($id, $arrayOfStatus));
                array_set($statistic, $oldStatus, $arrayOfStatus);
            }
            $arrayOfStatus = array_get($statistic, $newStatus, []);
            array_push($arrayOfStatus, $id);
            array_set($statistic, $newStatus, $arrayOfStatus);
            $user->statistic = $statistic;
            $user->save();
            return alert()->success('Статус книги изменен', '5000', true);
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