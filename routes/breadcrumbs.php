<?php
//home
Breadcrumbs::add('home', 'home');
//authors
Breadcrumbs::add('authors', 'authors', 'home');
//author
Breadcrumbs::add('author', 'author', 'authors', ['author'=>new \App\Author()]);
//books
Breadcrumbs::add('books', 'books', 'home');
//book
Breadcrumbs::add('book', 'book', 'books', ['book'=>new \App\Book()]);
//author-books
Breadcrumbs::add('author-books', 'author-books', 'author', ['books'=>new \App\Book()]);
//year-books
Breadcrumbs::add('year-books', 'year-books', 'books');
