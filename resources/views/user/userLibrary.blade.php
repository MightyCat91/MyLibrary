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
                <table class="table-body">
                    <thead class="table--row">
                        <th class="table-column--number">#</th>
                        <div class="table-column--name">Название книги</div>
                        <div class="table-column--status">Статус книги</div>
                        <div class="table-column--rating">Рейтинг книги</div>
                        <div class="table-column--authors">Авторы книги</div>
                        <div class="table-column--pages">Страниц в книге</div>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection