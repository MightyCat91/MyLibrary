<?php
$authorId = \App\Author::pluck('id')->toArray();
$bookId = \App\Book::pluck('id');
$bookYear = \App\Book::pluck('year');
$categoryId = \App\Categories::pluck('id');
$seriesId = \App\Series::pluck('id');
$publisherId = \App\Publisher::pluck('id');
$userId = \App\User::pluck('id');
$bookStatus = \App\Status::pluck('name')->toArray();

//home
Breadcrumbs::add('home', 'home');
//authors
Breadcrumbs::add('authors', 'authors', 'home');
//author
Breadcrumbs::add('author', 'author', 'authors', [['a','b'], ['1','2']]);
//add authors
Breadcrumbs::add('add-authors', 'author-add-get', 'home');
//books
Breadcrumbs::add('books', 'books', 'home');
//book
Breadcrumbs::add('book', 'book', 'books', [$bookId]);
//author-books
Breadcrumbs::add('author-books', 'author-books', 'books', [$authorId]);
//year-books
Breadcrumbs::add('year-books', 'year-books', 'books', [$bookYear]);
//add books
Breadcrumbs::add('add-books', 'book-add-get', 'home');
//categories
Breadcrumbs::add('categories', 'categories', 'home');
//category-books
Breadcrumbs::add('category-books', 'category-books', 'categories', [$categoryId]);
//category-authors
Breadcrumbs::add('category-authors', 'category-authors', 'categories', [$categoryId]);
//series-books
Breadcrumbs::add('series-books', 'series-books', 'books', [$seriesId]);
//publishers
Breadcrumbs::add('publishers', 'publishers', 'home');
//publisher-books
Breadcrumbs::add('publisher-books', 'publisher-books', 'publishers', [$publisherId]);
//userProfile
Breadcrumbs::add('userProfile', 'userProfile', 'home', [$userId]);
//userCollections
Breadcrumbs::add('userCollections', 'userCollections', 'home', [$userId]);
//userBooks
Breadcrumbs::add('userBooks', 'userBooks', 'home', [$userId]);
//userHistory
Breadcrumbs::add('userHistory', 'userHistory', 'home', [$userId]);
//userEditProfile
Breadcrumbs::add('userEditProfile', 'userEditProfile', 'home', [$userId]);
//userBooksStatistic
Breadcrumbs::add('userBooksStatistic', 'userBooksStatistic', 'userProfile', [$userId]);
//userAuthorsStatistic
Breadcrumbs::add('userAuthorsStatistic', 'userAuthorsStatistic', 'userProfile', [$userId]);
//userCategoriesStatistic
Breadcrumbs::add('userCategoriesStatistic', 'userCategoriesStatistic', 'userProfile', [$userId]);
//userStatusBooks
Breadcrumbs::add('userStatusBooks', 'userStatusBooks', 'userProfile', [$userId, $bookStatus]);