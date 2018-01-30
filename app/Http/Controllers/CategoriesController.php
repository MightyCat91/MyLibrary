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
        $books = $category->books;
        $booksId = $books->pluck('id');
        $booksName = $books->pluck('name');
        $favoriteBooksId = User::where('id', auth()->id())->pluck('favorite')->pluck('book')->flatten();
        $booksInFavorite = $booksId->map(function ($id) use ($favoriteBooksId) {
            if ($favoriteBooksId) {
                $inFavorite = $favoriteBooksId->search($id) === false ? false : true;
            } else {
                $inFavorite = false;
            }
            return $inFavorite;
        });
        $booksRating = $books->pluck('rating')->map(function ($item) {
            return empty($item) ? 0 : array_sum($item) / count($item);
        });

        $newCol = $booksId->map(function ($id, $key) use ($booksName, $booksInFavorite, $booksRating) {
            return [
                'id' => $id,
                'name' => $booksName[$key],
                'inFavorite' => $booksInFavorite[$key],
                'rating' => $booksRating[$key]
            ];
        })->toArray();
        if ($request->ajax()) {
            return view(
                'layouts.commonGrid',
                [
                    'array' => $newCol,
                    'routeName' => 'book',
                    'imgFolder' => 'books'
                ])->render();
        }

        $view = view('category', [
            'type' => 'book',
            'category' => $category,
            'books' => $newCol,
            'parent_template_name' => 'books'
        ]);

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
                'imgFolder' => 'authors',
                'type' => 'author',
            ])->render();
        }

        $view = view('category', [
            'type' => 'author',
            'category' => $category,
            'authors' => $authors,
            'parent_template_name' => 'authors'
        ]);

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
        return view('categories', [
            'type' => 'category',
            'categories' => Categories::get(['id', 'name'])
        ]);
    }
}
