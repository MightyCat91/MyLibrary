@push('styles')
    <link href="{{ asset('/css/Library/Owl.Carousel/owl.carousel.min.css') }}" rel='stylesheet' type='text/css'
          media="all"/>
    <link href="{{ asset('/css/Library/MorrisCharts/morris.css') }}" rel='stylesheet' type='text/css' media="all"/>
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
    <section id="user-information" class="user-section">
        <h2>Информация</h2>
        <ul>
            <li>
                <span>Имя:</span>
                <span>{{ $name }}</span>
            </li>
            <li>
                <span>Email:</span>
                <span>{{ $email }}</span>
            </li>
            <li>
                <span>Пол:</span>
                <span>{{ $gender }}</span>
            </li>
            <li>
                <span>Дата регистрации:</span>
                <span>{{ $created_at }}</span>
            </li>
            <li>
                <span>Последний визит:</span>
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
                    <a href="{{ action('UserController@showBooksForUser',
                        ['books' => Crypt::encrypt($statisticBooks), 'id' => auth()->id()]) }}">
                        {{ count(array_flatten($statisticBooks)) }}
                    </a>
                </div>
                <div>
                    <span>Всего авторов:</span>
                    <a href="{{ action('UserController@showAuthorsForUser',
                        ['authors' => Crypt::encrypt($statisticAuthors), 'id' => auth()->id()]) }}">
                        {{ count($statisticAuthors) }}
                    </a>
                </div>
                <div>
                    <span>Всего жанров:</span>
                    <a href="{{ action('UserController@showCategoriesForUser',
                        ['categories' => Crypt::encrypt($statisticCategories), 'id' => auth()->id()]) }}">
                        {{ count($statisticCategories) }}
                    </a>
                </div>
            </div>
            <div id="statistic-chart">
                <div id="diagram-legend">
                    @foreach($status as $st)
                        <a href="{{ action('UserController@showStatusBooksForUser',
                        ['books' => Crypt::encrypt(array_has($statisticBooks, $st->name) ? $statisticBooks[$st->name]: []),
                        'id' => auth()->id(),
                        'status' => $st->name,
                        'title' => $st->uname]) }}"
                           class="{{$st->name}}"
                           data-books="{{ array_has($statisticBooks, $st->name) ? count($statisticBooks[$st->name]) : 0 }}">
                            <span>{{ $st->uname }}</span>
                        </a>
                    @endforeach
                </div>
                <div id="book-diagram">
                </div>
            </div>
        </div>
    </section>
    <section id="user-favorite-books" class="user-section">
        <h2>
            <a href="{{ route('userFavorite', ['type'=> 'book',
            'favoriteId' => $favoriteBooks,
            'title' => 'Любимые книги']) }}">
                Любимые книги
            </a>
        </h2>

        @isset($favoriteBooks)
            <div class="books-slider owl-carousel owl-theme">
                @foreach($favoriteBooks as $id => $name)
                    <a href="{{ route('book', [$id]) }}" target="_blank" title="{{ $name }}">
                        <figure class="user-favorite-img item">
                            <img src="{{ asset(getStorageFile('books', $id))}}" alt="{{ $name }}">
                        </figure>
                    </a>
                @endforeach
            </div>
        @endisset
    </section>
    <section id="user-favorite-authors" class="user-section">
        <h2>
            <a href="{{ route('userFavorite', ['type'=> 'author', 'favoriteId' => $favoriteAuthors,
            'title' => 'Любимые авторы']) }}">
                Любимые авторы
            </a>
        </h2>

        @isset($favoriteAuthors)
            <div class="author-slider owl-carousel owl-theme">
                @foreach($favoriteAuthors as $id => $name)
                    <a href="{{ route('author', [$id]) }}" target="_blank" title="{{ $name }}">
                        <figure class="user-favorite-img item">
                            <img src="{{ asset(getStorageFile('authors', $id))}}" alt="{{ $name }}">
                        </figure>
                    </a>
                @endforeach
            </div>
        @endisset
    </section>
    <section id="user-favorite-categories" class="user-section">
        <h2>
            <a href="{{ route('userFavorite', ['type'=> 'category', 'favoriteId' => $favoriteCategories,
            'title' => 'Любимые жанры']) }}">
                Любимые жанры
            </a>
        </h2>

        @isset($favoriteCategories)
            <div class="owl-carousel owl-theme">
                @foreach($favoriteCategories as $id => $name)
                    <a href="{{ route('category', [$id]) }}" target="_blank" title="{{ $name }}">
                        <figure class="user-favorite-img item">
                            <img src="{{ asset(getStorageFile('categories', $id))}}" alt="{{ $name }}">
                        </figure>
                    </a>
                @endforeach
            </div>
        @endisset
    </section>
@endsection