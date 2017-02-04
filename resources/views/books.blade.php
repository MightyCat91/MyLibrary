@extends('layouts.main')
@section('content')
    @yield('category')
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
        @include('layouts.books')
    </div>
@endsection