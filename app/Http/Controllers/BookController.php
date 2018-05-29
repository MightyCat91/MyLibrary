<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Http\Requests\AddReview;
use App\Http\Requests\BookAddRequest;
use App\Publisher;
use App\Review;
use App\Series;
use App\Status;
use App\Author;
use App\Book;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
     * Смена типа отображения контента(книг определенного автора) на список или плитку
     *
     * @param Request $request
     * @param $id
     * @return string
     */
    public function changeBooksViewTypeForAuthor(Request $request, $id)
    {
        $author = Author::find($id);
        return $this->changeViewType($request, $author->books);
    }

    /**
     * Возврат шаблона с книгами определенного года
     *
     * @param string $year
     * @return \Illuminate\Http\Response
     */
    public function showBooksForYear($year)
    {
        $books = getGridItemsWithRatingAndFavoriteStatus(Book::where('year', $year)->get(['id', 'name', 'rating']), 'book');
        return view('books', [
            'type' => 'book',
            'books' => $books,
            'header' => 'Книги изданные в ' . $year . ' году',
            'title' => $year
        ]);
    }

    /**
     * Смена типа отображения контента(книг определенного года издания) на список или плитку
     *
     * @param Request $request
     * @param $year
     * @return string
     */
    public function changeBooksViewTypeForYear(Request $request, $year)
    {
        return $this->changeViewType($request, Book::where('year', $year)->get(['id', 'name', 'rating']));
    }

    /**
     * Вывод шаблона с книгами по id серии
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function showBooksForSeries($id)
    {
        $series = Series::FindOrFail($id);
        $view = view('books', [
            'type' => 'book',
            'header' => $series->name,
            'books' => getGridItemsWithRatingAndFavoriteStatus($series->books, 'book'),
            'title' => $series->name
        ]);
        return $view;
    }

    /**
     * Смена типа отображения контента(книг определенной серии) на список или плитку
     *
     * @param Request $request
     * @param $id
     * @return string
     */
    public function changeBooksViewTypeForSeries(Request $request, $id)
    {
        return $this->changeViewType($request, Series::FindOrFail($id)->books);
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
                'progress' => $progress,
                'statistic' => [
                    'inFavorite' => $book->inFavoriteCountWithInstance(),
                    'reading' => $book->nowReadingCountWithInstance(),
                    'completed' => $book->completedCountWithInstance(),
                    'inPlans' => $book->inPlansCountWithInstance()
                ],
                'reviews' => $book->reviews()
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
     * Смена типа отображения контента на список или плитку
     *
     * @param Request $request
     * @param \Illuminate\Database\Eloquent\Collection|null $items коллекция отображаемых книг
     * @return string html
     */
    public function changeViewType(Request $request, $items = null)
    {
        if ($request->ajax()) {
            $books = getGridItemsWithRatingAndFavoriteStatus($items ?? Book::all(['id', 'name', 'rating']), 'book');
            if ($request->viewType === 'list') {
                foreach ($books as $book) {
                    $b = Book::FindOrFail(array_get($book, 'id'));
                    $array[] = [
                        'id' => $book['id'],
                        'name' => $book['name'],
                        'description' => $b->description,
                        'series' => $b->series->map(function ($series) {
                            return collect($series)
                                ->only(['id', 'name'])
                                ->all();
                        }),
                        'categories' => $b->categories->map(function ($category) {
                            return collect($category)
                                ->only(['id', 'name'])
                                ->all();
                        }),
                        'inFavorite' => $book['inFavorite'],
                        'rating' => $book['rating'],
                        'statistic' => [
                            'inFavorite' => $b->inFavoriteCountWithInstance(),
                            'reading' => $b->nowReadingCountWithInstance(),
                            'completed' => $b->completedCountWithInstance(),
                            'inPlans' => $b->inPlansCountWithInstance()
                        ]
                    ];
                }
                $data = [
                    'array' => $array,
                    'routeName' => 'book',
                    'imgFolder' => 'books',
                    'title' => 'Все книги',
                    'type' => 'book'
                ];
                $view = 'layouts.commonList';
            } else {
                $data = [
                    'array' => $books,
                    'routeName' => 'book',
                    'imgFolder' => 'books',
                    'title' => 'Все книги',
                    'type' => 'book'
                ];
                $view = 'layouts.commonGrid';
            }
            return view($view, $data)->render();
        }
    }

    /**
     * Добавление рецензии на книгу
     *
     * @param Request $request
     * @throws ValidationException
     */
    public function addReview(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), AddReview::rules(), AddReview::messages());
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            $review = Review::firstOrNew(['book_id' => (int)$request->id, 'user_id' => auth()->id()]);
            if (!$review->exists) {
                $review->book_id = $request->id;
                $review->user_id = auth()->id();
                $review->text = $request->review;
                $review->save();
            }
        }
    }

    /**
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addVoteForReview(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->check()) {
                $review = Review::find($request->id);
                $rating = $review->rating;
                if (empty($rating)) {
                    array_add($rating, $request->vote, auth()->id());
//                    $rating[$request->vote] = [$request->vote => auth()->id()];
                    \Debugbar::info($rating);
                } else {
                    switch (array_keys($rating)) {
                        case 'positive':
                            $posRating = $rating['positive'];
                            if (in_array(auth()->id(), $posRating)) {
                                if ($request->vote != 'positive') {
                                    array_forget($rating['positive'],array_search(auth()->id(), $rating['positive']));
                                    array_push($rating['negative'], auth()->id);
                                } else {
                                    return response()->json([
                                        'type' => 'info',
                                        'message' => 'Вы уже голосовали за данную рецензию'
                                    ]);
                                }
                            }
                            break;
                        case 'negative':
                            $negRating = $rating['negative'];
                            if (in_array(auth()->id(), $negRating)) {
                                if ($request->vote != 'negative') {
                                    array_forget($rating['negative'],array_search(auth()->id(), $rating['negative']));
                                    array_push($rating['positive'], auth()->id);
                                } else {
                                    return response()->json([
                                        'type' => 'info',
                                        'message' => 'Вы уже голосовали за данную рецензию'
                                    ]);
                                }
                            }
                            break;
                    }
                }
                $review->rating = $rating;
                $review->save();

                return response()->json([
                    'scoreType' => $request->vote,
                    'score' => count($rating[$request->vote])
                ]);
            } else {
                return response()->json([
                    'message' => 'Только авторизованные пользователи могут ставить оценки рецензиям'
                ], 403);
            }
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
