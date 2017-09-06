<?php
$authorId = \App\Author::pluck('id');
$bookId = \App\Book::pluck('id');
$bookYear = \App\Book::pluck('year');
$categoryId = \App\Categories::pluck('id');
$seriesId = \App\Series::pluck('id');
$publisherId = \App\Publisher::pluck('id');
$userId = \App\User::pluck('id');
$bookStatus = \App\Status::pluck('name');

//home
Breadcrumbs::add('home', 'home', '');
//authors
Breadcrumbs::add('authors', 'authors', 'Авторы', 'home');
//author
Breadcrumbs::add('author', 'author', '', 'authors', ['id' => $authorId]);
//add authors
Breadcrumbs::add('add-authors', 'author-add-get', 'home');
//books
Breadcrumbs::add('books', 'books', 'home');
//book
Breadcrumbs::add('book', 'book', 'books', ['id' => $bookId]);
//author-books
Breadcrumbs::add('author-books', 'author-books', 'books', ['id' => $authorId]);
//year-books
Breadcrumbs::add('year-books', 'year-books', 'books', ['year' => $bookYear]);
//add books
Breadcrumbs::add('add-books', 'book-add-get', 'home');
//categories
Breadcrumbs::add('categories', 'categories', 'home');
//category-books
Breadcrumbs::add('category-books', 'category-books', 'categories', ['id' => $categoryId]);
//category-authors
Breadcrumbs::add('category-authors', 'category-authors', 'categories', ['id' => $categoryId]);
//series-books
Breadcrumbs::add('series-books', 'series-books', 'books', ['id' => $seriesId]);
//publishers
Breadcrumbs::add('publishers', 'publishers', 'home');
//publisher-books
Breadcrumbs::add('publisher-books', 'publisher-books', 'publishers', ['id' => $publisherId]);
//userProfile
Breadcrumbs::add('userProfile', 'userProfile', 'home', ['id' => $userId]);
//userCollections
Breadcrumbs::add('userCollections', 'userCollections', 'home', ['id' => $userId]);
//userBooks
Breadcrumbs::add('userBooks', 'userBooks', 'home', ['id' => $userId]);
//userHistory
Breadcrumbs::add('userHistory', 'userHistory', 'home', ['id' => $userId]);
//userEditProfile
Breadcrumbs::add('userEditProfile', 'userEditProfile', 'home', ['id' => $userId]);
//userBooksStatistic
Breadcrumbs::add('userBooksStatistic', 'userBooksStatistic', 'userProfile', ['id' => $userId]);
//userAuthorsStatistic
Breadcrumbs::add('userAuthorsStatistic', 'userAuthorsStatistic', 'userProfile', ['id' => $userId]);
//userCategoriesStatistic
Breadcrumbs::add('userCategoriesStatistic', 'userCategoriesStatistic', 'userProfile', ['id' => $userId]);
//userStatusBooks
Breadcrumbs::add('userStatusBooks', 'userStatusBooks', 'userProfile', ['id' => $userId, 'status' => $bookStatus]);