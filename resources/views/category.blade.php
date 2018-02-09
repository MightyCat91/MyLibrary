@extends($parent_template_name,['title'=>$category->name, 'type'=>$type])
@section('category')
    <header>
        <h2 class="page-title">{{ $category->name }}</h2>
    </header>
    {{Breadcrumbs::render()}}
    {{--<ul id="category" class="" data-id="{{ $category->id }}">--}}
        {{--<li class="tab-item {{ (str_is($parent_template_name, 'authors')) ? 'active' : '' }}">--}}
            {{--<a id="authors-tab" class="nav-link"--}}
               {{--href="{{ action('CategoriesController@showAuthors', [$category->id]) }}">Авторы</a>--}}
        {{--</li>--}}
        {{--<li class="tab-item {{ (str_is($parent_template_name, 'books')) ? 'active' : '' }}">--}}
            {{--<a id="books-tab" class="nav-link"--}}
               {{--href="{{ action('CategoriesController@showBooks', [$category->id]) }}">Книги</a>--}}
        {{--</li>--}}
    {{--</ul>--}}
    <div id="category" class="" data-id="{{ $category->id }}" data-toggle="buttons">
        <label class="btn-switch-label tab-item {{ (str_is($parent_template_name, 'authors')) ? 'active' : '' }}">
            <input type="radio" name="man" id="option1" autocomplete="off">
            <a id="authors-tab" class="nav-link"
               href="{{ action('CategoriesController@showAuthors', [$category->id]) }}">Авторы</a>
        </label>
        <label class="btn-switch-label tab-item {{ (str_is($parent_template_name, 'books')) ? 'active' : '' }}">
            <input type="radio" name="woman" id="option2" autocomplete="off">
            <a id="books-tab" class="nav-link"
               href="{{ action('CategoriesController@showBooks', [$category->id]) }}">Книги</a>
        </label>
    </div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('/js/custom/Categories.js') }}"></script>
@endpush