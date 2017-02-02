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
     * @return \Illuminate\Http\Response
     */
    public function showBooks($id)
    {
        $category = Categories::FindOrFail($id);
        $books = $category->books;
        return view('category', ['books' => $books]);
    }

    /**
     * Вывод шаблона с авторами по id категории
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function showAuthors($id)
    {
        $category = Categories::FindOrFail($id);
        $authors = $category->authors;
        return view('category', ['authors' => $authors]);
    }
}
