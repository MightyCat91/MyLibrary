<?php
$authorId = \App\Author::pluck('id');
$bookId = \App\Book::pluck('id');
$bookYear = \App\Book::pluck('year');
$categoryId = \App\Categories::pluck('id');
$seriesId = \App\Series::pluck('id');
$publisherId = \App\Publisher::pluck('id');
//home
Breadcrumbs::add('home', 'home');
//authors
Breadcrumbs::add('authors', 'authors', 'home');
//author
Breadcrumbs::add('author', 'author', 'authors', [$authorId]);
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