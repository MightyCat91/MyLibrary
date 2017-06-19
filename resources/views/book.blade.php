@push('styles')
    <link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Custom/itemInfo.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Library/Owl.Carousel/owl.carousel.min.css') }}" rel='stylesheet' type='text/css'
          media="all"/>
    <link href="{{ asset('/css/Library/Owl.Carousel/owl.theme.default.min.css') }}" rel='stylesheet' type='text/css'
      media="all"/>
    <link href="{{ asset('/css/Library/Owl.Carousel/owl.theme.default.css') }}" rel='stylesheet' type='text/css'
      media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Library/Owl.Carousel/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/Custom/book.js') }}"></script>
@endpush
{{ Session::flash('title', $book->name) }}
@extends('layouts.main',['title'=>$book->name])
@section('content')
    <div id="wrapper">
        <div id="container-info">
            <header>
                <h2 class="page-title">{{ $book->name }}</h2>
            </header>
            {{Breadcrumbs::render()}}
            <section id="short-info" class="row">
                <figure class="short-img owl-carousel owl-theme">
                    @foreach(getPublicFiles('books', $book->id) as $bookCover)
                        <img class="item" src="{{ asset($bookCover)}}" alt="{{ $book->name }}">
                    @endforeach
                    {{--<img src="{{ asset(getPublicFiles('books', $book->id)[0])}}" alt="{{ $book->name }}">--}}
                </figure>
                <aside class="short-info-items">
                    <ul>
                        <li>
                            <span><i class="fa fa-users fa-lg item-icon" aria-hidden="true"></i>Автор:</span>
                            @foreach($authors as $author)
                                <a href="{{ route('author', [$author->id]) }}"
                                   class="item-link authors-item">{{ $author->name . ' ' }}</a>
                            @endforeach
                        </li>
                        @if(!$bookSeries->isEmpty())
                            <li>
                                <div id="series">
                                    <span><i class="fa fa-slack fa-lg item-icon" aria-hidden="true"></i>Серия:</span>
                                    @foreach($bookSeries as $series)
                                        <a href="{{ route('series-books', [$series->id]) }}"
                                           class="item-link series-item">{{ $series->name }}</a>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                        <li>
                            <div id="categories">
                                <span><i class="fa fa-list fa-lg item-icon" aria-hidden="true"></i>Жанр:</span>
                                @foreach($categories as $category)
                                    <a href="{{ route('category-books', [$category->id]) }}"
                                       class="category">{{ $category->name . ' ' }}</a>
                                @endforeach
                            </div>
                        </li>
                        @if (isset($book->year))
                            <li>
                                <span><i class="fa fa-calendar fa-lg item-icon" aria-hidden="true"></i>Год:</span>
                                <a href="{{ route('year-books', [$book->year]) }}"
                                   class="item-link">{{ $book->year }}</a>
                            </li>
                        @endif
                        <li>
                            <span><i class="fa fa-pencil fa-lg item-icon" aria-hidden="true"></i>Издатель:</span>
                            @foreach($publishers as $publisher)
                                <a href="{{ route('publisher-books', [$publisher->id]) }}"
                                   class="item-link publisher-item">{{ $publisher->name . ' ' }}</a>
                            @endforeach
                        </li>
                        @if (isset($book->isbn))
                            <li>
                                <span><i class="fa fa-ticket fa-lg item-icon" aria-hidden="true"></i>ISBN:</span>
                                <span>{{ $book->isbn }}</span>
                            </li>
                        @endif
                        <li>
                            <span><i class="fa fa-hourglass-half fa-lg item-icon" aria-hidden="true"></i>Количество страниц:</span>
                            <span>{{ $book->page_counts }}</span>
                        </li>
                        <li>
                            <a id="add-to-favorite" href="#">
                                <i class="fa fa-heart-o fa-lg item-icon" aria-hidden="true"></i>Добавить в любимые</a>
                        </li>
                    </ul>
                </aside>
            </section>
            <section id="description">
                <p>{{ $book->description }}</p>
            </section>
        </div>
    </div>
    <aside id="books-sidebar" class="">
        @include('layouts.commonGrid',
        [
            'array' => $sidebarBooks,
            'routeName' => 'book',
            'imgFolder' => 'books'
        ])
    </aside>
@endsection