@extends($parent_template_name)
@section('category')
    <ul id="category" class="nav nav-tabs" data-id="{{ $category->id }}">
        <li class="nav-item">
            <a id="authors-tab" class="nav-link {{ (str_is($parent_template_name, 'authors')) ? 'active' : '' }}"
               href="{{ action('CategoriesController@showAuthors', [$category->id]) }}">Authors</a>
        </li>
        <li class="nav-item">
            <a id="books-tab" class="nav-link {{ (str_is($parent_template_name, 'books')) ? 'active' : '' }}"
               href="{{ action('CategoriesController@showBooks', [$category->id]) }}">Books</a>
        </li>
    </ul>
    <header>
        <h2>{{ $category->name }}</h2>
    </header>
@endsection