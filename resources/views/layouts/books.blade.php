@foreach($books as $book)
    <a href="{{ route('book', $book->id) }}">
        <figure class="col-md-3 col-sm-4 col-xs-6 thumbnail container">
            <img src="{{ asset('/BooksCover/book_'.$book->id.'.jpg')}}" alt="{{ $book->name }}"/>
            <figcaption class="resent-grid-info title">{{ $book->name }}</figcaption>
        </figure>
    </a>
@endforeach