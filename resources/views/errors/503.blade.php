@extends('layouts.main',['title'=>'503 - Сайт временно не доступен'])
@section('content')
    <section id="wrapperErrorPage">
        <h1>Сайт временно не доступен</h1>
        <h3>Попробуйте зайти позже</h3>
        <img id="imageErrorPage" src="{{ asset('images/503.jpg') }}">
        <blockquote class="titleErrorPage">
            <p><cite>Ожидание — это пустая трата времени и, в конечном счете, еще и полнейшее разочарование, ибо наши
                    надежды не оправдались.</cite></p>
            <p><cite>- Хардли Хавелок</cite></p>
        </blockquote>
    </section>
@endsection