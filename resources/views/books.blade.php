@extends('layouts.main',['title'=>$title])
@push('styles')
    <link href="{{ asset('/css/Custom/alphabetFilter.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/alphabetFilter.js') }}"></script>
@endpush
@section('content')
    @yield('category')
    @if (isset($header))
        <header>
            <h2 class="page-title">{{ $header }}</h2>
        </header>
    @endif
    @if (!trim($__env->yieldContent('category')))
        {{ Breadcrumbs::render($breadcrumbParams ?? null)}}
    @endif
    <div id="main-container" class="container">
        @include('layouts.commonGrid',
        [
            'array' => $books,
            'routeName' => 'book',
            'imgFolder' => 'books'
        ])
    </div>
    @include('layouts.alphabetFilter', ['type' => $type])
@endsection
