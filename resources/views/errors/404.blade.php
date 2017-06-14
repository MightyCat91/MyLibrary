@extends('layouts.main')
@section('content')
    {{\Debugbar::info('404-'.http_response_code())}}
    <blockquote class="title">Мы ищем не там, где надо, и потому не можем их найти...
        - Сесилия Ахерн. Там, где ты</blockquote>
@endsection