@push('styles')
    <link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Custom/itemInfo.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Custom/rating.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/rating.js') }}"></script>
@endpush
@extends('layouts.main',['title'=>$author->name])
@section('content')
    <div id="wrapper" class="">
        <div id="container-info">
            <header id="page-header">
                <h2 class="page-title">{{ $author->name }}</h2>
            </header>
            {{Breadcrumbs::render()}}
            <section id="short-info">
                <div class="short-img">
                    @auth
                        <div id="avg-rating-container">
                            <div id="avg-rating" title="Средний рейтинг">
                                <i class="fas fa-star"></i>
                                <span>{{ $avgRating }}</span>
                            </div>
                            <div id="rating-quantity" title="Количество оценок">
                                <i class="fas fa-users fa-lg"></i>
                                <span>{{ $quantityRating }}</span>
                            </div>
                        </div>
                    @endauth
                    <div class="image-wrapper">
                        <img src="{{ asset(getStorageFile('authors', $author->id))}}" alt="{{ $author->name }}">
                    </div>
                    @if(Auth::check())
                        <div id="user-actions-wrapper">
                            <div class="user-actions-container" title="Написать комментарий">
                                <a id="add-comment" href="#"><i class="far fa-comments"></i></a>
                            </div>
                            <div class="user-actions-container">
                                <a class="add-to-favorite {{ ($inFavorite) ? 'active' : '' }}" data-type="author"
                                   href="#" title="{{ ($inFavorite) ? 'Удалить из избранного' : 'Добавить в избранное'
                                   }}">
                                    <i class="fa fa-heart fa-fw" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        @include('layouts.rating', ['type'=>'author', 'score'=>$rating['score']])
                    @endif
                </div>
                <aside class="short-info-items">
                    <ul>
                        <li>
                            <span><i class="fa fa-book fa-lg item-icon" aria-hidden="true"></i>Количество книг:</span>
                            <a href="{{ route('author-books', [$author->id]) }}" class="item-link">{{ count($books) }}</a>
                        </li>
                        @if($categories->count() and !empty($categories->first()->id))
                            <li>
                                <div id="categories">
                                    <span><i class="fa fa-bars fa-lg item-icon" aria-hidden="true"></i>Жанр:</span>
                                    @foreach($categories as $category)
                                        <a href="{{ route('category-books', [$category->id]) }}"
                                           class="category">{{ $category->name }}</a>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                        @if($authorSeries->isNotEmpty())
                            <li>
                                <div id="series">
                                    <span><i class="fas fa-hashtag fa-lg item-icon" aria-hidden="true"></i>Серия:</span>
                                    @foreach($authorSeries as $series)
                                        <a href="{{ route('series-books', [$series->id]) }}"
                                           class="item-link series-item">{{ $series->name }}</a>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                        <li>
                            <div class="statistic-wrapper">
                                <div class="inFavorite-count-wrapper">
                                    <div class="inFavorite-count statistic-item"
                                         title="Количество людей, которым нравится данный автор">
                                        <i class="fas fa-heart"></i>
                                        <span>{{ $statistic['inFavorite'] }}</span>
                                    </div>
                                </div>
                                <div class="reading-count-wrapper">
                                    <div class="reading-count statistic-item"
                                         title="Количество людей, которые читают книги автора в данный момент">
                                        <i class="fas fa-book"></i>
                                        <span>{{ $statistic['reading'] }}</span>
                                    </div>
                                </div>
                            </div>
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
        <div id="sidebar-header">
            <h4>Книги автора:</h4>
        </div>
        <div id="sidebar-container">
            <div id="sidebar-absolute-wrapper">
                @include('layouts.commonGrid',
                [
                    'array' => $books,
                    'routeName' => 'book',
                    'imgFolder' => 'books',
                ])
            </div>
        </div>
    </aside>
@endsection
