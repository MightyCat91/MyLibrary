<?php
//home
Breadcrumbs::add('home', 'home');
//authors
Breadcrumbs::add('authors', 'authors', 'home');
//author
Breadcrumbs::add('author', 'author', 'authors', [\App\Author::pluck('id')]);
//add authors
Breadcrumbs::add('add-authors', 'author-add-get', 'home');
//books
Breadcrumbs::add('books', 'books', 'home');
//book
Breadcrumbs::add('book', 'book', 'books', [\App\Book::pluck('id')]);
//author-books
Breadcrumbs::add('author-books', 'author-books', 'books', [\App\Author::pluck('id')]);
//year-books
Breadcrumbs::add('year-books', 'year-books', 'books', [\App\Book::pluck('year')]);
//add books
Breadcrumbs::add('add-books', 'book-add-get', 'home');
//categories
Breadcrumbs::add('categories', 'categories', 'home');
//category-books
Breadcrumbs::add('category-books', 'category-books', 'categories', [\App\Categories::pluck('id')]);
//category-authors
Breadcrumbs::add('category-authors', 'category-authors', 'categories', [\App\Categories::pluck('id')]);
//series-books
Breadcrumbs::add('series-books', 'series-books', 'books', [\App\Series::pluck('id')]);
//publishers
Breadcrumbs::add('publishers', 'publishers', 'home');
//publisher-books
Breadcrumbs::add('publisher-books', 'publisher-books', 'publishers', [\App\Publisher::pluck('id')]);