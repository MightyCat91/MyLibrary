<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Categories;
use App\User;
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
        if ($request->ajax()) {
            return view(
                'layouts.commonGrid',
                [
                    'array' => getGridItemsWithRatingAndFavoriteStatus($category->books, 'book'),
                    'routeName' => 'book',
                    'imgFolder' => 'books'
                ])->render();
        }

        return view('category', [
            'type' => 'book',
            'category' => $category,
            'books' => getGridItemsWithRatingAndFavoriteStatus($category->books, 'book'),
            'parent_template_name' => 'books'
        ]);
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
        if ($request->ajax()) {
            return view('layouts.commonGrid', [
                'array' => getGridItemsWithRatingAndFavoriteStatus($category->authors(), 'author'),
                'routeName' => 'author',
                'imgFolder' => 'authors',
                'type' => 'author',
            ])->render();
        }

        return view('category', [
            'type' => 'author',
            'category' => $category,
            'authors' => getGridItemsWithRatingAndFavoriteStatus($category->authors(), 'author'),
            'parent_template_name' => 'authors'
        ]);
    }

    /**
     * Вывод шаблона с категориями
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return view('categories', [
            'type' => 'category',
            'categories' => Categories::get(['id', 'name'])
        ]);
    }
}
