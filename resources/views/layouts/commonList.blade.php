@push('styles')
    {{--<link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>--}}
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/filter-view.js') }}"></script>
@endpush
<h3 id="filter-header" class="hidden"></h3>
<div class="container-link">
    @foreach($array as $item)
        <div class="list-item-container-link">
            <div class="image-item-wrapper">
                <img src="{{ asset(getStorageFile($imgFolder, $item['id'])) }}" alt="{{ $item['name'] }}"/>
            </div>
            <div class="short-info-item-wrapper">
                <div class="item-name-wrapper">
                    <h3 class="item-name">{{ $item['name'] }}</h3>
                </div>
                <div class="item-categories-wrapper">
                    @foreach($categories as $category)
                        <a href="{{ route('category-books', [$category->id]) }}"
                           class="category">{{ $category->name }}</a>
                    @endforeach
                </div>
                <div class="item-rating-wrapper">
                    @include('layouts.rating', ['type'=>'author', 'score'=>$rating['score']])
                </div>
                @auth
                    <div class="list-item-user-actions-wrapper">
                        <div class="add-comment action-btn {{ ($type == 'author') ? $type : '' }}" title="Написать комментарий">
                            <i class="fa fa-comments fa-fw" aria-hidden="true"></i>
                        </div>
                        <div class="add-to-favorite action-btn {{ $item['inFavorite'] ? 'active' : '' }} {{ ($type == 'author') ? $type : '' }}"
                             data-type="{{ $type }}"
                             title="{{ $item['inFavorite'] ? 'Удалить из избранного' : 'Добавить в избранное'}}">
                            @if($item['inFavorite'])
                                <i class="fas fa-heart fa-fw"></i>
                                <i class="far fa-heart fa-fw hidden"></i>
                            @else
                                <i class="fas fa-heart fa-fw hidden"></i>
                                <i class="far fa-heart fa-fw"></i>
                            @endif
                        </div>
                    </div>
                @endauth
                <div class="item-description-wrapper"></div>
                <div class="item-btn-more-wrapper">
                    <a href="{{ route($routeName, $item['id']) }}">Подробнее</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{--<ol class="list">--}}
{{--<h3 id="filter-header" class="hidden"></h3>--}}
{{--@foreach($array as $item)--}}
{{--<li class="item">--}}
{{--<a href="{{ route($routeName, $item->id) }}" class="item-container-link">--}}
{{--<div class="cover-container">--}}
{{--@if(empty($imgFolder))--}}
{{--<i class="far fa-newspaper item-icon" aria-hidden="true"></i>--}}
{{--@else--}}
{{--<img src="{{ asset(getStorageFile($imgFolder, $item->id)) }}" class="cover">--}}
{{--@endif--}}
{{--</div>--}}
{{--<div class="title container-title">{{ $item->name }}</div>--}}
{{--</a>--}}
{{--</li>--}}
{{--@endforeach--}}
{{--</ol>--}}