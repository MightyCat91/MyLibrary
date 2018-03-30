<ol class="list">
    <h3 id="filter-header" class="hidden"></h3>
    @foreach($array as $item)
        <li class="item">
            <a href="{{ route($routeName, $item->id) }}" class="item-container-link">
                <div class="cover-container">
                    @if(empty($imgFolder))
                        <i class="far fa-newspaper item-icon" aria-hidden="true"></i>
                    @else
                        <img src="{{ asset(getStorageFile($imgFolder, $item->id)) }}" class="cover">
                    @endif
                </div>
                <div class="title container-title">{{ $item->name }}</div>
            </a>
        </li>
    @endforeach
</ol>