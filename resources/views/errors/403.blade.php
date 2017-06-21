@extends('layouts.main',['title'=>'403 - Сайт временно не доступен'])
@section('content')
    <section id="wrapperErrorPage">
        <h1>Доступ запрещён</h1>
        <h3>У Вас нет прав для просмотра данной страницы</h3>
        <img id="imageErrorPage" src="{{ asset('images/403.jpg') }}">
        <blockquote class="titleErrorPage">
            <p><cite>Мы всегда стремимся к запретному и желаем недозволенного.</cite></p>
            <p><cite>- Публий Овидий Назон</cite></p>
        </blockquote>
    </section>
@endsection