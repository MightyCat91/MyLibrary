<?php
//home
//Breadcrumbs::add('home', 'home');
////authors
//Breadcrumbs::add('authors', 'authors', 'home');
////books
//Breadcrumbs::add('books', 'books', 'home');
//book
Breadcrumbs::add('book', 'book/{book}', ['book'=>new \App\Book()], 'books');
