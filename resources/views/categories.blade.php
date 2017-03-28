@push('styles')
<link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@extends('layouts.main')
@section('content')
    <div id="main-container" class="row">
        @include('layouts.commonGrid',
        [
            'array' => $categories,
            'routeName' => 'category-books',
            'imgFolder' => 'categories'
        ])
    </div>
@endsection