<div class="container-link row">
    @foreach($array as $item)
        <a href="{{ route($routeName, $item->id) }}" class="item-container-link">
            <figure class="col-md-3 col-sm-4 col-xs-6 item-container">
                <div class="container-cover">
                    <img src="{{ asset(array_first(getPublicFiles($imgFolder, $item->id))) }}" alt="{{ $item->name }}"/>
                </div>
                <figcaption class="container-title">{{ $item->name }}</figcaption>
            </figure>
        </a>
    @endforeach
</div>