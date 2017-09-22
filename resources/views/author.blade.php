@push('styles')
<link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
<link href="{{ asset('/css/Custom/itemInfo.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/rating.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/Custom/rating.js') }}"></script>
@endpush
@extends('layouts.main',['title'=>$author->name])
@section('content')
    <div id="wrapper" class="">
        <div id="container-info" class="">
            <header>
                <h2 class="page-title">{{ $author->name }}</h2>
            </header>
            {{Breadcrumbs::render()}}
            <section id="short-info">
                <figure class="short-img">
                    {{--@auth--}}
                    @if(Auth::check())
                        <div id="avg-rating-container">
                            <div id="avg-rating" title="Средний рейтинг">
                                <i class="fa fa-star"></i>
                                <span>{{ $avgRating }}</span>
                            </div>
                            <div id="rating-quantity" title="Количество оценок">
                                <i class="fa fa-user-o" aria-hidden="true"></i>
                                <span>{{ $quantityRating }}</span>
                            </div>
                        </div>
                        {{--@endauth--}}
                    @endif
                    <img src="{{ asset(getStorageFile('authors', $author->id))}}" alt="{{ $author->name }}">
                    @if(Auth::check())
                        <div id="user-actions-wrapper">
                            <div class="user-actions-item" title="Написать комментарий">
                                <a id="add-comment" href="#"><i class="fa fa-comments fa-fw" aria-hidden="true"></i></a>
                            </div>
                            <div class="user-actions-item">
                                <a id="add-review" href="#" title="Написать рецензию">
                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="user-actions-item">
                                <a id="add-to-favorite" class="{{ ($inFavorite) ? 'active' : '' }}" data-type="author"
                                   href="#" title="{{ ($inFavorite) ? 'Удалить из избранного' : 'Добавить в избранное'
                                   }}">
                                    <i class="fa fa-heart fa-fw" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        <div class="user-item-rating"
                             data-rating="{{ $rating['score'] }}" data-type="{{ $rating['type'] }}">
                            <div class="rating-star-container">
                                <div class="hover-rating-container">
                                    <div class="left-half"></div>
                                    <div class="right-half"></div>
                                </div>
                                <div class="star-icon-container">
                                    <i class="fa star-icon fa-star-o active" aria-hidden="true"></i>
                                    <i class="fa star-icon fa-star-half-o" data-rating="1" aria-hidden="true"></i>
                                    <i class="fa star-icon fa-star" data-rating="2" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="rating-star-container">
                                <div class="hover-rating-container">
                                    <div class="left-half"></div>
                                    <div class="right-half"></div>
                                </div>
                                <div class="star-icon-container">
                                    <i class="fa star-icon fa-star-o active" aria-hidden="true"></i>
                                    <i class="fa star-icon fa-star-half-o" data-rating="3" aria-hidden="true"></i>
                                    <i class="fa star-icon fa-star" data-rating="4" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="rating-star-container">
                                <div class="hover-rating-container">
                                    <div class="left-half"></div>
                                    <div class="right-half"></div>
                                </div>
                                <div class="star-icon-container">
                                    <i class="fa star-icon fa-star-o active" aria-hidden="true"></i>
                                    <i class="fa star-icon fa-star-half-o" data-rating="5" aria-hidden="true"></i>
                                    <i class="fa star-icon fa-star" data-rating="6" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="rating-star-container">
                                <div class="hover-rating-container">
                                    <div class="left-half"></div>
                                    <div class="right-half"></div>
                                </div>
                                <div class="star-icon-container">
                                    <i class="fa star-icon fa-star-o active" aria-hidden="true"></i>
                                    <i class="fa star-icon fa-star-half-o" data-rating="7" aria-hidden="true"></i>
                                    <i class="fa star-icon fa-star" data-rating="8" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="rating-star-container">
                                <div class="hover-rating-container">
                                    <div class="left-half"></div>
                                    <div class="right-half"></div>
                                </div>
                                <div class="star-icon-container">
                                    <i class="fa star-icon fa-star-o active" aria-hidden="true"></i>
                                    <i class="fa star-icon fa-star-half-o" data-rating="9" aria-hidden="true"></i>
                                    <i class="fa star-icon fa-star" data-rating="10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    @endif
                </figure>
                <aside class="short-info-items">
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
                        @if(!$authorSeries->isEmpty())
                            <li>
                                <div id="series">
                                    <span><i class="fa fa-slack fa-lg item-icon" aria-hidden="true"></i>Серия:</span>
                                    @foreach($authorSeries as $series)
                                        <a href="{{ route('series-books', [$series->id]) }}"
                                           class="item-link series-item">{{ $series->name }}</a>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                    </ul>
                </aside>
            </section>
            <section id="description">
                <p>{{ $author->biography }}</p>
            </section>
        </div>
    </div>
    <aside id="books-sidebar" class="">
        @include('layouts.commonGrid',
        [
            'array' => $books,
            'routeName' => 'book',
            'imgFolder' => 'books'
        ])
    </aside>
@endsection
