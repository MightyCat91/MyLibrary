@extends('layouts.main')
@section('content')
    @yield('category')
    <div class="main-container row">
    @include('layouts.authors')
    </div>
@endsection