@section('category')
    <ul id="category" class="nav nav-tabs" data-id="{{ $category_id }}">
        <li class="nav-item">
            <span id="authors-tab" class="nav-link active">Authors</span>
        </li>
        <li class="nav-item">
            <span id="books-tab" class="nav-link">Books</span>
        </li>
    </ul>
@endsection
@if (Route::currentRouteNamed("category-books"))
    @include('books')
@else
    @include('authors')
@endif