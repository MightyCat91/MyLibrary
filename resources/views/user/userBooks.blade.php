@extends('layouts.main',['title'=>$title])
@push('styles')
    <link href="{{ asset('/css/Custom/alphabetFilter.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@section('content')
    @yield('category')
    @if (isset($title))
        <header>
            <h2 class="page-title">{{ $title }}</h2>
        </header>
    @endif
    {{ Breadcrumbs::render($breadcrumbParams)}}
    <div class="main-container container">
        @foreach($statistic as $status => $books)
            <section>
                <h2>{{ $status }}</h2>
                <div class="status-books-container">
                    @if(empty($books))
                        <span>В данном разделе пока нет книг</span>
                    @else
                        @include('layouts.commonGrid',
                        [
                            'array' => $books,
                            'routeName' => 'book',
                            'imgFolder' => 'books',
                            'type' => 'book'
                        ])
                    @endif
                </div>
            </section>
        @endforeach
    </div>
@endsection