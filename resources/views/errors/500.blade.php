@extends('layouts.main',['title'=>'500 - Ошибка сервера'])
@section('content')
    <section id="wrapperErrorPage">
        <h1>Внутренняя ошибка сервера</h1>
        <h3>Что-то случилось, но мы быстро это исправим</h3>
        <img id="imageErrorPage" src="{{ asset('images/500.jpg') }}">
        <blockquote class="titleErrorPage">
            <p><cite>Единственная настоящая ошибка — не исправлять своих прошлых ошибок.</cite></p>
            <p><cite>- Конфуций</cite></p>
        </blockquote>
    </section>
@endsection