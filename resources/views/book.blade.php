@push('styles')
    <link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Custom/itemInfo.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Custom/rating.css') }}" rel='stylesheet' type='text/css' media="all"/>
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
    <script type="text/javascript" src="{{ asset('/js/Custom/rating.js') }}"></script>
@endpush
@extends('layouts.main',['title'=>$book->name])
@section('content')
    <div id="wrapper" class="main-container">
        <div id="container-info">
            <header>
                <h2 class="page-title">{{ $book->name }}</h2>
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
                    <div class="slider owl-carousel owl-theme">
                        @foreach(getAllStorageFiles('books', $book->id) as $bookCover)
                            <img class="item" src="{{ asset($bookCover)}}" alt="{{ $book->name }}">
                        @endforeach
                    </div>
                    {{--@auth--}}
                    @if(Auth::check())
                        <div class="user-action-container">
                            <div id="user-actions-wrapper">
                                <div class="user-actions-container" title="Написать комментарий">
                                    <a id="add-comment" href="#"><i class="fa fa-comments fa-fw" aria-hidden="true"></i></a>
                                </div>
                                <div class="user-actions-container">
                                    <a id="add-review" href="#" title="Написать рецензию">
                                        <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="user-actions-container">
                                    <a class="add-to-favorite {{ ($inFavorite) ? 'active' : '' }}" data-type="book"
                                       href="#" title="{{ ($inFavorite) ? 'Удалить из избранного' : 'Добавить в избранное'
                                   }}">
                                        <i class="fa fa-heart fa-fw" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="users-book-status">
                                <a tabindex="0" id="status-btn" data-toggle="popover"
                                   data-status="{{ $status ? $status->name : '' }}">{{ $status ? $status->uname : 'Статус' }}</a>
                                <div id="status-list" class="hidden">
                                    @foreach($allStatuses as $stat)
                                        <div class="status-option {{ $stat->name }}"
                                             data-status="{{ $stat->name }}">{{ $stat->uname }}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="user-book-progress {{ empty($status) ? 'hidden' : '' }}">
                                <div class="progress-label">Прочитано страниц:</div>
                                <div class="progress-input-wrapper">
                                    <input type="text" class="no-focused"
                                           value="{{ sprintf('%s/%s', $progress, $book->page_counts) }}">
                                </div>
                                <div class="error-message hidden">
                                    <span>Введенное значение первышает количество страниц книги</span>
                                </div>
                            </div>
                            @include('layouts.rating', ['type'=>'book', 'score'=>$rating['score'], 'status'=>$status])
                        </div>
                    @endif
                    {{--@endauth--}}
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
                            <span><i class="fa fa-address-book fa-lg item-icon" aria-hidden="true"></i>Издатель:</span>
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
                            <span id="book-pages">{{ $book->page_counts }}</span>
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
        <div id="sidebar-header">
            <h4>Книги этих же серий:</h4>
        </div>
        <div id="sidebar-container">
            <div id="sidebar-absolute-wrapper">
                @include('layouts.commonGrid',
                [
                    'array' => $sidebarBooks,
                    'routeName' => 'book',
                    'imgFolder' => 'books'
                ])
            </div>
        </div>
    </aside>
@endsection