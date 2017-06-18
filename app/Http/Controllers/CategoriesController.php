<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
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
        if (empty($request->filter)) {
            $view = view('category', [
                'type' => 'book',
                'category' => $category,
                'books' => $books,
                'parent_template_name' => 'books'
            ]);
        } else {
            $view = view('category', [
                'type' => 'book',
                'category' => $category,
                'books' => Book::where('name', 'LIKE', $request->filter . '%')->get(['id','name']),
                'parent_template_name' => 'books'
            ]);
        }
        return $view;
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
        $authors = $category->authors();
        if ($request->ajax()) {
            return view('layouts.commonGrid', [
                    'array' => $authors,
                    'routeName' => 'author',
                    'imgFolder' => 'authors'
                ])->render();
        }
        if (empty($request->filter)) {
            $view = view('category', [
                'type' => 'author',
                'category' => $category,
                'authors' => $authors,
                'parent_template_name' => 'authors'
            ]);
        } else {
            $view = view('category', [
                'type' => 'author',
                'category' => $category,
                'authors' => Author::where('name', 'LIKE', $request->filter . '%')->get(['id','name']),
                'parent_template_name' => 'authors'
            ]);
        }
        return $view;
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
            $view = view('categories', [
                'type' => 'category',
                'categories' => Categories::get(['id','name'])
            ]);
        } else {
            $view = view('categories', [
                'type' => 'category',
                'categories' => Categories::where('name', 'LIKE', $request->filter . '%')->get(['id','name'])
            ]);
        }
        return $view;
    }
}
