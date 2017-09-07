@extends('layouts.main',['title'=>'Издательства'])
@push('styles')
    <link href="{{ asset('/css/Custom/alphabetFilter.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Custom/commonList.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/alphabetFilter.js') }}"></script>
@endpush
@section('content')
    {{Breadcrumbs::render()}}
    <div id="main-container" class="container">
        @include('layouts.commonList',
        [
            'array' => $publishers,
            'routeName' => 'publisher-books'
        ])
    </div>
    @include('layouts.alphabetFilter', ['type' => $type])
@endsection