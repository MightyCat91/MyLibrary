@foreach($authors as $author)
    <a href="{{ route('author', $author->id) }}" class="item-container-link">
        <figure class="col-md-3 col-sm-4 col-xs-6 item-container">
            <div class="container-cover">
                <img src="{{ asset('/authorsCover/'.$author->id.'.jpg') }}" alt="{{ $author->name }}"/>
            </div>
            <figcaption class="container-title">{{ $author->name }}</figcaption>
        </figure>
    </a>
@endforeach
