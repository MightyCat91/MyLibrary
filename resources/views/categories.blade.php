@extends('layouts.main')
@section('content')
    <div class="main-container row">
        @foreach($categories as $category)
            <a href="{{ route('category-books', $category->id) }}">
                <figure class="col-md-3 col-sm-4 col-xs-6 thumbnail container">
                    <img src="{{ asset('/categoryCover/'.$category->id.'.jpg') }}" alt="{{ $category->name }}"/>
                    <figcaption class="resent-grid-info title">{{ $category->name }}</figcaption>
                </figure>
            </a>
        @endforeach
    </div>
@endsection