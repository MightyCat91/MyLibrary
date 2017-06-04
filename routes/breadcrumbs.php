<?php
//home
Breadcrumbs::add('home', 'home');
//authors
Breadcrumbs::add('authors', 'authors', 'home');
//books
Breadcrumbs::add('books', 'books', 'home');
dd(route('book/^'));
//book
Breadcrumbs::add('book', 'book', 'books');
