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
use MyLibrary\Alerts\Alert;

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
     * Возврат шаблона с сущностями, отфильтрованными по начальной выбранной букве
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showFiltered(Request $request)
    {
        $idIsEmpty = empty($request->id);
        if ($request->ajax()) {
            switch ($request->type) {
                case 'author':
                    $model = new Author();
                    $routeName = 'author';
                    $imgFolder = 'authors';
                    $viewName = 'layouts.commonGrid';
                    break;
                case 'category':
                    $model = new Categories();
                    $routeName = 'category-books';
                    $imgFolder = 'categories';
                    $viewName = 'layouts.commonGrid';
                    break;
                case 'publisher':
                    $model = new Publisher();
                    $routeName = 'publisher-books';
                    if ($idIsEmpty) {
                        $imgFolder = null;
                        $viewName = 'layouts.commonList';
                    } else {
                        $imgFolder = 'books';
                        $viewName = 'layouts.commonGrid';
                    }
                    break;
                case 'series':
                    $model = new Series();
                    $routeName = 'book';
                    $imgFolder = 'books';
                    $viewName = 'layouts.commonGrid';
                    break;
                default:
                    $model = new Book();
                    $routeName = 'book';
                    $imgFolder = 'books';
                    $viewName = 'layouts.commonGrid';
                    break;
            }
            if (empty($request->filter)) {
                if ($idIsEmpty) {
                    $arrays = $model->all();
                } else {
                    $arrays = $model::FindOrFail($request->id)->books;
                }
            } else {
                if ($idIsEmpty) {
                    $arrays = $model->where('name', 'LIKE', $request->filter . '%')->get();
                } else {
                    $arrays = $model::FindOrFail($request->id)->books()->where('name', 'LIKE', $request->filter . '%')
                        ->get();
                }
            }
            return view(
                $viewName,
                [
                    'array' => $arrays,
                    'routeName' => $routeName,
                    'imgFolder' => $imgFolder
                ])->render();
        }
    }

    public function alert(){
        alert()->success('This is success message', 5000);
    }
}
