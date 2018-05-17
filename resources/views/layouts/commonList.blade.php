<link href="{{ asset('/css/Custom/commonList.css') }}" rel='stylesheet' type='text/css' media="all"/>
<h3 id="filter-header" class="hidden"></h3>
<div class="container-link">
    @foreach($array as $item)
        <div class="list-item-container-link">
            <div class="image-item-wrapper">
                <img src="{{ asset(getStorageFile($imgFolder, $item['id'])) }}" alt="{{ $item['name'] }}"/>
            </div>
            <div class="short-info-item-wrapper {{ Auth::check() ? '' : 'anon' }}">
                <div class="short-info-subwrapper">
                    <div class="item-name-wrapper">
                        <h3 class="item-name">{{ $item['name'] }}</h3>
                    </div>
                    @if(!empty($item['categories']))
                        <div class="item-categories-wrapper">
                            @foreach($item['categories'] as $category)
                                <a href="{{ route('category-books', [$category['id']]) }}"
                                   class="category">{{ $category['name'] }}</a>
                            @endforeach
                        </div>
                    @endif
                    @if(!empty($item['series']))
                        <div class="item-series-wrapper">
                            @foreach($item['series'] as $key => $series)
                                <a href="{{ route('series-books', [$series['id']]) }}"
                                   class="series">{{ (count($item['series'])-1!=$key)?$series['name'].',':$series['name'] }}</a>
                            @endforeach
                        </div>
                    @endif
                    <div class="item-rating-wrapper">
                        <span>Рейтинг: </span>
                        <span class="rating-count"><strong>{{ $item['rating'] }}</strong></span>
                        <div class="rating-icons-wrapper">
                            @switch($item['rating'])
                                @case(0)
                                @for($i = 0; $i < 5; $i++)
                                    <i class="far empty-star fa-star"></i>
                                @endfor
                                @break
                                @case(10)
                                @for($i = 0; $i < 5; $i++)
                                    <i class="fas fa-star fa-fw"></i>
                                @endfor
                                @break
                                @default
                                @if((round($item['rating']) % 2) == 0)
                                    @for($i = 0; $i < $item['rating']/2; $i++)
                                        <i class="fas fa-star fa-fw"></i>
                                    @endfor
                                    @for($i = $item['rating']/2+1; $i <= 5; $i++)
                                        <i class="far empty-star fa-star"></i>
                                    @endfor
                                @else
                                    @for($i = 0; $i < round($item['rating']/2, 0, PHP_ROUND_HALF_DOWN); $i++)
                                        <i class="fas fa-star fa-fw"></i>
                                    @endfor
                                    <span class="fa-layers fa-fw">
                                    <i class="fas fa-star-half"></i>
                                    <i class="far fa-star-half" data-fa-transform="flip-h"></i>
                                </span>
                                    @for($i = round($item['rating']/2); $i < 5; $i++)
                                        <i class="far empty-star fa-star"></i>
                                    @endfor
                                @endif
                            @endswitch
                        </div>
                    </div>
                    <div class="statistic-wrapper">
                        <div class="inFavorite-count-wrapper">
                            <div class="inFavorite-count statistic-item"
                                 title="{{ ($type == 'author') ? 'Нравится автор' : 'Нравится книга' }}">
                                <i class="fas fa-heart"></i>
                                <span>{{ $item['statistic']['inFavorite'] }}</span>
                            </div>
                        </div>
                        <div class="reading-count-wrapper">
                            <div class="reading-count statistic-item"
                                 title="{{ ($type == 'author') ? 'Читают книги автора' : 'Читают книгу' }}">
                                <i class="fas fa-clock"></i>
                                <span>{{ $item['statistic']['reading'] }}</span>
                            </div>
                        </div>
                        @if($type != 'author')
                            <div class="completed-count-wrapper">
                                <div class="completed-count statistic-item"
                                     title="Прочитали книгу">
                                    <i class="fas fa-calendar-check"></i>
                                    <span>{{ $item['statistic']['completed'] }}</span>
                                </div>
                            </div>
                            <div class="inPlans-count-wrapper">
                                <div class="inPlans-count statistic-item"
                                     title="Планируют прочитать">
                                    <i class="fas fa-calendar-plus"></i>
                                    <span>{{ $item['statistic']['inPlans'] }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @if(Auth::check())
                    <div class="list-item-user-actions-wrapper">
                        <div class="add-comment action-btn {{ ($type == 'author') ? $type : '' }}"
                             title="Написать комментарий">
                            <i class="fa fa-comments fa-fw" aria-hidden="true"></i>
                        </div>
                        @if($type != 'author')
                            <div class="add-review action-btn" href="#" title="Написать рецензию">
                                <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                            </div>
                        @endif
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
                @endif
                <div class="item-description-wrapper">
                    {{ (strlen($item['description']) > 420) ? str_limit($item['description'], 420) :
                    $item['description'] }}
                </div>
                <div class="item-btn-more-wrapper">
                    <div class="btn submit-btn">
                        <a href="{{ route($routeName, $item['id']) }}">Подробнее</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>