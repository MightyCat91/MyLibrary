@push('styles')
    <link href="{{ asset('/css/Custom/userLibrary.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/userLibrary.js') }}"></script>
@endpush
@extends('layouts.main',['title'=>'Моя библиотека'])
@section('content')
    <div class="user-wrapper">
        <div class="user-book-library">
            <div class="book-status-container">
                <div class="book-status element active">
                    <span>Все книги</span>
                </div>
                @foreach($statuses as $status)
                    <div class="book-status element">
                        <span>{{ $status }}</span>
                    </div>
                @endforeach
            </div>
            <div class="user-book-library-table">
                <div class="table-header">
                    <span>Все книги</span>
                </div>
                <table class="table-body">
                    <thead>
                        <tr class="table-row">
                            <th class="table-column number">#</th>
                            <th class="table-column name">Название</th>
                            <th class="table-column status">Статус</th>
                            <th class="table-column rating">Рейтинг</th>
                            <th class="table-column authors">Авторы</th>
                            <th class="table-column pages">Прогресс</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $key => $book)
                            <tr class="table-row" data-bookid="{{ $book['id'] }}">
                                <th class="table-column number-value">
                                    <span class="status_color" data-status="{{ $book['status_name'] }}"></span>
                                    <span>{{ ++$key }}</span>
                                </th>
                                <th class="table-column name-value">
                                    <a href="{{ route('book', [$book['id']]) }}">{{ $book['name'] }}</a>
                                </th>
                                <th class="table-column status-value">
                                    <input type="button" class="status-btn" data-toggle="popover"
                                           data-status="{{ $book['status_name'] }}" value="{{ $book['status_uname'] }}">
                                </th>
                                <th class="table-column rating-value">{{ $book['rating'] }}</th>
                                <th class="table-column authors-value">{{ $book['authors'] }}</th>
                                <th class="table-column pages-value">{{ $book['page_counts'] }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="status-list" class="hidden">
                    @foreach($allStatuses as $stat)
                        <div class="status-option {{ $stat->name }}"
                             data-status="{{ $stat->name }}">{{ $stat->uname }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection