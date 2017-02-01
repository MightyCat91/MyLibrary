@extends('layouts.main')
@section('content')
    <div class="wrapper">
        <div class="container-info">
            <header>
                <h2>{{ $book->name }}</h2>
            </header>
            <section class="short-info">
                <figure class="col-md-4 col-sm-4 short-img">
                    <img src="{{ asset('/booksCover/book_'.$book->id.'.jpg')}}" alt="{{ $book->name }}">
                </figure>
                <aside class="col-md-8 col-sm-8 short-info-items">
                    <ul>
                        <li>
                            <span><i class="fa fa-pencil fa-lg item-icon" aria-hidden="true"></i>Автор:</span>
                            @foreach($authors as $author)
                                <a href="{{ route('author', [$author->id]) }}">{{ $author->name . ' ' }}</a>
                            @endforeach
                        </li>
                        <li>
                            <div class="categories">
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
                                <a href="{{ route('year-books', [$book->year]) }}">{{ $book->year }}</a>
                            </li>
                        @endif
                        <li>
                            <span><i class="fa fa-users fa-lg item-icon" aria-hidden="true"></i>Издатель:</span>
                            @foreach($publishers as $publisher)
                                <a href="{{ route('publisher-books', [$publisher->id]) }}">{{ $publisher->name . ' ' }}</a>
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
                            <a class="add-to-favorite" href="#">
                                <i class="fa fa-heart-o fa-lg item-icon" aria-hidden="true"></i>Добавить в любимые</a>
                        </li>
                    </ul>
                </aside>
            </section>
            <section class="description">
                <p>{{ $book->description }}</p>
            </section>
        </div>
        {{--<aside class="books-sidebar">--}}
        {{--@foreach($books as $book)--}}
        {{--<a href="{{ route('book', $book->id) }}" >--}}
        {{--<figure class="thumbnail container">--}}
        {{--<img src="{{ asset('/booksCover/book_'.$book->id.'.jpg') }}" alt="{{ $book->name }}"/>--}}
        {{--<figcaption class="resent-grid-info title">{{ $book->name }}</figcaption>--}}
        {{--</figure>--}}
        {{--</a>--}}
        {{--@endforeach--}}
        {{--</aside>--}}
    </div>
@endsection