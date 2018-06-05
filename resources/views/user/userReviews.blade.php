@extends('layouts.main',['title'=> $title ?? ('Все рецензии пользователя ' . $reviews->first()->author)])
@section('content')
    {{Breadcrumbs::render()}}
    <div class="container review-container">
        @include('layouts.reviews', $reviews)
    </div>
@endsection