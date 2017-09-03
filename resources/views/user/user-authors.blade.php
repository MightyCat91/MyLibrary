@extends('layouts.main',['title'=>$title])
@push('styles')
    <link href="{{ asset('/css/Custom/alphabetFilter.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/alphabetFilter.js') }}"></script>
@endpush
{{ Session::flash('title', $title) }}
@section('content')
    @yield('category')
    @if (isset($title))
        <header>
            <h2 class="page-title">{{ $title }}</h2>
        </header>
    @endif
        {{--{{ Breadcrumbs::render()}}--}}
    <div id="main-container" class="container">
        @include('layouts.commonGrid',
        [
            'array' => $authors,
            'routeName' => 'author',
            'imgFolder' => 'authors'
        ])
    </div>
    @include('layouts.alphabetFilter', ['type' => 'author'])
@endsection