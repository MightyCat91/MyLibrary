<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Http\Requests\AuthorAddRequest;
use App\Series;
use Illuminate\Http\Request;
use App\Author;
use Storage;
use Validator;

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
        return view('author-add');
    }

    /**
     * Сохранение добавляемого автора, требующей модерации, в базу.
     *
     * @param AuthorAddRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorAddRequest $request)
    {
        $validate = Validator::make($request->all(), $request->rules(), $request->messages());
        if ($validate->fails()) {
            $response = back()->withErrors($validate)->withInput();
        } else {
            $author = new Author;
            $author->name = $request->input('nameInput');
            $author->biography = $request->input('biographyInput');
            $author->moderate = false;
            $author->save();
            $series = $request->input('seriesInput.*');
            foreach ($series as $serie) {
                Series::addSeries($serie);
            }
            $id = $author->id;
            $image = $request->file('imageInput');
            $filename = $image->getClientOriginalName();
            Storage::disk('authors')->put(sprintf('/%s/%s', $id, $filename), file_get_contents($image));
            Storage::disk('authorsTemporary')->delete($filename);

            $response = redirect()->back()->with('success', 'Спасибо. Автор будет добавлен после модерации.');
        }
        return $response;
    }

    /**
     * Обработка ajax-загрузки файла и возврат урл для отображения превью пользователю.
     *
     * @param AuthorAddRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function addImgAJAX(AuthorAddRequest $request)
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
            $filename = $file->getClientOriginalName();
            Storage::disk('authorsTemporary')->put(
                $filename,
                file_get_contents($file)
            );
            $url = Storage::disk('authorsTemporary')->url($filename);
            return $url;
        }
    }

    /**
     * Возврат шаблона со всеми авторами или конкретного автора, если указан id
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id = null)
    {
        if (empty($request->filter)) {
            if (!$id) {
                $view = view('authors', ['authors' => Author::all()]);
            } else {
                $author = Author::FindOrFail($id);
                $view = view('author', [
                    'author' => $author,
                    'authorSeries' => $author->series(),
                    'books' => $author->books,
                    'categories' => $author->categories()
                ]);
            }
        } else {
            $view = view('authors', ['authors' => Author::where('name', 'LIKE', $request->filter . '%')->get()]);
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
