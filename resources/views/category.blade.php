@extends($parent_template_name)
{{ Session::flash('title', $category->name) }}
@section('category')
    <header>
        <h2 class="page-title">{{ $category->name }}</h2>
    </header>
    <ul id="category" class="" data-id="{{ $category->id }}">
        <li class="tab-item {{ (str_is($parent_template_name, 'authors')) ? 'active' : '' }}">
            <a id="authors-tab" class="nav-link"
               href="{{ action('CategoriesController@showAuthors', [$category->id]) }}">Авторы</a>
        </li>
        <li class="tab-item {{ (str_is($parent_template_name, 'books')) ? 'active' : '' }}">
            <a id="books-tab" class="nav-link"
               href="{{ action('CategoriesController@showBooks', [$category->id]) }}">Книги</a>
        </li>
    </ul>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('/js/custom/Categories.js') }}"></script>
@endpush