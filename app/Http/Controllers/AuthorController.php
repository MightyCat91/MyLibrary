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
     * @return \Illuminate\Http\Response
     */
    public function addImgAJAX(AuthorAddRequest $request)
    {
        if ($request->ajax()) {
            return $this->putFileToTemporaryStorage($request);
        }
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id = null)
    {
        if (!$id) {
            $authors = Author::get(['id', 'name', 'rating']);
            $authorsId = $authors->pluck('id');
            $authorsName = $authors->pluck('name');
            $favoriteAuthorsId = User::where('id', auth()->id())->pluck('favorite')->pluck('author')->flatten();
            $authorsInFavorite = $authorsId->map(function ($id) use ($favoriteAuthorsId) {
                if ($favoriteAuthorsId) {
                    $inFavorite = $favoriteAuthorsId->search($id) === false ? false : true;
                } else {
                    $inFavorite = false;
                }
                return $inFavorite;
            });
            $authorsRating = $authors->pluck('rating')->map(function ($item) {
                return empty($item) ? 0 : array_sum($item) / count($item);
            });

            $newCol = $authorsId->map(function ($id, $key) use ($authorsName, $authorsInFavorite, $authorsRating) {
                return [
                    'id' => $id,
                    'name' => $authorsName[$key],
                    'inFavorite' => $authorsInFavorite[$key],
                    'rating' => $authorsRating[$key]
                ];
            })->toArray();

            $view = view('authors', [
                'type' => 'author',
                'authors' => $newCol,
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
            $avgRating = empty($authorRating) ? 0 : array_sum($authorRating) / count($authorRating);
            $view = view('author', [
                'author' => $author,
                'authorSeries' => $author->series(),
                'books' => $author->books,
                'categories' => $author->categories(),
                'inFavorite' => $inFavorite,
                'avgRating' => $avgRating,
                'quantityRating' => count($authorRating),
                'rating' => $userRating
            ]);
        }

        return $view;
    }

    public
    function changeAuthorRating($id, Request $request)
    {
        if ($request->ajax()) {
            $data = parent::changeRating($id, $request, Author::class);
            return response()->json($data);
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
