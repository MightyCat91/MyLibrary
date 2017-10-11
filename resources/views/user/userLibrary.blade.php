@push('styles')
    <link href="{{ asset('/css/Library/jQuery/jquery-ui.min.css')  }} " rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Custom/userLibrary.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Custom/rating.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@extends('layouts.main',['title'=>'Моя библиотека'])
@section('content')
    <div class="user-wrapper">
        <div class="user-book-library">
            <div class="book-status-container">
                <div class="book-status element active" data-tab="all">
                    <span>Все книги</span>
                </div>
                @foreach($statuses as $status => $statusName)
                    <div class="book-status element" data-tab="{{ $status }}">
                        <span>{{ $statusName }}</span>
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
                            <td class="table-column number value">
                                <div class="number-wrapper">
                                    <span class="status_color" data-status="{{ $book['status_name'] }}"></span>
                                    <span>{{ ++$key }}</span>
                                </div>
                            </td>
                            <td class="table-column name value">
                                    <a href="{{ route('book', [$book['id']]) }}">{{ $book['name'] }}</a>
                                </td>
                                <td class="table-column status value">
                                    <input type="button" class="status-btn" data-toggle="popover"
                                           data-status="{{ $book['status_name'] }}" value="{{ $book['status_uname'] }}">
                                </td>
                                <td class="table-column rating value">
                                    <input type="text" class="rating-btn no-focused" value="{{ $book['rating'] }}">
                                    <div class="rating-wrapper">
                                        <datalist class="rating-list">
                                            @foreach(range(1, 10) as $rating)
                                                <option>{{ $rating }}</option>
                                            @endforeach
                                        </datalist>
                            </td>
                            <td class="table-column authors value">
                                <div class="author-link-wrapper">
                                    <a href="{{ route('author', key($book['authors'])) }}">{{ current($book['authors']) }}</a>
                                </div>
                                @if(count($book['authors']) >= 2)
                                    <div class="other-authors-controller">
                                        <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-o-up hidden" aria-hidden="true"></i>
                                    </div>
                                    <div class="other-author-wrapper hidden">
                                        @foreach(array_slice($book['authors'],1) as $id => $author)
                                            <a href="{{ route('author', $id) }}">{{ $author }}</a>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="table-column pages value">
                                <input type="text" class="progress"
                                       value="{{ printf("%s/%s",$book['progress'], $book['page_counts']) }}">
                            </td>
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
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Library/jQuery/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/Custom/userLibrary.js') }}"></script>
@endpush