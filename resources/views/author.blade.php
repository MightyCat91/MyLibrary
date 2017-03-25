@push('styles')
<link href="{{ asset('/css/Custom/itemInfo.css') }}" rel='stylesheet' type='text/css' media="all"/>
<link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@extends('layouts.main')
@section('content')
    <div id="wrapper" class="">
        <div id="container-info" class="">
            <header>
                <h2>{{ $author->name }}</h2>
            </header>
            <section id="short-info" class="row">
                <figure class="col-4 col-md-4 col-sm-4 short-img">
                    <img src="{{ asset('/authorsCover/'.$author->id.'.jpg')}}" alt="{{ $author->name }}">
                </figure>
                <aside class="col-8 col-md-8 col-sm-8 short-info-items">
                    <ul>
                        <li>
                            <span><i class="fa fa-book fa-lg item-icon" aria-hidden="true"></i>Количество книг:</span>
                            <a href="{{ route('author-books', [$author->id]) }}" class="item-link">{{ count($books)
                            }}</a>
                        </li>
                        <li>
                            <div id="categories">
                                <span><i class="fa fa-bars fa-lg item-icon" aria-hidden="true"></i>Жанр:</span>
                                @foreach($categories as $category)
                                    <a href="{{ route('category-books', [$category->id]) }}"
                                       class="category">{{ $category->name }}</a>
                                @endforeach
                            </div>
                        </li>
                        <li>
                            <a id="add-to-favorite" href="#">
                                <i class="fa fa-heart-o fa-lg item-icon" aria-hidden="true"></i>Добавить в любимые</a>
                        </li>
                    </ul>
                </aside>
            </section>
            <section id="description">
                <p>{{ $author->biography }}</p>
            </section>
        </div>
    </div>
    <aside id="books-sidebar" class="">
        @include('layouts.books')
    </aside>
@endsection
