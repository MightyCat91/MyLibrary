<?php
// Home
Breadcrumbs::create('home', function($breadcrumbs)
{
    $breadcrumbs->add('Home', route('home'));
});
Breadcrumbs::create('authors', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->add('Authors', route('authors'));
});