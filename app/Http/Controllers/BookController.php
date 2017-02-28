<?php

namespace App\Http\Controllers;

use App\Author;
use App\Categories;
use App\Http\Requests\BookAddRequest;
use App\Publisher;
use Illuminate\Http\Request;
use App\Book;
use Storage;
use Validator;

class BookController extends Controller
{
    /**
     * Возврат шаблона с книгами по id автора
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
     * Возврат шаблона с книгами определенного года
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
     * Возврат шаблона со всеми книгами
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

    /**
     * Возврат шаблона с формой добавления книги.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categories::all();
        $authors = Author::all();
        $publishers = Publisher::all();
        return view('book-add', ['categories' => $categories, 'authors' => $authors, 'publishers' => $publishers]);
    }

    /**
     * Сохранение добавляемой книги, требующей модерации, в базу.
     *
     * @param BookAddRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookAddRequest $request)
    {
        $validate = Validator::make($request->all(), $request->rules(), $request->messages());
        if($validate->fails()) {
            $response = back()->withErrors($validate)->withInput();
        }
        else {
            $book = new Book();
            $book->name = $request->input('nameInput');
            $book->description = $request->input('descriptionInput');
            $book->page_counts = $request->input('pageCountsInput');
            $book->year = $request->input('yearInput');
            $book->isbn = $request->input('isbnInput');
            $book->moderate = false;
            $book->save();
            foreach($request->input('categoryInput.*') as $category){
                $id = Categories::where('name',$category)->first();
                $book->categories()->attach($id);
            }
            foreach($request->input('authorInput.*') as $author){
                $id = Author::where('name',$author)->first();
                $book->categories()->attach($id);
            }
            foreach($request->input('publisherInput.*') as $publisher){
                $id = Publisher::where('name',$publisher)->first();
                $book->categories()->attach($id);
            }
            $response = redirect()->back()->with('success', 'Спасибо. Книга будет добавлена после модерации.');
        }
        return $response;
    }

    /**
     * Обработка ajax-загрузки файла и возврат урл для отображения превью пользователю.
     *
     * @param BookAddRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function addImgAJAX(BookAddRequest $request)
    {
        if ($request->ajax()) {
            return $this->putFileToTemporaryStorage($request);
        }
    }

    /**
     * Загрузка изображений во временное хранилище и возврат урл
     *
     * @param $request
     * @return string
     */
    private function putFileToTemporaryStorage($request)
    {
        if ($request->hasFile('imageInput')) {
            $file = $request->file('imageInput');
            $filename = str_random(6) . '.' . $file->getClientOriginalExtension();
            Storage::disk('bookTemporary')->put(
                $filename,
                file_get_contents($file)
            );
            $url = Storage::disk('bookTemporary')->url($filename);
            return $url;
        }
    }
}
