<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Вывод шаблона с книгами по id категории
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showBooks($id, Request $request)
    {
        $category = Categories::FindOrFail($id);
        $books = $category->books;

        if ($request->ajax()) {
            return view('books', ['books' => $books]);
        }
        return view('category', ['category_id' => $category->id, 'books' => $books]);
    }

    /**
     * Вывод шаблона с авторами по id категории
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showAuthors($id, Request $request)
    {
        $category = Categories::FindOrFail($id);
        $authors = $category->authors;

        if ($request->ajax()) {
            return view('authors', ['authors' => $authors]);
        }
        return view('category', ['authors' => $authors]);
    }
}
