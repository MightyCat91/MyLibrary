<!DOCTYPE HTML>
<html>
<head>
    <title>
        @if (trim($__env->yieldContent('title')))
            @yield('title')
        @else
            MyLibrary.ru
        @endif
    </title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <link href='http://fonts.googleapis.com/css?family=Oxygen:400,300,700' rel='stylesheet' type='text/css'>
    <script src="{{asset('js/jquery-2.1.4.min.js')}}"></script>
    <script src="{{asset('js/skel.min.js')}}"></script>
    <script src="{{asset('js/skel-panels.min.js')}}"></script>
    <script src="{{asset('js/init.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/book-add.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/skel-noscript.css')}}"/>
    <link rel="stylesheet" href="{{asset("css/bootstrap.min.css")}}"/>
    <link rel="stylesheet" href="{{asset("css/bootstrap-theme.min.css")}}"/>
    <link rel="stylesheet" href="{{asset("css/style.css")}}"/>
    <link rel="stylesheet" href="{{asset("css/style-desktop.css")}}"/>
</head>
<body class="homepage">

<!-- Header -->
<div id="header">
    <div class="container">

        <!-- Logo -->
        <div id="logo">
            <h1 class="display-3">{!! link_to_route('home', 'MyLibrary') !!}</h1>
            <span>Library your dream</span>
        </div>

        <!-- Nav -->
        <nav id="nav">
            <ul>
                <li class="active">{!! link_to_route('home', 'Homepage') !!}</li>
                <li>{!! link_to_route('book.index', 'Books') !!}</li>
                <li>{!! link_to_route('book.create', 'Authors') !!}</li>
                <li>{!! link_to_route('book.create', 'Genres') !!}</li>
                <li>{!! link_to_route('book.create', 'Add') !!}</li>
                {{--<li><a href="threecolumn.html">Two Sidebars</a></li>--}}
                {{--<li><a href="twocolumn1.html">Left Sidebar</a></li>--}}
                {{--<li><a href="twocolumn2.html">Right Sidebar</a></li>--}}
                {{--<li><a href="onecolumn.html">No Sidebar</a></li>--}}
            </ul>
        </nav>

    </div>
</div>
<!-- Header -->