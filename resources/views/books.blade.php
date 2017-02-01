@extends('layouts.main')
@section('content')
    <div class="main-container row">
        @if (Route::current()->getName() == 'author-books')
            <header>
                <h2>{{ $authorName }}</h2>
            </header>
        @endif
        @if (Route::current()->getName() == 'year-books')
            <header>
                <h2>Книги изданные в {{ $books[0]->year }} году</h2>
            </header>
        @endif
        @foreach($books as $book)
            <a href="{{ route('book', $book->id) }}">
                <figure class="col-md-3 col-sm-4 col-xs-6 thumbnail container">
                    <img src="{{ asset('/BooksCover/book_'.$book->id.'.jpg')}}" alt="{{ $book->name }}"/>
                    <figcaption class="resent-grid-info title">{{ $book->name }}</figcaption>
                </figure>
            </a>
        @endforeach
    </div>
@endsection