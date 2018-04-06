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
        $user = auth()->user();
        $favorite = $user->favorite;
        $favoriteBooks = array_get($favorite, 'book');
        if (!empty($favoriteBooks)) {
            $favoriteBooks = Book::whereIn('id', $favoriteBooks)->get(['id', 'name']);
            foreach ($favoriteBooks as $book) {
                $books = array_add($books, $book->id, $book->name);
            }
        }
        $favoriteAuthors = array_get($favorite, 'author');
        if (!empty($favoriteAuthors)) {
            $favoriteAuthors = Author::whereIn('id', $favoriteAuthors)->get(['id', 'name']);
            foreach ($favoriteAuthors as $author) {
                $authors = array_add($authors, $author->id, $author->name);
            }
        }
        $favoriteCategories = array_get($favorite, 'categories');
        if (!empty($favoriteCategories)) {
            $favoriteCategories = Categories::whereIn('id', $favoriteCategories)->get(['id', 'name']);
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

        $status = Status::all('name', 'uname');

        foreach ($status as $st) {
            $booksWithStatus[$st->name] = [
                'name' => $st->uname,
                'count' => count($statisticBooks[$st->name])
            ];
        }
        $statistic = [
            'statuses' => $booksWithStatus,
            'booksCount' => count(array_collapse($statisticBooks)),
            'authorsCount' => count(array_unique($statisticAuthors)),
            'categoriesCount' => count(array_unique($statisticCategories)),
        ];

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
            'statistic' => $statistic,
            'status' => $status,
        ]);
    }

    public function showEditUserProfilePage($id)
    {
        $user = auth()->user();
        return view('user.editProfile', [
            'login' => $user->login,
            'email' => $user->email,
            'name' => $user->name,
            'gender' => $user->gender
        ]);
    }

    public function editUserProfilePage($id, EditUserProfile $request)
    {
        $user = auth()->user();
        $user->login = $request->input(['login']);
        $user->name = $request->input(['name']);
        $user->gender = $request->input(['man']) ? 'мужской' : 'женский';
        $user->save();

        alert('success', 'Изменения сохранены.');
        return redirect()->back();
    }

    public function storeEmailPass(EditUserProfile $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();
            $inputs = array_where(array_except($request->input(), ['_token', 'oldPassword']),
                function ($value, $key) {
                    return !empty($value);
                });
            foreach ($inputs as $key => $value) {
                $user->$key = ($key == 'password') ? \Hash::make($value) : $value;
            }
            $user->save();
        }
    }

    /**
     * Изменение пользовательского аватара
     *
     * @param $id
     * @param EditUserProfile $request
     * @return string
     */
    public function updateProfileImg($id, EditUserProfile $request)
    {
        if ($request->ajax() and $request->hasFile('imageInput')) {
            $this->deleteProfileImgFromStorage($id);
            $file = $request->file('imageInput');
            $filepath = sprintf('/%s/%s.%s', $id, $id, $file->getClientOriginalExtension());
            Storage::disk('users')->put($filepath, file_get_contents($file));
            \Debugbar::info(Storage::disk('users'));
            $url = Storage::disk('users')->url($filepath);
            \Debugbar::info($url);
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

    public function changeFavoriteStatus(Request $request)
    {
        if ($request->ajax()) {
            $type = $request->get('type');
            $user = auth()->user();
            $favorite = $user->favorite;
            $arrayOfType = array_get($favorite, $type, []);
            if ($request->get('delete') == 'true') {
                array_forget($arrayOfType, array_search($request->get('id'), $arrayOfType));
            } else {
                array_push($arrayOfType, $request->get('id'));
            }
            array_set($favorite, $type, $arrayOfType);
            $user->favorite = $favorite;
            $user->save();
        }
    }

    public function changeStatus($id, Request $request)
    {
        if ($request->ajax()) {
            $newStatus = $request->get('newStatus');
            $oldStatus = $request->get('oldStatus');
            $user = auth()->user();
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
        }
    }

    /**
     * Изменение рейтинга книги
     *
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function changeBookRating($id, Request $request)
    {
        if ($request->ajax()) {
            $bookId = $request->get('id');
            $newRating = $request->get('rating');
            $oldRating = Book::where('id', $bookId)->first(['rating'])->rating[$id];

            if ($newRating > 10 and !empty($oldRating)) {
                return response()->json('Введенное значение больше максимально возможного рейтинга');
            }
            parent::changeRating($bookId, $request, Book::class);
        }
    }

    public function changeProgress($id, Request $request)
    {
        if ($request->ajax()) {
            $newProgress = $request->get('progress');
            if ($newProgress > Book::where('id', $id)->first(['page_counts'])->page_counts) {
                return response()->json([
                    'message' => 'Введенное значение больше количества страниц данной книги',
                    'type' => 'danger'
                ]);
            }
            $user = auth()->user();
            $progress = $user->progress;
            $progress[$id] = $newProgress;
            $user->progress = $progress;
            $user->save();

            return response()->json([
                'message' => 'Прогресс для данной книги изменен',
                'type' => 'success'
            ]);
        }
    }

    /**
     * Возврат шаблона с книгами, которым юзер установил какой-либо статус
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showBooksForUser($id)
    {
        //массив статусов с масиивами id книг в качестве значений
        $books = array_where(auth()->user()->statistic, function ($value) {
            return !empty($value);
        });
        //формирование массива книг для вьюхи
        foreach ($books as $status => $arrayId) {
            $newKey = Status::where('name', $status)->first(['uname'])->uname;
            $statistic[$newKey] = getGridItemsWithRatingAndFavoriteStatus(Book::whereIn('id', $arrayId)->get(['id', 'name', 'rating']), 'book');
        }
        return view('user.userBooks', [
            'statistic' => $statistic,
            'title' => 'Статистика. Книги',
            'breadcrumbParams' => ['id' => $id]
        ]);
    }

    /**
     * Возврат шаблона с книгами, соответствующим выбранному статусу
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showStatusBooksForUser(Request $request)
    {
        $books = auth()->user()->statistic[$request->status];
        return view('books', [
            'type' => 'book',
            'books' => getGridItemsWithRatingAndFavoriteStatus(Book::whereIn('id', $books)->get(['id', 'name', 'rating']), 'book'),
            'title' => $request->title,
            'header' => $request->title,
            'breadcrumbParams' => ['id' => $request->id]

        ]);
    }

    /**
     * Возврат шаблона с авторами, соответствующим выбранному статусу
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showAuthorsForUser(Request $request)
    {
        //коллекция id авторов, книги которых имеют какой либо статус
        $authors = Book::whereIn('id', array_flatten(auth()->user()->statistic))->get()->map(function ($book) {
            return $book->authors->map(function ($author) {
                return $author->id;
            });
        })->flatten()->unique();
        return view('user.userAuthors', [
            'authors' => getGridItemsWithRatingAndFavoriteStatus(Author::whereIn('id', $authors)->get(['id', 'name', 'rating']), 'author'),
            'title' => 'Статистика. Авторы',
            'breadcrumbParams' => ['id' => $request->id]
        ]);
    }

    /**
     * Возврат шаблона с жанрами, соответствующим выбранному статусу
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showCategoriesForUser(Request $request)
    {
        //коллекция id авторов, книги которых имеют какой либо статус
        $categories = Book::whereIn('id', array_flatten(auth()->user()->statistic))->get()->map(function ($book) {
            return $book->categories->map(function ($category) {
                return $category->id;
            });
        })->flatten()->unique();
        return view('user.userCategories', [
            'categories' => Categories::whereIn('id', $categories)->get(['id', 'name']),
            'title' => 'Статистика. Жанры',
            'breadcrumbParams' => ['id' => $request->id]
        ]);
    }

    /**
     * Возврат шаблона избранных книг, авторов, жанров в зависимости от полученного типа
     *
     * @param $id
     * @param $type
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showUserFavorite($id, $type, Request $request)
    {
        $favoriteBooks = array_get(auth()->user()->favorite, 'book');
        switch ($type) {
            case 'book':
                $viewName = 'Books';
                $itemsType = 'books';
                $item = getGridItemsWithRatingAndFavoriteStatus(Book::whereIn('id', $favoriteBooks)->get(['id', 'name', 'rating']), 'book');
                break;
            case 'author' :
                $viewName = 'Authors';
                $itemsType = 'authors';
                $item = getGridItemsWithRatingAndFavoriteStatus(Author::whereIn('id', $favoriteBooks)->get(['id', 'name', 'rating']), 'book');
                break;
            case 'category' :
                $viewName = 'Categories';
                $itemsType = 'categories';
                $item = getGridItemsWithRatingAndFavoriteStatus(Categories::whereIn('id', $favoriteBooks)->get(['id', 'name', 'rating']), 'book');
                break;
            default :
                $viewName = $item = $itemsType = null;
                abort(500);
        };
        return view($viewName, [
            'type' => $type,
            $itemsType => $item,
            'title' => $request->title,
            'breadcrumbParams' => ['id' => $id]
        ]);
    }

    public function showUserLibrary($id)
    {
        $books = $statuses = [];
        $user = \Auth::user();
        foreach ($user->statistic as $bookStatus => $booksId) {
            $authors = [];
            foreach ($booksId as $bookId) {

                $book = Book::findOrFail($bookId);
                foreach ($book->authors as $author) {
                    $authors[$author->id] = $author->name;
                }
                $status = Status::where('name', $bookStatus)->first(['uname'])->uname;
                $statuses[$bookStatus] = $status;
                $books[] = [
                    'id' => $bookId,
                    'status_uname' => $status,
                    'status_name' => $bookStatus,
                    'authors' => $authors,
                    'page_counts' => $book->page_counts,
                    'name' => $book->name,
                    'rating' => array_get($book->rating, $id),
                    'progress' => $user->progress[$bookId]
                ];
            }
        }

        return view('user.userLibrary', [
            'books' => $this->userLibrarySort($books, 'rating'),
            'statuses' => array_unique($statuses),
            'allStatuses' => Status::get(['name', 'uname'])
        ]);
    }

    private function userLibrarySort($array, $field, $order = 'desc')
    {
        usort($array, function ($firstEl, $secondEl) use ($field) {
            return $firstEl[$field] <=> $secondEl[$field];
        });

        return ($order == 'desc') ? array_reverse($array) : $array;
    }

    private function deleteProfileImgFromStorage($id)
    {
        $files = Storage::disk('users')->files($id);
        if ($files) {
            Storage::disk('users')->delete($files);
        }
    }
}