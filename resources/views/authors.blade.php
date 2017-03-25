@push('styles')
<link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@extends('layouts.main')
@section('content')
    @yield('category')
    <div id="main-container" class="row">
    @include('layouts.authors')
    </div>
@endsection