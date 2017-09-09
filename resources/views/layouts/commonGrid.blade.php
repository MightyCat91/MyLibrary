<div class="container-link row">
    <h3 id="filter-header" class="hidden"></h3>
    @foreach($array as $item)
        <a href="{{ route($routeName, $item->id) }}" class="item-container-link">
            <figure class="col-md-4 col-sm-5 col-xs-6 item-container">
                <div class="container-cover">
                    <img src="{{ asset(getStorageFile($imgFolder, $item->id)) }}" alt="{{ $item->name }}"/>
                </div>
                <figcaption class="container-title">{{ $item->name }}</figcaption>
            </figure>
        </a>
    @endforeach
</div>