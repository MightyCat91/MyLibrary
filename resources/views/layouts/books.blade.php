@foreach($books as $book)
    <a href="{{ route('book', $book->id) }}" class="item-container-link">
        <figure class="col-md-3 col-sm-4 col-xs-6 item-container">
            <div class="container-cover">
                <img src="{{ asset('/BooksCover/book_'.$book->id.'.jpg')}}" alt="{{ $book->name }}"/>
            </div>
            <figcaption class="container-title">{{ $book->name }}</figcaption>
        </figure>
    </a>
@endforeach