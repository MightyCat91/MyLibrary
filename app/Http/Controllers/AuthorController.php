<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorAddRequest;
use App\Series;
use App\User;
use function foo\func;
use Illuminate\Http\Request;
use App\Author;
use Storage;
use Validator;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('author-add');
    }

    /**
     * Сохранение добавляемого автора, требующей модерации, в базу.
     *
     * @param AuthorAddRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorAddRequest $request)
    {
        $validate = Validator::make($request->all(), $request->rules(), $request->messages());
        if ($validate->fails()) {
            $response = back()->withErrors($validate)->withInput();
        } else {
            $author = new Author;
            $author->name = $request->input('nameInput');
            $author->biography = $request->input('biographyInput');
            $author->moderate = false;
            $author->save();
            $series = $request->input('seriesInput.*');
            foreach ($series as $serie) {
                Series::addSeries($serie);
            }
            $id = $author->id;
            $image = $request->file('imageInput');
            $filename = $image->getClientOriginalName();
            Storage::disk('authors')->put(sprintf('/%s/%s', $id, $filename), file_get_contents($image));
            Storage::disk('authorsTemporary')->delete($filename);

            $response = redirect()->back();
            alert('success', 'Спасибо. Автор будет добавлен после модерации.');
        }
        return $response;
    }

    /**
     * Обработка ajax-загрузки файла и возврат урл для отображения превью пользователю.
     *
     * @param AuthorAddRequest|Request $request
     * @return string
     */
    public function addImgAJAX(AuthorAddRequest $request)
    {
        if ($request->ajax()) {
            return $this->putFileToTemporaryStorage($request);
        }
    }

    /**
     * Удаление ранее добавленного файла-изображени автора.
     *
     * @param Request $request
     * @return string|void
     */
    public function deleteImgAJAX(Request $request)
    {
        parent::deleteImgAddedItem($request, 'authorsTemporary');
    }

    /**
     * Загрузка изображений во временное хранилище и возврат урл
     *
     * @param $request
     * @return string
     */
    private function putFileToTemporaryStorage($request)
    {
        if ($request->hasFile('imageInput')) {
            $file = $request->file('imageInput');
            $filename = $file->getClientOriginalName();
            Storage::disk('authorsTemporary')->put(
                $filename,
                file_get_contents($file)
            );
            $url = Storage::disk('authorsTemporary')->url($filename);
            return $url;
        }
    }

    /**
     * Возврат шаблона со всеми авторами или конкретного автора, если указан id
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        if (!$id) {
            $view = view('authors', [
                'type' => 'author',
                'authors' => getGridItemsWithRatingAndFavoriteStatus(Author::get(['id', 'name', 'rating']), 'author'),
                'title' => 'Все авторы'
            ]);

        } else {
            $author = Author::FindOrFail($id);
            if (auth()->check()) {
                $user = auth()->user();
                $favorite = $user->favorite;
                $favoriteOfType = array_has($favorite, 'author');
                $inFavorite = $favoriteOfType ? array_has($favorite['author'], array_search($id,
                    $favorite['author']) ?: '') : null;
                $userRating['type'] = 'author';
                $userRating['score'] = null;
                if (array_has($user->rating, $userRating['type'])) {
                    foreach ($user->rating[$userRating['type']] as $key => $value) {
                        if (array_search($id, $value) !== false) {
                            $userRating['score'] = $key;
                        }
                    }
                }
            } else {
                $inFavorite = null;
                $userRating = null;
            }
            $authorRating = $author->rating;
            $view = view('author', [
                'author' => $author,
                'authorSeries' => $author->series(),
                'books' => $author->books,
                'categories' => $author->categories(),
                'inFavorite' => $inFavorite,
                'avgRating' => empty($authorRating) ? 0 : array_sum($authorRating) / count($authorRating),
                'quantityRating' => empty($authorRating) ? 0 : count($authorRating),
                'rating' => $userRating
            ]);
        }

        return $view;
    }

    public function changeAuthorRating($id, Request $request)
    {
        if ($request->ajax()) {
            $data = parent::changeRating($id, $request, Author::class);
            return response()->json($data);
        }
    }

    /**
     * Смена типа отображения контента на список или плитку
     *
     * @param Request $request
     * @return string html
     */
    public function changeViewType(Request $request)
    {
        if ($request->ajax()) {
            $authors = getGridItemsWithRatingAndFavoriteStatus(Author::all(['id', 'name', 'rating']), 'author');
            if ($request->viewType === 'list') {
                foreach ($authors as $author) {
                    $id = array_get($author, 'id');
                    $array[] = [
                        'id' => $author['id'],
                        'name' => $author['name'],
                        'description' => Author::whereKey($id)->value('biography'),
                        'series' => Author::series($id),
                        'categories' => Author::categories($id),
                        'inFavorite' => $author['inFavorite'],
                        'rating' => $author['rating']
                    ];
                    \Debugbar::info(Author::series($id));
                }
                $data = [
                    'array' => $array,
                    'routeName' => 'author',
                    'imgFolder' => 'authors',
                    'title' => 'Все авторы',
                    'type' => 'author'
                ];
                $view = 'layouts.commonList';
            } else {
                $data = [
                    'array' => $authors,
                    'routeName' => 'author',
                    'imgFolder' => 'authors',
                    'type' => 'author',
                    'title' => 'Все авторы'
                ];
                $view = 'layouts.commonGrid';
            }
            return view($view, $data)->render();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }
}
