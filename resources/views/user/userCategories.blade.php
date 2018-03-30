@extends('layouts.main',['title'=>'Жанры'])
@push('styles')
    <link href="{{ asset('/css/Custom/alphabetFilter.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/alphabetFilter.js') }}"></script>
@endpush
@section('content')
    {{Breadcrumbs::render($breadcrumbParams)}}
    <div class="main-container container">
        @include('layouts.commonGrid',
        [
            'array' => $categories,
            'routeName' => 'category-books',
            'imgFolder' => 'categories'
        ])
    </div>
    @include('layouts.alphabetFilter', ['type' => 'book'])
@endsection