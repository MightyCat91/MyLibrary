@extends('layouts.main',['title'=>'Жанры'])
@push('styles')
    <link href="{{ asset('/css/Custom/alphabetFilter.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/alphabetFilter.js') }}"></script>
@endpush
{{ Session::flash('title', 'Жанры') }}
@section('content')
    {{--{{Breadcrumbs::render()}}--}}
    <div id="main-container" class="container">
        @include('layouts.commonGrid',
        [
            'array' => $categories,
            'routeName' => 'category-books',
            'imgFolder' => 'categories'
        ])
    </div>
    @include('layouts.alphabetFilter', ['type' => 'book'])
@endsection