{{ Session::flash('title', '404 - Страница не найдена') }}
@extends('layouts.main')
@section('content')
    <section id="wrapper404">
        <h1>404</h1>
        <h2>Страница не найдена</h2>
        <img id="image404" src="{{ asset('images/404.jpg') }}">
        <blockquote class="title404">Мы ищем не там, где надо, и потому не можем их найти...
            - Сесилия Ахерн</blockquote>
    </section>
@endsection