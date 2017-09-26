@extends('layouts.main',['title'=>'Моя библиотека'])
@section('content')
    <div class="user-wrapper">
        <div class="user-book-library">
            <div class="book-status-container">
                @foreach($statuses as $status)
                    <div class="book-status--element">
                        <span>{{ $status }}</span>
                    </div>
                @endforeach
            </div>
            <div class="user-book-library-table">
                <div class="table-header--title">
                    <span>Все книги</span>
                </div>
                <div class="table-body">
                    <div class="table--row">
                        <div class="table-column--number">#</div>
                        <div class="table-column--name">Название книги</div>
                        <div class="table-column--status">Статус книги</div>
                        <div class="table-column--rating">Рейтинг книги</div>
                        <div class="table-column--authors">Авторы книги</div>
                        <div class="table-column--pages">Страниц в книге</div>
                    </div>
                    {{dd($books)}}
                    @foreach($books as $id => $book)
                        <div class="table-column--number">{{ $id++ }}</div>
                        <div class="table-column--name">Название книги</div>
                        <div class="table-column--status">Статус книги</div>
                        <div class="table-column--rating">Рейтинг книги</div>
                        <div class="table-column--authors">Авторы книги</div>
                        <div class="table-column--pages">Страниц в книге</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection