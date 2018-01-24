<div class="container-link">
    <h3 id="filter-header" class="hidden"></h3>
    {{dd($array)}}
    @foreach($array as $item)
        <div class="item-container-link">
            {{dd($item)}}
            <a href="{{ route($routeName, $item->id) }}">
                <div class="item-container">
                    <div class="btn-container">
                        <div class="user-actions-item">
                            <a id="change-to-favorite" class="{{ ($item->inFavorite) ? 'active' : '' }}"
                               data-type="author"
                               href="#" title="{{ ($item->inFavorite) ? 'Удалить из избранного' : 'Добавить в избранное'
                                   }}">
                                <i class="fa fa-heart fa-fw" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="user-actions-item">
                            <a id="add-to-favorite" class="{{ ($item->inFavorite) ? 'active' : '' }}" data-type="author"
                               href="#" title="{{ ($item->inFavorite) ? 'Удалить из избранного' : 'Добавить в избранное'
                                   }}">
                                <i class="fa fa-heart fa-fw" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <img src="{{ asset(getStorageFile($imgFolder, $item->id)) }}" alt="{{ $item->name }}"/>
                    <div class="container-title">{{ $item->name }}</div>
                </div>
            </a>
        </div>
    @endforeach
</div>