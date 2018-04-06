@push('styles')
    <link href="{{ asset('/css/Library/Owl.Carousel/owl.carousel.min.css') }}" rel='stylesheet' type='text/css'
          media="all"/>
    <link href="{{ asset('/css/Library/MorisCharts/morris.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/custom/userProfile.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Library/Owl.Carousel/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/Library/MorrisCharts/raphael-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/Library/MorrisCharts/morris.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/Custom/userProfile.js') }}"></script>
@endpush
@extends('layouts.main',['title'=>'Профиль пользователя'])
@section('content')
    {{Breadcrumbs::render()}}
    <div class="container main-container">
        <section id="user-information" class="user-section">
            <h2>Информация</h2>
            <ul>
                <li>
                    <span class="information-item-title">Имя:</span>
                    <span>{{ $name }}</span>
                </li>
                <li>
                    <span class="information-item-title">Email:</span>
                    <span>{{ $email }}</span>
                </li>
                <li>
                    <span class="information-item-title">Пол:</span>
                    <span>{{ $gender }}</span>
                </li>
                <li>
                    <span class="information-item-title">Дата регистрации:</span>
                    <span>{{ $created_at }}</span>
                </li>
                <li>
                    <span class="information-item-title">Последний визит:</span>
                    <span>{{ $last_visit }}</span>
                </li>

            </ul>
        </section>
        <section id="user-statistic" class="user-selection">
            <h2>Статистика</h2>
            <div id="statistic-wrapper">
                <div id="statistic-count">
                    <div>
                        <span>Всего книг:</span>
                        <a href="{{ action('UserController@showBooksForUser', ['id' => auth()->id()]) }}">
                            {{ $statistic['booksCount'] }}
                        </a>
                    </div>
                    <div>
                        <span>Всего авторов:</span>
                        <a href="{{ action('UserController@showAuthorsForUser', ['id' => auth()->id()]) }}">
                            {{ $statistic['authorsCount'] }}
                        </a>
                    </div>
                    <div>
                        <span>Всего жанров:</span>
                        <a href="{{ action('UserController@showCategoriesForUser', ['id' => auth()->id()]) }}">
                            {{ $statistic['categoriesCount'] }}
                        </a>
                    </div>
                </div>
                <div id="statistic-chart">
                    <div id="diagram-legend">
                        @foreach($statistic['statuses'] as $status => $statusValue)
                            <a href="{{ action('UserController@showStatusBooksForUser', ['status'=>$status, 'id' => auth()->id()]) }}"
                               class="{{ $status }}" data-books="{{ $statusValue['count'] }}">
                                <span>{{ $statusValue['name'] }}</span>
                            </a>
                        @endforeach
                    </div>
                    <div id="book-diagram">
                    </div>
                </div>
            </div>
        </section>
        <section id="user-favorite-books" class="user-section user-favorite">
            @if(!empty($favoriteBooks))
                <h2>
                    <a href="{{ route('userFavorite', ['type' => 'book', 'id' => auth()->id(), 'title' => 'Любимые книги']) }}">
                        Любимые книги
                    </a>
                </h2>
                <div class="books-slider owl-carousel owl-theme">
                    @foreach($favoriteBooks as $id => $name)
                        <a href="{{ route('book', [$id]) }}" target="_blank" title="{{ $name }}">
                            <figure class="user-favorite-img item">
                                <img src="{{ asset(getStorageFile('books', $id))}}" alt="{{ $name }}">
                            </figure>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>
        <section id="user-favorite-authors" class="user-section user-favorite">
            @if(!empty($favoriteAuthors))
                <h2>
                    <a href="{{ route('userFavorite', ['type'=> 'author', 'id' => auth()->id(), 'title' => 'Любимые авторы']) }}">
                        Любимые авторы
                    </a>
                </h2>
                <div class="author-slider owl-carousel owl-theme">
                    @foreach($favoriteAuthors as $id => $name)
                        <a href="{{ route('author', [$id]) }}" target="_blank" title="{{ $name }}">
                            <figure class="user-favorite-img item">
                                <img src="{{ asset(getStorageFile('authors', $id))}}" alt="{{ $name }}">
                            </figure>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>
        <section id="user-favorite-categories" class="user-section user-favorite">
            @if(!empty($favoriteCategories))
                <h2>
                    <a href="{{ route('userFavorite', ['type'=> 'category', 'id' => auth()->id(), 'title' => 'Любимые жанры']) }}">
                        Любимые жанры
                    </a>
                </h2>
                <div class="owl-carousel owl-theme">
                    @foreach($favoriteCategories as $id => $name)
                        <a href="{{ route('category', [$id]) }}" target="_blank" title="{{ $name }}">
                            <figure class="user-favorite-img item">
                                <img src="{{ asset(getStorageFile('categories', $id))}}" alt="{{ $name }}">
                            </figure>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
@endsection