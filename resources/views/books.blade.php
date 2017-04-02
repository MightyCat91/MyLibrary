@push('styles')
<link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
<script type="text/javascript" src="{{ asset('/js/Custom/StickyBlock.js') }}"></script>
@endpush
@extends('layouts.main')
@section('alphabetFilter')
    <section id="alphabet-filter-container">
        <div id="alphabet-sticky-block">
            @foreach(range(chr(0xC0),chr(0xDF)) as $letter)
                <div class="letter-filter">{{ iconv('CP1251','UTF-8',$letter) }}</div>
            @endforeach
        </div>
    </section>
@endsection
@section('content')
    @yield('category')
    <div id="main-container" class="row container">
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