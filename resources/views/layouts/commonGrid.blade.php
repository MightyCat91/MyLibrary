<h3 id="filter-header" class="hidden"></h3>
<div class="container-link">
    @foreach($array as $item)
        <div class="item-container-link" data-id="{{ $item['id'] }}">
            <a href="{{ route($routeName, $item['id']) }}">
                <div class="item-container">
                    @if(Auth::check() and isset($type) ? in_array($type,['book','author']) : false)
                        <div class="btn-container">
                            <div class="user-actions-item">
                            <span class="add-to-favorite {{ $item['inFavorite'] ? 'active' : '' }}"
                                  data-type="{{ $type }}"
                                  title="{{ $item['inFavorite'] ? 'Удалить из избранного' : 'Добавить в избранное'}}">
                                <i class="fa fa-heart fa-fw" aria-hidden="true"></i>
                            </span>
                            </div>
                            <div id="avg-rating" title="Средний рейтинг">
                                <i class="fa fa-star"></i>
                                <span>{{ $item['rating'] ?? 0 }}</span>
                            </div>
                        </div>
                    @endif
                    <img src="{{ asset(getStorageFile($imgFolder, $item['id'])) }}" alt="{{ $item['name'] }}"/>
                    <div class="container-title">{{ $item['name'] }}</div>
                </div>
            </a>
        </div>
    @endforeach
</div>