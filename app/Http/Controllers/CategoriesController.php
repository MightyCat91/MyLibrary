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
            return view('layouts.books', ['books' => $books])->render();
        }
        return view('category', ['category' => $category, 'books' => $books, 'parent_template_name' => 'books']);
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
            return view('layouts.authors', ['authors' => $authors])->render();
        }
        return view('category', ['category' => $category, 'authors' => $authors, 'parent_template_name' =>
            'authors']);
    }

    /**
     * Вывод шаблона с авторами по id категории
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $categories = Categories::all();
        return view('categories', ['categories' => $categories]);
    }
}
