@push('styles')
<link href="{{ asset('/css/Library/Owl.Carousel/owl.carousel.min.css') }}" rel='stylesheet' type='text/css'
      media="all"/>
<link href="{{ asset('/css/custom/userProfile.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
<script type="text/javascript" src="{{ asset('/js/Library/Owl.Carousel/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/Custom/userProfile.js') }}"></script>
@endpush
@extends('layouts.main',['title'=>'Профиль'])
@section('content')
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

        <div id="book-diagram">
            <span class="reading"></span>
            <span class="complited"></span>
            <span class="drop"></span>
            <span class="hold"></span>
            <span class="planing"></span>
        </div>
        <div id="diagram-legend">
            <div>
                <a href="#" class="reading">
                    <span>Читаю</span>
                </a>
                <a href="#" class="complited">
                    <span>Прочитано</span>
                </a>
                <a href="#" class="drop">
                    <span>Бросил</span>
                </a>
                <a href="#" class="hold">
                    <span>Отложил</span>
                </a>
                <a href="#" class="planing">
                    <span>Запланировано</span>
                </a>
            </div>
            <div>
                <div>
                    <span>Всего книг:</span>
                    <span>{{ $statisticsBooks }}</span>
                </div>
                <div>
                    <span>Всего авторов:</span>
                    <span>{{ $statisticsAuthors }}</span>
                </div>
                <div>
                    <span>Всего жанров:</span>
                    <span>{{ $statisticsCategories }}</span>
                </div>
            </div>
        </div>
    </section>
    <section id="user-favorite-books" class="user-section">
        <h2>Любимые книги</h2>

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
        <h2>Любимые авторы</h2>

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
        <h2>Любимые жанры</h2>
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