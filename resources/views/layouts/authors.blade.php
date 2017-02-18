@foreach($authors as $author)
    <a href="{{ route('author', $author->id) }}" class="card-container">
        <figure class="col-md-3 col-sm-4 col-xs-6 container">
            <img src="{{ asset('/authorsCover/'.$author->id.'.jpg') }}" alt="{{ $author->name }}"/>
            <figcaption class="resent-grid-info title">{{ $author->name }}</figcaption>
        </figure>
    </a>
@endforeach
