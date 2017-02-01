@extends('layout.main')

@section('title')
    Create book
@stop

@section('content')
    <div id="content" class="8u">
        <section>
            <header>
                <h2>Create Book</h2>
            </header>
            @if (Session::has("message"))
                <p class="message alert-success">{!! Session::get('message') !!}</p>
            @endif
            <hr/>
            {!! Form::open(['route' => 'book.store', 'files'=>true, 'class' => 'form-horizontal']) !!}
            @include('pages.book.editForm')
            {!! Form::close()!!}
        </section>
    </div>
@stop

@section('sidebar')
    <!-- Sidebar -->
    <div id="sidebar" class="4u">
        <section>
            <header>
                <h2>Gravida praesent</h2>
                <span class="byline">Praesent lacus congue rutrum</span>
            </header>
            <p>Donec leo, vivamus fermentum nibh in augue praesent a lacus at urna congue rutrum. Maecenas luctus lectus
                at sapien. Consectetuer adipiscing elit.</p>
            <ul class="default">
                <li><a href="#">Pellentesque quis lectus gravida blandit.</a></li>
                <li><a href="#">Lorem ipsum consectetuer adipiscing elit.</a></li>
                <li><a href="#">Phasellus nec nibh pellentesque congue.</a></li>
                <li><a href="#">Cras aliquam risus pellentesque pharetra.</a></li>
                <li><a href="#">Duis non metus commodo euismod lobortis.</a></li>
                <li><a href="#">Lorem ipsum dolor adipiscing elit.</a></li>
            </ul>
        </section>
    </div>
    <!-- Sidebar -->
@stop
