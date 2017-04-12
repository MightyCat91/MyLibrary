<?php

namespace App\Http\Controllers;

use App\Book;
use App\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * Вывод шаблона с книгами по id серии
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showBooks($id, Request $request)
    {
        $series = Series::FindOrFail($id);
        if (empty($request->filter)) {
            $view = view('books', [
                'type' => 'series',
                'header' => $series->name,
                'books' => $series->books
            ]);
        } else {
            $view = view('books', [
                'type' => 'series',
                'header' => $series->name,
                'books' => $series->books()->where('name', 'LIKE', $request->filter . '%')->get()
            ]);
        }
        return $view;
    }
}
