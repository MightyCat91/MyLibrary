<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;
use App\Author;
use Storage;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $categories = Categories::all();
        return view('author-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        echo '<script>console.log($request)</script>';
        $author = new Author;
        $author->name = $request->input('nameInput');
        $author->biography = $request->input('biographyInput');
        $author->save();
        return redirect()->back()->with('success', 'Спасибо. Автор будет добавлен после модерации.');
    }

    /**
     * Загрузка изображений во ыременное хранилище и отображение превью пользователю.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addImgAJAX(Request $request)
    {
        if ($request->ajax()) {
            echo '<script>console.log($request)</script>';
            $file = $request->file('imageInput');
            echo '<script>console.log($file)</script>';
            $filename = $file->hashName();
            //Не работает сохранение в хранилище и вывод на экран
            Storage::disk('local')->put(
                'images/authors/temporary',
                file_get_contents($file)
            );
            $data = Storage::url('images/authors/temporary' . $filename);
            return redirect()->back()
                ->with('data', $data)
                ->with('success', 'Спасибо. Автор будет добавлен после модерации.');
        }
    }

    /**
     * ����� ������� ���� �� id ������, ���� ���� �������
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        if (!$id) {
            $view = view('authors', ['authors' => Author::all()]);
        }
        else {
            $author = Author::FindOrFail($id);
            $books = $author->books;
            $categories = $author->categories;
            $view = view('author', ['author' => $author, 'books' => $books, 'categories' => $categories]);
        }
        return $view;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
