@extends($parent_template_name,['title'=>$category->name, 'type'=>$type])
@section('category')
    <header>
        <h2 class="page-title">{{ $category->name }}</h2>
    </header>
    {{Breadcrumbs::render()}}
    <div id="category" class="" data-id="{{ $category->id }}" data-toggle="buttons">
        <label id="authors-tab" class="btn-switch-label tab-item {{ (str_is($parent_template_name, 'authors')) ?
        'active' : '' }}" data-href="{{ action('CategoriesController@showAuthors', [$category->id]) }}">
            <input type="radio" id="option1" autocomplete="off">
            <i class="fa fa-users fa-lg fa-fw nav-item-icon" aria-hidden="true"></i>
            <span>Авторы</span>
        </label>
        <label id="books-tab" class="btn-switch-label tab-item {{ (str_is($parent_template_name, 'books')) ? 'active'
         : '' }}" data-href="{{ action('CategoriesController@showBooks', [$category->id]) }}">
            <input type="radio" id="option2" autocomplete="off">
            <span>Книги</span>
            <i class="fa fa-book fa-lg fa-fw nav-item-icon" aria-hidden="true"></i>
        </label>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/custom/Categories.js') }}"></script>
@endpush