@push('styles')
<link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@extends('layouts.main')
@section('content')
    @yield('category')
    <div id="main-container" class="row">
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
        @include('layouts.commonGrid',
        [
            'array' => $books,
            'routeName' => 'book',
            'imgFolder' => 'books'
        ])
    </div>
@endsection