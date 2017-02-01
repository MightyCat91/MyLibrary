<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Вывод шаблона по id категории
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Categories::FindOrFail($id);
        $books = $category->books;
        $authors = $category->authors;
        return view('category', ['books' => $books, 'authors' => $authors]);
    }
}
