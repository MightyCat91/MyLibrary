@extends('layouts.main',['title'=>'Авторы'])
@push('styles')
    <link href="{{ asset('/css/Custom/alphabetFilter.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/alphabetFilter.js') }}"></script>
@endpush
@section('content')
    @yield('category')
    @if (!trim($__env->yieldContent('category')))
        {{ Breadcrumbs::render($breadcrumbParams ?? null)}}
    @endif
    <div class="main-container">
        @include('layouts.commonGrid',
        [
            'array' => $authors,
            'routeName' => 'author',
            'imgFolder' => 'authors',
            'type' => $type
        ])
    </div>
    @include('layouts.alphabetFilter', ['type' => $type])
@endsection