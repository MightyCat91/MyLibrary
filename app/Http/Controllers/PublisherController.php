<?php

namespace App\Http\Controllers;

use App\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Возврат шаблона со всеми книгами
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function show($id = null)
    {
        if (!$id) {
            $view = view('publishers', [
                'type' => 'publisher',
                'publishers' => Publisher::get(['id', 'name'])
            ]);
        } else {
            $publisher = Publisher::FindOrFail($id);
            $view = view('books', [
                'type' => 'book',
                'header' => $publisher->name,
                'books' => $publisher->books,
                'title' => $publisher->name
            ]);
        }

        return $view;
    }
}
