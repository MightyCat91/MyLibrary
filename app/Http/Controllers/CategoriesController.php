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
            return view(
                'layouts.commonGrid',
                [
                    'array' => $books,
                    'routeName' => 'book',
                    'imgFolder' => 'books'
                ])->render();
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
            return view(
                'layouts.commonGrid',
                [
                    'array' => $authors,
                    'routeName' => 'author',
                    'imgFolder' => 'authors'
                ])->render();
        }
        return view('category', ['category' => $category, 'authors' => $authors, 'parent_template_name' =>
            'authors']);
    }

    /**
     * Вывод шаблона с категориями
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (empty($request->filter)) {
            $view = view('categories', ['categories' => Categories::all()]);
        } else {
            $view = view('categories', ['categories' => Categories::where('name', 'LIKE', $request->filter . '%')->get()]);
        }
        return $view;
    }

    /**
     * Возврат шаблона с жанрами, отфильтрованными по начальной выбранной букве
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showFiltered(Request $request)
    {
        if ($request->ajax()) {
            if (empty($request->filter)) {
                $categories = Categories::all();
            } else {
                $categories = Categories::where('name', 'LIKE', $request->filter . '%')->get();
            }
            return view(
                'layouts.commonGrid',
                [
                    'array' => $categories,
                    'routeName' => 'category-books',
                    'imgFolder' => 'categories'
                ])->render();
        }
    }
}
