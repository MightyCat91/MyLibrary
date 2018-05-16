<?php
$author = \App\Author::all('id', 'name');
$book = \App\Book::all('id', 'name');
$bookYear = \App\Book::pluck('year');
$category = \App\Categories::all('id', 'name');
$series = \App\Series::all('id', 'name');
$publisher = \App\Publisher::all('id', 'name');
$userId = \App\User::pluck('id');
$bookStatus = \App\Status::all('name', 'uname');

//home
Breadcrumbs::add('home', 'home', '');

//authors
Breadcrumbs::add('authors', 'authors', 'Авторы', 'home');

//author
Breadcrumbs::add('author', 'author', ['id' => $author->pluck('name')->toArray()],
    'authors', ['id' => $author->pluck('id')]);

//add authors
Breadcrumbs::add('add-authors', 'author-add-get', 'Добавление автора', 'home');

//books
Breadcrumbs::add('books', 'books', 'Книги', 'home');

//book
Breadcrumbs::add('book', 'book', ['id' => $book->pluck('name')->toArray()],
    'books', ['id' => $book->pluck('id')]);

//author-books
Breadcrumbs::add('author-books', 'author-books', 'Книги','author', ['id' => $author->pluck('id')]);

//year-books
Breadcrumbs::add('year-books', 'year-books', ['year' => $bookYear->toArray()],
    'books', ['year' => $bookYear]);

//add books
Breadcrumbs::add('add-books', 'book-add-get', 'Добавление книги','home');

//categories
Breadcrumbs::add('categories', 'categories', 'Жанры', 'home');

//category-books
Breadcrumbs::add('category-books', 'category-books', ['id' => $category->pluck('name')->toArray()],
    'categories', ['id' => $category->pluck('id')]);

//category-authors
Breadcrumbs::add('category-authors', 'category-authors', ['id' => $category->pluck('name')->toArray()],
    'categories', ['id' => $category->pluck('id')]);

//series-books
Breadcrumbs::add('series-books', 'series-books', ['id' => $series->pluck('name')->toArray()],
    'home', ['id' => $series->pluck('id')]);

//publisher-books
Breadcrumbs::add('publisher-books', 'publisher-books', ['id' => $publisher->pluck('name')->toArray()],
    'home', ['id' => $publisher->pluck('id')]);

//userProfile
Breadcrumbs::add('userProfile', 'userProfile','Профиль','home', ['id' => $userId]);

//userCollections
Breadcrumbs::add('userCollections', 'userCollections','Коллекции','home', ['id' => $userId]);

//userLibrary
Breadcrumbs::add('userLibrary', 'userLibrary','Личная библиотека','home', ['id' => $userId]);

//userHistory
Breadcrumbs::add('userHistory', 'userHistory','История действий','home', ['id' => $userId]);

//userEditProfile
Breadcrumbs::add('userEditProfile', 'userEditProfile','Настройки профиля','home',
    ['id' => $userId]);

//userBooksStatistic
Breadcrumbs::add('userBooksStatistic', 'userBooksStatistic', 'Статистика книг из личной библиотеки',
    'userProfile', ['id' => $userId]);

//userAuthorsStatistic
Breadcrumbs::add('userAuthorsStatistic', 'userAuthorsStatistic','Статистика авторов из личной библиотеки',
    'userProfile', ['id' => $userId]);

//userCategoriesStatistic
Breadcrumbs::add('userCategoriesStatistic', 'userCategoriesStatistic',
    'Статистика жанров из личной библиотеки','userProfile', ['id' => $userId]);

//userStatusBooks
Breadcrumbs::add('userStatusBooks', 'userStatusBooks',
    ['status' => $bookStatus->pluck('uname')->toArray()],
    'userProfile', ['id' => $userId, 'status' => $bookStatus->pluck('name')]);

//userStatusBooks
Breadcrumbs::add('userFavorite', 'userFavorite',
    ['type' => ['Любимые книги', 'Любимые авторы', 'Любимые жанры']],
    'userProfile', ['id' => $userId, 'type' => collect(['book', 'author', 'category'])]);
//todo: добавить проверку на то, что получаемое значение в качестве параметра это массив или коллекция