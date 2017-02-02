@extends('layouts.main')
@section('content')
    <div class="wrapper">
        <div class="container-info">
            <header>
                <h2>{{ $author->name }}</h2>
            </header>
            <section class="short-info">
                <figure class="col-md-4 col-sm-4 short-img">
                    <img src="{{ asset('/authorsCover/'.$author->id.'.jpg')}}" alt="{{ $author->name }}">
                </figure>
                <aside class="col-md-8 col-sm-8 short-info-items">
                    <ul>
                        <li>
                            <a class="add-to-favorite" href="#">
                                <i class="fa fa-heart-o fa-lg item-icon" aria-hidden="true"></i>Добавить в любимые</a>
                        </li>
                        <li>
                            <span><i class="fa fa-book fa-lg item-icon" aria-hidden="true"></i>Количество книг:</span>
                            <a href="{{ route('author-books', [$author->id]) }}">
                                {{ count($books) }}
                            </a>
                        </li>
                        <li>
                            <div class="categories">
                                <span><i class="fa fa-bars fa-lg item-icon" aria-hidden="true"></i>Жанр:</span>
                                @foreach($categories as $category)
                                    <a href="{{ route('category-books', [$category->id]) }}" class="category">{{ $category->name . ' ' }}</a>
                                @endforeach
                            </div>
                        </li>
                    </ul>
                </aside>
            </section>
            <section class="description">
                <p>{{ $author->biography }}</p>
            </section>
        </div>
        <aside class="books-sidebar">
            @foreach($books as $book)
                <a href="{{ route('book', $book->id) }}" >
                    <figure class="thumbnail container">
                        <img src="{{ asset('/booksCover/book_'.$book->id.'.jpg') }}" alt="{{ $book->name }}"/>
                        <figcaption class="resent-grid-info title">{{ $book->name }}</figcaption>
                    </figure>
                </a>
            @endforeach
        </aside>
    </div>
@endsection
