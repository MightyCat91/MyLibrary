<h3 id="filter-header" class="hidden"></h3>
<div class="container-link">
    @foreach($array as $item)
        <div class="item-container-link" data-id="{{ $item['id'] }}">
            @if(Auth::check() and isset($type) ? in_array($type,['book','author']) : false)
                <div class="avg-rating" title="Средний рейтинг">
                    <i class="fa fa-star"></i>
                    <span>{{ $item['rating'] ?? 0 }}</span>
                </div>
                <input type="checkbox" id="checkbox-{{$item['id']}}" class="check-with-label"/>
                <label for="checkbox-{{$item['id']}}" class="user-action-icon-wrapper">
                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                </label>
                @if($type != 'author')
                    <div class="add-review action-btn" href="#" title="Написать рецензию">
                        <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                    </div>
                @endif
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
            @endif
            <a href="{{ route($routeName, $item['id']) }}">
                <div class="item-container">
                    <img src="{{ asset(getStorageFile($imgFolder, $item['id'])) }}" alt="{{ $item['name'] }}"/>
                    <div class="container-title">{{ $item['name'] }}</div>
                </div>
            </a>
        </div>
    @endforeach
</div>