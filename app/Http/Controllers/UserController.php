<?php

namespace App\Http\Controllers;


use App\Author;
use App\Book;
use App\Categories;
use App\Http\Requests\EditUserProfile;
use App\Status;
use App\User;
use Crypt;
use function foo\func;
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
            $favoriteBooks = Book::whereIn('id', $favoriteBooks)->get(['id','name']);
            foreach ($favoriteBooks as $book) {
                $books = array_add($books, $book->id, $book->name);
            }
        }
        $favoriteAuthors = array_get($favorite, 'author');
        if(!empty($favoriteAuthors)) {
            $favoriteAuthors = Author::whereIn('id', $favoriteAuthors)->get(['id','name']);
            foreach ($favoriteAuthors as $author) {
                $authors = array_add($authors, $author->id, $author->name);
            }
        }
        $favoriteCategories = array_get($favorite, 'categories');
        if(!empty($favoriteCategories)) {
            $favoriteCategories = Categories::whereIn('id', $favoriteCategories)->get(['id','name']);
            foreach ($favoriteCategories as $category) {
                $collections = array_add($collections, $category->id, $category->name);
            }
        }

        if ($statisticBooks = $user->statistic) {
            $statisticAuthors = $statisticCategories = [];
            foreach (Book::whereIn('id', array_flatten($statisticBooks))->get() as $book) {
                foreach ($book->authors as $author) {
                    $statisticAuthors[$author->id] = $author->name;
                }
                foreach ($book->categories as $category) {
                    $statisticCategories[$category->id] = $category->name;
                }
            }
        } else {
            $statisticBooks = $statisticAuthors = $statisticCategories = [];
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
            'statisticBooks' => $statisticBooks,
            'statisticAuthors' => $statisticAuthors,
            'statisticCategories' => $statisticCategories
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

    /**
     * Возврат шаблона с книгами, которым юзер установил какой-либо статус
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showBooksForUser($id, Request $request)
    {
        $statistic = array_wrap(Crypt::decrypt($request->books));
        foreach ($statistic as $key => $value) {
            $newKey = Status::where('name', $key)->first(['uname'])->uname;
            $statistic[$newKey] = $value ? Book::whereIn('id', $value)->get(['id', 'name']) : [];
            array_forget($statistic, $key);
        }

        return view('user.user-books', [
            'statistic' => $statistic,
            'title' => 'Статистика. Книги'
        ]);
    }

    /**
     * Возврат шаблона с авторами, книгам которых юзер установил какой-либо статус
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showAuthorsForUser($id, Request $request)
    {
        $authors = array_keys(array_wrap(Crypt::decrypt($request->authors)));
        return view('user.user-authors', [
            'authors' => Author::whereIn('id', $authors)->get(['id', 'name']),
            'title' => 'Статистика. Авторы'
        ]);
    }

    /**
     * Возврат шаблона с жанрами, книгам которых юзер установил какой-либо статус
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showCategoriesForUser($id, Request $request)
    {
        $categories = array_keys(array_wrap(Crypt::decrypt($request->categories)));
        return view('user.user-categories', [
            'categories' => Categories::whereIn('id', $categories)->get(['id', 'name']),
            'title' => 'Статистика. Жанры'
        ]);
    }


    private function deleteProfileImgFromStorage($id)
    {
        $files = Storage::disk('users')->files($id);
        if ($files) {
            Storage::disk('users')->delete($files);
        }
    }
}