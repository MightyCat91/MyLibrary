<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
    /**
     * ¬ывод шаблона с книгами по id автора
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function showBooksForAuthor($id)
    {
        $author = Author::find($id);
        return view('books', ['books' => $author->books, 'authorName' => $author->name]);
    }

    /**
     * ¬ывод шаблона с книгами определенного года издательства
     *
     * @param string $year
     * @return \Illuminate\Http\Response
     */
    public function showBooksForYear($year)
    {
        $books = Book::where('year', $year)->get();
        return view('books', ['books' => $books]);
    }

    /**
     * ¬ывод шаблона либо по id книги, либо всех
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        if (!$id) {
            $view = view('books', ['books' => Book::all()]);
        }
        else {
            $book = Book::FindOrFail($id);
            $authors = $book->authors;
            $categories = $book->categories;
            $publishers = $book->publishers;
            $view = view('book', [
                'book' => $book,
                'authors' => $authors,
                'categories' => $categories,
                'publishers' => $publishers
            ]);
        }
        return $view;
    }
}
