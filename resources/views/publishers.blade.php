@push('styles')
<link href="{{ asset('/css/Custom/alphabetFilter.css') }}" rel='stylesheet' type='text/css' media="all"/>
<link href="{{ asset('/css/Custom/commonList.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
<script type="text/javascript" src="{{ asset('/js/Custom/alphabetFilter.js') }}"></script>
@endpush
@extends('layouts.main')
@section('content')
    <div id="main-container" class="container">
        @include('layouts.commonList',
        [
            'array' => $publishers,
            'routeName' => 'publisher-books'
        ])
    </div>
@endsection
@section('alphabetFilter')
    <section id="alphabet-filter-container">
        <div id="alphabet-sticky-block" class="publisher">
            @foreach(range(chr(0xC0),chr(0xDF)) as $letter)
                <div class="letter-filter">{{ iconv('CP1251','UTF-8',$letter) }}</div>
            @endforeach
        </div>
    </section>
@endsection