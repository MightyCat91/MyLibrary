<?php

namespace App\Http\Controllers;


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
        $view = view('books', [
            'type' => 'series',
            'header' => $series->name,
            'books' => $series->books,
            'title' => $series->name
        ]);
        return $view;
    }
}
