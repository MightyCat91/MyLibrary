@push('styles')
<link href="{{ asset('/css/Custom/commonGrid.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
<script type="text/javascript" src="{{ asset('/js/Custom/StickyBlock.js') }}"></script>
@endpush
@extends('layouts.main')
@section('alphabetFilter')
    <section id="alphabet-filter-container">
        <div id="alphabet-sticky-block" class="category">
            @foreach(range(chr(0xC0),chr(0xDF)) as $letter)
                <div class="letter-filter">{{ iconv('CP1251','UTF-8',$letter) }}</div>
            @endforeach
        </div>
    </section>
@endsection
@section('content')
    <div id="main-container" class="row container">
        @include('layouts.commonGrid',
        [
            'array' => $categories,
            'routeName' => 'category-books',
            'imgFolder' => 'categories'
        ])
    </div>
@endsection