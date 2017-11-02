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
                    <div class="filter-container">
                        <div class="search-wrapper">
                            <div class="search-field-wrapper">
                                <input type="text" class="search-field" placeholder="Название или автор">
                            </div>
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </div>
                        <div class="filter-wrapper">
                            <div id="filterDialog" data-toggle="modal" data-target="#filterForm">
                                <i class="fa fa-filter" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="library-table">
                    <thead>
                    <tr class="table-row">
                        <th class="table-column number">
                            <div class="title">#</div>
                        </th>
                        <th class="table-column name can-sort">
                            <div class="title">Название</div>
                            <i class="fa sort-controls fa-sort-asc hidden" aria-hidden="true" data-order="asc"></i>
                            <i class="fa sort-controls fa-sort-desc hidden" aria-hidden="true" data-order="desc"></i>
                        </th>
                        <th class="table-column status can-sort">
                            <div class="title">Статус</div>
                            <i class="fa sort-controls fa-sort-asc hidden" aria-hidden="true" data-order="asc"></i>
                            <i class="fa sort-controls fa-sort-desc hidden" aria-hidden="true" data-order="desc"></i>
                        </th>
                        <th class="table-column rating can-sort">
                            <div class="title">Рейтинг</div>
                            <i class="fa sort-controls fa-sort-asc hidden test" aria-hidden="true" data-order="asc"></i>
                            <i class="fa sort-controls fa-sort-desc" aria-hidden="true" data-order="desc"></i>
                        </th>
                        <th class="table-column authors can-sort">
                            <div class="title">Авторы</div>
                            <i class="fa sort-controls fa-sort-asc hidden" aria-hidden="true" data-order="asc"></i>
                            <i class="fa sort-controls fa-sort-desc hidden" aria-hidden="true" data-order="desc"></i>
                        </th>
                        <th class="table-column pages can-sort">
                            <div class="title">Прогресс</div>
                            <i class="fa sort-controls fa-sort-asc hidden" aria-hidden="true" data-order="asc"></i>
                            <i class="fa sort-controls fa-sort-desc hidden" aria-hidden="true" data-order="desc"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="table-body">
                    @foreach($books as $key => $book)
                        <tr class="table-row" data-bookid="{{ $book['id'] }}">
                            <td class="table-column number value">
                                <div class="number-wrapper">
                                    <span class="status_color" data-status="{{ $book['status_name'] }}"></span>
                                    <span>{{ ++$key }}</span>
                                </div>
                            </td>
                            <td class="table-column name line-height-1-5 value">
                                <a href="{{ route('book', [$book['id']]) }}">{{ $book['name'] }}</a>
                            </td>
                            <td class="table-column status value">
                                <input type="button" class="status-btn" data-toggle="popover"
                                       data-status="{{ $book['status_name'] }}" value="{{ $book['status_uname'] }}">
                            </td>
                            <td class="table-column rating value">
                                <input type="text" class="rating-btn no-focused" value="{{ $book['rating'] ?: '---' }}">
                                <div class="rating-wrapper hidden">
                                    <datalist class="rating-list">
                                        @foreach(range(1, 10) as $rating)
                                            <option>{{ $rating }}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </td>
                            <td class="table-column authors value {{ (count($book['authors']) >= 2)?
                            '' : 'vertical-middle' }}">
                                <div class="author-link-wrapper">
                                    <a class="author" href="{{ route('author', key($book['authors'])) }}">
                                        {{ current($book['authors']) }}</a>
                                </div>
                                @if(count($book['authors']) >= 2)
                                    <div class="other-authors-controller">
                                        <i class="fa fa-arrow-circle-o-down" aria-hidden="true"
                                           title="Показать остальных авторов"></i>
                                        <i class="fa fa-arrow-circle-o-up hidden" aria-hidden="true"
                                           title="Скрыть остальных авторов"></i>
                                    </div>
                                    <div class="other-author-wrapper line-height-1-5 hidden">
                                        @foreach(array_slice($book['authors'],1) as $id => $author)
                                            <a class="author" href="{{ route('author', $id) }}">{{ $author }}</a>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="table-column pages value">
                                <input type="text" class="book-progress no-focused"
                                       data-route="{{ route('book', $book['id']) }}"
                                       value="{{ round(($book['progress']/$book['page_counts'])*100) }}%"
                                       title="{{ sprintf("%s/%s",$book['progress'], $book['page_counts']) }}">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mobile-table">
                    @foreach($books as $key => $book)
                        <div class="mobile-table-row table-row" data-bookid="{{ $book['id'] }}">
                            <div class="mobile-short-info-container">
                                <div class="number-wrapper">
                                    <span class="status_color" data-status="{{ $book['status_name'] }}"></span>
                                    <span>{{ ++$key }}</span>
                                </div>
                                <div class="mobile-short-info-wrapper">
                                    <div class="name">
                                        <a href="{{ route('book', [$book['id']]) }}">{{ $book['name'] }}</a>
                                    </div>
                                    <div class="mobile-other-short-field-wrapper">
                                        <div class="authors-short">
                                            @if(count($book['authors']) > 1)
                                                {{ current($book['authors']) }}...
                                            @else
                                                {{ current($book['authors']) }}
                                            @endif
                                        </div>
                                        <div class="status-short">
                                            {{ $book['status_uname'] }}
                                        </div>
                                        <div class="rating-short">
                                            {{ $book['rating'] ?: '' }}
                                        </div>
                                        <div class="progress-short">
                                            {{ round(($book['progress']/$book['page_counts'])*100) }}%
                                        </div>
                                    </div>
                                </div>
                                <div class="show-full-controller" data-parent=".mobile-table">
                                    <i class="fa show fa-arrow-circle-o-down" aria-hidden="true"
                                       title="Показать полную информацию"></i>
                                    <i class="fa hide fa-arrow-circle-o-up hidden" aria-hidden="true"
                                       title="Скрыть полную информацию"></i>
                                </div>
                            </div>
                            <div class="mobile-full-info-wrapper collapse">
                                <div class="authors">
                                    @foreach($book['authors'] as $id => $author)
                                        <a class="author" href="{{ route('author', $id) }}">{{ $author }}</a>
                                    @endforeach
                                </div>
                                <div class="mobile-controls">
                                    <div class="rating">
                                        <input type="text" class="rating-btn no-focused" value="{{ $book['rating'] ?: '---' }}">
                                        <div class="rating-wrapper hidden">
                                            <datalist class="rating-list">
                                                @foreach(range(1, 10) as $rating)
                                                    <option>{{ $rating }}</option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="status">
                                        <input type="button" class="status-btn" data-toggle="popover"
                                               data-status="{{ $book['status_name'] }}" value="{{ $book['status_uname'] }}">
                                    </div>
                                    <div class="pages">
                                        <input type="text" class="book-progress no-focused"
                                               data-route="{{ route('book', $book['id']) }}"
                                               value="{{ round(($book['progress']/$book['page_counts'])*100) }}%"
                                               title="{{ sprintf("%s/%s",$book['progress'], $book['page_counts']) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="status-list" class="hidden">
                    @foreach($allStatuses as $stat)
                        <div class="status-option {{ $stat->name }}"
                             data-status="{{ $stat->name }}">{{ $stat->uname }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- The modal -->
    <div class="modal fade" id="filterForm" tabindex="-1" role="dialog" aria-labelledby="modalLabelSmall"
         aria-hidden="true">
        <div class="modal-dialog modal-vertical-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Фильтры</h3>
                    <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-status-container">
                        <div class="modal-container-header">
                            <span>Статус</span>
                        </div>
                        <div class="modal-status-btn-wrapper">
                            @foreach($allStatuses as $stat)
                                <div class="modal-status-btn" data-status="{{ $stat->name }}">{{ $stat->uname }}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-rating-range-container">
                        <div class="modal-container-header">
                            <span>Рейтинг</span>
                        </div>
                        <div class="modal-rating-slider-wrapper">
                            <div class="rating-range-scale">
                                @foreach(range(1, 10) as $rating)
                                    <div>{{ $rating }}</div>
                                @endforeach
                            </div>
                            <div id="rating-slider-range" data-min="1" data-max="10"></div>
                        </div>
                    </div>
                    <div class="modal-progress-slider-container">
                        <div class="modal-container-header">
                            <span>Прогресс</span>
                        </div>
                        <div class="modal-progress-slider-wrapper">
                            <div class="form-group">
                                <input type="text" id="min-progress" name="min-progress" class="form-control"
                                       maxlength="3">
                                <label for="min-progress" class="input-label">От</label>
                            </div>
                            <div class="progress-slider-range-wrapper">
                                <div id="progress-slider-range" data-min="0" data-max="100"></div>
                                <div class="error-message"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" id="max-progress" name="max-progress" class="form-control"
                                       maxlength="3">
                                <label for="max-progress" class="input-label">До</label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-filter-clear">
                        <span class="dflt-text">Сбросить</span>
                    </button>
                    <button class="btn btn-primary btn-filter">
                        <span class="dflt-text">Применить</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Library/jQuery/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/Custom/userLibrary.js') }}"></script>
@endpush