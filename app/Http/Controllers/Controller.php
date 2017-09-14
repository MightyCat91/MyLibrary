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

    public function changeRating($id, $request)
    {
        $rating = $request->rating;
        $type = $request->type;
        $user = auth()->user();
        $ratingsCollection = $user->rating;

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
    }
}
