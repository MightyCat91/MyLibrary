<ol class="list">
    @foreach($array as $item)
        <li class="item">
            <a href="{{ route($routeName, $item->id) }}">
                <div class="cover-container">
                    @if(empty($imgFolder))
                        <i class="fa fa-pencil fa-lg item-icon" aria-hidden="true"></i>
                    @else
                        <img src="{{ asset(array_first(getPublicFiles($imgFolder, $item->id))) }}" class="cover">
                    @endif
                </div>
                <div class="title">{{ $item->name }}</div>
            </a>
        </li>
    @endforeach
</ol>