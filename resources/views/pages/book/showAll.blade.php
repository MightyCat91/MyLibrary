@extends('layout.main')

@section('title')
    MyLibrary
@stop

@section('content')
    <h1>All books</h1>
    <div class="books list-group">
        @foreach($books as $book)
            <div class="list-group-item">
                <div class="book-cover">
                    <img src="{{asset("uploads/booksCover/" . $book->imgHref)}}"
                         class="img-rounded pull-left img-responsive" alt="{{$book->imgHref}}">
                </div>
                <div class="book-name book-attr">
                    <label for="book-name">Name:</label>
                    {{--<div class="glyphicon-book"></div>--}}
                    <h4 class="list-group-item-heading book-name">{{ $book->name }}</h4>
                </div>
                <div class="book-authors book-attr">
                    <label for="author">Authors:</label>
                    @foreach($book->authors as $author)
                        <a href="#" class="author">{{ $author->name }}</a>
                    @endforeach
                </div>
                <div class="book-categories book-attr">
                    <label for="category">Genre:</label>
                    @foreach($book->categories as $category)
                        <a class="label label-info label-pill category">{{ $category->name }}</a>
                    @endforeach
                </div>
                <div class="book-page-count book-attr">
                    <label class="book-page-count">Count of page:</label>

                    <p>{{ $book->pageCount }}</p>
                </div>
                <div class="book-sinopsis book-attr">
                    <label for="book-sinopsis">Sinopsis:</label>
                    <p class="book-sinopsis">{{ $book->sinopsis }}</p>
                </div>
            </div>
        @endforeach
    </div>
@stop