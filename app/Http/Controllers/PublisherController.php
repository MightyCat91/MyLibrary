<?php

namespace App\Http\Controllers;

use App\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Возврат шаблона со всеми книгами
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id = null)
    {
        if (empty($request->filter)) {
            if (!$id) {
                $view = view('publishers', ['publishers' => Publisher::all()]);
            } else {
                $publisher = Publisher::FindOrFail($id);
                $view = view('books', [
                    'type' => 'publisher',
                    'header' => $publisher->name,
                    'books' => $publisher->books
                ]);
            }
        } else {
            if ($id) {
                $publisher = Publisher::FindOrFail($id);
                $view = view('books', [
                    'type' => 'publisher',
                    'header' => $publisher->name,
                    'books' => $publisher->books()->where('name', 'LIKE', $request->filter . '%')->get()
                ]);
            } else {
                $view = view('publishers', [
                    'publishers' => Publisher::where('name', 'LIKE', $request->filter . '%')->get()
                ]);
            }
        }
        return $view;
    }
}
