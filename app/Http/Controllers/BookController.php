<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Http\Requests\BookAddRequest;
use App\Publisher;
use App\Series;
use App\Status;
use App\Author;
use App\Book;
use App\User;
use Illuminate\Http\Request;
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
        return view('books', [
            'type' => 'book',
            'books' => $author->books,
            'header' => $author->name,
            'title' => 'Книги'
        ]);
    }

    /**
     * Возврат шаблона с книгами определенного года
     *
     * @param string $year
     * @return \Illuminate\Http\Response
     */
    public function showBooksForYear($year)
    {
        $books = Book::where('year', $year)->get(['id', 'name']);
        return view('books', [
            'type' => 'book',
            'books' => $books,
            'header' => 'Книги изданные в ' . $year . ' году',
            'title' => $year
        ]);
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
            $view = view('books', [
                'type' => 'book',
                'books' => getGridItemsWithRatingAndFavoriteStatus(Book::get(['id', 'name', 'rating']), 'book'),
                'title' => 'Все книги'
            ]);
        } else {
            $book = Book::FindOrFail($id);
            $series = $book->series;
            if (count($series)) {
                $sidebarBooks = $book->authorSeriesBooks();
                if (!count($sidebarBooks)) {
                    $sidebarBooks = $book->publisherSeriesBooks();
                    if (!count($sidebarBooks) or empty($sidebarBooks)) {
                        $sidebarBooks = $book->authorBooks();
                    }
                }
            } else {
                $sidebarBooks = $book->authorBooks();
            }
            if (auth()->check()) {
                $user = auth()->user();
                $favorite = $user->favorite;
                $favoriteOfType = array_has($favorite, 'book');
                $inFavorite = $favoriteOfType ? array_has($favorite['book'], array_search($id,
                    $favorite['book']) ?: '') : null;
                $statistic = $user->statistic;
                $status = null;
                if (!empty($statistic)) {
                    foreach ($statistic as $key => $value) {
                        if (in_array($id, $value)) {
                            $status = Status::where('name', '=', $key)->first(['name', 'uname']);
                        }
                    }
                }
                $userRating['type'] = 'book';
                $userRating['score'] = null;
                if (array_has($user->rating, $userRating['type'])) {
                    foreach ($user->rating[$userRating['type']] as $key => $value) {
                        if (array_search($id, $value) !== false) {
                            $userRating['score'] = $key;
                        }
                    }
                }
                $progress = array_get($user->progress, $id, 0);
            } else {
                $inFavorite = $status = $userRating = $progress = null;
            }
            $bookRating = $book->rating;
            $view = view('book', [
                'book' => $book,
                'authors' => $book->authors,
                'bookSeries' => $series,
                'categories' => $book->categories,
                'publishers' => $book->publishers,
                'sidebarBooks' => $sidebarBooks,
                'inFavorite' => $inFavorite,
                'status' => $status,
                'allStatuses' => Status::get(['name', 'uname']),
                'avgRating' => empty($bookRating) ? 0 : array_sum($bookRating) / count($bookRating),
                'quantityRating' => empty($bookRating) ? 0 : count($bookRating),
                'rating' => $userRating,
                'progress' => $progress
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
        $categories = Categories::orderBy('name', 'asc')->get();
        $authors = Author::orderBy('name', 'asc')->get();
        $series = Series::orderBy('name', 'asc')->get();
        $publishers = Publisher::orderBy('name', 'asc')->get();
        return view('book-add', [
            'categories' => $categories,
            'authors' => $authors,
            'bookSeries' => $series,
            'publishers' => $publishers
        ]);
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
        if ($validate->fails()) {
            $response = back()->withErrors($validate)->withInput();
        } else {
            $book = new Book();
            $book->name = $request->input('nameInput');
            $book->description = $request->input('descriptionInput');
            $book->page_counts = $request->input('pageCountsInput');
            $book->year = $request->input('yearInput');
            $book->isbn = $request->input('isbnInput');
            $book->moderate = false;
            $book->save();
            foreach ($request->input('categoryInput.*') as $category) {
                $id = Categories::where('name', $category)->first();
                $book->categories()->attach($id);
            }
            foreach ($request->input('authorInput.*') as $author) {
                $id = Author::where('name', $author)->first();
                $book->authors()->attach($id);
            }
            foreach ($request->input('publisherInput.*') as $publisher) {
                $id = Publisher::where('name', $publisher)->first();
                $book->publishers()->attach($id);
            }
            foreach ($request->input('seriesInput.*') as $series) {
                $id = Series::where('name', $series)->first();
                $book->series()->attach($id);
            }
            $id = $book->id;
            foreach ($request->file('imageInput') as $image) {
                $filename = $image->getClientOriginalName();
                Storage::disk('books')->put(sprintf('/%s/%s', $id, $filename), file_get_contents($image));
                Storage::disk('booksTemporary')->delete($filename);
            }

            $response = redirect()->back();
            alert('success', 'Спасибо. Книга будет добавлена после модерации.');
        }
        return $response;
    }

    /**
     * Обработка ajax-загрузки файла и возврат урл для отображения превью пользователю.
     *
     * @param BookAddRequest|Request $request
     * @return array
     */
    public function addImgAJAX(BookAddRequest $request)
    {
        if ($request->ajax()) {
            return $this->putFileToTemporaryStorage($request);
        }
    }

    /**
     * Удаление ранее добавленного файла-изображени книги.
     *
     * @param Request $request
     * @return string|void
     */
    public function deleteImgAJAX(Request $request)
    {
        parent::deleteImgAddedItem($request, 'booksTemporary');
    }

    /**
     * Изменение рейтинга книги
     *
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function changeBookRating($id, Request $request)
    {
        if ($request->ajax()) {
            $data = parent::changeRating($id, $request, Book::class);
            return response()->json($data);
        }
    }

    /**
     * Загрузка изображений во временное хранилище и возврат урл
     *
     * @param $request
     * @return array
     */
    private function putFileToTemporaryStorage($request)
    {
        if ($request->hasFile('imageInput')) {
            $url = [];
            foreach ($request->file('imageInput') as $file) {
                $filename = $file->getClientOriginalName();
                //TODO: добавить в путь id юзера добавляющего книгу
                Storage::disk('booksTemporary')->put(
                    $filename,
                    file_get_contents($file)
                );
                $url[$filename] = Storage::disk('booksTemporary')->url($filename);
            }
            return $url;
        }
    }
}
