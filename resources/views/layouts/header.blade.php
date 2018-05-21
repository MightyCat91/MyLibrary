<!DOCTYPE HTML>
<html>
<head>
    <title>{{ $title }}</title>
    <meta name="title" content="{{ $title }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <meta name="keywords" content="My Play Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template,
    Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" /> -->
    <script type="application/x-javascript"> addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);
        function hideURLbar() {
            window.scrollTo(0, 1);
        } </script>
    <link rel="shortcut icon" type="image/png" href="{{ asset('/images/icon.png') }}"/>
    <!-- bootstrap-social -->
    <link href="{{ asset('/css/Library/Bootstrap/bootstrap-social.css') }}" rel="stylesheet" type='text/css' media="all">
    <!-- bootstrap -->
    <link href="{{ asset('/css/Library/Bootstrap/bootstrap.min.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <!-- general -->
    <link href="{{ asset('/css/Custom/general.css') }}" rel="stylesheet" type='text/css' media="all">
    <!-- Font Awesome -->
    {{--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">--}}
    <script>
        FontAwesomeConfig = { searchPseudoElements: true };
    </script>
    <script defer src="{{ asset('/js/Library/FontAwesome/fontawesome-all.min.js') }}"></script>
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lobster|Philosopher:400,400i,700,700i&amp;subset=cyrillic" rel="stylesheet">
    <!-- alert -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/Custom/alert.css') }}">
    {{-- search--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/Custom/search.css') }}">
    <!-- include summernote css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    {{--<link href="{{ asset('/css/Library/Summernote/summernote.css') }}" rel="stylesheet">--}}
    @stack('styles')
</head>
<body>