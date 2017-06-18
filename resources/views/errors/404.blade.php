@extends('layouts.main',['title'=>'404 - Страница не найдена'])
@section('content')
    <section id="wrapperErrorPage">
        <h1>Страница не найдена</h1>
        <h3>Возможно, Вы допустили опечатку или такой страницы не существует</h3>
        <img id="imageErrorPage" src="{{ asset('images/404.jpg') }}">
        <blockquote class="titleErrorPage">
            <p><cite>Мы ищем не там, где надо, и потому не можем их найти...</cite></p>
            <p><cite>- Сесилия Ахерн</cite></p>
        </blockquote>
    </section>
@endsection