<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Categories;
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
     * Возврат шаблона с сущностями, отфильтрованными по начальной выбранной букве
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showFiltered(Request $request)
    {
        if ($request->ajax()) {
            switch ($request->type) {
                case 'author':
                    $model = new Author();
                    $routeName = 'author';
                    $imgFolder = 'authors';
                    break;
                case 'category':
                    $model = new Categories();
                    $routeName = 'category-books';
                    $imgFolder = 'categories';
                    break;
                default:
                    $model = new Book();
                    $routeName = 'book';
                    $imgFolder = 'books';
                    break;
            }
            if (empty($request->filter)) {
                if (empty($request->id)) {
                    $arrays = $model->all();
                } else {
                    $arrays = Series::FindOrFail($request->id)->books;
                }
            } else {
                if (empty($request->id)) {
                    $arrays = $model->where('name', 'LIKE', $request->filter . '%')->get();
                } else {
                    $arrays = Series::FindOrFail($request->id)->books()->where('name', 'LIKE', $request->filter . '%')
                        ->get();
                }
            }
            return view(
                'layouts.commonGrid',
                [
                    'array' => $arrays,
                    'routeName' => $routeName,
                    'imgFolder' => $imgFolder
                ])->render();
        }
    }
}
