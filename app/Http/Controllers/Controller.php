<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Categories;
use App\Publisher;
use App\Series;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Изменение рейтинга книги или автора
     *
     * @param $id - идентификатор сущности, которой меняют рейтинг
     * @param $request - данные реквест-запроса
     * @param $ModelClass - класс модели сущности, рейтинг которой изменяют(Book::class или Author::class)
     * @return array
     */
    public function changeRating($id, Request $request, $ModelClass)
    {
        $rating = $request->rating;
        $type = $request->type;
        $user = auth()->user();
        $ratingsCollection = $user->rating;

        $elRating = $ModelClass::where('id', $id)->first(['rating'])->rating;
        $elRating[auth()->id()] = $request->rating;
        $ModelClass::where('id', $id)->update(['rating' => json_encode($elRating)]);

        if (empty($ratingsCollection)) {
            $ratingArray[$rating] = array_wrap($id);
            $ratingsCollection[$type] = array_wrap($ratingArray);
        } else {
            if ($ratingItemsId = array_get($ratingsCollection, $type . '.' . $rating, null)) {
                $ratingItemsId[] = $id;
                array_set($ratingsCollection[$type], $rating, $ratingItemsId);
            } else {
                if (array_has($ratingsCollection, $type)) {
                    foreach (array_get($ratingsCollection, $type) as $key => $value) {
                        $idKey = array_search($id, $value);
                        if ($idKey !== false) {
                            array_forget($ratingsCollection[$type][$key], $idKey);
                        }
                    }
                }
                array_set($ratingsCollection[$type], $rating, [$id]);
            }
        }

        $user->rating = $ratingsCollection;
        $user->save();

        return ['avgRating' => array_sum($elRating) / count($elRating), 'quantityRating' => count($elRating)];
    }


    public function alphabetFilter(Request $request)
    {
        $filterLetter = $request->get('filterLetter');
        $type = $request->get('type');
        $isCurrent = $request->get('isCurrent') === 'true';
        $data = $view = null;

        switch ($type) {
            case 'book':
                $data = [
                    'array' => $isCurrent ? Book::get(['id', 'name']) : Book::where('name', 'like', $filterLetter . '%')->get(['id', 'name']),
                    'routeName' => $type,
                    'imgFolder' => 'books'
                ];
                $view = 'layouts.commonGrid';
                break;
            case 'author':
                $data = [
                    'array' => $isCurrent ? Author::get(['id', 'name']) : Author::where('name', 'like', $filterLetter . '%')->get(['id', 'name']),
                    'routeName' => $type,
                    'imgFolder' => 'authors'
                ];
                $view = 'layouts.commonGrid';
                break;
            case 'category':
                $data = [
                    'array' => $isCurrent ? Categories::get(['id', 'name']) : Categories::where('name', 'like', $filterLetter . '%')->get(['id', 'name']),
                    'routeName' => 'category-books',
                    'imgFolder' => 'categories'
                ];
                $view = 'layouts.commonGrid';
                break;
            case 'publisher':
                $data = [
                    'array' => $isCurrent ? Publisher::get(['id', 'name']) : Publisher::where('name', 'LIKE', $filterLetter . '%')->get(['id', 'name']),
                    'routeName' => 'publisher-books'
                ];
                $view = 'layouts.commonList';
                break;
        }


        return view($view, $data);
    }
}
