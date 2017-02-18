<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Http\Requests\AuthorAddRequest;
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
     * @param AuthorAddRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorAddRequest $request)
    {
//      TODO: добавить данных при валидации
        $author = new Author;
        $author->name = $request->input('nameInput');
        $author->biography = $request->input('biographyInput');
        $author->save();
        return redirect()->back()->with('success', 'Спасибо. Автор будет добавлен после модерации.');
    }

    /**
     * Обработка ajax-загрузки файла и возврат урл для отображения превью пользователю.
     *
     * @param AuthorAddRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function addImgAJAX(AuthorAddRequest $request)
    {
//        TODO: добавть валидациюпо аяксу
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
            Storage::disk('authorTemporary')->put(
                $filename,
                file_get_contents($file)
            );
            $url = Storage::disk('authorTemporary')->url($filename);
            return $url;
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
        } else {
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
