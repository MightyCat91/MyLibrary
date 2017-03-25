@push('styles')
<link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@extends('layouts.main')
@section('content')
    <div id="main-container" class="row">
        @foreach($categories as $category)
            <a href="{{ route('category-books', $category->id) }}" class="item-container-link">
                <figure class="col-md-3 col-sm-4 col-xs-6 thumbnail item-container">
                    <div class="container-cover">
                        <img src="{{ asset('/categoryCover/'.$category->id.'.jpg') }}" alt="{{ $category->name }}"/>
                    </div>
                    <figcaption class="container-title">{{ $category->name }}</figcaption>
                </figure>
            </a>
        @endforeach
    </div>
@endsection