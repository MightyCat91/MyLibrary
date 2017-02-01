<?php

namespace App\Http\Controllers;

use Faker\Provider\Image;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BookAddRequest;
use App\Models\Book;
use App\Models\Authors;
use App\Models\Categories;
use Illuminate\Support\Str;
use Session;
use Validator;

class Book_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with('authors', 'categories')->get();
        $destinationPath = public_path('uploads/booksCover');
        return view('pages.book.showAll', ['books' => $books, 'imgPath' => $destinationPath]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Authors::lists('name', 'id');
        $categories = Categories::lists('name', 'id');
        return view("pages.book.create", ['authors' => $authors, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookAddRequest $request)
    {
        $file = $request->file('image');

        $destinationPath = public_path('/uploads/booksCover'); // upload path
        $extension = $file->getClientOriginalExtension(); // getting image extension
        $fileName = "book_" . Str::limit(Str::snake(substr($file->getClientOriginalName(), 0,
                strpos($file->getClientOriginalName(), "."))), 44) . '.' . $extension; // renaming image
        $file->move($destinationPath, $fileName); // uploading file to given path

        $book = Book::create([
            'name' => $request->get('title'),
            'sinopsis' => $request->get('sinopsis'),
            'pageCount' => $request->get('pageCount'),
            'imgHref' => $fileName,
        ]);
        $book->authors()->sync($request->input('authors'));
        $book->categories()->sync($request->input('categories'));

        return back()->with('message', "Book added successful");
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
