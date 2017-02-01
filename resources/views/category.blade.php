
@section('category')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="{{ redirect()->action('UserController@profile', [1]); }}">Authors</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ view('books', ['books' => $books]) }}">Books</a>
        </li>
    </ul>
@endsection