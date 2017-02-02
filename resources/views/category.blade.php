
@section('category')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a id="authors-tab" class="nav-link active" href="{{ redirect()->action('UserController@profile', [1]); }}">Authors</a>
        </li>
        <li class="nav-item">
            <a id="books-tab" class="nav-link" href="{{ view('books', ['books' => $books]) }}">Books</a>
        </li>
    </ul>
@endsection